<?php

namespace App\Controllers;

use App\Models\Friend;
use App\Models\ChatModel;
use App\Models\UserModel;
use CodeIgniter\Controller;




class ChatController extends BaseController
{
    protected $messageModel;
    protected $user_id;
    public function __construct()
    {
        $this->user_id = getCurrentUser()['id'];
        $this->messageModel = new ChatModel();
    }

    // Send a message
    public function sendMessage()
    {        
        helper(['form', 'url']);
        updateLastSeen();   
        $messagearray = [];
        // Input validation for message fields
        $validationRules = [
            'to_id' => [
                'label' => 'Recipient ID',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.to_id_required'),
                    'integer' => lang('Api.to_id_integer'),
                ],
            ],
        ];
    
        if (! $this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $to_id =  $this->request->getPost('to_id');

        $userModel = New UserModel;
        $userMessagePrivacy = $userModel->select('privacy_message')->where('id',$to_id)->first();
        if(empty($userMessagePrivacy))
        {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.user_not_found'),
            ]);
        }
        if($userMessagePrivacy['privacy_message']==2)
        {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.message_privacy_error'),
            ]);
        }
        if($userMessagePrivacy['privacy_message']==1)
        {
            $friendModel = New Friend;
            $check_friend  = $friendModel->checkFriends($this->user_id,$to_id);
            if($check_friend=='0')
            {
                return $this->response->setJSON([
                    'status' => '400',
                    'message' => lang('Api.message_privacy_error'),
                ]);
            }
        }
        $data = [
            'from_id' => $this->user_id,
            'to_id' => $this->request->getPost('to_id'),
            'message' => $this->request->getPost('message') ?? '', 
            'type' => $this->request->getPost('type') ?? '',
            'lat'  => $this->request->getPost('lat'),
            'lon'  => $this->request->getPost('lon'),
            'media_type'=> (int)$this->request->getVar('media_type'),
        ];
        $mediaFile = $this->request->getFile('media');
        if(!empty($mediaFile))
        {
            $mediaPath = storeMedia($mediaFile, 'chat');
            $data['media']= $mediaPath;
            $data['media_name'] =  $mediaFile->getClientName();
        }
        $thumbnail = $this->request->getFile('thumbnail');
        if(!empty($thumbnail))
        {
            $data['thumbnail']= storeMedia($thumbnail, 'chat_thumbnail');
        }
       
        $result = $this->messageModel->save($data);
        $messagearray = $this->messageModel->getMessageDetails($this->messageModel->insertID());
        // Assuming saveMessage() is a method in your model
        if ($result) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => lang('Api.message_send_success'),
                'data' => $messagearray,
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.message_send_fail'),
            ]);
        }
        
    }


    // Fetch messages
    public function getMessages()
    {
        helper(['form', 'url']);
        $userModel =  New UserModel;
        $messages = [];
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 15;
        // Input validation for fetching messages
        $validationRules = [
            'to_id' => [
                'label' => 'Recipient ID',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.to_id_required'),
                    'integer' => lang('Api.to_id_integer'),
                ],
            ],
        ];
    
        if (!$this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $from_id = $this->user_id;
        $to_id = $this->request->getPost('to_id');



        try {
            $messages = $this->messageModel->getMessages($from_id, $to_id,$limit,$offset,$this->user_id);
            $user_info = $userModel->getUserShortInfo($to_id);

            // Assuming getMessages() is a method in your model
            if (!empty($messages)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => lang('Api.messages_fetch_success'),
                    'data' => $messages,
                    'user_info' => $user_info,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => lang('Api.no_messages_found'),
                    'data' => $messages,
                    'user_info' => $user_info,
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.error_occurred', [$e->getMessage()]),
            ]);
        }
    }
    public function getChatListByPage()
    {
        helper(['form', 'url']);

        // Input validation for page_id
        $validationRules = [
            'page_id' => [
                'label' => 'Page ID',
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.page_id_required'),
                    'integer' => lang('Api.page_id_integer'),
                ],
            ],
        ];
    
        if (! $this->validate($validationRules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $page_id = $this->request->getPost('page_id');

        try {
            $chatList = $this->messageModel->getChatListByPage($page_id);
            if (!empty($chatList)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => lang('Api.chat_list_fetch_success'),
                    'data' => $chatList,
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => lang('Api.no_chats_found'),
                ]);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.error_occurred', [$e->getMessage()]),
            ]);
        }
    }


    public function getUserChats($userId)
    {
        return $this->messageModel
        ->select('messages.*, 
            CASE 
                WHEN messages.from_id = '.$userId.' THEN sender.name 
                ELSE receiver.name 
            END as other_party_name,
            CASE 
                WHEN messages.from_id = '.$userId.' THEN messages.to_id 
                ELSE messages.from_id 
            END as other_party_id')
        ->join('users as sender', 'messages.from_id = sender.id', 'left')
        ->join('users as receiver', 'messages.to_id = receiver.id', 'left')
        ->where('messages.from_id', $userId)
        ->orWhere('messages.to_id', $userId)
        ->whereNull('sender.deleted_at') // Use whereNull for soft delete check
        ->whereNull('receiver.deleted_at') // Use whereNull for soft delete check
        ->groupBy('messages.id')
        ->orderBy('messages.created_at', 'DESC')
        ->findAll();
        

    }
    public function deleteMessage()
    {
      
        $rules = [
            'message_id' => [
                'label' => 'Message ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_failed'),
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $message_id = $this->request->getVar('message_id');
        $message = $this->messageModel->find($message_id);
        if(!empty($message))
        {   
            if($message['from_id']==$this->user_id)
            {
                if($this->messageModel->delete($message_id))
                {
                    return $this->response->setJSON([
                        'status' => 200,
                        'message' => lang('Api.message_deleted_success'),
                    ]);
                }
            }
            else
            {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => lang('Api.not_allowed_to_delete_message'),
                ]);

            }
        }else{
            return $this->response->setJSON([
                'status' => 404,
                'message' => lang('Api.message_not_found'),
            ]);
        }
    }
    public function getuserChat()
    {
        $offset = !empty($this->request->getVar('offset'))?$this->request->getVar('offset'):0;
        $limit = !empty($this->request->getVar('limit'))?$this->request->getVar('limit'):6;
        $chatusers = $this->messageModel->getchatUser($this->user_id,$limit,$offset);

        return $this->response->setJSON([
            'status' => '200',
            'message' => lang('Api.chat_users_fetched_success'),
            'data' => $chatusers,
        ]);
    }
}
