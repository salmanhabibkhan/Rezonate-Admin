<?php

namespace App\Controllers\Admin;

use App\Models\PostModel;

use App\Controllers\Admin\AdminBaseController;

class PostsController extends AdminBaseController
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new PostModel();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_posts');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => ''];
        $this->data['posts'] = $this->postModel->getAllPost();
        return view('admin/pages/all-posts', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_post');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => ''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        return view('admin/posts/create', $this->data);
    }

    public function delete($id)
    {
        $this->postModel->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', lang('Admin.post_deleted_successfully'));
        return redirect('admin/posts');
    }
}

