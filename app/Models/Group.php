<?php

namespace App\Models;

use CodeIgniter\Model;

class Group extends Model
{
    protected $table            = 'groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = ['user_id','group_name','group_title','avatar','cover','about_group','category','sub_category','privacy','join_privacy','active','registered','members_count'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    



    public function getCompiledGroupData($group_id,$loggedInUserId=0){
            
            $group = $this->where('id',$group_id)->first();

            if(!empty($group))
            {
               
                $group['avatar'] = !empty($group['avatar'])?getMedia($group['avatar']):''; 
                $group['cover'] =  !empty($group['cover'])?getMedia($group['cover']):'';
                $group['is_group_owner'] = ($group['user_id']==$loggedInUserId)?true:false ;  
                $group['category'] = GROUP_CATEGORIES[$group['category']];
              
                $groupMemberInfo = $this->checkMemberStatus($group['id'], $loggedInUserId);
                $group['is_joined'] = empty($groupMemberInfo) ? '0' : '1';
                $group['is_admin'] = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;
                
                return $group;
            }else{
                return null;
            }
    }



    public function incrementGroupMembers($groupId)
    {
        
        $group = $this->find($groupId);

            if (!empty($group)) {
                
                $this->where('id', $groupId)->set('members_count', 'members_count + 1', false)->update();
    
                return true;
            }

        return false;
    }
    public function decrementGroupMembers($groupId)
    {
        // Ensure $groupId is valid and exists in the database
        $group = $this->find($groupId);

        if (!empty($group) && $group['members_count'] > 0) {
            // Decrement the members_count field
            $this->where('id', $groupId)->set('members_count', 'members_count - 1', false)->update();

            return true;
        }

        return false;
    }
    public function getUnJoinedGroups($userId,$limit,$offset)
    {
 
        $groups =  $this
        ->distinct()
        
        ->where('user_id!=',$userId)
      
        ->findAll($limit,$offset);
        foreach($groups as &$group)
        {
            $groupMemberInfo = $this->checkMemberStatus($group['id'], $userId);
            $group['is_joined'] = empty($groupMemberInfo) ? '0' : '1';
            $group['cover'] = getMedia($group['cover']);
            $group['is_admin'] = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;
            $group['is_group_owner'] = ($group['user_id']==$userId)?true:false;
        }
        return $groups;
    }
    public function getJoinedGroups($userId, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $groups = $this
            ->select($dbPrefix.'groups.id')
            ->join($dbPrefix.'group_members', $dbPrefix.'groups.id = '.$dbPrefix.'group_members.group_id')
            ->where($dbPrefix.'group_members.user_id', $userId)
            ->where($dbPrefix.'groups.deleted_at', null) // Exclude soft-deleted groups
            ->where($dbPrefix.'group_members.deleted_at', null)
            ->where($dbPrefix.'groups.user_id !=', $userId) // Exclude soft-deleted memberships
            ->findAll($limit, $offset);
    
        foreach ($groups as &$group) {
            $group = $this->getCompiledGroupData($group['id'], $userId);
        }
    
        return $groups;
    }
    
    public function getJoinedGroupsIds($userId)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $groupIDs = $this->select($dbPrefix.'groups.id')
            ->join($dbPrefix.'group_members', $dbPrefix.'groups.id = '.$dbPrefix.'group_members.group_id')
            ->where($dbPrefix.'group_members.user_id', $userId)
            ->where($dbPrefix.'groups.deleted_at', null) // Exclude soft-deleted groups
            ->where($dbPrefix.'group_members.deleted_at', null) // Exclude soft-deleted memberships
            ->findAll();
    
