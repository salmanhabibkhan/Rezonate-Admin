<?php

namespace App\Controllers\Admin;

use App\Models\Group;
use App\Models\GroupMember;

use App\Controllers\Admin\AdminBaseController;

class groupController extends AdminBaseController
{
    private $groupModel;
    public  $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        $this->groupModel = new group();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_groups');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.all_groups'), 'url' => ''];
        $perPage = 20;
        $this->data['groups'] = $this->groupModel->select(['group_title','category','about_group','id'])->paginate($perPage);
        $this->data['pager'] = $this->groupModel->pager;
        return view('admin/pages/groups/index', $this->data);
    }



    public function edit($id)
    {

        $this->data['page_title'] = lang('Admin.edit_group');

        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_group'), 'url' => ''];
        $this->data['js_files'] = ['/js/jquery.validate.min.js'];

        $this->data['group'] = $this->groupModel->find($id);
        return view('admin/pages/groups/edit', $this->data);
    }


    public function update($id)
    {
        $inserted_data = [

            'group_title' => $this->request->getVar('group_title'),
            'about_group' => $this->request->getVar('about_group'),
            'category' => $this->request->getVar('category'),
        ];
        $avatar  = $this->request->getFile('avatar');
        $cover = $this->request->getFile('cover');
        if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
            $groupcover = storeMedia($cover, 'cover');
            $inserted_data['cover'] = $groupcover;
        }
        if (!empty($avatar)  && $avatar->isValid() && !$avatar->hasMoved()) {
            $groupavatar = storeMedia($avatar, 'avatar');
            $inserted_data['avatar'] = $groupavatar;
        }
        $this->groupModel->update($id, $inserted_data);
        $this->session->setFlashdata('success', lang('Admin.update_group_success'));
        return redirect('admin/groups');
    }


    public function delete($id)
    {
        $this->groupModel->delteGroupById($id);
        $this->session->setFlashdata('success', lang('Admin.delete_group_success'));
        
        return redirect('admin/groups');
    }
    public function getGroupMembers($id)
    {
        $groupMemberModel = new GroupMember();
        $this->data['page_title'] = lang('Admin.group_members');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.group_members'), 'url' => ''];
        $this->data['groupmembers'] = $groupMemberModel->getGroupMembers($id);
        return view('admin/pages/groups/details', $this->data);
    }
}
