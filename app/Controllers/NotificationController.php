<?php

namespace App\Controllers;


use App\Models\Page;
use App\Models\Group;
use App\Models\UserModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class NotificationController extends BaseController
{
    use ResponseTrait;
    private $notificationModel;
    public $user_id;
    public $userModel;


    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = New UserModel();
        $this->notificationModel = New NotificationModel();
        $this->user_id = getCurrentUser()['id'];
    }
    public function showUserNewNotification()
    {
        
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):10;
        if( $limit > 20)  $limit = 20;
        
        $pageModel =  New Page;
        $groupModel =  New Group;
        
        $notifications = $this->notificationModel->where('from_user_id !=', $this->user_id)->where('to_user_id',$this->user_id)->where('seen',0)->orderBy('id','desc')->findAll($limit,$offset);
        if(!empty($notifications))
        {
            foreach($notifications as &$notification)
            {
                
                $notification['notifier'] = $this->userModel->getUserShortInfo($notification['from_user_id']);
                $page = $pageModel->find($notification['page_id']);
                $notification['page_url'] = (!empty($page))?$page['page_username']:'';
                $notification['created_human'] = HumanTime($notification['created_at']);
                $group = $groupModel->find($notification['group_id']);
                $notification['group_url'] = (!empty($group))?$group['group_name']:'';
              
            }
            return $this->respond([
                'code' => '200',
               'message' => lang('Api.fetch_notifications_success'),
                'data' => $notifications
            ], 200);
        }
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.no_notifications_found'),
            'data' => $notifications
        ], 200);
    }

    public function notifcations_list()
    {
     
        $notifications = $this->notificationModel->where('from_user_id !=', $this->user_id)->where('to_user_id',$this->user_id)->orderBy('id','desc')->findAll(10);
       
        $pageModel =  New Page;
        $groupModel =  New Group;
        $is_seen = 0;
        if(!empty($notifications))
        {
            foreach($notifications as &$notification)
            {
                $notification['notifier'] = $this->userModel->getUserShortInfo($notification['from_user_id']);
                $page = $pageModel->find($notification['page_id']);
                $notification['page_url'] = (!empty($page))?$page['page_username']:'';
                $group = $groupModel->find($notification['group_id']);
                $notification['group_url'] = (!empty($group))?$group['group_name']:'';
                if($notification['seen']==0)
                {
                    $is_seen= 1 ;
                }
            }    
        }
        
        $this->data['is_seen'] = $is_seen;
        $this->data['notifications'] = $notifications;     
      
        echo load_view('pages/notifications',$this->data);   
    }

    public function showOldNotification()
    {
        // Simplify fetching of request variables with default values
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 10;

        // Retrieve notifications
        $notifications = $this->notificationModel
                            ->where('from_user_id !=', $this->user_id)
                            ->where('to_user_id', $this->user_id)
                            ->orderBy('id', 'desc')
                            ->findAll($limit, $offset);

        // Enhance the readability of the loop
        foreach ($notifications as &$notification) {
            $notifier = $this->userModel->getUserShortInfo($notification['from_user_id']);
            $notification['notifier'] = empty($notifier) ? null : $notifier;
        }

        // Simplify the response structure
        $message = empty($notifications) ? lang('Api.no_notifications_found') : lang('Api.fetch_notifications_success');
        return $this->respond([
            'code' => '200',
            'message' => $message,
            'data' => $notifications
        ], 200);
    }
    
    public function markAllAsRead()
    {
        $this->notificationModel->markAllNotificationAsRead($this->user_id);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.all_notifications_marked_as_read'),
            'data' => ''
        ], 200);
    }
    public function deleteAllNotifications()
    {
        $this->notificationModel->deleteAllNotifications($this->user_id);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.all_notifications_deleted_successfully'),
            'data' => ''
        ], 200);
    }
    public function deleteNotification()
    {
        $rules = [
            'notification_id' => [
                'label' => 'Notification Id',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Validation.notification_id_required'),
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => 'Validation errors',
                'data' => $validationErrors
            ], 400);
        }
        $notification_id = $this->request->getVar('notification_id');

        $notification = $this->notificationModel->find($notification_id);
        if(empty($notification)) {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.notification_not_found'),
                
            ], 404);
        }
        if($notification['to_user_id']!=$this->user_id)
        {
            return $this->respond([
                'code' => '401',
                'message' => lang('Api.not_allowed'),
            ], 200);
        }
        $this->notificationModel->delete($notification_id);
        $notification_count = $this->notificationModel->where('from_user_id !=', $this->user_id)->where('to_user_id',$this->user_id)->orderBy('id','desc')->countAllResults();
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.notification_deleted_successfully'),
            'count_notification' => $notification_count
        ], 200);
    }
    public function markAsRead()
    {
        $rules = [
            'notification_id'=>'required'
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
        $notification_id = $this->request->getVar('notification_id');

        $notification = $this->notificationModel->find($notification_id);
        if(empty($notification)) {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.notification_not_found'),
                
            ], 404);
        }
        if($notification['to_user_id']!=$this->user_id)
        {
            return $this->respond([
                'code' => '401',
                'message' => lang('Api.not_allowed'),
            ], 200);
        }
        $this->notificationModel->update($notification_id,['seen'=>1]);
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.notification_updated_successfully'),
            
        ], 200);  
    }
    public function details($id)
    {
        $notification = $this->notificationModel->find($id);
        if(!empty($notification))
        {
            $this->notificationModel->update($id,['seen'=>1,'is_reacted'=>1]);
            if ($notification['type'] == 'Comment' || $notification['type'] == 'post-reaction' || $notification['type'] == 'share-post' || $notification['type2'] > 0) {
                $link = site_url('posts/' . $notification['post_id']);
            } elseif ($notification['type'] == 'Like-page') {
                $pageModel =  New Page;
                $page = $pageModel->find($notification['page_id']);
                $link = site_url('pages/' . $page['page_username']);
            } elseif ($notification['type'] == 'Join-group') {
                $groupModel =  New Group;
                $group = $groupModel->find($notification['group_id']);
                $link = site_url('group/' . $group['group_name']);
            } elseif ($notification['type'] == 'sent_request') {
                $link = site_url('friends');
            }
            else{
                $userModel = New UserModel;
                $user = $userModel->select('username')->where('id',$notification['from_user_id'])->first();
                $link = site_url($user['username']);
            }
       
            if(!empty($link))
            {
                return redirect()->to($link);
            }
           
            
        }
    }
}