        return array_column($groupIDs, 'id');
    }
    
    public function getMembersInGroup($groupId, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
        $modifiedmembers = [];
        $members = $this
            ->select([$dbPrefix.'users.id', $dbPrefix.'users.is_verified', $dbPrefix.'users.username', $dbPrefix.'users.first_name', $dbPrefix.'users.last_name', $dbPrefix.'users.avatar', $dbPrefix.'users.cover', $dbPrefix.'users.gender', $dbPrefix.'users.level', $dbPrefix.'users.role', $dbPrefix.'group_members.is_admin as isAdmin'])
            ->join($dbPrefix.'group_members', $dbPrefix.'groups.id = '.$dbPrefix.'group_members.group_id')
            ->join($dbPrefix.'users', $dbPrefix.'group_members.user_id = '.$dbPrefix.'users.id')
            ->where($dbPrefix.'groups.id', $groupId)
            ->where($dbPrefix.'groups.deleted_at', null)
            ->where($dbPrefix.'group_members.deleted_at', null)
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll($limit, $offset);

        foreach ($members as $member) {
            $modifiedmember = $member;
            $modifiedmember['avatar'] = !empty($member['avatar']) ? getMedia($member['avatar']) : '';
            $modifiedmember['cover'] = !empty($member['cover']) ? getMedia($member['cover']) : '';
            $modifiedmember['isAdmin'] = ($member['isAdmin'] == 1) ? 1 : 0;

            $modifiedmembers[] = $modifiedmember;
        }
        return $modifiedmembers;
    }

    
    
    public function getSearchedGroups($search_string, $limit, $offset)
    {
        $user_id = getCurrentUser()['id'];
        $groups = $this->like('group_title', $search_string)->findAll($limit, $offset);
        $modifiedgroups = [];

        if (!empty($groups)) {
            foreach ($groups as $group) {
                $modifiedgroup = $group;
                $modifiedgroup['category'] = GROUP_CATEGORIES[$group['category']];
                $modifiedgroup['avatar'] = !empty($group['avatar']) ? getMedia($group['avatar']) : '';
                $modifiedgroup['cover'] = !empty($group['cover']) ? getMedia($group['cover']) : '';
                $modifiedgroup['is_group_owner'] = ($group['user_id'] == $user_id) ? true : false;

                $groupMemberInfo = $this->checkMemberStatus($group['id'], $user_id);
                $modifiedgroup['is_joined'] = empty($groupMemberInfo) ? '0' : '1';
                $modifiedgroup['is_admin'] = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;

                $modifiedgroups[] = $modifiedgroup;
            }
        }

        return $modifiedgroups;
    }

    public function checkMemberStatus($group_id,$user_id)
    {
        $groupMemberModel =  New GroupMember();
        $checkMemberStatus = $groupMemberModel->where('user_id', $user_id)->where('group_id',$group_id)->first();
        return $checkMemberStatus;
    }


   
    public function getWebSearchGroups($search_string,$user_id)
    {
        
        $groups = $this->select('group_name,group_title,cover,avatar,id')->like('group_title',$search_string)->findAll();
        if(!empty($groups))
        {
            foreach($groups as &$group)
            {
                $group['cover'] = !empty($group['cover'])?getMedia($group['cover']):'';
              
                $groupMemberInfo = $this->checkMemberStatus($group['id'], $user_id);
                $group['is_joined'] = empty($groupMemberInfo) ? 0 : 1;
                $group['is_admin'] = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;
            }
           return $groups;
        }
        return $groups;
    }
    public function deleteGroupsByUserId($userId)
    {
        $this->where('user_id', $userId)->delete();    
    }

    public function delteGroupById($group_id)
    {
        $postModel = New PostModel;
        $commentModel = New CommentModel;
        $reactionModel =  New PostsReactionsModel;
        $posts = $postModel->where('group_id',$group_id)->findALL();
        
        foreach($posts as $post){
            $commentModel->where('post_id',$post['id'])->delete();
            $reactionModel->where('post_id',$post['id'])->delete();
            
        }
        $postModel->where('group_id',$group_id)->delete();

        $this->delete($group_id);
    }
    public function getnewGroup($userId,$limit,$offset)
    {
        $groupModel = New Group;
      
    $groups = [];
    $builder = $groupModel->builder();
    $builder->select('g.*')
        ->distinct()
        ->from('groups as g')
        ->join('group_members', 'g.id = group_members.group_id', 'left')
        ->where('g.user_id', $userId)
        ->orWhere('group_members.user_id IS NULL')
        ->orWhere('group_members.user_id !=', $userId)
        ->where('g.deleted_at IS NULL')
        ->limit($limit, $offset); // Set the limit and offset

        $query = $builder->get();
        $groups = $query->getResult();
        if(!empty($groups))
        {
            foreach($groups as &$group)
            {
                $group->category = GROUP_CATEGORIES[$group->category];
                $group->avatar = !empty($group->avatar) ? getMedia($group->avatar) : '';
                $group->cover = !empty($group->cover) ? getMedia($group->cover) : '';
                $group->is_group_owner = ($group->user_id == $userId) ? true : false;

                $groupMemberInfo = $this->checkMemberStatus($group->id, $userId);
                $group->is_joined = empty($groupMemberInfo) ? '0' : '1';
                $group->is_admin = $groupMemberInfo ? $groupMemberInfo['is_admin'] : 0;
                $grouparray[] = $group;
            }
        }
        return $groups;
    }
    public function getusergroup($userId)
    {
        $groups = $this->distinct()
        ->select('groups.id,groups.group_title')
        ->join('group_members', 'groups.id = group_members.group_id', 'left')
        ->where('groups.user_id ', $userId)
        
        ->orWhere('group_members.user_id ', $userId)
        ->where('groups.deleted_at', null)
        ->findAll();
        return $groups;
    }

}
