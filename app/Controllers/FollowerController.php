<?php

namespace App\Controllers;

use App\Models\Follower;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\UserModel;

class FollowerController extends BaseController
{
    use ResponseTrait;
    public function createFollower()
    {
        $rules = [
            'follower_id'=>'required'
        ];
       
        if($this->validate($rules))
        {
            
            
            $follower_id = $this->request->getVar('follower_id');
           
            $loggedInUser = getCurrentUser()['id'];
        
            $follwerModel = New Follower;
            $userModel = New UserModel;
            $checkUser = $userModel->find($follower_id);
            if(!empty($checkUser))
            {
                $loggedInUser = getCurrentUser()['id'];
                $checkoldData = $follwerModel->where(['following_id'=>$loggedInUser,'follower_id'=>$follower_id,'active'=>1])->first();
                if(!empty($checkoldData))
                {
                    $follwerModel->delete($checkoldData['id']);
                    return $this->respond([
                        'code' => '200',
                        'message' => 'Unfollow User Successfully',
                        'data' => ''
                    ], 200);
                }
                else{
                    $follwerModel->save(['following_id'=>$loggedInUser,'follower_id'=>$follower_id,'active'=>1]);
                    return $this->respond([
                        'code' => '200',
                        'message' => 'Follow User Successfully',
                        'data' => ''
                    ], 200);
                }
            }
            else{
                return $this->respond([
                    'code' => '200',
                    'message' => 'User Not found',
                    'data' => ''
                ], 200);
            }
        }
        else
        {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '',
                'message' => 'Validation Error',
                'data' => $validationErrors
            ], 400);
        }
    }
}
