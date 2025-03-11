<?php

namespace App\Controllers;

use App\Models\Block;
use App\Models\Page;
use App\Models\Group;
use App\Models\Friend;
use App\Models\Follower;

use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class SettingsController extends BaseController
{
    private $userModel;
    private $currentuser;
    
    use ResponseTrait;
    public function __construct()
    {
        parent::__construct();
        $this->userModel  = New UserModel;
        $this->currentuser = getCurrentUser()['id'];
    }

    public function profileEdit()
    {
        $data=base_urls();
        echo load_view('pages/profile/settings',$this->data);
    }

    public function generalSettings()
    {
        $loggendInUserID = $this->currentuser;
        $userdata  = $this->userModel->where('id',$loggendInUserID)->first();
        $this->data['js_files'] = ['https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js'];    
       
        $userdata['avatar'] = getMedia($userdata['avatar'],'avatar');
        $userdata['cover'] = getMedia($userdata['cover'],'cover');

        $this->data['userdata'] = $userdata;

        echo load_view('pages/settings/general',$this->data);
    }

    public function blockedUser()
    {
        $loggendInUserID = $this->currentuser;
        $blockModel = New Block;
        $blockusers = $blockModel->getblockuser($loggendInUserID);
        if(!empty($blockusers))
        {
            $userModel = New UserModel;
            
            foreach($blockusers as $blockuser)
            {
                $users[]  = $userModel->getUserShortInfo($blockuser);
            }
            $this->data['users'] = $users;
        }
        else{
            $this->data['users'] = null;
        }
        echo load_view('pages/settings/blockeduser',$this->data);
    }
    
    public function profileSettings()
    {
        echo load_view('pages/settings/profile',$this->data);
    }

    public function socialSettings()
    {

        $loggendInUserID = $this->currentuser;
        $userdata  = $this->userModel->where('id',$loggendInUserID)->first();
        $this->data['js_files'] = ['https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js'];    
       
        $this->data['userdata'] = $userdata;

        echo load_view('pages/settings/social',$this->data);
    }

    public function notificationSettings()
    {
        $loggendInUserID = $this->currentuser;
        $userdata  = $this->userModel->where('id',$loggendInUserID)->first();
        $this->data['js_files'] = ['https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js'];    
       
        $this->data['userdata'] = $userdata;
        echo load_view('pages/settings/notification',$this->data);
    }

    public function privacySettings()
    {
        
        $loggendInUserID = $this->currentuser;
        $userdata  = $this->userModel->where('id',$loggendInUserID)->first();
        $this->data['js_files'] = ['https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js'];    
       
        $this->data['userdata'] = $userdata;
        echo load_view('pages/settings/privacy',$this->data);
    }

    public function passwordSettings()
    {
        echo load_view('pages/settings/password',$this->data);
    }
    public function  manageSessions()
    {
        $user_id = getCurrentUser()['id'];
        $db = \Config\Database::connect();
        $builder = $db->table('ci_sessions');
        $builder->where('user_id', $user_id);
        $query = $builder->get();
        $sessions = $query->getResult();
        $this->data['sessions'] = $sessions;
        echo load_view('pages/settings/managesession',$this->data);
    }
    public function deleteAccount()
    {
        
        echo load_view('pages/settings/deleteaccount',$this->data);
    }
    public function changeLanguage()
    {
        $user_id = getCurrentUser()['id'];
        $db = \Config\Database::connect();
        $directoryPath = APPPATH . 'Language'; // Change to your directory path
        $directories = [];

        // Check if the directory exists
        if (is_dir($directoryPath)) {
            // Get all files and directories in the given path
            $items = scandir($directoryPath);

            // Filter out '.' and '..'
            $items = array_diff($items, ['.', '..']);

            // Loop through the items and check if they are directories
            foreach ($items as $item) {
                $fullPath = $directoryPath . DIRECTORY_SEPARATOR . $item;
                if (is_dir($fullPath)) {
                    $directories[] = $item;
                }
            }
        }
        $this->data['languages'] = $items;
        $userModel  = New UserModel();  
        $this->data['user_language']   = $userModel->where('id',$user_id)->first()['lang']; 
        echo load_view('pages/settings/changeLanguage',$this->data);
    }

}
