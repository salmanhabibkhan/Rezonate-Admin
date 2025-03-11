<?php

namespace App\Models;

use DateTime;
use CodeIgniter\Model;


class Event extends Model
{
    protected $current_user_id;

    public function __construct()
    {
      parent::__construct();
     
    }

    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['name',	'location',	'description','start_date',	'start_time','end_date','end_time','user_id','cover','is_owner','is_intersting','is_going','url'];

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


    public function getEvent($event_id){
      $event = $this->where('id', $event_id)->get()->getFirstRow('array');
      if(empty($event)) return;
      $event = $this->compile_event_data($event);
      return $event;
    }



    public function compile_event_data($event){
        $current_user_id = getCurrentUser()['id'];
        $userModel = new UserModel();
        $dateTime = new DateTime($event['start_time']);
        $event['start_time'] =$dateTime->format('h:i A'); 
        $dateTime = new DateTime($event['end_time']);
        $event['url'] = site_url('events/event-details/'.$event['id']);
        $event['end_time'] =$dateTime->format('h:i A'); 
        $event['cover'] = getMedia($event['cover']);
        $event['is_owner'] = ($event['user_id'] == $current_user_id)?true:false;
        $event['is_interested'] = $this->InterestedEvent($event['id']);
        $event['is_going'] = $this->goingEvent($event['id']);  
        $event['userdata'] = $userModel->getUserShortInfo($event['user_id']);

        return $event;

    }


    public function InterestedEvent($event_id)
    {
        $user_id=  getCurrentUser()['id'];
        $eventInterest = model('InterestedEvent');
        $checkInterest = $eventInterest->where(['event_id'=>$event_id,'user_id'=>$user_id])->first();
        if(!empty($checkInterest))
        {
            return true;
        }
        else{
            return false;
        }
    }


    public function goingEvent($event_id)
    {
        $user_id=  getCurrentUser()['id'];
        $event_going = model('GoingEvent');
        $checgostatus = $event_going->where(['event_id'=>$event_id,'user_id'=>$user_id])->first();
        if(!empty($checgostatus))
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function getAllEventes()
    {
        $dbPrefix = $this->db->DBPrefix;
        
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'events.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'events.user_id')
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll();
    }

    public function getSearchEvents($search_string,$limit,$offset)
    {
        $events = $this->like('name',$search_string)->findAll($limit, $offset);
        if(!empty($events))
        {
            $userModel = New UserModel();
            $user_id = getCurrentUser()['id'];
            foreach($events as &$event)
            {
                $event['cover'] = getMedia($event['cover']);
                $event['is_owner'] = ($event['user_id'] == $user_id) ? true : false;
                $event['is_interested'] = $this->InterestedEvent($event['id']);
                $event['is_going'] = $this->goingEvent($event['id']);
                $event['userdata'] = $userModel->getUserShortInfo($event['user_id']);
            }
           return $events;
        }
    }
    public function getWebSearchEvents($search_string,$user_id)
    {
        $events = $this->select('name,location,cover,id')->where('deleted_at',null)->like('name',$search_string)->findAll();
        if(!empty($events))
        {
            $user_id = getCurrentUser()['id'];
            foreach($events as &$event)
            {
                $event['cover'] = getMedia($event['cover']);
                $event['is_interested'] = $this->InterestedEvent($event['id']);
                $event['is_going'] = $this->goingEvent($event['id']);
            }
           
        }
        return $events;
    }
   
 






}
