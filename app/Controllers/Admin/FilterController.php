<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Filter;

class FilterController extends AdminBaseController
{
    public function index()
    {
        $filterModel = New Filter();
        $this->data['page_title'] = lang('Admin.all_filters'); // Translated string for "All Filters"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.filters'), 'url' => '']; 
        $this->data['filters'] = $filterModel->findAll();
        return view('admin/pages/filters/index', $this->data);
    }
    public function create()
    {
        $this->data['page_title'] = lang('Admin.add_filter'); // Translated string for "All Filters"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.add_filter'), 'url' => '']; 
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        return view('admin/pages/filters/create', $this->data);
    }

    public function store()
    {
        $rules = [
            'name' => [
                'label' => lang('Admin.filter_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.filter_message.name_required')
                ]
            ],
            'link' => [
                'label' => lang('Admin.filter_message.link_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.filter_message.link_required')
                ]
            ],
        ];

        if ($this->validate($rules)) {

            $inserted_data = [
                'name' => $this->request->getVar('name'),
                'link' => $this->request->getVar('link'),
            ];
            $filter  = New Filter();
            $image = $this->request->getFile('image');
            if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
                $filterimage = storeMedia($image, 'filter_image');
                $inserted_data['image'] = $filterimage;
            }
            $filter->save($inserted_data);
            $session = \Config\Services::session();
            $session->setFlashdata('success', lang('Admin.create_filter_success'));
            return redirect('admin/filters');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/filters/create', ['validation' => $validationErrors]);
        }
    }
    public function edit($id)
    {
        $filterModel = New Filter();
        $this->data['page_title'] = lang('Admin.edit_filter'); 
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_filter'), 'url' => ''];
        $this->data['filter'] =$filterModel->find($id);

        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        
        return view('admin/pages/filters/edit', $this->data);
    }
    public function update($id)
    {
        $rules = [
            'name' => [
                'label' => lang('Admin.filter_message.name_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.filter_message.name_required')
                ]
            ],
            'link' => [
                'label' => lang('Admin.filter_message.link_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.filter_message.link_required')
                ]
            ],
        ];

        if ($this->validate($rules)) {

            $inserted_data = [
                'name' => $this->request->getVar('name'),
                'link' => $this->request->getVar('link'),
            ];
            $filter  = New Filter();
            $image = $this->request->getFile('image');
            if (!empty($image) && $image->isValid() && !$image->hasMoved()) {
                $filterimage = storeMedia($image, 'filter_image');
                $inserted_data['image'] = $filterimage;
            }
            $filter->update($id,$inserted_data);
            $session = \Config\Services::session();
            $session->setFlashdata('success', lang('Admin.update_filter_success'));
            return redirect('admin/filters');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/filters/create', ['validation' => $validationErrors]);
        }
    }
    public function delete($id)
    {
        $filterModel = New Filter;
        $filterModel->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', lang('Admin.delete_filter_success'));
        return redirect('admin/filters');

    }
}
