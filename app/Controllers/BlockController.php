<?php

namespace App\Controllers;

use App\Models\Block;
use Firebase\JWT\JWT;
use App\Models\Friend;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class BlockController extends BaseController
{
    use ResponseTrait;
    public function blockuser()
    {
        $rules = [
            'user_id' => [
                'label' => 'User ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.validation_error'),
                ],
            ],
        ];
         if ($this->validate($rules)) {
            $block = New Block;              
            $user_data = getCurrentUser();
            $user_id = $this->request->getVar('user_id'); 
            $logged_userId = $user_data['id'];
            if($user_id==$logged_userId)
            {
                return $this->respond([
                    'code' => 501,
                    'message' => lang('Api.block_self_error'),
                    'data' => ''
                ], 403);
            }

            $checkblock = $block->where('blocker',$logged_userId)->where('blocked',$user_id)->first();
            if(!empty($checkblock))
            {
                $block->delete($checkblock['id']);
                return $this->respond([
                    'code' => 200,
                    'message' => lang('Api.user_unblocked_success'),
                    'data' => ''
                ], 200);
            }
            else{
                $friendModel =  New Friend;
                $friend = $friendModel->groupStart()
                ->where('friend_one',$logged_userId)
                ->where('friend_two',$user_id)                
            ->groupEnd()
           
                ->orwhere('friend_two',$logged_userId)->GroupStart()
                ->where('friend_one',$user_id)
                ->GroupEnd()
                ->first();
                if(!empty($friend))
                {
                    $friendModel->delete($friend['id']);
                }
                $data=[
                    'blocker'=>$logged_userId,
                    'blocked'=>$user_id,
                ];
                $block->save($data);
                return $this->respond([
                    'code' => 200,
                    'message' => lang('Api.user_blocked_success'),
                    'data' => $data
                ], 200);
            }
            
         }
         else
         {
             $validationErrors = $this->validator->getErrors();
             return $this->respond([
                'code' => 502,
                'message' => lang('Api.validation_error'),
                'errors' => $validationErrors
            ], 400);
         }
    }
    public function blocklist()
    {
        $block = New Block;
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):10;
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        $blockusers = $block->getblockuser($user_id);
        $users = [];
        if(!empty($blockusers))
        {
            $userModel = New UserModel;
            
            foreach($blockusers as $blockuser)
            {
                $users[]  = $userModel->getUserShortInfo($blockuser);
            }
      
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.block_user_fetch_success'),
                'data' => $users
            ], 200);
        }
    
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.block_user_not_found'),
            'data' => $users
        ], 200);
    }
    public function reportUser()
    {

        $rules = [
            'report_user_id' => [
                'label' => lang('Api.report_user_id_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.report_user_id_required'),
                ],
            ],
            'reason' => [
                'label' => lang('Api.reason_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.reason_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $db = \Config\Database::connect();             
            $user_data = getCurrentUser();
            $report_user_id = $this->request->getVar('report_user_id'); 
            $logged_userId = $user_data['id'];
            $reason = $this->request->getVar('reason');
            $checkreport = $db->table('user_report')->where('user_id',$logged_userId)->where('report_user_id',$report_user_id)->get()->getFirstRow();
            if(!empty($checkreport))
            {
                return $this->respond([
                    'code' => 200,
                    'message' => lang('Api.user_already_reported'),
                    'data' => ''
                ], 200);
            }
            else{
                $data=[
                    'user_id'=>$logged_userId,
                    'report_user_id'=>$report_user_id,
                    'reason'=>$reason
                ];
                $db->table('user_report')->insert($data);
                
                return $this->respond([
                    'code' => 200,
                    'message' => lang('Api.user_reported_success'),
                    'data' => $data
                ], 200);
            }
        
        }
        else
        {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 502,
                'message' => lang('Api.validation_error'),
                'errors' => $validationErrors
            ], 502);
        }

    }
}
