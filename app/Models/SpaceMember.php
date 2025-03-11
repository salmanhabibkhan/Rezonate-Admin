<?php

namespace App\Models;

use CodeIgniter\Model;

class SpaceMember extends Model
{
    protected $table            = 'space_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','space_id','is_active','is_cohost','is_host','is_speaking_allowed'];

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
    public function getUserById($spaceId)
    {
        $user = $this->select(['space_members.*','users.first_name','users.last_name','users.avatar'])
            ->join('users', 'users.id = space_members.user_id')
            ->where('space_members.space_id ',$spaceId)
            ->where('space_members.deleted_at', null)
            ->where('users.deleted_at', null)
        ->first();
        if(!empty($user))
        {
            $user['avatar'] = !empty($user)?  getMedia($user['avatar']):''; 
            return $user;
        }
        return null;
    }
    public function getspaceallmembers($spaceId)
    {
       
        $users = $this->select(['space_members.*','users.username','users.avatar','users.gender'])
            ->join('users', 'users.id = space_members.user_id')
            ->where('space_members.space_id ',$spaceId)
            ->where('space_members.deleted_at', null)
            ->where('users.deleted_at', null)
        ->findAll();
        return $users;       
    }
    public function getAllUserofSpace($spaceId,$limit,$offset)
    {
        return $this->select(['space_members.*','users.first_name','users.last_name','users.avatar'])
            ->join('users', 'users.id = space_members.user_id')
            ->where('space_members.space_id ',$spaceId)
            ->where('space_members.deleted_at', null)
            ->where('space_members.is_host',0)
            ->where('users.deleted_at', null)
        ->findAll($limit,$offset);
    }
    public function getspacemembercount($space_id)
    {
        $spaceMemberModel = New SpaceMember;
        return  $spaceMemberModel->where(['space_id'=>$space_id,'is_host'=>0])->countAllResults();
    }

    public function deletememberBySpaceId($id)
    {
        return $this->where('space_id',$id)->delete();
    }
}
