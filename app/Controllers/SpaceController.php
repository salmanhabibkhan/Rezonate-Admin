<?php

namespace App\Controllers;

use App\Models\Block;
use App\Models\Space;


use App\Models\Friend;
use App\Models\UserModel;
use App\Models\SpaceMember;
use App\Models\TransactionModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class SpaceController extends BaseController
{
    use ResponseTrait;
    public function createSpace()
    {
        $rules = [
            'title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.title_required'),
                ]
            ],
            'privacy' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.privacy_required'),
                    'integer' => lang('Api.privacy_integer'),
                ]
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.description_required'),
                ]
            ],
        ];
    
        if ($this->validate($rules)) {
            $user_id = getCurrentUser()['id'];
           
            $spaceModel = new Space;
            $spaceModel->where('user_id',$user_id)->set(['status'=>2])->update();
            $data = [
                'user_id' => $user_id,
                'title' => $this->request->getVar('title'),
                'privacy' => $this->request->getVar('privacy'),
                'is_paid' => !empty($this->request->getVar('is_paid'))?1:0,
                'amount' => $this->request->getVar('amount')??0, 
                'description' => $this->request->getVar('description'),
                'agora_access_token' => $this->request->getVar('agora_access_token'),

            ];
            if ($spaceModel->save($data)) {
                $data['id'] = (string)$spaceModel->insertID();
                $spaceMemberModel = new SpaceMember;
                $memberdata = [
                    'space_id' => $spaceModel->insertID(),
                    'user_id' => $user_id,
                    'is_host' => 1,
                    'is_cohost' => 0,
                    'is_speaking_allowed' => 1,
                ];
                $spaceMemberModel->save($memberdata);
                $spacememberdata = $spaceMemberModel->find($spaceMemberModel->insertID());
                $userModel = new UserModel;
                $userdata = $userModel->select(['first_name', 'last_name', 'avatar'])->where('id', $user_id)->first();
                $spacememberdata['first_name'] = $userdata['first_name'];
                $spacememberdata['last_name'] = $userdata['last_name'];
                $spacememberdata['avatar'] = !empty($userdata['avatar']) ? base_url($userdata['avatar']) : "";
                $data['members'] = $spacememberdata;
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.space_created_successfully'),
                    'data' => $data
                ], 200);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function updateSpace()
    {
        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $spaceModel =  new Space;
            $user_data = getCurrentUser();
            $space_id = $this->request->getVar('space_id');
            // Check ownership
            $space_data = $this->checkOwnership($space_id);

            if ($space_data == 200) {
                // Get all input data
                $data = [];

                // Loop through all input values and add them to the update array
                foreach ($this->request->getPost() as $key => $value) {
                    // Exclude the 'job_id' from the update array
                    if ($key != 'job_id') {
                        $data[$key] = $value;
                    }
                }

                // Handle file upload for cover or avatar if needed

                // Corrected the object name to $job instead of $group
                $spaceModel->update($space_id, $data); // Change 'group' to 'job'

                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.space_updated_successfully'),
                    'data' => $data
                ], 200);
            } elseif ($space_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.space_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }
    public function checkOwnership($space_id)
    {
        $user_data = getCurrentUser();
        $spaceModel = new Space();
        $space_data = $spaceModel->where('id', $space_id)->first();

        if (!empty($space_data)) {
            if ($space_data['user_id'] == $user_data['id']) {
                return 200;
            } else {
                return 401;
            }
        } else {
            return 404;
        }
    }
    public function deleteSpace()
    {
        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $spaceModel =  new Space;
            $user_data = getCurrentUser();
            $space_id = $this->request->getVar('space_id');

            // Check ownership
            $space_data = $this->checkOwnership($space_id);

            if ($space_data == 200) {


                $spaceModel->update($space_id,['status'=>2]);

                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.space_deleted_successfully'),
                    'data' => ''
                ], 200);
            } elseif ($space_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.space_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function joinSpace()
    {
        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => 'Validation Error',
                'data' => $validationErrors
            ], 200);
        }
            $spacememberModel = new SpaceMember;
            $user_id = getCurrentUser()['id'];
            $space_id = $this->request->getVar('space_id');
            $spaceModel = New Space;
            $space =$spaceModel->find($space_id);

            if (empty($space)) {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.space_not_found'),
                ]);
            }
        
            if ($space['user_id'] == $user_id) {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.cannot_join_own_space'),
                ]);
            }
            $checkOldData = $spacememberModel->where(['user_id' => $user_id, 'space_id' => $space_id, 'status' => 1])->first();
            if (!empty($checkOldData)) {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.already_member_of_space'),
                ]);
            }
            if($space['is_paid']==1)
            {
                if($space['amount']>getuserwallet($user_id)){
                    return $this->respond([
                        'code' => '400',
                        'message' => lang('Api.insufficient_balance'),
                    ]);
                }

                $transactionModel = New TransactionModel();
                $credit_transaction = [
                    'user_id'=>$space['user_id'],
                    'flag'=>'C',
                    'action_type'=>13,
                    'amount'=>$space['amount'],
                ];
                $transactionModel->save($credit_transaction);
                $debit_transaction = [
                    'user_id'=>$user_id,
                    'flag'=>'D',
                    'action_type'=>13,
                    'amount'=>$space['amount'],
                ];
                $transactionModel->save($debit_transaction);
            }
            $spaceMemberData = [
                    'user_id' => $user_id,
                    'space_id' => $space_id,
                    'status' => 1             
            ];
            $spacememberModel->save($spaceMemberData);
            $member = $space['members'] +1;
            $spaceModel->update($space['id'],['members'=>$member]);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.space_joined_successfully'),
            ]);
        
    }
    public function leaveSpace()
    {

        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
        ];
        if ($this->validate($rules)) {
            $spacememberModel = new SpaceMember;
            $user_id = getCurrentUser()['id'];
            $space_id = $this->request->getVar('space_id');
            $checkOldData = $spacememberModel->where(['user_id' => $user_id, 'space_id' => $space_id, 'status' => 1])->first();
            if (empty($checkOldData)) {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.not_member_of_space'),
                ], 404);
            } else {
                if ($checkOldData['is_host'] == 1) {
                    $spacememberModel->deletememberBySpaceId($space_id);
                    $spaceModel = new Space;
                    $spaceModel->update($space_id,['status'=>2]);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.space_left_successfully'),
                        'data'=>''
                    ], 200);
                } else {
                    $spacememberModel->delete($checkOldData['id']);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.space_left_successfully'),
                        'data' => ''
                    ], 200);
                }
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }
    public function makeCoHost()
    {
        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ]
        ];
    
        if ($this->validate($rules)) {
            $spacememberModel = new SpaceMember;
            $user_id = getCurrentUser()['id'];
            $space_id = $this->request->getVar('space_id');
            $checkOldCoHost = $spacememberModel->where(['user_id' => $user_id, 'space_id' => $space_id, 'status' => 1, 'is_cohost' => 1])->first();

            if (!empty($checkOldCoHost)) {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.already_cohost'),
                    'data' => ''
                ], 200);
            } else {
                $getId = $spacememberModel->where(['user_id' => $user_id, 'space_id' => $space_id, 'status' => 1])->first();
                if (!empty($getId)) {
                    $spacememberModel->update($getId['id'], ['is_cohost' => 1]);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.cohost_created_successfully'),
                        'data' => ''
                    ], 200);
                } else {
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.user_not_member_of_space'),
                        'data' => ''
                    ], 200);
                }
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }
    public function removeCohost()
{
    $rules = [
        'space_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => lang('Api.space_id_required'),
            ]
        ],
        'user_id' => [
            'rules' => 'required',
            'errors' => [
                'required' => lang('Api.user_id_required'),
            ]
        ]
    ];

    if ($this->validate($rules)) {
        $spacememberModel = new SpaceMember;
        $user_id = getCurrentUser()['id'];
        $space_id = $this->request->getVar('space_id');
        $checkOldCoHost = $spacememberModel->where([
            'user_id' => $user_id, 
            'space_id' => $space_id, 
            'status' => 1, 
            'is_cohost' => 1
        ])->first();

        if (!empty($checkOldCoHost)) {
            $spacememberModel->update($checkOldCoHost['id'], ['is_cohost' => 0]);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.cohost_removed_successfully'),
                'data' => ''
            ], 200);
        } else {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.not_a_cohost'),
                'data' => ''
            ], 200);
        }
    } else {
        $validationErrors = $this->validator->getErrors();
        return $this->respond([
            'code' => '404',
            'message' => lang('Api.validation_error'),
            'data' => $validationErrors
        ], 404);
    }
}

    public function getSpace()
    {
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;
        $blockModel = new Block;
        $friendsModel = new Friend;
        $loggedInUser = getCurrentUser()['id'];
        $get_blocked_users = $blockModel->getblockuser($loggedInUser);
        $get_friends_users = $friendsModel->getFriendIds($loggedInUser);

        $db = \config\Database::connect();
        $builder = $db->table('spaces');
        $builder->where('status', 1);
        $builder->where('user_id !=', $loggedInUser);

        if (!empty($get_blocked_users)) {
            $builder->whereNotIn('user_id', $get_blocked_users);
        }

        $builder->groupStart();
        $builder->where('privacy', 0);

        if (!empty($get_friends_users)) {
            $builder->orGroupStart();
            $builder->where('privacy', 1);
            $builder->whereIn('user_id', $get_friends_users);
            $builder->groupEnd();
        }

        $builder->groupEnd();
        $builder->limit($limit, $offset);
        $query = $builder->get();

        $spaces = $query->getResult();

        if (!empty($spaces)) {
            foreach ($spaces as &$space) {
                $membersModel = new SpaceMember;
                $users = $membersModel->getUserById($space->id);
                $space->listners_count = $membersModel->getspacemembercount($space->id);
                $space->members = $users;
            }

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.spaces_fetched_successfully'),
                'data' => $spaces
            ], 200);
        }

        return $this->respond([
            'code' => '404',
            'message' => lang('Api.no_data_found'),
            'data' => $spaces
        ], 404);
    }

    public function getSpaceMember()
    {
        $rules = [
            'space_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.space_id_required'),
                ]
            ],
        ];
        $modiefiedMembers = [];

        if ($this->validate($rules)) {

            $space_id = $this->request->getVar('space_id');
            $spaceMemberModel = new SpaceMember;
            $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
            $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
            
            $spaceMembers = $spaceMemberModel->getAllUserofSpace($space_id, $limit, $offset);
           
            foreach ($spaceMembers as $member) {
                $modiefiedMember = $member;
                $modiefiedMember['avatar'] = !empty($member['avatar']) ? getMedia(($member['avatar'])) : "";
                $modiefiedMembers[] = $modiefiedMember;
            }
            
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.members_fetched_successfully'),
            'data' => $modiefiedMembers
        ], 200);
    } else {
        $validationErrors = $this->validator->getErrors();
        return $this->respond([
            'code' => '404',
            'message' => lang('Api.validation_error'),
            'data' => $validationErrors
        ], 404);
    }
    }
    public function searchSpace()
    {
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
        $blockModel = New Block;
        $friendsModel = New Friend;
        $search_title = $this->request->getVar('title');
        $loggedInUser = getCurrentUser()['id'];
        $get_blocked_users = $blockModel->getblockuser($loggedInUser);
        $get_friends_users = $friendsModel->getFriendIds($loggedInUser);
        $db = \config\Database::connect();
        $builder = $db->table('spaces');
        $builder->where('deleted_at', null);

        if (!empty($get_blocked_users)) {
            $builder->whereNotIn("user_id",$get_blocked_users);
        }
        $builder->groupStart();
        $builder->where('privacy', 0);
        if (!empty($search_title)) {
            $builder->like('title', $search_title);
        }
        if (!empty($get_friends_users)) {
            $builder->orGroupStart();
            $builder->where('privacy', 1);
            $builder->whereIn('user_id', $get_friends_users);
            $builder->groupEnd();
        }

        $builder->groupEnd();
        $builder->limit($limit, $offset);
        $query = $builder->get();
    
        $spaces = $query->getResult();
   
// Fetch results or handle the query as needed


        if (!empty($spaces)) {
            foreach ($spaces as &$space) {
                $membersModel = new SpaceMember;
                $users = $membersModel->getUserById($space->id);
                $space->listners_count = $membersModel->getspacemembercount($space->id);
                $space->members = $users;  
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Messages.spaces_data_fetched_successfully'),
                'data' => $spaces
            ], 200);
        }
        return $this->respond([
            'code' => '404',
            'message' => lang('Messages.no_data_found'),
            'data' => ''
        ], 404);
    }
}
