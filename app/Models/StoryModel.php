<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\NotificationModel;

class StoryModel extends Model
{
    protected $db;
    protected $userModel;


    public function __construct()
    {
        parent::__construct();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->userModel = new UserModel();
    }
    protected $table            = 'stories';
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

    public function getallStories($user_id)
    {
        $currentTime = date('Y-m-d H:i:s');       
        $twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($currentTime)));
        return $this->where('user_id',$user_id)
                ->where('created_at >=', $twentyFourHoursAgo)
                ->orderBy('id','desc')
            ->findAll();
    }
    public function checkoldmutedata($loggedinuser,$story_user_id)
    {
        
        $builder = $this->db->table('stories_mute');
        $builder->where('user_id',$loggedinuser);
        $builder->where('story_user_id',$story_user_id);
        $query = $builder->get();
        $record = $query->getRow();
        if(!empty($record))
        {
            $this->unmuteuser($record->id);
            return 'unmute';
        }
        else
        {
            $this->muteuser($loggedinuser,$story_user_id);
            return 'mute';
        }
    }
    public function unmuteuser($Id)
    {
        return $this->db->table('stories_mute')->delete(['id' => $Id]); 
    }
    public function muteuser($userId,$story_user_id)
    {
        $data = [
            'user_id' => $userId,
            'story_user_id' => $story_user_id,
        ];

        return $this->db->table('stories_mute')->insert($data);
    }
    public function checkstoryOldView($user_id,$story_id)
    {
      
        $builder = $this->db->table('stories_seen');
        $builder->where('user_id',$user_id);
        $builder->where('story_id',$story_id);
        $query = $builder->get();
        $record = $query->getRow();
       
        if(empty($record))
        {
            return $this->addstoryseen($user_id,$story_id);
        }
       
        

    }
    public function addstoryseen($userId,$story_id)
    {
        $story = $this->find($story_id);
        if($story['user_id'] ==$userId)
        {
            return 2;
        }
        $data = [
            'user_id' => $userId,
            'story_id' => $story_id,
        ];
        $this->db->table('stories_seen')->insert($data);
        // create Notification 
       
        
        return $this->set('views_count', 'views_count + ' . 1, false)
      ->where('id', $story_id)
      ->update();
    }
    public function getseenusers($storyId)
    {
        $builder = $this->db->table('stories_seen ss');
        $builder->select(['u.id','u.is_verified', 'u.username','u.first_name', 'u.last_name', 'u.avatar', 'u.cover', 'u.gender', 'u.level']);
        $builder->where('ss.story_id',$storyId);
        $builder->join('users u', 'u.id = ss.user_id');
        $builder->orderBy('ss.created_at','desc');
        $query = $builder->get();
        return $query->getResultArray();
    }



    
}
