<?php

namespace App\Controllers\Admin;

use App\Models\Page;
use App\Controllers\BaseController;
use App\Controllers\Admin\AdminBaseController;

class PageController extends AdminBaseController
{
    public  $session;
    private $pageModel;
    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new Page();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $this->data['page_title'] = lang('Admin.pages');
        $this->data['breadcrumbs'][] = ['name' =>  lang('Admin.pages'),'url' => ''];
        $perPage = 20;
        $this->data['pages'] = $this->pageModel->select(['page_title','page_username','id','page_description'])->paginate($perPage);
        $this->data['pager'] = $this->pageModel->pager;
        return view('admin/pages/all-pages', $this->data);
    }
    public function create()
    {
        $this->data['page_title'] = "Create new  Page";
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
        return view('admin/pages/add-page', $this->data);
    }
    public function store()

    {

        $rules = [
            'page_username' => 'required|min_length[5]|max_length[50]',
            'page_title' => 'required|min_length[5]|max_length[50]',
            'page_description' => 'required',
            'page_category' => 'required',

        ];


        if ($this->validate($rules)) {

            $pageTitle = $this->request->getVar('page_title');
            $basePAgeName = url_title($pageTitle, '-', true);
            $uniqueGroupName = $basePAgeName;
            $counter = 1;

            // Check if the group name already exists and modify it if necessary
            while ($this->pageModel->where('page_username', $uniqueGroupName)->first()) {
                $uniqueGroupName = $basePAgeName . '-' . $counter;
                $counter++;
            }

            $pageUserName = !empty($uniqueGroupName) ? $uniqueGroupName : $basePAgeName;
            $inserted_data = [

                'page_username' => $pageUserName,
                'page_title' => $this->request->getVar('page_title'),
                'page_description' => $this->request->getVar('page_description'),
                'page_category' => $this->request->getVar('page_category'),
                'website' => $this->request->getVar('website'),
                'facebook' => $this->request->getVar('facebook'),
                'google' => $this->request->getVar('google'),
                'phone' => $this->request->getVar('phone'),
                'address' => $this->request->getVar('address'),
                'company' => $this->request->getVar('company'),
                'background_image_status' => $this->request->getVar('background_image_status'),

            ];
            $avatar  = $this->request->getFile('avatar');
            $background_image = $this->request->getFile('background_image');
            $cover = $this->request->getFile('cover');
            if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
                $pagecover = storeMedia($cover, 'cover');
                $inserted_data['cover'] = $pagecover;
            }
            if (!empty($avatar) && $avatar->isValid() && !$avatar->hasMoved()) {
                $pageavatar = storeMedia($avatar, 'avatar');
                $inserted_data['avatar'] = $pageavatar;
            }
            if (!empty($background_image) &&  $background_image->isValid() && !$background_image->hasMoved()) {
                $page_background = storeMedia($background_image, 'background_image');
                $inserted_data['page_background'] = $page_background;
            }


            $this->pageModel->save($inserted_data);
            $this->session->setFlashdata('success', 'Page  is create');
            return redirect('admin/pages');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/create', ['validation' => $validationErrors]);
        }
    }



    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_page'); // Translated string for "Edit Page"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_page'), 'url' => '']; // Translated string for "Website Information"
        $this->data['page'] = $this->pageModel->find($id);
        return view('admin/pages/edit-page', $this->data);
    }


    public function update($id)
    {
        $userid = getCurrentUser()['id'];

        $inserted_data = [
            'user_id' => $userid,

            'page_title' => $this->request->getVar('page_title'),
            'page_description' => $this->request->getVar('page_description'),
            'page_category' => $this->request->getVar('page_category'),
            'website' => $this->request->getVar('website'),
            'facebook' => $this->request->getVar('facebook'),
            'google' => $this->request->getVar('google'),
            'vk' => $this->request->getVar('vk'),
            'twitter' => $this->request->getVar('twitter'),
            'linkedin' => $this->request->getVar('linkedin'),
            'phone' => $this->request->getVar('phone'),
            'address' => $this->request->getVar('address'),
            'instgram' => $this->request->getVar('instgram'),
            'youtube' => $this->request->getVar('youtube'),
            'company' => $this->request->getVar('company'),



        ];
        $avatar  = $this->request->getFile('avatar');
        $background_image = $this->request->getFile('background_image');
        $cover = $this->request->getFile('cover');

        if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
            $pagecover = storeMedia($cover, 'cover');
            $inserted_data['cover'] = $pagecover;
        }
        if (!empty($avatar) && $avatar->isValid() && !$avatar->hasMoved()) {
            $pageavatar = storeMedia($avatar, 'avatar');
            $inserted_data['avatar'] = $pageavatar;
        }
        if (!empty($background_image) &&  $background_image->isValid() && !$background_image->hasMoved()) {
            $page_background = storeMedia($background_image, 'background_image');
            $inserted_data['page_background'] = $page_background;
        }



        if ($this->pageModel->update($id, $inserted_data)) {
            $this->session->setFlashdata('success', lang('Admin.page_message.update_success'));
        } else {
            $this->session->setFlashdata('error', lang('Admin.page_message.update_error'));
        }
        return redirect('admin/pages');
    }


    public function delete($id)
    {
        $this->pageModel->deltePageById($id);
        $this->session->setFlashdata('success', 'Page  is deleted');
        return redirect('admin/pages');
    }
}
