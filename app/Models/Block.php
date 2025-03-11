<?php

namespace App\Models;

use CodeIgniter\Model;

class Block extends Model
{
    protected $table            = 'blocks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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
   
    public function getblockuser($user_id )
    {
        $blockedUsers = $this->select('blocked')
                              ->where('blocker', $user_id)
                              ->findAll();

        $blockedUserIds = array_column($blockedUsers, 'blocked');
        return $blockedUserIds;
    }
    public function checkuserblock($loggedUserId,$userId)
    {
        if($loggedUserId == 0) return [];
        
        return  $this->groupStart()
        ->where('blocker', $loggedUserId)
        ->where('blocked', $userId)
        ->groupEnd()
        
        ->OrGroupStart()
            ->where('blocked', $loggedUserId)
            ->where('blocker', $userId)
        ->groupEnd()
        ->first();

    }
}
