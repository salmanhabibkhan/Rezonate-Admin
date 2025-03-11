<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductCategory;

class ProductCategoryController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = lang('Admin.productcategories');
        $ProductCategoryModel = New ProductCategory();
		$this->data['categories'] =  $ProductCategoryModel->findAll();
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_or_customize_product_categories'), 'url' => ''];
		return view('admin/pages/productcateogries/index',$this->data);
    }
    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_package');
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.create_new_package'), 'url' => ''];
		return view('admin/pages/packages/create',$this->data);
    }
   
    public function store()
    {
        $validationRules = [
            'name' => [
                'label' => 'Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.categoryname_required'),
                ],
            ],
           
        ];
    
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = lang('Admin.add_new_category');
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Package Information', 'url' => ''];
    
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/productcateogries/index', $this->data);
        }
        $data = [
            'name' => $this->request->getVar('name'),
        ];
        $ProductCategoryModel = New ProductCategory();
        $res =$ProductCategoryModel->save($data);
        $session = \Config\Services::session();
        if ($res) {
            $session->setFlashdata('success', lang('Admin.category_created_success'));
            return redirect('admin/product-categories');
        } else {
            $session->setFlashdata('error', lang('Admin.category_creation_failed'));
            return redirect('admin/productcateogries/create');
        }
    }
    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_category');
        $ProductCategoryModel = New ProductCategory();
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_category'), 'url' => ''];
        $this->data['category'] = $ProductCategoryModel->find($id);
        return view('admin/pages/productcateogries/edit', $this->data);
    }
    public function update($id)
    {

        $validationRules = [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.categoryname_required'),
                ],
            ],
          
         
        ];
        $session = \Config\Services::session();
        $ProductCategoryModel = New ProductCategory();
        if (!$this->validate($validationRules)) {
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'General Settings', 'url' => ''];
            $this->data['package'] = $ProductCategoryModel->find($id);
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/product-catgories/edit', $this->data);
        }
        
        $data = [
            'name' => $this->request->getVar('name'),
            

        ];

        $res = $ProductCategoryModel->update($id, $data);
        if ($res) {
            $session->setFlashdata('success', lang('Admin.category_updated_success'));
            return redirect('admin/product-categories');
        } else {
            $session->setFlashdata('error', lang('Admin.category_update_failed'));
            return redirect('admin/product-categories');
        }
    }


    public function delete($id)
    {
        $session = \Config\Services::session();
        $ProductCategoryModel = New ProductCategory();
        
        if($id>10)
        {
            $res = $ProductCategoryModel->delete($id);
            if ($res) {
                $session->setFlashdata('success', lang('Admin.category_deleted_success'));
                return redirect('admin/product-categories');
            } else {
                $session->setFlashdata('error', lang('Admin.category_deletion_failed'));
                return redirect('admin/product-categories');
            }
        }
        $session->setFlashdata('error', lang('Admin.can_not_delete'));
       return redirect('admin/product-categories');
    }
}
