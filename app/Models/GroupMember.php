<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMember extends Model
{
    protected $table            = 'group_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];
// 'user_id','group_id','active','created_by','removed_by
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
    public function getGroupMembers($group_id){
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username',$dbPrefix.'users.first_name',$dbPrefix.'users.last_name', $dbPrefix.'users.email', $dbPrefix.'users.avatar', $dbPrefix.'users.gender', $dbPrefix.'group_members.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'group_members.user_id')
            ->where($dbPrefix.'group_members.group_id', $group_id)
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll();
    }
    
    public function getGroupShortMembers($group_id){
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.email', $dbPrefix.'users.avatar', $dbPrefix.'users.gender', $dbPrefix.'group_members.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'group_members.user_id')
            ->where($dbPrefix.'group_members.group_id', $group_id)
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll(3);
    }
    
    public function deleteGroupMembersByUserId($userId)
    {
        $this->where('user_id', $userId)->delete();
    }
    public function checkGroupAdmin($group_id,$user_id)
    {
        $checkAdmin = $this->where('user_id', $user_id)->where('group_id',$group_id)->where('is_admin',1)->first();
        if(!empty($checkAdmin))
        {
            return '1';
        }
        else{
            return '0';
        }
    }
}
