<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;
use App\Models\Settings;
use App\Models\UserModel;
use App\Models\Advertisement;
use App\Controllers\BaseController;
use App\Models\PostsAdvertisementModel;

class AdvertisementController extends AdminBaseController
{
    public function index()
    {
        $advertisement = new Advertisement;
        $this->data['page_title'] = lang('Admin.manage_advertisement'); // Replace with language key
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_customize_ads'), 'url' => ''];
        $settings = new Settings();
        $allSettings = $settings->getSettings();
        
		$this->data['settings'] = $allSettings;
        
		return view('admin/pages/advertisement/advertisement',$this->data);
    }
    public function updateAd()
    {
        $data = [
            1=>$this->request->getVar('header'),
            2=>$this->request->getVar('sidebar'),
            3=>$this->request->getVar('footer'),
            4=>$this->request->getVar('first_post'),
            5=>$this->request->getVar('second_post'),
            6=>$this->request->getVar('third_post'),
        ];
        $advertisement = New Advertisement;
        
        foreach($data as $key=>$index)
        {
            $advertisement->update($key,['html_code'=>$index]);
        }
        $session = \Config\Services::session();
       
        $session->setFlashdata('success', 'Ads are updated');
        return redirect('admin/manage-advertisements');
    }
    public function changeshare()
    {
        if (IS_DEMO) {
            return $this->respond(['error' => 'You cant do this action in demo.'], 200);
        }
        $adminshare  = $this->request->getVar('admin_share');
        $postownershare  = $this->request->getVar('post_owner_share');
        $settingModel =  New Settings();
        $settingModel->set('value',$adminshare)->where('name=','ad-admin_share')->update();
        $settingModel->set('value',$postownershare)->where('name=','ad-post_owner_share')->update();
        return $this->response->setJSON([
            'code'    => 200,
            'message' => 'The share is changed'
        ], 200);
        
    }
    public function getPostAdvertisement()
    {
        $this->data['page_title'] = lang('Admin.manage_advertisement'); // Replace with language key
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_customize_ads'), 'url' => ''];
        $postadvertisementModel = New PostsAdvertisementModel;
        $perPage = 20;
        $postadvertisements = $postadvertisementModel->paginate($perPage);
        $userModel = New UserModel;
        $postModel = New PostModel(); 
        if(count($postadvertisements)>0)
        {
           
            foreach($postadvertisements as &$postadvertisement)
            {
                $postadvertisement['from_user'] = $userModel->getUsername($postadvertisement['from_user_id']);
                $postadvertisement['post'] =  $postModel->getPostLink($postadvertisement['post_id']);               
            }
            $this->data['postadvertisements'] = $postadvertisements;
            $this->data['pager'] = $userModel->pager;
            return view('admin/pages/advertisement/index',$this->data);
        }
        $this->data['postadvertisements'] = $postadvertisements;
        $this->data['pager'] = $userModel->pager;
        return view('admin/pages/advertisement/index',$this->data);

    }
    
}