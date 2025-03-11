<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BloodRequest;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class BloodBankController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        echo load_view('pages/blood/index',$this->data); 
    }
    public function findDonors()
    {
        $limit = $this->request->getVar('limit')?? 6;
        $offset = $this->request->getVar('offset')?? 0;
        $userModel  = New UserModel;
        $users = [];
        $user_id = getCurrentUser()['id'];
        $blood_group = $this->request->getVar('blood_group');
        $query = $userModel->select('id')->where('id!=',$user_id)->where('blood_group!=',null)->where('donation_available',1);
        if(!empty($blood_group))
        {
            $query->where('blood_group',$blood_group);
        }
        $blood_users = $query->findAll($limit,$offset);
       
        if(!empty($blood_users))
        {
            $userModel = New UserModel;
            $users = [];
            $userfields = ['blood_group','phone','donation_date','address','donation_available','date_of_birth'];
            foreach($blood_users as &$user)
            {
                $users[] =  $userModel->getUserShortInfo($user['id'],$userfields);
   
            }
            
            
        }
        $this->data['users'] = $users;
        $this->data['blood_group'] = $blood_group;
        echo load_view('pages/blood/finddonor',$this->data);
    }
    public function becomeDonor()
    {
        $userModel = New UserModel;
        $userfields = ['blood_group','phone','donation_date','address','donation_available','date_of_birth'];
        $user = getCurrentUser();
        $this->data['userdata'] =  $userModel->getUserShortInfo($user['id'],$userfields);
        echo load_view('pages/blood/becomedonor',$this->data);
        
    }
    public function bloodRequest()
    {
        $bloodRequestModel  = New BloodRequest;
        $blood_requests = $bloodRequestModel->orderBy('id','desc')->findAll();
        if(!empty($blood_requests))
        {
            $userModel = New UserModel;
            foreach ($blood_requests as  &$bloodrequest) {
                $bloodrequest['user'] = $userModel->getUserShortInfo($bloodrequest['user_id']);
            }
        }
        $this->data['blood_requests'] = $blood_requests;
       
        echo load_view('pages/blood/bloodrequest',$this->data);

    }
    public function addBloodRequest()
    {
        echo load_view('pages/blood/addbloodrequest',$this->data);
    }
    public function deleteBloodRequest()
    {
        $rules = [
            'request_id' => [
                'label' => 'Request ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error'),
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
        $user_id  = getCurrentUser()['id'];
        $request_id = $this->request->getVar('request_id');
        $bloodrequestModel = New BloodRequest;
        $bloodrequest =$bloodrequestModel->find($request_id);
        if(empty($bloodrequest))
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.blood_request_not_found'),
            ], 200);
        }
        if($bloodrequest['user_id']!= $user_id)
        {
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.unauthenticated_error'),
            ], 200);
        }
        $bloodrequestModel->where('id',$request_id)->delete();
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.blood_request_delete_success'),
        ], 200);
        
    }
}
