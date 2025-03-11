<?php

namespace App\Controllers;

use App\Models\PostModel;
use DateTime;
use App\Models\Group;
use Firebase\JWT\JWT;
use App\Models\UserModel;
use App\Models\GroupMember;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\GroupCategory;
use CodeIgniter\RESTful\ResourceController;

class GroupController extends BaseController
{
    use ResponseTrait;

    public function groupProfile($group_name,$section="posts")
    {
        $groupModel = new Group;
        $groupMemberModel = new GroupMember;

        // Retrieve the group by group_name instead of id
        $group = $groupModel->where('group_name', $group_name)->first();

        if (!$group) {
            // Handle the case where the group doesn't exist
            // You might want to redirect to a different page or show an error message
        return; // Adjust as needed
        }
        $this->data['userdata'] = getCurrentUser();
        $user_id =  $this->data['userdata']['id'];
        $this->data['section'] = $section;
        $this->data['group'] = $group;
        $this->data['js_files'] = [ 'js/posts.js',
								    'js/jquery.uploader.min.js',
								    'js/vanillaEmojiPicker.min.js',
								    'vendor/zuck.js/dist/zuck.min.js',
								    'vendor/imagepopup/imagepopup.min.js',
                                    'js/post_plugins.js',
                                    'vendor/imagepopup/js/lightbox.min.js',
								];
		$this->data['css_files'] = ['css/jquery.uploader.css',
                                    'css/posts_plugins.css',
									'css/posts.css','vendor/zuck.js/dist/zuck.min.css',
									'vendor/imagepopup/imagepopup.min.css'];
        $this->data['group']['is_admin'] = ($groupMemberModel->where([
            'user_id' => $this->data['user_data']['id'],
            'group_id' => $group['id'],
            'is_admin' => 1
        ])->countAllResults() > 0) ? true : false;
        $this->data['group']['is_joined'] = $groupMemberModel->where([
            'user_id' => $this->data['user_data']['id'],
            'group_id' => $group['id'],
        ])->countAllResults() > 0;
        $this->data['unjoined_groups'] = $groupModel->getUnJoinedGroups($user_id,5,0);
        
        $this->data['group_short_members'] = $groupMemberModel->getGroupShortMembers($group['id']);

        $this->data['groupmembers'] = $groupMemberModel->getGroupMembers($group['id']);
          
        echo load_view('pages/groups/group_profile', $this->data);
    }


