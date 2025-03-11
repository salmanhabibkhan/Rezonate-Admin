<?php

namespace App\Models;


use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
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
    
     /**
     * Fetches a user's short info along with optional extra fields.
     *
     * @param mixed $id The user's ID.
     * @param string|array $extra_fields Additional fields to include in the result.
     * @return array The user's information or an empty array if not found.
     */
    public function getUserShortInfo($id, $extra_fields = "")
    {
        // Base fields to select
        $base_fields = ['id', 'is_verified', 'username', 'first_name', 'email', 'last_name', 'avatar', 'cover', 'gender', 'level', 'role'];
        
        // Include extra fields if provided
        if (!empty($extra_fields)) {
            if (is_string($extra_fields)) {
                // Convert comma-separated string to array
                $extra_fields = explode(',', $extra_fields);
            }
            $fields_to_select = array_merge($base_fields, $extra_fields);
        } else {
            $fields_to_select = $base_fields;
        }

        // Fetch the user data
        $userdata = $this->select($fields_to_select)
                         ->where('id', $id)
                         ->first();
        
        if ($userdata !== null) {
            // Process and return the user data
   
            $default_avatar = getMedia('uploads/placeholder/avatar-1.jpg', 'avatar');
            if($userdata['gender'] == "Female"){
                $default_avatar = getMedia('uploads/placeholder/avatar-f1.jpg', 'avatar');
            }
            $default_cover = getMedia('uploads/placeholder/placeholder-cover.png');
            $userdata['avatar'] = !empty($userdata['avatar']) ? getMedia($userdata['avatar'], 'avatar') : $default_avatar;
            $userdata['cover']  = !empty($userdata['cover']) ? getMedia($userdata['cover'], 'avatar') : $default_cover;



            $userdata['first_name'] = ucwords($userdata['first_name']);
            $userdata['last_name'] = ucwords($userdata['last_name']);

            return $userdata;
        }

        return [];
    }
    
    public function getUserInfo($id)
    {
        $userdata = $this->where('id', $id)->first();
        if ($userdata !== null) {
            $userinfo = $userdata;
            $default_avatar = getMedia('uploads/placeholder/avatar-1.jpg', 'avatar');
            if($userdata['gender'] == "Female"){
                $default_avatar = getMedia('uploads/placeholder/avatar-f1.jpg', 'avatar');
            }
            $default_cover = getMedia('uploads/placeholder/placeholder-cover.png');
            $userinfo['avatar'] = !empty($userdata['avatar']) ? getMedia($userdata['avatar'], 'avatar') : $default_avatar;
            $userinfo['cover']  = !empty($userdata['cover']) ? getMedia($userdata['cover'], 'avatar') : $default_cover;

        } else {
            return "Data not found";
        }
        
        return $userinfo;
    }
    public function getUsersNotInFriends($user_id, $limit, $offset, $keyword = null, $relationship = null, $gender = null)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
        
        $query = $db->table($dbPrefix . 'users')
            ->select("$dbPrefix"."users.id, $dbPrefix"."users.is_verified, $dbPrefix"."users.username, $dbPrefix"."users.first_name, $dbPrefix"."users.last_name, $dbPrefix"."users.avatar, $dbPrefix"."users.gender, $dbPrefix"."users.level")
            ->where("$dbPrefix"."users.id !=", $user_id)
            ->where("$dbPrefix"."users.privacy_friends", 0)
            ->where("$dbPrefix"."users.deleted_at", null)
            ->where("$dbPrefix"."users.privacy_private_account",0)
            ->where("$dbPrefix"."users.id NOT IN (SELECT DISTINCT ".$dbPrefix."friends.friend_one FROM ".$dbPrefix."friends UNION SELECT DISTINCT ".$dbPrefix."friends.friend_two FROM ".$dbPrefix."friends WHERE ".$dbPrefix."friends.status=1)");

        if ($gender != null) {
            $query->where("$dbPrefix"."users.gender", $gender);
        }
        
        if ($keyword != null) {
            $query->like("$dbPrefix"."users.username", $keyword);
        }
        
        if ($relationship != null) {
            $query->where("$dbPrefix"."users.relation_id", $relationship);
        }
        
        $query->limit($limit)
            ->offset($offset);

        return $query->get()->getResult();
    }
    


    public function getDataTableData($length, $start, $order, $columns, $search)
    {
        $builder = $this->builder();

        if(isset($search['value']) && !empty($search['value'])){
            $builder->like('username', $search['value']);
            $builder->orLike('first_name', $search['value']);
            $builder->orLike('last_name', $search['value']);
            $builder->orLike('email', $search['value']);
        }

        if(isset($order)){
            $builder->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir']);
        }

        $recordsTotal = $builder->countAllResults(false);
        $data = $builder->get($length, $start)->getResult();
       
        return [
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $builder->countAllResults(),
            "data" => $data
        ];
    }
    public function getLeveldata($user_id)
    {
        return $this->select('packages.*')
                ->join('packages','packages.id = users.level' )
                ->where('users.id',$user_id)
                ->first();
    }
    public function getsearchUsers($term,$loggedInUserId,$is_verified='',$gender='',$avatar='')
    {
        $users = $this
        ->select('id,username,avatar,cover,first_name,last_name,deleted_at')
        ->where('deleted_at',null)
        ->where('id!=',$loggedInUserId)
        ->groupStart()
        ->like('first_name', $term)
        ->orLike('last_name', $term)
        ->orLike('username', $term)
        ->orlike('email', $term)
    ->groupEnd();   
    if ($is_verified!=null || $is_verified!='') {
        $users->where('is_verified', $is_verified);
    }
    if ($gender!=null && $gender!='') {
        $users->where('gender', $gender);
    }
    if ($gender!=null && $gender!='') {
        $users->where('gender', $gender);
    }
    if ($avatar!=null && $avatar!='' && $avatar==1 ) {
        $users->where('avatar IS NOT NULL');
    }
    if ($avatar!=null && $avatar!='' && $avatar==0 ) {
        $users->where('avatar IS  NULL');
    }
        
        
    $users = $users->findAll();
     
        
        $friendModel = New Friend;
        foreach($users as &$user){
            $user['is_friend'] = $friendModel->checkFriends($loggedInUserId,$user['id']);
            $user['is_pending'] = $friendModel->checkrequestStaus($loggedInUserId,$user['id']);
        }
        return $users;
    }

    public function getUsername($id)
    {
        $user = $this->select('username')->where('id',$id)->first();
        if(!empty($user))
        {
            return $user;
        }
        return null;
    }
    public function deleteuser($userId)
    {
        
    }


}
