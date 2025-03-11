<?php

namespace App\Models;

use CodeIgniter\Model;

class InterestedEvent extends Model
{
    protected $table            = 'interested_events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','event_id'];

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
    public function getInterestedEventsByUserId($userId, $limit, $offset)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
        $today = $today = date('Y-m-d');
        return $this->select('events.*')
            ->join('events', $dbPrefix.'events.id = '.$dbPrefix.'interested_events.event_id')
            ->where($dbPrefix.'interested_events.user_id', $userId)
            ->where($dbPrefix.'events.end_date >', $today)
            ->where($dbPrefix.'events.deleted_at', null)
            ->orderBy($dbPrefix.'events.id', 'desc')
            ->findAll($limit, $offset);
    }
    
    public function deleteInterestedEvetByEventId($eventId)
    {
        return $this->where('event_id', $eventId)->delete();
    }
    
    public function getInterested($id)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
        
        return $this->select([$dbPrefix.'users.id', $dbPrefix.'users.is_verified', $dbPrefix.'users.username', $dbPrefix.'users.avatar', $dbPrefix.'users.gender', $dbPrefix.'users.email'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'interested_events.user_id')
            ->where($dbPrefix.'interested_events.event_id', $id)
            ->where($dbPrefix.'users.deleted_at', null)
           
            ->orderBy($dbPrefix.'interested_events.id', 'desc')
            ->findAll();
    }
    
}