    public function allGroups()
    {
        $user_data = getCurrentUser();
        $groups = [];
        $user_id = $user_data['id'];
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $model  = New Group;
        $groups = $model->where('user_id !=',$user_id)->findAll($limit, $offset);
        if(!empty($groups))
        {
            foreach($groups as &$group)
            {
                $group['category'] = GROUP_CATEGORIES[$group['category']];
                $group['avatar'] = !empty($group['avatar'])?getMedia($group['avatar']):''; 
                $group['cover'] = !empty($group['cover'])?getMedia($group['cover']):'';
                $group['is_group_owner'] = ($group['user_id']==$user_id)?true:false ;  
                $groupMemberInfo = $model->checkMemberStatus($group['id'], $user_id);
                $group['is_joined'] = empty($groupMemberInfo) ? '0' : '1';
                $group['is_admin'] = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.groups_fetched_successfully'),
                    'data' => $groups
                ], 200);
            }
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.no_groups_found'),
                'data' => []
            ], 400);

    
    }
    public function userGroups()
    {
       
        $user_id =getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $model  = New Group;
        $groups = [];
        $groups = $model->where('user_id', $user_id)->orderBy('id','desc')->findAll($limit, $offset);
        if(!empty($groups))
        {
            foreach($groups as &$group)
            {
                $group['category'] = GROUP_CATEGORIES[$group['category']];
                $group['avatar'] = !empty($group['avatar'])?getMedia($group['avatar']):''; 
                $group['cover'] = !empty($group['cover'])?getMedia($group['cover']):'';
                $group['is_group_owner'] = true;        
                $group['is_joined'] = '1';
   
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.user_groups_fetched_successfully'),
                'data' => $groups
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.no_user_groups_found'),
            'data' => $groups
        ], 200);

    }

 
    public function allWebGroups()
    {
      
        $user_id = getCurrentUser()['id'];
        $page = (int) ($this->request->getVar('page') ?? 1);
        $choice = $this->request->getVar('choice');
        $model = new Group();
        $group_member = new GroupMember();
        $postModel = new PostModel();
        $perPage = 12;
        $pager = service('pager');
        
        $query = $model->where('user_id !=', $user_id);
        
        if ($choice == null) {
            $query->orderBy('id', 'desc');
        } elseif ($choice == 'AB') {
            $query->orderBy('group_title', 'asc');
        }
        
        $groups = $query->paginate($perPage);
        
        if (!empty($groups)) {
            foreach ($groups as &$group) {
                $group['category'] = GROUP_CATEGORIES[$group['category']];
                $group['avatar'] = getMedia($group['avatar']);
                $group['cover'] = getMedia($group['cover']);
                $group['is_group_owner'] = false;
                $group['post_count'] = $postModel->where('group_id', $group['id'])->countAllResults();
                $group['is_group_joined'] = $group_member
                    ->where(['group_id' => $group['id'], 'user_id' => $user_id, 'active' => 1])
                    ->countAllResults() > 0;
            }
        }
        
        $this->data['choice'] = $choice;
        $this->data['groups'] = $groups;
        $total = $model->where('user_id !=', $user_id)->countAllResults();
      
        
        $this->data['pager_links'] = $pager->makeLinks($page, $perPage, $total, 'socio_custom_pagination');
        $this->data['pager'] = $pager;
        
        echo load_view('pages/groups/all-groups', $this->data);
        

    }
    public function myGroups()
    {
        $user_data = getCurrentUser();
        $user_id   = $user_data['id'];
       
        $page = (!empty($this->request->getVar('page'))) ? $this->request->getVar('page') : 1;
        $model     = new Group();
        $postModel =  New PostModel();
        $perPage = 12;
        $pager = service('pager');      
        $groups    = $model->where('user_id', $user_id)->orderBy('id','desc')->paginate($perPage);
        if (!empty($groups)) {
            foreach ($groups as &$group) {
                $group['category'] = GROUP_CATEGORIES[$group['category']];
                $group['avatar'] = getMedia($group['avatar']);
                $group['cover'] = getMedia($group['cover']);
                $group['is_group_owner'] = true;   
                $group['post_count'] = $postModel->where('group_id',$group['id'])->countAllResults();
                $group['is_joined'] = $model->checkMemberStatus($group['id'],$user_id);
            }
        }
        $total   = $model->where('user_id!=', $user_id)->countAllResults();
        $this->data['pager_links'] = $pager->makeLinks($page, $perPage, $total, 'socio_custom_pagination');
        $this->data['groups'] = $groups;
     
        echo load_view('pages/groups/my-groups', $this->data);
    }
    public function createGroup()
	{
        $categoriesModel  = New GroupCategory();
        $this->data['categories'] = $categoriesModel->findAll();
        echo load_view('pages/groups/create-group',$this->data);   
	}

    public function addGroup()
    {
        $rules = [
            'group_title' => [
                'label' => 'Group Title',
                'rules' => 'required|regex_match[/^[a-zA-Z0-9 ]+$/]',
                'errors' => [
                    'required' => lang('Api.group_title_required'),
                    'regex_match' => lang('Api.group_title_invalid_characters'),
                ]
            ],
            'about_group' => [
                'label' => 'About Group',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.about_group_required'),
                ]
            ],
            'category' => [
                'label' => 'Category',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.category_required'),
                ]
            ],
            'privacy' => [
                'label' => 'Privacy',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.privacy_required'),
                ]
            ],
        ];
         if ($this->validate($rules)) {
             $group = New Group;              
             $groupMemberModel = New GroupMember();
             $user_data = getCurrentUser();
             
            $groupTitle = $this->request->getVar('group_title');
            $baseGroupName = url_title($groupTitle, '-', true); // Sanitized group name
             // Further sanitize to remove any remaining special characters
            $baseGroupName = preg_replace('/[^A-Za-z0-9\-]/', '', $baseGroupName); 

            $uniqueGroupName = $baseGroupName;
            $counter = 1;

            // Check if the group name already exists and modify it if necessary
            while ($group->where('group_name', $uniqueGroupName)->first()) {
                $uniqueGroupName = $baseGroupName . '-' . $counter;
                $counter++;
            }
            $data = [
                'user_id'=>$user_data['id'],
                'group_title'=> $this->request->getVar('group_title'),
                'group_name' => $uniqueGroupName,
                'about_group'=> $this->request->getVar('about_group'),
                'category'=> $this->request->getVar('category'),
                'privacy'=> $this->request->getVar('privacy'),
                'members_count'=>1
            ];
            $groupcover = $this->request->getFile('cover');
           
            if(!empty($groupcover) && $groupcover->isValid() && $groupcover->getSize() > 0){
                $data['cover']= storeMedia($groupcover,'cover');
            }
            $groupavatar = $this->request->getFile('avatar');
             if(!empty($groupavatar))
             {   
                $data['avatar'] = storeMedia($groupavatar,'avatar');
             }
            $group->save($data);
            $groupId  = $group->insertID();
            $groupAdminData = [
                'group_id'=>$groupId,
                'user_id'=>$user_data['id'],
                'is_admin'=>1
            ];
             
            $groupMemberModel->save($groupAdminData);
            $groupResponse = $group->getCompiledGroupData($groupId,$user_data['id']);
           
             return $this->respond([
                'code' => '200',
                'message' => lang('Api.group_created_successfully'),
                'data' => $groupResponse
            ], 200);
        }
        else
        {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
    }
    public function getGroupData()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        if ($this->validate($rules)) {
            $model = new Group();
            $group_id = $this->request->getVar('group_id');
            
            $group_model = new Group();
            $group = $group_model->getCompiledGroupData($group_id,$user_id);
            
            if(!empty($group))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.group_data_fetch_success'),
                    'data' => $group
                ], 200);
            }
            return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.group_data_not_found'),
                    'data' => ''
                ], 404);
            
             
        }
        else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $validationErrors
            ], 403);
            // Send a JSON response or render a view with validation errors
        }
    }
    
    public function updateGroup()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
    
        if ($this->validate($rules)) {
            $group = new Group;
            $user_data = getCurrentUser();
            $group_id = $this->request->getVar('group_id');
    
            // Check ownership
            $group_data = $this->checkOwnership($group_id);
    
            if ($group_data == 200) {
                // Get all input data
                $data = [];

            // Loop through all input values and add them to the update array
                foreach ($this->request->getPost() as $key => $value) {
                    // Exclude the 'page_id' from the update array
                    if ($key != 'group_id') {
                        $data[$key] = $value;
                    }
                }
                $groupcover = $this->request->getFile('cover');
                $groupavatar = $this->request->getFile('avatar');
                if(!empty($groupcover)&& $groupcover->isValid()){
                  
                   $groupcoverPath = storeMedia($groupcover,'cover');
                   $data['cover'] = $groupcoverPath;
                }
                if(!empty($groupavatar)  && $groupavatar->isValid())
                {
                   $groupavatarPath = storeMedia($groupavatar,'avatar');
                    $data['avatar'] = $groupavatarPath;
                }
    
                // Handle file upload for cover or avatar if needed
                
                $group->update($group_id, $data);

                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.group_update_success'),
                    'data' => $data
                ], 200);
            } elseif ($group_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.unauthorized_access'),
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                   'message' => lang('Api.group_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON($validationErrors);
        }
    }
    public function deleteGroup()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
        if ($this->validate($rules)) {
            $group = new Group();
            $group_id = $this->request->getPost('group_id');
          
            $group_data = $this->checkOwnership($group_id);
            if($group_data==200)
            {
                $group->delteGroupById($group_id);
                return $this->respond([
                    'code' => '200',
                    'message' => 'The group is deleted successfully',
                    'data' => "success"
                ], 200);
            }
            elseif($group_data==401)
            {
                return $this->respond([
                    'code' => '401',
                    'message' => 'You are not allowed',
                    'data' => "success"
                ], 401);
            }
            else{
                return $this->respond([
                    'code' => '404',
                    'message' => 'Group Not found',
                    'data' => "not found"
                ], 404);
            }
        }  
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON($validationErrors);
        }
    }
    public function checkOwnership($group_id)
    {
        $user_data = getCurrentUser();
        $model = New Group;
        $group_data = $model->where('id',$group_id)->first();
        
        if(!empty($group_data))
        {
            if($group_data['user_id']==$user_data['id'])
            {
                return 200;
            }
            else{
                return 401;
            }
            
        }
        else{
           return 404;
        }
    }
    public function joinGroup()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        if ($this->validate($rules)) {
            $group = new Group();
            $group_id = $this->request->getVar('group_id');
            $group_data = $group->find($group_id);
            if(empty($group_data))
            {
                return $this->respond([
                    'code' => '400',
                  'message' => lang('Api.group_not_found'),
                    'data' => ""
                ], 200);
            }
            $group_member = New GroupMember;
            $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1])->first();
            if(!empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.already_member'),
                    'data' => ""
                ], 200);
            } 
            else{
                $data= [
                    'user_id'=>$user_id,
                    'group_id'=>$group_id,
                    'active'=>1
                ];
               
                $group_member->save($data);
                // Create Notification 
               
                $userModel = New UserModel();
                $user_device = $userModel->select(['device_id','notify_joined_group','email'])->where('id', $group_data['user_id'])->first();
                if(get_setting('chck-emailNotification')==1)
                {
                    sendmailnotificaiton($user_device['email'],'Joined Group',"joined your group .");
                }
                if(!empty($user_device) && $user_device['notify_joined_group'] == 1 && $user_id != $group_data['user_id'] )
                {
                    $notificationModel = New NotificationModel();
                    $notificationdata = [
                        'from_user_id'=>$user_data['id'],
                        'to_user_id'=>$group_data['user_id'],
                        'group_id'=>$group_id,
                        'type'=>'Join-group',
                        'text'=>'joined your group.',
                    ];
                    $notificationModel->save($notificationdata);                    
                    sendPushNotification($user_device['device_id'],'joined your group');
                }
                $groupModel  =New Group;
                $groupModel->incrementGroupMembers($group_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.group_join_success'),
                    'data' => ""
                ], 200);
            }  
        }  
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $validationErrors
            ], 200);
        }
    }   
    public function leaveGroup()
    {
      
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
    
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        if ($this->validate($rules)) {
            $group = new Group();
            $group_id = $this->request->getVar('group_id');
            $group_member = New GroupMember;
            $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1])->first();
            
            if(empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.not_member'),
                    'data' => ""
                ], 200);
            } 
            
            else{
                $group_member->delete($checkmemberexistence['id']);
                $groupModel = New Group;
                $groupModel->decrementGroupMembers($group_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.group_left_success'),
                    'data' => ""
                ], 200);
            }  
        }  
        else{
        $validationErrors = $this->validator->getErrors();
        return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $validationErrors
            ], 200);
             
        }
    }
    public function joinedGroups()
    {
        $groupModel = New Group;
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $user_id = getCurrentUser()['id'];
        $groups = $groupModel->getJoinedGroups($user_id,$limit,$offset);
        if(!empty($groups))
        {
           
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.groups_fetched_successfully'),
                'data' => $groups
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' =>  lang('Api.no_data_found'),
            'data' => $groups
        ], 200);
             
        
    }
    public function addGroupMember()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ],
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ]
        ];
        $user_data = getCurrentUser();
        $loggedInUserId = $user_data['id'];
        if ($this->validate($rules)) {
            $group = new Group();
            $group_id = $this->request->getVar('group_id');
            $user_id = $this->request->getVar('user_id');
            $group_member = New GroupMember;
            $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1])->first();
            if(!empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.member_already_in_group'),
                    'data' => ""
                ], 200);
            } 
            else{
                $data= [
                    'user_id'=>$user_id,
                    'group_id'=>$group_id,
                    'active'=>1,
                    'created_by'=>$loggedInUserId
                ];
                $group_member->save($data);
                $groupModel  =New Group;
                $groupModel->incrementGroupMembers($group_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.member_added_successfully'),
                    'data' => ""
                ], 200);
            }  
        }  
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
    }
    public function removeMember()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ],
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ],
        ];
        $loggedInUserId = getCurrentUser()['id'];
        
        if ($this->validate($rules)) {
            $group = new Group();
            $group_id = $this->request->getVar('group_id');
            $user_id = $this->request->getVar('user_id');
            $group_member = New GroupMember;
            $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1])->first();
            
            if(empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.user_not_member'),
                    'data' => ""
                ], 200);
            } 
            
            else{
               
                $data = [
                    'removed_by'=>$loggedInUserId,
                    'deleted_at'=>date('Y-m-d H:i:s')

                ];
                $group_member->update($checkmemberexistence['id'],$data);
                
                $groupModel = New Group;
                $groupModel->decrementGroupMembers($group_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.member_removed_successfully'),
                    'data' => ""
                ], 200);
            }  
        }  
        else{
        $validationErrors = $this->validator->getErrors();
        return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $validationErrors
            ], 200);
             
        }
    }
    public function getGroupMembers()
    { 
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ]
        ];
    
        if(!$this->validate($rules))
        {

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $this->validator->getErrors()
            ], 200);
        }
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6; 
        $group_id = $this->request->getVar('group_id');
        $groupModel = New Group;
        $members = $groupModel->getMembersInGroup($group_id,$limit,$offset);
        if(!empty($members))
        {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.group_members_fetched_successfully'),
                'data' => $members
            ], 200);
        }
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.group_members_not_found'),
            'data' => $members
        ], 200);   
    }
    public function createAdmin()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ],
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '200',
               'message' => lang('Api.validation_error'),
                'validation_error' => $validationErrors
            ], 200);
        }
        $group = new Group();
        $group_id = $this->request->getVar('group_id');
        $user_id = $this->request->getVar('user_id');
        $group_member = New GroupMember;
        $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1])->first();
        if(empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.user_not_member'),
                    'data' => ""
                ], 200);
            } 
            
            else{
               
                $data = [
                    'is_admin'=>1,
                    
                ];
                $group_member->update($checkmemberexistence['id'],$data);
                
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.admin_creation_success'),
                ], 200);
                   
            }  

    }
    public function dismissAdmin()
    {
        $rules = [
            'group_id' => [
                'label' => 'Group ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.group_id_required'),
                ]
            ],
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ]
            ]
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'validation_error' => $validationErrors
            ], 200);
        }
        $group = new Group();
        $group_id = $this->request->getVar('group_id');
        $user_id = $this->request->getVar('user_id');
        $group_member = New GroupMember;
        $checkmemberexistence = $group_member->where(['group_id'=>$group_id,'user_id'=>$user_id,'active'=>1,'is_admin'=>1])->first();
        if(empty($checkmemberexistence))
            {
                return $this->respond([
                    'code' => '200',
                  'message' => lang('Api.not_group_admin'),
                    'data' => ""
                ], 200);
            } 
            
            else{
               
                $data = [
                    'is_admin'=>0,
                    
                ];
                $group_member->update($checkmemberexistence['id'],$data);
                
                return $this->respond([
                    'code' => '200',
                   'message' => lang('Api.admin_dismiss_success'),
                   
                ], 200);
            }  

    }
    public function editWebGroup($id)
    {
        $groupModel  = New Group;
        $this->data['group'] = $groupModel->find($id);
        if($this->data['group']['user_id'] == getCurrentUser()['id'])
        {
            $categoriesModel  = New GroupCategory();
            $this->data['categories'] = $categoriesModel->findAll();
            echo load_view('pages/groups/edit-group',$this->data);   
        }
        else{
        }
    }
    public function groupWebDetails($id)
    {
        $groupModel  = New Group;
        $groupMemberModel = New GroupMember;
       
        $this->data['group'] = $groupModel->find($id);
        $this->data['group']['is_admin'] = ($groupMemberModel->where(['user_id'=>$this->data['user_data']['id'],'is_admin'=>1])->countAllResults()>0)?true:false;   
        
        $this->data['groupmembers'] = $groupMemberModel->getGroupMembers($id);
        
        echo load_view('pages/groups/group-details',$this->data);   
        
    }
    public function getMyGroup()
    {
        $user_id = getCurrentUser()['id'];
        $groupModel = New Group;
        $groups = $groupModel->getusergroup($user_id);
        if(!empty($groups))
        {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.groups_fetch_success'),
                'data'=>$groups
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.user_groups_not_found'),

        ], 200);
    }
    
}
