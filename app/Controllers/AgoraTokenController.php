<?php

namespace App\Controllers;

use App\Models\GiftModel;
use App\Models\LivetreamUser;
use App\Models\Space;
use App\Models\Friend;
use App\Models\CallModel;
use App\Models\UserModel;
use App\Models\CallMemberModel;
use CodeIgniter\API\ResponseTrait;

use App\Controllers\BaseController;
use App\Classes\AgoraDynamicKey\RtcTokenBuilder;
use App\Models\MultiLivestreamUser;
use App\Models\TransactionModel;

require_once APPPATH . 'ThirdParty/AgoraDynamicKey/RtcTokenBuilder.php';

class AgoraTokenController extends BaseController
{
    use ResponseTrait;
    public function generateAgoraToken()
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.channel_name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.channel_name_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $user = getCurrentUser();
        $appID = get_setting('agora_app_id');
        $appCertificate = get_setting('agora_app_secret');
        $channelName = $this->request->getVar('channel_name'); // Assuming you're using the User model for authentication
        $role = RtcTokenBuilder::RolePublisher;
        $expireTimeInSeconds = 7200;
        $currentTimestamp = time(); // Use time() instead of now()->getTimestamp()
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, 0, $role, $privilegeExpiredTs);
        $userModel = new UserModel;
        $userModel->update($user['id'], ['agora_token_id' => $token]);
        return $this->response->setJSON([
            'status' => 200,
            'message' => lang('Api.token_generated_success'),
            'token' => $token
        ]);
    }
    public function goToLive()
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.channel_name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.channel_name_required')
                ]
            ],
            'type' => [
                'label' => lang('Api.type_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.type_required')
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }

        $user = getCurrentUser();

        $callModel = new CallModel();
        $callModel->where('user_id', $user['id'])->delete();

        $type = $this->request->getVar('type');
        $data = [
            'user_id' => $user['id'],
            'channel_name' => $this->request->getVar('channel_name'),
            'type' => $type,
            'agora_access_token' => $user['agora_token_id'],
        ];

        if ($type != 'live_stream') {
            $to_user_id = $this->request->getVar('to_user_id');
            if (empty($to_user_id)) {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.to_user_id_required'),
                ], 400);
            }
            $data['to_user_id'] = $to_user_id;
        }

        $callModel->save($data);
        $userModel = new UserModel();
      
        if ($type == 'live_stream') {
            $userModel->update($user['id'], ['is_live' => 1]);
            $friendModel = new Friend();
            $friends = $friendModel->userFriendList($user['id'], 1000, 0);
            foreach ($friends as $friend) {
                $userdevice = $userModel->select(['device_id', 'email'])->where('id', $friend['id'])->first();
                if (!empty($userdevice)) {
                    sendPushNotification($userdevice['device_id'], $user['name'] . ' ' . lang('Api.is_live_notification'));
                }
                if (get_setting('chck-emailNotification') == 1) {
                    sendmailnotificaiton($userdevice['email'], lang('Api.is_live_notification'), $user['name'] . ' ' . lang('Api.is_live_notification'));
                }
            }
        } else {
            $touser = $userModel->select(['device_id'])->where('id', $to_user_id)->first();
            sendPushNotification($touser['device_id'], $user['username'] . ' ' . lang('Api.is_calling_you'), $type);
        }

        return $this->response->setJSON([
            'status' => 200,
            'message' => lang('Api.user_is_live'),
        ]);
    }

    public function EndLiveStream()
    {
        $user = getCurrentUser();
        $callModel = new CallModel();
        $calls = $callModel->where('user_id', $user['id'])->findAll();

        if (!empty($calls)) {
            $livestreamModel = New LivetreamUser;
            $multiLivestreamUser = new MultiLivestreamUser();
            foreach ($calls as $call) {
                $livestreamModel->where('channel_name', $call['channel_name'])->delete();
                $multiLivestreamUser->where('channel_name', $call['channel_name'])->delete();
            }
        }
        $callModel->where('user_id', $user['id'])->delete();
        $userModel = new UserModel();
        $userModel->update($user['id'], ['is_live' => 0]);
        return $this->response->setJSON([
            'status' => 200,
            'message' => lang('Api.live_stream_ended'),
        ]);
    }

    public function getLiveUsers()
    {
        $user = getCurrentUser();
        $userModel = new UserModel;
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;
        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 100;

        $spaceModel = new CallModel;
        $friendModel = New Friend;
        $users = $friendModel->userfriend($user['id'],$limit,$offset);
       
        if (!empty($users)) {
            foreach ($users as &$user) {
                $user = $userModel->getUserShortInfo($user['id']);
                $spacedata = $spaceModel->where('user_id', $user['id'])->first();
                $user['agora_access_token'] = !empty($spacedata) ? $spacedata['agora_access_token'] : '';
                $user['channel_name'] = !empty($spacedata) ? $spacedata['channel_name'] : '';
                $user['type'] = !empty($spacedata) ? $spacedata['type'] : '';
            }
            return $this->response->setJSON([
                'status' => 200,
                'message' => lang('Api.live_user_fetch_success'),
                'data' => $users
            ]);
        }
        return $this->response->setJSON([
            'status' => 200,
            'message' => lang('Api.no_live_user_found'),
            'data' => []
        ]);
    }
    public function getCallHistory()
    {
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;
        $limit = !empty($this->request->getVar('limti')) ? $this->request->getVar('limti') : 10;
        $loggedInUser = getCurrentUser();
        $spaceModel = new CallModel();
        $userModel = new UserModel();

        $calls = $spaceModel->getUserCallHistory($loggedInUser['id'], $limit, $offset);
       
        $users = [];

        if (!empty($calls)) {
            foreach ($calls as $call) {
                
                $user = ($call['user_id'] == $loggedInUser['id']) ?
                    $userModel->getUserShortInfo($call['to_user_id']) :
                    $userModel->getUserShortInfo($call['user_id']);
                  
                if (!empty($user)) {
                    $user['call_type'] = $call['type'];
                    $user['incoming'] = ($call['user_id'] == $loggedInUser['id']) ? '0' : '1';
                    $user['time'] = HumanTime($call['created_at']);
                    // $user['call_id'] = $call['id'];
                    $users[] = $user;
                }
            }

            return $this->respond([
                'code' => 200,
                'message' => lang('Api.call_history_fetch_success'),
                'data' => $users
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.history_not_found'),
                'data' => $users
            ], 200);
        }
    }
    public function joinstream()
    {
        $rules = [
            'agora_access_token' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
            'channel_name' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $callModel =  new CallModel;
        $channel_name = $this->request->getVar('channel_name');
        $agora_access_token = $this->request->getVar('agora_access_token');
        $user = getCurrentUser();

        $call = $callModel->where(['title' => $channel_name, 'agora_access_token' => $agora_access_token])->first();


        if (empty($call)) {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.stream_not_found'),
            ], 400);
        }
        $callmemberModel = new CallMemberModel;
        $callmembercheck = $callmemberModel->where(['user_id' => $user['id'], 'call_id' => $call['id']])->first();
        if (empty($callmembercheck)) {
            $callMemberdata = [
                'user_id' => $user['id'],
                'call_id' => $call['id']
            ];
            $callmemberModel->save($callMemberdata);
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.live_stream_join_success'),
            ], 200);
        } else {
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.already_joined_stream'),
            ], 200);
        }
    }
    public function getToken()
    {
        $user  = getCurrentuser();
        $userModel = new UserModel;
        $user  = $userModel->getUserShortInfo($user['id']);
        $callModel = new CallModel;
        $space = $callModel->where('user_id', $user['id'])->first();

        $user['type'] = $space['type'];
        $user['agora_access_token'] = $space['agora_access_token'];
        $user['channel_name'] = $space['title'];
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.token_fetch_success'),
            'data' => $user
        ], 200);
    }
    public function declineCall()
    {
        $rules = [
            'user_id' => [
                'label' => lang('Api.user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required')
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $userModel= New UserModel;
        $user_id = $this->request->getVar('user_id');
        $user_device = $userModel->select(['device_id',])->where('id',$user_id)->first();
        sendPushNotification($user_device['device_id'],"declined your call","call_declined");
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.notification_sent_success'),
        ], 200);

    }
    public function livestreamRequest()
    {
        $rules = [
            'user_id' => [
                'label' => lang('Api.user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required')
                ]
            ],
            'type' => [
                'label' => lang('Api.type_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.type_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $userModel= New UserModel;
        $user_id = $this->request->getVar('user_id');
        $type = $this->request->getVar('type');
        $user_device = $userModel->select(['device_id',])->where('id',$user_id)->first();
        if ($user_device) {
            sendPushNotification($user_device['device_id'], lang('Api.livestream_request_accepted'), $type);
        }
    
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.notification_sent_success'),
        ], 200);
    }
    public function joinLiveStream()
    {
        $rules = [
            'user_id' => [
                'label' => lang('Api.user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required')
                ]
            ],
            'channel_name' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $userModel= New UserModel;
        $user_id = $this->request->getVar('user_id');
        $channel_name = $this->request->getVar('channel_name');
        $livestreamUserModel = New LivetreamUser();
        $livestreamUserdata = [
            'user_id'=>$user_id,
            'channel_name'=>$channel_name    
        ];
        $livestreamUserModel->save($livestreamUserdata);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.live_stream_join_success'),
        ], 200);
    }
    public function getLiveStreamUser()
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $userModel= New UserModel;
        $limit = $this->request->getVar('limit')??10;
        $offset = $this->request->getVar('offset')??0;
        
        $channel_name = $this->request->getVar('channel_name');
        $livestreamUserModel = New LivetreamUser();
        $livestreamusers = $livestreamUserModel->where('channel_name',$channel_name)->findAll($limit,$offset);
        if(!empty($livestreamusers))
        {
            $userModel = New UserModel;
            $users = [];
            foreach ($livestreamusers as  $user) {
                $users[] = $userModel->getUserShortInfo($user['user_id']); 
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.live_stream_users_fetch_success'),
                'data' => $users
            ], 200);
        }
    
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.no_live_stream_users_found'),
        ], 200);
       
    }
    public function LivestreamUserAction()
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
            'agora_uid' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
            'action' => [
                'label' => lang('Api.validation_error'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error')
                ]
            ],
            'user_id' => [
                'label' => lang('Api.user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $action = $this->request->getVar('action');
        $channel_name = $this->request->getVar('channel_name');
        $agora_uid = $this->request->getVar('agora_uid');
        $user_id=   $this->request->getVar('user_id');    
        if($action=='add')
        {
            $multilivestreamuserModel = New MultiLivestreamUser;
            $existuser = $multilivestreamuserModel->where(['channel_name'=>$channel_name,'user_id'=>$user_id])->first();
            if(!empty($existuser))
            {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.user_already_in_livestream'),
                ], 200);
            }
            $livestreamdata = [
                'agora_uid'=>$this->request->getVar('agora_uid'),
                'channel_name'=>$this->request->getVar('channel_name'),
                'user_id'=>$this->request->getVar('user_id'),    
            ];
            $multilivestreamuserModel->save($livestreamdata);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.user_added_to_livestream'),
            ], 200);
        }
        else if($action=='remove')
        {
            $multilivestreamuserModel = New MultiLivestreamUser;
            $existuser = $multilivestreamuserModel->where(['channel_name'=>$channel_name,'user_id'=>$user_id])->first();
            if(empty($existuser))
            {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.user_not_in_livestream'),
                ], 200);
            }
           
            $multilivestreamuserModel->where('id',$existuser['id'])->delete();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.user_removed_from_livestream'),
            ], 200);
        }
        else
        {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.invalid_choice'),
            ], 200);
        }
    }
    public function getmultilivestreamusers() 
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.channel_name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.channel_name_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $multilivestreamuserModel = New MultiLivestreamUser;
        $channel_name = $this->request->getVar('channel_name');
        $users = $multilivestreamuserModel->select('agora_uid')->where('channel_name',$channel_name)->findAll();
        // $idArray = array();
        if(empty($users))
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.no_live_stream_users_found'),
            ], 400);
        }
        // foreach($users as $user)
        // {
        //     array_push($idArray,(int)$user['agora_uid']);
        // }
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.live_stream_user_found_success'),
            'data' => $users
        ], 200);
    }  
    public function getMultiLiveStreamUserInfo()
    {
        $rules = [
            'channel_name' => [
                'label' => lang('Api.channel_name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.channel_name_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $multilivestreamuserModel = New MultiLivestreamUser;
        $channel_name = $this->request->getVar('channel_name');
        $users = $multilivestreamuserModel->where('channel_name',$channel_name)->findAll();
        $modiefiedUsers = [];
       
        if(!empty($users))
        {
            $userModel = New UserModel;
            foreach ($users as  &$user) {
                $user = $userModel->getUserShortInfo($user['user_id']);
            }
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.user_fetch_success'),
                'data' => $users
            ], 200);
        }
    
        return $this->respond([
            'code' => 400,
            'message' => lang('Api.user_not_found'),
        ], 200);
    }
    public function sendGift()
    {
        $rules = [
            'user_id' => [
                'label' => lang('Api.user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required')
                ]
            ],
            'gift_id' => [
                'label' => lang('Api.gift_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.gift_id_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
        $gift_id  = $this->request->getVar('gift_id');
        $user_id = $this->request->getVar('user_id');
        $giftModel = New GiftModel();
        $userModel = New UserModel();
        $loggedInUser = getCurrentUser()['id'];
        $user  = $userModel->where('id',$user_id)->first();
        if(empty($user))
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.user_not_found'),
            ], 200);
        }
        if($user_id == $loggedInUser)
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.cannot_send_gift_to_self'),
            ], 200);
        }
        $gift  = $giftModel->where('id',$gift_id)->first();
        if(empty($gift))
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.gift_not_found'),
            ], 200);
        }
        $user_balance = getuserwallet($loggedInUser);
        
        if($gift['price']> $user_balance)
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.insufficient_balance'),
            ], 200);
        }
        $transactionModel = New TransactionModel();
        $creditTransaction = [
            'user_id' => $user_id,
            'flag' => 'C',
            'action_type' => 15,
            'gift_id' =>$gift_id,
            'amount' => $gift['price'],
        ];
        $transactionModel->save($creditTransaction);
        $debitTransaction = [
            'user_id' => $loggedInUser,
            'flag' => 'D',
            'action_type' => 15,
            'gift_id' =>$gift_id,
            'amount' => $gift['price'],
        ];
        $transactionModel->save($debitTransaction);
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.gift_sent_success'),
        ], 200);
    }
    public function deleteCall()
    {
         
        $rules = [
            'call_id' => [
                'label' => lang('Api.call_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.call_id_required')
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
        $call_id = $this->request->getVar('call_id');
        $callModel = New CallModel();
        $call = $callModel->where('id',$call_id)->first();
        if(empty($call))
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.call_not_found'),
            ], 200);
        }
        if($call['user_id']!=getCurrentUser()['id'])
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.unauthenticated'),
            ], 200);
        }
        $callModel->where('id', $call_id)->set(['is_deleted'=>1])->update();
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.call_deleted_success'),
        ], 200);

    }
    public function deleteallCall()
    {
        $user_id = getCurrentUser()['id'];
        $callModel = New CallModel();
        $callModel->where('user_id', $user_id)->set(['is_deleted'=>1])->update();
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.call_history_deleted_success'),
        ], 200);        
    }
}
