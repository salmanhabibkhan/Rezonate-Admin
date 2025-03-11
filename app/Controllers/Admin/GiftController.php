<?php

namespace App\Controllers\Admin;

use App\Models\GiftModel;
use App\Controllers\BaseController;

class GiftController extends AdminBaseController
{
    private $giftModel ;
    private $session;
    
    public function __construct()
    {
        parent::__construct();
        $this->giftModel = new GiftModel();
        $this->session = \Config\Services::session();
    } 
    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_gifts');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_gifts'), 'url' => ''];
        $perPage = 20;
        $this->data['gifts'] = $this->giftModel->paginate($perPage);
        $this->data['pager'] = $this->giftModel->pager;
        return view('admin/pages/gifts/index', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_gift');

        $this->data['breadcrumbs'][] = ['name' => lang('Admin.create_gift'), 'url' => ''];
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];

        return view('admin/pages/gifts/create', $this->data);
    }

    public function store()
    {
        $validationRules = [
        'name' => 'required',
        'price' => 'required',
       
        ];
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = lang('Admin.create_gift');
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Package Information', 'url' => ''];
            $this->data['validation']=$this->validator->getErrors();
            return view('admin/pages/gifts/create', $this->data);
        }
        $giftdata = [
            'name' => $this->request->getVar('name'),
            'price' => $this->request->getVar('price')
        ];
        $image = $this->request->getFile('image');
        if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
            $giftdata['image'] = storeMedia($image, 'gift_image');
        }
      
        $res = $this->giftModel->save($giftdata);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.gift_created_success'));
            return redirect('admin/gifts');
        } else {
            $this->session->setFlashdata('error', lang('Admin.gift_creation_failed'));
            return redirect('admin/gifts/create');
        }
        
    }

    public function edit($id = null)
    {
        $this->data['page_title'] = lang('Admin.edit_gift');

        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_gift'), 'url' => ''];
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        $this->data['gift']  = $this->giftModel->find($id);
        return view('admin/pages/gifts/edit', $this->data);
    }

    public function update($id = null)
    {
       
        $validationRules = [
            'name' => 'required',
            'price' => 'required',
           
        ];
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = lang('Admin.edit_gift');
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_gift'), 'url' => ''];
            $this->data['validation']=$this->validator->getErrors();
            $this->data['gift']  = $this->giftModel->find($id);
            return view('admin/pages/gifts/edit', $this->data);
        }
        $giftdata = [
            'name' => $this->request->getVar('name'),
            'price' => $this->request->getVar('price')
        ];
        $image = $this->request->getFile('image');
        if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
            $giftdata['image'] = storeMedia($image, 'gift_image');
        }
        
        $res = $this->giftModel->update($id,$giftdata);
        if ($res) {
            $this->session->setFlashdata('success',lang('Admin.update_gift_success') );
            return redirect('admin/gifts');
        } else {
            $this->session->setFlashdata('error', lang('Admin.update_gift_error'));
            return redirect('admin/gifts/edit/'.$id);
        }
    }

    public function delete($id = null)
    {
        $model = new GiftModel();
        $res = $model->delete($id);
        if ($res) {
            $this->session->setFlashdata('success',lang('Admin.delete_gift_success') );
        } else {
            $this->session->setFlashdata('error', lang('Admin.delete_gift_error')); 
        }
        return redirect('admin/gifts');
    }
}
