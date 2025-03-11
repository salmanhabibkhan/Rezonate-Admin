<?php

namespace App\Controllers\Admin;

use App\Models\DepositModel;
use App\Models\TransactionModel;
;
use App\Controllers\Admin\AdminBaseController;

class DepositController extends AdminBaseController
{
    protected  $deposit_model;
    public $session ;
    public function __construct()
    {
        $this->deposit_model = new DepositModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $this->data['page_title'] = lang('Admin.deposit_requests'); // Translated string for "Deposit Requests"
        
        $this->data['deposit_requests'] = $this->deposit_model->getDepositRequestData();
        $this->data['all_settings'] = ""; // Assuming "All Settings" is a key or placeholder, you might want to replace it with a relevant translation if necessary.
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.deposits_list'), 'url' => '']; // Translated string for "Deposits List"
        return view('admin/pages/deposits/index', $this->data);
    }
    public function approve($id)
    {
        $this->deposit_model->update($id, ['status' => 'approved']);
        $this->session->setFlashdata('success', lang('Admin.withdraw_request_approved')); // Translated string for "Withdraw Request is approved"
        
        return redirect('admin/withdraw-requests');
    }
    // public function reject($id)
    // {
    //     $withdrawrequest= $this->deposit_model->find($id);
        

    //     $this->deposit_model->update($id,['status'=>'rejected']);
        
    //     $transactionModel  = New TransactionModel();
    //     $transactiondata = [
    //         'user_id'=>$withdrawrequest['user_id'],
    //         'amount'=>$withdrawrequest['amount'],
    //         'flag'=>'C',
    //         'action_type'=>9
    //     ];
    //     $transactionModel->save($transactiondata);
    //     $transactiondata = [
    //         'user_id'=>1,
    //         'amount'=>$withdrawrequest['amount'],
    //         'flag'=>'D',
    //         'action_type'=>9
    //     ];
    //     $transactionModel->save($transactiondata);
    //     $this->session->setFlashdata('success', 'Withdraw Request is rejected');
    //     return redirect('admin/withdraw-requests');
    // }
    public function details($id)
    {
        $this->data['page_title'] = lang('Admin.deposit_request_details'); // Translated string for "Deposit Request Details"
        $this->data['deposit_request'] = $this->deposit_model->getDepositRequest($id);
        $this->data['all_settings'] = lang('Admin.website_information'); // Translated string for "Website Information"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.deposit_request_details'), 'url' => '']; // Translated string for "Deposit Request Details"
        return view('admin/pages/deposits/details', $this->data);

    }
}