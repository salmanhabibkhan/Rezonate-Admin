<?php

namespace App\Controllers\Admin;


use App\Models\Gateway;

use App\Models\GatewayModel;


use App\Controllers\Admin\AdminBaseController;

class gatewaysController extends AdminBaseController
{
    private $gatewaysModel;
    public  $session;
    public function __construct()
    {
        parent::__construct();
        $this->gatewaysModel = New GatewayModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_gateways');
		$this->data['breadcrumbs'][] = ['name'=>lang('Admin.all_gateways'),'url'=>''];
        $this->data['gateways'] = $this->gatewaysModel->findAll();
		return view('admin/pages/all-gateways',$this->data);
    }


    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_gateway');
		$this->data['breadcrumbs'][] = ['name'=>lang('Admin.create_gateway'),'url'=>''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
		return view('admin/pages/gateways/create',$this->data);
    }


    public function store()
    {

        $rules = [
            'name' => [
                'label' => lang('Admin.gateway_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.gateway_message.name_required')
                ]
            ],
            'currency' => [
                'label' => lang('Admin.gateway_message.currency_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.gateway_message.currency_required')
                ]
            ],
        ];

        // Validate the request
        if ($this->validate($rules)) {
            $inserted_data = [
                'name' => $this->request->getVar('name'),
                'currency' => $this->request->getVar('currency') ?: 1,
                'rate' => $this->request->getVar('rate'),
                'minimum_amount' => $this->request->getVar('minimum_amount'),
                'maximum_amount' => $this->request->getVar('maximum_amount') ?: '',
                'fix_charge' => $this->request->getVar('fix_charge') ?: 0,
                'percentage_charge' => $this->request->getVar('percentage_charge') ?: 0,
            ];

            $logo = $this->request->getFile('logo');
            if (!empty($logo) && $logo->isValid() && !$logo->hasMoved()) {
                $gatewaylogo = storeMedia($logo, 'gateway_logo');
                $inserted_data['logo'] = $gatewaylogo;
            }

            $this->gatewaysModel->save($inserted_data);
            return redirect()->to('admin/gateways');

        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/gateways/create', ['validation' => $validationErrors]);
        }
    }
        
    
    
    public function edit($id)
    {
        $this->data['page_title'] = "Create new  gateways";
		$this->data['breadcrumbs'][] = ['name'=>'Website Information','url'=>''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
		$this->data['gateways'] = $this->gatewaysModel->find($id);
		return view('admin/pages/gateways/edit',$this->data);
    }


    public function update($id)
    {
        $inserted_data = [
            'name' => $this->request->getVar('name'),
            'currency' => $this->request->getVar('currency')?: 1,
            'rate' => $this->request->getVar('rate'),
            'minimum_amount' => $this->request->getVar('minimum_amount'),
            'maximum_amount' => $this->request->getVar('maximum_amount') ?: '',
            'fix_charge' => $this->request->getVar('fix_charge') ?: 0,
            'percentage_charge' => $this->request->getVar('percentage_charge') ?: 0,
        ];
        $logo = $this->request->getFile('logo');
        if (!empty($logo) ) {
            $gatewaylogo = storeMedia($logo, 'gateway_logo');
            $inserted_data['logo'] = $gatewaylogo;
        }
   
        $this->gatewaysModel->update($id,$inserted_data);
        $this->session->setFlashdata('success', 'Gateway  is updated');
        return redirect('admin/gateways');
    }
    
    
    public function delete($id)
    {
        $this->gatewaysModel->delete($id);
        return redirect('admin/gateways');
    }

}
