<?php

namespace App\Controllers\Admin;

use App\Models\WithdrawRequest;

use App\Controllers\Admin\AdminBaseController;
use App\Models\TransactionModel;

class WithdrawController extends AdminBaseController
{
    protected  $withdraw_request;
    public $session ;
    public function __construct()
    {
        $this->withdraw_request = new WithdrawRequest();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
		$this->data['page_title'] = lang('Admin.withdraw_requests');
       
		$this->data['withdraw_requests'] = $this->withdraw_request->getWithdrawRequestData();
		$this->data['All Settings'] =lang('Admin.withdraw_requests');
		$this->data['breadcrumbs'][] = ['name'=>lang('Admin.withdraw_requests'),'url'=>''];
		return view('admin/pages/withdrawrequest/index',$this->data);
    }
    public function approve($id)
    {
        $this->withdraw_request->update($id,['status'=>2]);
        $this->session->setFlashdata('success', lang('Admin.withdraw_request_approved'));
        
        return redirect('admin/withdraw-requests');

    }
    public function reject($id)
    {
        $withdrawrequest= $this->withdraw_request->find($id);
       

        $this->withdraw_request->update($id,['status'=>3]);
        
        $transactionModel  = New TransactionModel();
        $transactiondata = [
            'user_id'=>$withdrawrequest['user_id'],
            'amount'=>$withdrawrequest['amount'],
            'flag'=>'C',
            'action_type'=>9
        ];
        $transactionModel->save($transactiondata);
        $transactiondata = [
            'user_id'=>1,
            'amount'=>$withdrawrequest['amount'],
            'flag'=>'D',
            'action_type'=>9
        ];
        $transactionModel->save($transactiondata);
        $this->session->setFlashdata('success', lang('Admin.withdraw_request_rejected'));
        return redirect('admin/withdraw-requests');
    }
    public function details($id)
    {
        $this->data['page_title'] = lang('Admin.withdraw_request_details');
		$this->data['withdraw_request'] = $this->withdraw_request->getwithdrawrequest($id);
		$this->data['All Settings'] =  lang('Admin.website_information');
		$this->data['breadcrumbs'][] = ['name'=>lang('Admin.general_settings'),'url'=>''];
       
		return view('admin/pages/withdrawrequest/details',$this->data);
    }
}
