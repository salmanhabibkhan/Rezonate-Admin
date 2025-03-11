<?php

namespace App\Models;

use CodeIgniter\Model;

class LikePage extends Model
{
    protected $table            = 'like_pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','page_id','status'];

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

    public function checkpageLike($user_id,$page_id)
    {
        $checklike = $this->where(['user_id'=>$user_id,'page_id'=>$page_id])->first();
        if(!empty($checklike))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
    
    public function getShortPageUser($page_id)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.avatar', $dbPrefix.'users.id', $dbPrefix.'like_pages.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'like_pages.user_id')
            ->where($dbPrefix.'users.deleted_at', null)
            ->where($dbPrefix.'like_pages.page_id', $page_id)
            ->findAll(3);
    }
    
    public function getAllPageUser($page_id)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.gender',$dbPrefix.'users.first_name',$dbPrefix.'users.last_name', $dbPrefix.'users.avatar', $dbPrefix.'like_pages.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'like_pages.user_id')
            ->where($dbPrefix.'users.deleted_at', null)
            ->where($dbPrefix.'like_pages.page_id', $page_id)
            ->findAll();
    }
    
}
