<?php

namespace App\Controllers\Admin;

use App\Models\PoliticalNews;
use App\Controllers\BaseController;

class PoliticalNewsController extends BaseController
{
    
    public $politicalModel;

    public function __construct()
    {
        parent::__construct();
        $this->politicalModel = new PoliticalNews();
       
    }

    public function index()
    {
        // Set page information and load necessary JS files
        $this->data['page_title'] = "Manage Political News";
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => 'Manage Political News', 'url' => ''];

       
      
        $perPage = 20;

        // Execute pagination on the query
        $this->data['politicalnews'] =  $this->politicalModel->paginate($perPage);

        // Assign the pager object for pagination links
        $this->data['pager'] = $this->politicalModel->pager;
      
        // Render the view with supplied data
        return view('admin/pages/political/news/index', $this->data);
    }

    
    public function create()
    {
        $this->data['page_title'] = "Add Political News ";
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
       
        return view('admin/pages/political/news/create', $this->data);
    }
    public function store()
    {
        $session = \Config\Services::session();
        $rules = [
            'title' => 'required|min_length[5]|max_length[50]',
            'description' => 'required|min_length[5]|max_length[50]',
        ];
        if ($this->validate($rules)) {
            $inserted_data = [
                'title' => $this->request->getVar('title'),
                'description' => $this->request->getVar('description'),
                'created_by' =>getCurrentUser()['id'],
            ];
            $attachment  = $this->request->getFile('attachment');
          
            if (!empty($attachment) && $attachment->isValid() && !$attachment->hasMoved()) {
                $inserted_data['attachment'] = storeMedia($attachment, 'attachment');
                
            }
            $this->politicalModel->save($inserted_data);
            $session->setFlashdata('success', 'Political News is created');
            return redirect('admin/political-news');
        } else {
            $validationErrors = $this->validator->getErrors();
       
            return view('admin/pages/political/news/create', ['validation' => $validationErrors]);
        }
    }
    public function edit($id)
    {
        $this->data['page_title'] = "Edit news";
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
        $this->data['news'] = $this->politicalModel->find($id);
        return view('admin/pages/political/news/edit', $this->data);
    }

    public function update($id)
    {
        $rules = [
            'title' => 'required|min_length[5]|max_length[50]',
            'description' => 'required|min_length[5]|max_length[50]',
        ];
        if (!$this->validate($rules)) {
            $this->data['validation'] = $this->validator->getErrors();
            $this->data['page_title'] = "Edit political news";
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
            $this->data['news'] = $this->politicalModel->find($id);
            return view('admin/pages/political/news/edit', $this->data);
        }

        $updateData = [
            'title' => $this->request->getVar('title'),
            'description' => $this->request->getVar('description'),
            'created_by' =>getCurrentUser()['id'],
        ];
        $attachment  = $this->request->getFile('attachment');
      
        if (!empty($attachment) && $attachment->isValid() && !$attachment->hasMoved()) {
            $updateData['attachment'] = storeMedia($attachment, 'attachment');
            
        }
        $res = $this->politicalModel->update($id, $updateData);
        $session = \Config\Services::session();
        if ($res) {
            $session->setFlashdata('success', 'News   is updated');
            return redirect('admin/political-news');
        } else {
            $session->setFlashdata('error', 'Failed to update the news');
            return redirect('admin/political-news');

        }
    }

    public function delete($id)
    {
        $session = \Config\Services::session();
        if ($this->politicalModel->delete($id)) {
          
            $session->setFlashdata('success', 'News  is deleted');
        } else {
            $session->setFlashdata('error', 'Failed to delete news');
        }
        return redirect('admin/political-news');
    }

  
   
}
