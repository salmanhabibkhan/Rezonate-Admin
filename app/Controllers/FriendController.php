<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use App\Models\Friend;
use App\Models\Follower;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class FriendController extends BaseController
{
    use ResponseTrait;
    public function friendRequestAction()
    {
        $rules = [
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ],
            'request_action' => [
                'label' => 'Request Action',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.request_action_required'),
                ]
            ]
        ];
        
        if($this->validate($rules))
        {
            $user_id = $this->request->getVar('user_id');
            $friendModel = New Friend;
            $followerModel = New Follower;
            $notificationModel = New NotificationModel;
            $loggendInUser = getCurrentUser();
            $loggendInUserID = $loggendInUser['id'];
            $friendrequestdata = $friendModel->where(['friend_one'=>$user_id,'friend_two'=>$loggendInUserID,'status'=>0])->first();
            $checkfollowerdata = $followerModel->where(['follower_id'=>$user_id,'following_id'=>$loggendInUserID])->first();
            $request_action = $this->request->getVar('request_action');
            $notification_id = $this->request->getVar('notification_id');
            if(!empty($notification_id))
            {
                $notification = $notificationModel->where(['from_user_id'=>$user_id,'to_user_id'=>$loggendInUserID,'type'=>'sent_request'])->first();
                $notificationModel->update($notification['id'],['is_reacted'=>1,'seen'=>1]);                
            }
            if(!empty($friendrequestdata))
            {
                
                if($request_action=='accept')
                {
                    $currentDatetime = Time::now();
                    $friendModel->update($friendrequestdata['id'],['status'=>1,'role'=>2,'accepted_time'=>$currentDatetime]);
                    $userModel = New UserModel();
                    $user_device = $userModel->select(['device_id','notify_accept_request','email'])->where('id', $user_id)->first();
                    if(get_setting('chck-emailNotification')==1)
                        {
                            sendmailnotificaiton($user_device['email'],'Accept Request ',"Accepted Your Friend Request.");
                        }
                    if(!empty($user_device) && $user_device['notify_accept_request']==1 && $user_id !=$loggendInUserID )
                    {
                        $notificationdata = [
                            'from_user_id'=>$loggendInUserID,
                            'to_user_id'=>$user_id,
                            'type'=>'accepted-request',
                            'text'=>'Accepted Your Friend Request.',
                        ];
                        sendPushNotification($user_device['device_id'],'accepted your friend request');
                    }

                    if(empty($checkfollowerdata))
                    {
                        $followerModel->save(['follower_id'=>$user_id,'following_id'=>$loggendInUserID,'active'=>1]);
                    }
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.friend_request_accepted'),
                        'data' => ''
                    ], 200);
                }
                elseif($request_action=='decline')
                {
                    $friendModel->delete($friendrequestdata['id']);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.friend_request_declined'),
                        'data' => ''
                    ], 200);
                }

               
            }
            else{
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.friend_request_not_found'),
                    'data' => ''
                ], 404);
            }
        }
        else
        {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validator->getErrors()
            ], 400);
        }
    }

    public function makeFriend()
    {
        $rules = [
            'friend_two' => [
                'label' => 'Friend ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.friend_two_required'),
                ]
            ]
        ];
        if ($this->validate($rules)) {


            $friend_one = getCurrentUser()['id'];
            $friend_two = $this->request->getVar('friend_two');
            $userModel = New UserModel;
            $user = $userModel->select('privacy_friends')->where('id',$friend_two)->first();
        
            $friendModel = new Friend;
            if(empty($user))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.userNotFound'),
                    'friend_status' => 'Not Friends',
                    'ispending' => 0
                ], 200);
            }
            if($user['privacy_friends']==2)
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.privacySettings'),
                    'friend_status' => 'Not Friends',
                    'ispending' => 0
                ], 200);
            }
            if($user['privacy_friends']==1)
            {
                $countMutual = $friendModel->countMutualFriends($friend_two,$friend_one);
                if($countMutual==0)
                {
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.privacySettings'),
                        'friend_status' => 'Not Friends',
                        'ispending' => 0
                    ], 200);
                }
            }
                
             
           
            $sentRequest = $friendModel->where('friend_one', $friend_one)
                                    ->where('friend_two', $friend_two)
                                    ->first();
            $receivedRequest = $friendModel->where('friend_one', $friend_two)
                                        ->where('friend_two', $friend_one)
                                        ->first();

            // Cancel sent friend request
            if (!empty($sentRequest) && $sentRequest['status'] == 0) {
                $friendModel->delete($sentRequest['id']);
                $notificationModel = new NotificationModel();
                $notificationModel->where([
                    'from_user_id' => $friend_one,
                    'to_user_id' => $friend_two,
                    'type' => 'sent_request',
                    'text' => lang('Api.requestSent'),
                ])->delete();  
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.requestCancelled'),
                    'friend_status' => 'Not Friends',
                    'ispending' => 0
                ], 200);
            }

            // Handle existing friends
            if (!empty($sentRequest) && $sentRequest['status'] == 1) {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.alreadyFriends'),
                    'friend_status' => 'Friends',
                    'ispending' => 0
                ], 200);
            }

            // Handle existing received friend request
            if (!empty($receivedRequest)) {
                if ($receivedRequest['status'] == 0) {
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.pendingRequest'),
                        'friend_status' => 'Pending Response',
                        'ispending' => 1
                    ], 200);
                } elseif ($receivedRequest['status'] == 1) {
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.alreadyFriends'),
                        'friend_status' => 'Friends',
                        'ispending' => 0
                    ], 200);
                }
            }

            // Send new friend request
            $create_request = [
                'friend_one' => $friend_one,
                'friend_two' => $friend_two,
            ];

            if ($friendModel->save($create_request)) {
                $notificationModel = new NotificationModel();
                $notificationdata = [
                    'from_user_id' => $friend_one,
                    'to_user_id' => $friend_two,
                    'type' => 'sent_request',
                    'text' => lang('Api.requestSent'),
                    'seen' => 0
                ];
                $notificationModel->save($notificationdata);
    
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.requestSent'),
                    'friend_status' => 'Request Sent',
                    'ispending' => 1
                ], 200);
            }
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validationError'),
                'data' => $this->validator->getErrors()
            ], 400);
        }
    }

    public function deleteRequest()
    {
        $rules = [
            'request_id' => [
                'label' => 'Request ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.request_id_required'),
                ]
            ]
        ];
       
        if($this->validate($rules))
        {
            $request_id = $this->request->getVar('request_id');
            $friendModel = New Friend;
            $friendrequestdata = $friendModel->find($request_id);
            if(!empty($friendrequestdata))
            {
                if($friendrequestdata['status']==0)
                {
                    $friendModel->delete($request_id);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.requestSuccessfullyDeleted'),
                        'data' => ''
                    ], 200);
                }
                else{
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.alreadyFriends'),
                        'data' => ''
                    ], 200);
                }
               
            }
            else{
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.requestNotFound'),
                    'data' => ''
                ], 404);
            }
        }
        else
        {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validationError'),
                'data' => $this->validator->getErrors()
            ], 400);
        }
    }
    
    public function unfriend()
    {
        $rules = [
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ]
        ];
        
        if($this->validate($rules))
        {
            $user_id = $this->request->getVar('user_id');
            $friendModel = New Friend;
            $loggendInUserID = getCurrentUser()['id'];
            $friendrequestdata  =  $friendModel
            ->groupStart()
                ->where('friend_one',$loggendInUserID)
                ->where('friend_two',$user_id)
            ->groupEnd()
           
                ->orwhere('friend_two',$loggendInUserID)->GroupStart()
                ->where('friend_one',$user_id)
                ->GroupEnd()
                ->first();
            
            
            if(!empty($friendrequestdata))
            {
                $friendModel->delete($friendrequestdata['id']);
                $followerModel = New Follower;
                $checkFollwerData = $followerModel->where(['following_id'=>$user_id,'follower_id'=>$loggendInUserID])->orwhere(['follower_id'=>$user_id,'following_id'=>$loggendInUserID])->first();
                if(!empty($checkFollwerData))
                {
                    $followerModel->delete($checkFollwerData['id']);
                }
                $friendcount = $friendModel->getFriendCount($loggendInUserID);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.unfriendSuccess'),
                    'data' => $friendcount
                ], 200);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.friendRequestNotFound'),
                    'data' => ''
                ], 404);
            }
        }
        else
        {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validationError'),
                'data' => $this->validator->getErrors()
            ], 400);
        }
    }
    
    public function fetchRecommended()
    {
        $userModel = new UserModel;
        $friendModel = new Friend;
        $keyword = $this->request->getVar('keyword') ?? null;
        $gender = $this->request->getVar('gender') ?? null;
        $relation = $this->request->getVar('relation') ?? null;
        $loggedInUserID = getCurrentUser()['id'];
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;
        
        $users = $userModel->getUsersNotInFriends($loggedInUserID, $limit, $offset, $keyword, $relation, $gender);
        
        $modifiedUsers = [];
        
        foreach ($users as $user) {
            $modifiedUser = (array) $user;
            
            // Modify avatar
            $modifiedUser['avatar'] = getMedia($user->avatar, 'avatar');
            
            // Check friend data
            $checkFriendData = $friendModel->where(['friend_one' => $loggedInUserID, 'friend_two' => $user->id, 'status' => 0])->first();
            $modifiedUser['isfollowing'] = $friendModel->checkFriends($loggedInUserID, $user->id);
            $modifiedUser['ispending'] = !empty($checkFriendData) ? 1 : 0;
            $modifiedUser['details']['mutualfriendsCount'] = $friendModel->countMutualFriends($user->id, $loggedInUserID, $limit, $offset);
            
            $modifiedUsers[] = $modifiedUser;
        }
    
        $responseMessage = empty($modifiedUsers) ? lang('Api.noRecommendations') : lang('Api.recommendationsFound');

        $response = [
            'code' => '200',
            'message' => $responseMessage,
            'data' => $modifiedUsers
        ];
    
        return $this->respond($response, 200);
    }
    

    public function feriendRequest()
    {
        $loggendInUserID = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $friendModel = New Friend;
        $userModel = New UserModel;
        $modiefiedusers = [];
        $follwerModel = New Follower;
        $friendrequests = $friendModel->getFriendRequest($loggendInUserID,$limit,$offset);
        
        foreach($friendrequests as &$user)
        {
            
            $user['avatar'] = getMedia($user['avatar']);
            // $checkfolloingdata = $follwerModel->where(['following_id'=>$loggendInUserID,'follower_id'=>$user['id'],'active'=>1])->first();
            $checkfreienddata = $friendModel->where(['friend_one'=>$loggendInUserID,'friend_two'=>$user['id'],'status'=>0])->first();
            $user['isfollowing'] = $friendModel->checkFriends($loggendInUserID,$user['id']);
            $user['ispending'] = !empty($checkfreienddata)?1:0;
            $user['details']['mutualfriendsCount'] = $friendModel->countMutualFriends($user['id'],$loggendInUserID,$limit,$offset) ;    
        }
        
        $responseMessage = empty($friendRequests) ? lang('Api.noFriendRequests') : lang('Api.friendRequestsFound');

        return $this->respond([
            'code' => '200',
            'message' => $responseMessage,
            'data' => $friendrequests
        ], 200);
        
        
    }

    public function friends()
    {
        $this->data['js_files'] = ['js/friends.js'];
        return load_view('pages/friends/friends',$this->data);
    }

    public function getFriends()
    { 
        $user_id = $this->request->getVar('user_id');
        if(empty($user_id)){
            $user_id = getCurrentUser()['id'];
        }

        $userModel = New UserModel;
        $follwerModel = New Follower;
        $friendsModel = New Friend;

        
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $keyword = $this->request->getVar('keyword')??null;
        $gender = $this->request->getVar('gender')??null;
        $relation = $this->request->getVar('relation')??null;
        $friendList = $friendsModel->getFriendList($user_id,$limit,$offset,$keyword,$gender,$relation);
    
        if(!empty($friendList))
        {
            foreach($friendList as &$user)
            {
                $user['avatar'] = getMedia($user['avatar']);
                // $checkfolloingdata = $follwerModel->where(['following_id'=>$user_id,'follower_id'=>$user['id'],'active'=>1])->first();
                $checkfreienddata = $friendsModel->where(['friend_one'=>$user_id,'friend_two'=>$user['id'],'status'=>0])->first();
                $user['isfollowing'] = $friendsModel->checkFriends($user_id,$user['id']);
                $user['ispending'] = !empty($checkfreienddata)?1:0;
                $user['details']['mutualfriendsCount'] =  $friendsModel->countMutualFriends($user['id'],$user_id,$limit,$offset); 
            } 
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.friend_list_fetch'),
                'data' => $friendList,
                
            ], 200);
        }

    
        return $this->respond([
            'code' => '200',
            'message' =>lang('Api.friend_not_found'),
            'data' => $friendList
        ], 200);
       
    }

    public function getSendRequest()
    {
        $loggendInUserID = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $friendModel = New Friend;
        $userModel = New UserModel;

        $follwerModel = New Follower;
        $friendrequests = $friendModel->getSendRequestdata($loggendInUserID,$limit,$offset);
        if(!empty($friendrequests))
        {
            foreach($friendrequests as $user)
            {
                $modiefieduser = $user;
                $modiefieduser['avatar'] = getMedia($user['avatar'],'avatar');
                $checkfolloingdata = $follwerModel->where(['following_id'=>$loggendInUserID,'follower_id'=>$user['id'],'active'=>1])->first();
                $checkfreienddata = $friendModel->where(['friend_one'=>$loggendInUserID,'friend_two'=>$user['id'],'status'=>0])->first();
                $modiefieduser['isfollowing'] = $friendModel->checkFriends($loggendInUserID,$user['id']);
                $modiefieduser['ispending'] = !empty($checkfreienddata)?1:0;
                $modiefieduser['details']['mutualfriendsCount'] = 0 ; 
                $modiefiedusers[]  = $modiefieduser;
            }

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.sent_requests_fetched'),
                'data' => $modiefiedusers
            ], 200);
        }
    
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.no_sent_requests'),
            'data' => []
        ], 200);
    }
    public function changeFriendRole()
    {
        // Define validation rules with translation labels
        $rules = [
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ],
            'role' => [
                'label' => 'Role',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.role_required'),
                ]
            ]
        ];
    
        // Validate request data
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validationError'),
                'data' => $validationErrors
            ], 400);
        }
    
        // Retrieve validated data
        $user_id = $this->request->getVar('user_id');
        $role = $this->request->getVar('role');
        
        $loggedInuserId = getCurrentUser()['id'];
        
        // Check if the user is trying to add themselves
        if ($user_id == $loggedInuserId) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.cannot_add_self')
            ], 400);
        }
    
        // Initialize Friend model
        $friendModel = new Friend;
        
        // Get the friend relationship
        $friend = $friendModel->getfriendID($user_id, $loggedInuserId);
        
        // Define role array for translations
        $roleArray = [
            '2' => lang('Api.friend'),
            '3' => lang('Api.family'),
            '4' => lang('Api.business'),
        ];
        
        // Check if the friend relationship exists
        if (!empty($friend)) {
            // Update the friend role
            $friendModel->update($friend['id'], ['role' => $role]);
            return $this->respond([
                'code' => '200',
                'message' => sprintf(lang('Api.role_updated_success'), $roleArray[$role])
            ], 200);
        }
    
        return $this->respond([
            'code' => '404',
            'message' => lang('Api.user_not_found')
        ], 404);
    }
    
}
