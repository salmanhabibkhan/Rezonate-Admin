<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $db;
    protected $userModel;


    public function __construct()
    {
        parent::__construct();
        
        $this->db = \Config\Database::connect();
        $this->userModel = new UserModel();
    }

    protected $table            = 'notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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
    public function markAllNotificationAsRead($userId)
    {
        $data = [
            'seen'=>1
        ];
        return $this->builder()->where('to_user_id',$userId)->update($data);
    }
    public function deleteAllNotifications($userId)
    {
        
        $this->where('to_user_id',$userId)->delete();
    }
    public function getRecentNotifications($loggedInUserId,$user_id)
    {
        return $this->where('created_at > NOW() - INTERVAL 2 HOUR', null, false)->where(['from_user_id'=>$loggedInUserId,'to_user_id'=>$user_id,'type'=>'view_profile'])->first();
    }
}
