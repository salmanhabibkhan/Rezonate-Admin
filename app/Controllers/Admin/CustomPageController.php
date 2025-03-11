<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CustomPage;

class CustomPageController extends AdminBaseController
{
    public $custompageModel;
    public $session;
    public function __construct()
    {
        $this->custompageModel = new CustomPage();
        parent::__construct();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $this->data['page_title'] = lang('Admin.custom_pages'); // Translated string for "Custom Pages"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_custom_pages'), 'url' => '']; // Translated string for "Manage or customize Custom Pages"
        $this->data['custompages'] = $this->custompageModel->findAll();

        return view('admin/pages/custompage/index', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_custom_page'); // Translated string for "Create New Custom Page"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.create_custom_page'), 'url' => '']; // Translated string for "Create Custom Page"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['css_files'] = ['/summernote/summernote.min.css'];

        return view('admin/pages/custompage/create', $this->data);
    }

    public function store()
    {
        $validationRules = [
            'page_title' => [
                'label' => lang('Admin.custom_page_message.page_title_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.custom_page_message.page_title_required')
                ]
            ],
        ];
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = "Create New Package";
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Package Information', 'url' => ''];
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/custom-pages/create', $this->data);
        }

        $page_name =  str_replace(" ", "-", strtolower($this->request->getVar('page_title')));

        $data = [
            'page_name' => $page_name,
            'page_title' => $this->request->getPost('page_title'),
            'page_content' => $this->request->getPost('page_content'),
            'page_type' => $this->request->getPost('page_type'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];
        $res = $this->custompageModel->save($data);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.create_custompage_success'));
            return redirect()->to('admin/custom-page');
        } else {
            $this->session->setFlashdata('error', lang('Admin.create_custompage_error'));
            return redirect()->to('admin/packages/create');
        }
    }

    public function edit($id = null)
    {
        $this->data['page_title'] = lang('Admin.edit_custom_page'); // Translated string for "Edit Custom Page"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_custom_page'), 'url' => '']; // Translated string for "Package Information"
        $this->data['custompage'] = $this->custompageModel->find($id);

        return view('admin/pages/custompage/edit', $this->data);
    }
    public function update($id = null)
    {
        $validationRules = [
            'page_title' => [
                'label' => lang('Admin.custom_page_message.page_title_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.custom_page_message.page_title_required')
                ]
            ],
        ];
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = "Edit Custom Page";
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Package Information', 'url' => ''];
            $this->data['validation'] = $this->validator->getErrors();
            $this->data['custompage'] = $this->custompageModel->find($id);

            return view('admin/pages/custom-pages/edit', $this->data);
        }
        $data = [

            'page_title' => $this->request->getPost('page_title'),
            'page_content' => $this->request->getPost('page_content'),
            'page_type' => $this->request->getPost('page_type'),
            'meta_title' => $this->request->getPost('meta_title'),
            'meta_description' => $this->request->getPost('meta_description'),
        ];
        $res = $this->custompageModel->update($id, $data);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.update_custompage_success'));
            return redirect()->to('admin/custom-page');
        } else {
            $this->session->setFlashdata('success', lang('Admin.update_custompage_error'));

            return redirect()->to('admin/custom-pages/edit/' . $id);
        }
    }

    public function delete($id = null)
    {

        $res = $this->custompageModel->delete($id);
        if ($res) {

            $this->session->setFlashdata('success', lang('Admin.delete_custompage_success'));
            return redirect('admin/custom-page');
        } else {
            $this->session->setFlashdata('error', lang('Admin.delete_custompage_error'));
            return redirect('admin/custom-page');
        }
    }
}
