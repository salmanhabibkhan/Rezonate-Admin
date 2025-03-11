<?php

namespace App\Controllers;
use App\Models\UserModel;
use Stripe\Stripe;

use App\Models\WithdrawRequest;
use App\Models\TransactionModel;
use App\Controllers\BaseController;

class WalletController extends BaseController
{
    protected $transactionModel;
    protected $withdrawModel;
    protected $css_files;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->withdrawModel = new WithdrawRequest();
        $this->css_files = ['css/wallet.css'];
    }

    public function getuserwallet()
    {
        $user = getCurrentUser();
        $this->data['user_balance'] = $this->transactionModel->get_user_balance($user['id']);
        $this->data['css_files'] = $this->css_files;
        $this->data['user_data'] = $user;
        $earnings = $this->transactionModel->get_breakdown($user['id']);
        $this->data['earnings'] = $earnings;

        echo load_view('pages/wallet/wallet', $this->data);
    }

    public function create_withdraw()   
    {
        $user = getCurrentUser();
        $this->data['user_balance'] = $this->transactionModel->get_user_balance($user['id']);
        $this->data['css_files'] = $this->css_files;
        $this->data['user_data'] = $user;
        echo load_view('pages/wallet/create-withdraw', $this->data);
    }

    public function withdrawrequest()
    {
        $user = getCurrentUser();
        $this->data['user_balance'] = $this->transactionModel->get_user_balance($user['id']);
        $this->data['withdrawrequests'] = $this->withdrawModel->where('user_id', $user['id'])->findAll();
        $this->data['css_files'] = $this->css_files;
        $this->data['user_data'] = $user;
        echo load_view('pages/wallet/withdraw-requests', $this->data);
    }
    public function transferAmount()
    {
        $user = getCurrentUser();
        $this->data['user_balance'] = $this->transactionModel->get_user_balance($user['id']);
        $userModel = New UserModel;
        $this->data['users']= $userModel->select(['id','first_name','last_name'])->where('id!=',$user['id'])->findAll();
        $this->data['css_files'] = $this->css_files;
        $this->data['user_data'] = $user;
        echo load_view('pages/wallet/transferAmount', $this->data);
    }

}
