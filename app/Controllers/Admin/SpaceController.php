<?php

namespace App\Controllers\Admin;

use App\Models\Space;
use App\Models\SpaceMember;
use App\Models\UserModel;
use App\Controllers\BaseController;

class SpaceController extends AdminBaseController
{
    private $spaceModel;

    public function __construct()
    {
        parent::__construct();
        $this->spaceModel = new Space();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_spaces');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_spaces'), 'url' => ''];
        $perPage = 20;
        $spaces = $this->spaceModel->paginate($perPage);
        $userModel = new UserModel();
        
        if (!empty($spaces)) {
            foreach ($spaces as &$space) {
                $space['user'] = $userModel->getUsername($space['user_id']);
            }
        }

        $this->data['spaces'] = $spaces;
        $this->data['pager'] = $this->spaceModel->pager;
 
        return view('admin/pages/spaces/index', $this->data);
    }

    public function details($id)
    {
        $this->data['page_title'] = lang('Admin.space_detail');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.space_detail'), 'url' => ''];
        $userModel = new UserModel();
        $space = $this->spaceModel->find($id);
        $this->data['space_owner'] = $userModel->getUserShortInfo($space['user_id']);
        $this->data['space'] = $space;

        $spaceMemberModel = new SpaceMember();
        $this->data['members'] = $spaceMemberModel->getspaceallmembers($id); 

        return view('admin/pages/spaces/details', $this->data);
    }

    public function delete($id)
    {
        $this->spaceModel->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', lang('Admin.space_deleted'));

        return redirect('admin/spaces');
    }
}

