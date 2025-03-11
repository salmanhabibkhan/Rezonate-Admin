<?php

namespace App\Controllers;

use App\Models\Page;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use App\Models\Settings;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class BackendController extends BaseController
{
    use ResponseTrait;
    
    public function fileUpload()
    {
        if (IS_DEMO) {
            return $this->respond(['error' => lang('Api.demo_restriction')], 200);
        }
        $site_logo = $this->request->getFile('site_logo');
        $favicon = $this->request->getFile('favicon');
        $settingModel  = New Settings();
        $data = [];
        if(!empty($site_logo) && $site_logo->isValid() && !$site_logo->hasMoved() && $site_logo->getSize() > 0)
        {
            $sitelogoUploadPath  = storeMedia($site_logo,'site_logo') ;
            $setting = $settingModel->where('name','site_logo')->first();
            if(!empty($setting))
            {
                $settingModel->update($setting['id'],['value'=>$sitelogoUploadPath]);   
                $data['site_logo']=getMedia($sitelogoUploadPath);
                
            }
        }
        if(!empty($favicon) && $favicon->isValid() && !$favicon->hasMoved() && $favicon->getSize() > 0)
        {
            $faviconUploadPath  = storeMedia($favicon,'favicon') ;
            $setting = $settingModel->where('name','favicon')->first();
            if(!empty($setting))
            {
                $settingModel->update($setting['id'],['value'=>$faviconUploadPath]);  
                $data['favicon']=getMedia($faviconUploadPath);
            }
            
        }
        return $this->response->setJSON([
            'status' => 200,
            'message' => lang('Api.file_upload_success'),
            'data' => $data
        ]);
    }
    public function sendpush()
    {
        $rules = [
            'user_id'=>'required'
        ];
        if(!$this->validate($rules))
        {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }  
        $user_id = $this->request->getVar('user_id');
        $userModel = New UserModel();
        $user = $userModel->find($user_id); 
        if(!empty($user))
        {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'user Not Found',
                
            ]);
        }                                                                                                                                                                                                                                                                                                                                 
        $app_id = '6a42ead8-fed5-4791-9728-ac3060d511c3';
        $app_key = 'NWQzOTJjZTctZDAzYS00NWU5LWE1MmQtMzEyZmRiMmE4MWE3';

        $final_request_data = array(
            'app_id' => $app_id,
            'include_player_ids' =>  [$user['device_id']],
            'send_after' => new \DateTime('1 second'),
            'isChrome' => false,
            'contents' => array(
                'en' =>     "testing"
            ),
            'headings' => array(
                'en' => 'Testing User Name'
            ),
            'android_led_color' => 'FF0000FF',
            'priority' => 10
        );
        $final_request_data['large_icon'] = '';
        $fields = json_encode($final_request_data);
        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ' . $app_key
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        echo $response;

        $responseData = json_decode($response, true);

        if ($responseData === null) {
            // Handle invalid JSON response
            return $this->failServerError('Invalid JSON response from OneSignal API');
        }

    curl_close($ch);

    }
    public function checkBalance()
    {
        $user_id = getCurrentUser()['id'];
        $user_balance = getuserwallet($user_id);
         // Round balance to four digits
        $rounded_balance = round($user_balance, -strlen((string)$user_balance) + 4);

        return $this->response->setJSON([
            'status' => '200',
            'balance' => $rounded_balance,
        ], 200);
    }
}
