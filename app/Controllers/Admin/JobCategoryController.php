<?php

namespace App\Controllers\Admin;

use App\Models\JobCategory;
use App\Controllers\BaseController;

class JobCategoryController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = lang('Admin.jobcategories');
        $jobCategoryModel = New JobCategory();
        
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_or_customize_job_categories'), 'url' => ''];
        $this->data['page'] = $this->request->getVar('page') ?? 1; // Default to first page if not specified
        $perPage = 15;
		$this->data['categories'] =  $jobCategoryModel->paginate($perPage);
        $this->data['pager'] = $jobCategoryModel->pager;
        $this->data['perPage'] = $perPage;
		return view('admin/pages/jobcategories/index',$this->data);
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
            return view('admin/pages/groupcategories/index', $this->data);
        }
        $data = [
            'name' => $this->request->getVar('name'),
        ];
        $groupCategoryModel = New JobCategory();
        $res =$groupCategoryModel->save($data);
        $session = \Config\Services::session();
        if ($res) {
            $session->setFlashdata('success', lang('Admin.category_created_success'));
            return redirect('admin/group-categories');
        } else {
            $session->setFlashdata('error', lang('Admin.category_creation_failed'));
            return redirect('admin/groupcateogries/create');
        }
    }
    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_category');
        $GroupCategoryModel = New JobCategory();
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_category'), 'url' => ''];
        $this->data['category'] = $GroupCategoryModel->find($id);
        return view('admin/pages/jobcategories/edit', $this->data);
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
        $jobCategoryModel = New JobCategory();
        if (!$this->validate($validationRules)) {
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'General Settings', 'url' => ''];
            $this->data['category'] = $jobCategoryModel->find($id);
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/jobcategories/edit', $this->data);
        }
        
        $data = [
            'name' => $this->request->getVar('name'),
            

        ];
        
        $res = $jobCategoryModel->update($id, $data);
        if ($res) {
            $session->setFlashdata('success', lang('Admin.category_updated_success'));
            return redirect('admin/job-categories');
        } else {
            $session->setFlashdata('error', lang('Admin.category_update_failed'));
            return redirect('admin/job-categories');
        }
    }


    public function delete($id)
    {
        $session = \Config\Services::session();
        $GroupCategoryModel = New GroupCategory();

       if($id>22)
       {
            $res = $GroupCategoryModel->delete($id);
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
