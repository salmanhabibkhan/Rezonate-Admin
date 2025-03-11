<?php

namespace App\Models;

use CodeIgniter\Model;

class GoingEvent extends Model
{
    protected $table            = 'going_events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['event_id','user_id'];

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
    public function getGoingEventsByUserId($userId, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
        $today = date('Y-m-d');
        return $this->select($dbPrefix.'events.*')
            ->join($dbPrefix.'events', $dbPrefix.'events.id = '.$dbPrefix.'going_events.event_id')
            ->where($dbPrefix.'going_events.user_id', $userId)
            ->where($dbPrefix.'events.deleted_at', null)
            ->where($dbPrefix.'events.end_date >', $today)
            ->orderBy($dbPrefix.'events.id', 'desc')
            ->findAll($limit, $offset);
    }
    
    public function deletegoingEvetByEventId($eventId)
    {
        $dbPrefix = $this->db->DBPrefix;
        
        return $this->where('event_id', $eventId)->delete();
    }
    
    public function getGoingUsers($id)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.id', $dbPrefix.'users.is_verified', $dbPrefix.'users.username', $dbPrefix.'users.email', $dbPrefix.'users.avatar', $dbPrefix.'users.gender'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'going_events.user_id')
            ->where($dbPrefix.'going_events.event_id', $id)
            ->where($dbPrefix.'users.deleted_at', null)
            ->orderBy($dbPrefix.'going_events.id', 'desc')
            ->findAll();
    }
    
}
