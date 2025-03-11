<?php

namespace App\Models;

use DateTime;
use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'messages';
    protected $db; 
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $useSoftDeletes   = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $allowedFields = [
        'from_id', 'to_id', 'group_id', 'page_id', 'message', 
        'media', 'media_name', 'is_seen', 'deleted_one', 
        'deleted_two', 'is_push_sent', 'noti_id', 'product_id', 
        'reply_id', 'story_id', 'forward', 'created_at', 
        'updated_at', 'deleted_at','media_type','thumbnail'
    ];
    public function __contruct()
    {
       $this->db =  \Config\Database::connect();
    }

    

    public function getMessages($from_id, $to_id, $limit, $offset, $currentUserId)
    {
        $compiledMessages = [];
   
        $this->where('from_id', $to_id)
            ->where('to_id', $currentUserId)
            ->where('is_seen',0)
            ->set('is_seen', 1)
        ->update();

        $messages = $this
            ->where('deleted_at', null)
            ->groupStart()
                ->where("from_id", $from_id)
                ->where("to_id", $to_id)
            ->groupEnd()
            ->orGroupStart()
                ->where("from_id", $to_id)
                ->where("to_id", $from_id)
            ->groupEnd()
            ->orderBy('id','DESC')
            ->findAll($limit, $offset);

        if (!empty($messages)) {
            foreach ($messages as &$message) {
                $message['media'] = !empty($message['media']) ? getMedia($message['media']) : '';
                $message['thumbnail'] = !empty($message['thumbnail']) ? getMedia($message['thumbnail']) : '';
                // Determine the other user's ID
                $otherUserId = ($message['from_id'] == $currentUserId) ? $message['to_id'] : $message['from_id'];

                $message['user'] = $this->getUserData($otherUserId);
                $message['human_time'] = HumanTime($message['created_at']);
            }
        }
        return $messages;
    }

    public function getUserChats($userId)
    {
        return $this->select('messages.*, 
                              CASE 
                                  WHEN messages.from_id = '.$userId.' THEN sender.name 
                                  ELSE receiver.name 
                              END as other_party_name')
                    ->join('users as sender', 'messages.from_id = sender.id', 'left')
                    ->join('users as receiver', 'messages.to_id = receiver.id', 'left')
                    ->where('messages.from_id', $userId)
                    ->where('messages.deleted_at', null)
                    ->orWhere('messages.to_id', $userId)
                    ->where('messages.deleted_at', null)
                    ->groupBy('messages.id') // Adjust this based on how you want to group messages
                    ->orderBy('messages.created_at', 'ASC')
                    ->findAll();
    }

    public function getGroupChatList()
    {
        $session = session();

        $userId = $session->get('user_id');
        if (!$userId) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in',
            ]);
        }

        try {
            $groupChats = $this->messageModel->getGroupChatList($userId);
            if (!empty($groupChats)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Group chat list fetched successfully',
                    'data' => $groupChats,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No group chats found for the user',
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage(),
            ]);
        }
    }
    public function getChatListByPage($page_id)
    {
        $chats = $this->where('page_id',$page_id)->findAll();
        return $this->compile_chat_data($chats); 
    }
    public function compile_chat_data($chats)
    {
        if(!empty($chats))
        {
            foreach($chats as $singleMessage)
            {
                $modiefiedmessage = $singleMessage;
                if($singleMessage['media'])
                {
                    $modiefiedmessage['media'] = getMedia($singleMessage['media']);
                }
                $modiefiedmessages[] = $modiefiedmessage;
            }
            return $modiefiedmessages;
        }

    }
    public function getMessageDetails($chatId)
    {
        $message = $this->find($chatId);
        if(!empty($message))
        {
            $modiefiedmessage = $message;
            $modiefiedmessage['media'] = !empty($message['media'])?getMedia($message['media']):'';
            $modiefiedmessage['thumbnail'] = !empty($message['thumbnail'])?getMedia($message['thumbnail']):'';
            $modiefiedmessage['user'] = $this->getUserData($message['from_id']);
        }
        $dateFromDB = new DateTime($message['created_at']);
        $currentDateTime = new DateTime();
        $timeDifference = $currentDateTime->diff($dateFromDB);

        // Access time difference components
        $daysDifference = $timeDifference->days;
        $hoursDifference = $timeDifference->h;
        $minutesDifference = $timeDifference->i;
        $secondsDifference = $timeDifference->s;
        $total =$daysDifference." days ".$hoursDifference ." hours ".$minutesDifference." mintus ".$secondsDifference." sec ago " ;
        $modiefiedmessage['human_time'] = $total;
        return $modiefiedmessages[] = $modiefiedmessage;
    }
    public function getUserData($userId)
    {
        $userdata = $this->db->table('users')
                    ->select(["avatar", "id", "username", "CONCAT(first_name, ' ', last_name) as name"]) // Note the space between first_name and last_name
                    ->where('id', $userId)
                    ->get()
                    ->getFirstRow();

        if (!empty($userdata)) {
            $userdata = (array) $userdata;
            $userdata['avatar'] = getMedia($userdata['avatar'], 'avatar');
        }

        return $userdata;
    }
    // public function getchatUser($user_id,$limit,$offset)
    // {
    //     $users = $this->distinct()
    //     ->select(['users.id','users.is_verified','users.username', 'users.first_name', 'users.last_name', 'users.avatar'])
    //         ->join('users', 'users.id = messages.from_id OR users.id = messages.to_id')
    //         ->where("(messages.from_id = $user_id OR messages.to_id = $user_id)")
    //         ->where("users.id != $user_id")
    //         ->where("messages.deleted_at",null)
    //         ->orderBy('id','desc')
    //         ->findAll($limit,$offset);

        
    //     foreach($users as &$user)
    //     {
    //         $user['avatar'] =getMedia($user['avatar'],'avatar'); 
    //     }
       
    //     return $users;
    // }

    public function getchatUser($user_id, $limit, $offset)
    {
        $dbPrefix = $this->db->DBPrefix;

        $sql = "SELECT DISTINCT
            $dbPrefix"."users.id,
            $dbPrefix"."users.is_verified,
            $dbPrefix"."users.username,
            $dbPrefix"."users.first_name,
            $dbPrefix"."users.last_name,
            $dbPrefix"."users.avatar,
            last_message.message AS last_message,
            last_message.is_seen AS is_seen,
            
            last_message.created_at AS last_message_time
        FROM
            $dbPrefix"."messages
            INNER JOIN $dbPrefix"."users ON $dbPrefix"."users.id = CASE WHEN $dbPrefix"."messages.from_id = ? THEN $dbPrefix"."messages.to_id ELSE $dbPrefix"."messages.from_id END
            INNER JOIN
                (SELECT MAX(id) as last_message_id
                FROM $dbPrefix"."messages
                WHERE deleted_at IS NULL  -- Filter out soft-deleted messages
                GROUP BY LEAST(from_id, to_id), GREATEST(from_id, to_id)) AS sub
                ON $dbPrefix"."messages.id = sub.last_message_id
            LEFT JOIN $dbPrefix"."messages AS last_message ON last_message.id = sub.last_message_id
        WHERE (
            $dbPrefix"."messages.from_id = ? OR $dbPrefix"."messages.to_id = ?
        )
        AND $dbPrefix"."users.id != ?
        AND $dbPrefix"."users.deleted_at IS NULL  
        ORDER BY last_message.id DESC
        LIMIT ?, ?";

        $query = $this->db->query($sql, array($user_id, $user_id, $user_id, $user_id, (int)$offset, (int)$limit));

        $users = $query->getResult();

        
        foreach($users as &$user)
        {
            $user->avatar = getMedia($user->avatar, 'avatar');
            $user->time_ago = HumanTime($user->last_message_time);
        }
        return $users;
    }
    
    
    


}
