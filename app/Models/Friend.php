<?php

namespace App\Models;

use CodeIgniter\Model;

class Friend extends Model
{
    protected $table            = 'friends';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['friend_one','friend_two','status','role','accepted_time'];

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
    public function getFriendRequest($userId,$limit,$offset)
    {
        $dbPrefix = $this->db->DBPrefix;

        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.avatar', $dbPrefix.'users.id', $dbPrefix.'users.first_name', $dbPrefix.'users.last_name'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = friends.friend_one')
            ->where($dbPrefix.'friends.friend_two', $userId)
            ->where($dbPrefix.'friends.status', 0)
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll($limit, $offset);

    }
    public function getFriendList($loggedInUserId, $limit, $offset, $keyword = null, $gender = null, $relationship = null)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $query = $this->select($dbPrefix.'users.id, '.$dbPrefix.'users.username, '.$dbPrefix.'users.avatar, '.$dbPrefix.'users.first_name, '.$dbPrefix.'users.last_name, '.$dbPrefix.'friends.role')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId");
    
        if ($gender != null) {
            $query->where($dbPrefix.'users.gender', $gender);
        }
    
        if ($keyword != null) {
            $query->like($dbPrefix.'users.username', $keyword);
        }
    
        if ($relationship != null) {
            $query->where($dbPrefix.'users.relation_id', $relationship);
        }
    
        $result = $query->findAll($limit, $offset);
        return $result;
    }
    public function userfriend($loggedInUserId,$limit,$offset)
    {
        $dbPrefix = $this->db->DBPrefix;
        $result = $this->select($dbPrefix.'users.id,'.$dbPrefix.'users.is_live')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId") 
            ->where("$dbPrefix"."users.is_live",1)     
            ->findAll($limit, $offset);
        return $result;
    }
    
    public function getFriendsIDByGroup($loggedInUserId)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $data = $this->select($dbPrefix.'users.id, '.$dbPrefix.'users.username, '.$dbPrefix.'users.avatar, '.$dbPrefix.'users.first_name, '.$dbPrefix.'users.last_name')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where($dbPrefix.'friends.role', '2') // Assuming '2' means Friends (adjust as needed)
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId")
            ->findAll();
    
        return array_column($data, 'id');
    }
    public function getFriendIds($loggedInUserId)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $data = $this->select($dbPrefix.'users.id')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId")
            ->findAll();
    
        return array_column($data, 'id');
    }
    
    public function getSendRequestdata($userId, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.avatar', $dbPrefix.'users.id', $dbPrefix.'users.first_name', $dbPrefix.'users.last_name'])
        ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
        ->where($dbPrefix.'friends.friend_one', $userId)
        ->where($dbPrefix.'friends.status', 0)
        ->where($dbPrefix.'users.deleted_at', null)
        ->findAll($limit, $offset);
    }

    public function getFriendsWithPagination($user_id, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        return $this->select('IF(friend_one = ' . $this->db->escape($user_id) . ', friend_two, friend_one) AS friend_id', false)
            ->where("($dbPrefix"."friend_one = " . $this->db->escape($user_id) . " OR $dbPrefix"."friend_two = " . $this->db->escape($user_id) . ")")
            ->where("$dbPrefix"."status", 1)
            ->limit($limit, $offset)
            ->get()
            ->getResultArray();
    }
    
    public function userFriendList($loggedInUserId, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        return $this->select($dbPrefix.'users.id, '.$dbPrefix.'users.username,'.$dbPrefix.'users.avatar, is_verified, '.$dbPrefix.'users.first_name, '.$dbPrefix.'users.last_name')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where($dbPrefix.'friends.role', '2') // Assuming '2' means Friends (adjust as needed)
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId")
            ->findAll($limit, $offset);
    }
    public function userFriends($loggedInUserId)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        return $this->select($dbPrefix.'users.id,'.$dbPrefix.'users.notify_friends_newpost,'.$dbPrefix.'users.device_id')
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId")
            ->findAll();
    }
    
    public function checkFriends($loggedInUserId, $userId)
    {
        $dbPrefix = $this->db->DBPrefix;

        $friend = $this->groupStart()
            ->where("friend_one", $loggedInUserId)
            ->where("friend_two", $userId)
        ->groupEnd()
        ->orGroupStart()
            ->where("friend_two", $loggedInUserId)
            ->where("friend_one", $userId)
        ->groupEnd()
        ->first();

        if (!empty($friend) && $friend['status'] == 1) {
            return '1';
        }
        return '0';
    }
    public function checkFriend($loggedInUserId, $userId)
    {
        $dbPrefix = $this->db->DBPrefix;

        $friend = $this->groupStart()
            ->where("friend_one", $loggedInUserId)
            ->where("friend_two", $userId)
        ->groupEnd()
        ->orGroupStart()
            ->where("friend_two", $loggedInUserId)
            ->where("friend_one", $userId)
        ->groupEnd()
        ->first();

        if (!empty($friend) && $friend['status'] == 1) {
            return $friend;
        }
        return null;
    }

    public function checkrequestStaus($loggedInUserId, $userId)
    {
        $dbPrefix = $this->db->DBPrefix;

        $request = $this->where(['friend_one' => $loggedInUserId, 'friend_two' => $userId, 'status' => 0])->first();
        if (!empty($request)) {
            return '1';
        }
        return '0';
    }
    public function checkincomingrequestStatus($loggedInUserId, $userId)
    {
        $dbPrefix = $this->db->DBPrefix;

        $request = $this->where([ 'friend_one'=>$userId,'friend_two'=>$loggedInUserId,'status' => 0])->first();
        if (!empty($request)) {
            return '1';
        }
        return '0';
    }

    public function countMutualFriends($user_id, $loggedInUserId, $limit = 100, $offset = 0)
    {
        if($user_id == 0) return 0;

        
        $dbPrefix = $this->db->DBPrefix;
        $friends = $this->getFriendList($user_id, $limit, $offset);
        $loggendPersonfriends = $this->getFriendList($loggedInUserId, $limit, $offset);
        $friends = array_column($friends, 'id');
        $myfriends = array_column($loggendPersonfriends, 'id');
        $commonfriends = array_intersect($friends, $myfriends);
        return count($commonfriends);
    }

    public function getFriendCount($loggedInUserId)
    {
        $dbPrefix = $this->db->DBPrefix;

        return $this->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'friends.friend_one OR '.$dbPrefix.'users.id = '.$dbPrefix.'friends.friend_two')
            ->where($dbPrefix.'friends.status', 1) // Assuming 1 means the friend request is accepted
            // ->where($dbPrefix.'friends.role', '2') // Assuming '2' means Friends (adjust as needed)
            ->where("($dbPrefix"."friends.friend_one = $loggedInUserId OR $dbPrefix"."friends.friend_two = $loggedInUserId)")
            ->where("$dbPrefix"."users.id != $loggedInUserId")
            ->countAllResults();
    }

    public function getfriendID($loggedInUserId, $userId)
    {

        return $this->groupStart()
            ->where("friend_one", $loggedInUserId)
            ->where("friend_two", $userId)
            ->where("status", 1)
        ->groupEnd()
        ->orGroupStart()
            ->where("friend_two", $loggedInUserId)
            ->where("friend_one", $userId)
            ->where("status", 1)
        ->groupEnd()
        ->first();
    }

  
    
}
