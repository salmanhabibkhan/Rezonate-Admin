<?php

namespace App\Controllers\Admin;

use App\Models\Package;
use App\Models\PackageModel;
use App\Controllers\Admin\AdminBaseController;

class PackageController extends AdminBaseController
{
    private  $packageModel;
    public  $session;
    public function __construct()
    {
        parent::__construct();
        $this->packageModel = new PackageModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        $this->data['page_title'] = lang('Admin.packages');
		$this->data['packages'] =  $this->packageModel->findAll();
		$this->data['All Settings'] = "All Packages";
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_or_customize_package'), 'url' => ''];
		return view('admin/pages/packages/index',$this->data);
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
                    'required' => lang('Admin.package_message.name_required'),
                ],
            ],
            'description' => [
                'label' => 'Description',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.description_required'),
                ],
            ],
            'like_amount' => [
                'label' => 'Like Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.like_amount_required'),
                ],
            ],
            'share_amount' => [
                'label' => 'Share Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.share_amount_required'),
                ],
            ],
            'comment_amount' => [
                'label' => 'Comment Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.comment_amount_required'),
                ],
            ],
            'po_like_amount' => [
                'label' => 'Post Like Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_like_amount_required'),
                ],
            ],
            'po_share_amount' => [
                'label' => 'Post Share Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_share_amount_required'),
                ],
            ],
            'po_comment_amount' => [
                'label' => 'Post Comment Amount',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_comment_amount_required'),
                ],
            ],
            'package_price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.package_price_required'),
                ],
            ],
        ];
    
        if (!$this->validate($validationRules)) {
            $this->data['page_title'] = lang('Admin.create_new_package');
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Package Information', 'url' => ''];
    
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/packages/create', $this->data);
        }
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'color' => $this->request->getVar('color'),
            'like_amount' => $this->request->getVar('like_amount'),
            'package_price' => $this->request->getVar('package_price'),
            'share_amount' => $this->request->getVar('share_amount'),
            'comment_amount' => $this->request->getVar('comment_amount'),
            'po_like_amount' => $this->request->getVar('po_like_amount'),
            'po_share_amount' => $this->request->getVar('po_share_amount'),
            'po_comment_amount' => $this->request->getVar('po_comment_amount'),
            'point_spendable' => !empty($this->request->getVar('point_spendable')) ? $this->request->getVar('point_spendable') : "0",
            'verified_badge' => !empty($this->request->getVar('verified_badge')) ? $this->request->getVar('verified_badge') : "0",
            'featured_member' => !empty($this->request->getVar('featured_member')) ? $this->request->getVar('featured_member') : "0",
            'post_promo' => !empty($this->request->getVar('post_promo')) ? $this->request->getVar('post_promo') : "0",
            'page_promo' => !empty($this->request->getVar('page_promo')) ? $this->request->getVar('page_promo') : "0",
            'status' => !empty($this->request->getVar('status')) ? $this->request->getVar('status') : "enable",
            'duration' => $this->request->getVar('duration'),
            'video_upload_size' => !empty($this->request->getVar('video_upload_size')) ?? 0,
            'longer_post' => $this->request->getVar('longer_post'),
            'edit_post' => $this->request->getVar('edit_post') ?? 0,
        ];

        $res = $this->packageModel->save($data);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.package_created_success'));
            return redirect('admin/packages');
        } else {
            $this->session->setFlashdata('error', lang('Admin.package_creation_failed'));
            return redirect('admin/packages/create');
        }
    }
    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_package');

        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_package'), 'url' => ''];
        $this->data['package'] = $this->packageModel->find($id);
        return view('admin/pages/packages/edit', $this->data);
    }
    public function update($id)
    {

        $validationRules = [
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.name_required'),
                ],
            ],
            'description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.description_required'),
                ],
            ],
            'package_price' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.package_price_required'),
                ],
            ],
            'like_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.like_amount_required'),
                ],
            ],
            'share_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.share_amount_required'),
                ],
            ],
            'comment_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.comment_amount_required'),
                ],
            ],
            'po_like_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_like_amount_required'),
                ],
            ],
            'po_share_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_share_amount_required'),
                ],
            ],
            'po_comment_amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.package_message.po_comment_amount_required'),
                ],
            ],
        ];
        
        if (!$this->validate($validationRules)) {
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'General Settings', 'url' => ''];
            $this->data['package'] = $this->packageModel->find($id);
            $this->data['validation'] = $this->validator->getErrors();
            return view('admin/pages/packages/edit', $this->data);
        }
        
        $data = [
            'name' => $this->request->getVar('name'),
            'description' => $this->request->getVar('description'),
            'color' => $this->request->getVar('color'),
            'like_amount' => $this->request->getVar('like_amount'),
            'package_price' => $this->request->getVar('package_price'),
            'share_amount' => $this->request->getVar('share_amount'),
            'comment_amount' => $this->request->getVar('comment_amount'),
            'po_like_amount' => $this->request->getVar('po_like_amount'),
            'po_share_amount' => $this->request->getVar('po_share_amount'),
            'po_comment_amount' => $this->request->getVar('po_comment_amount'),
            'point_spendable' => !empty($this->request->getVar('point_spendable')) ? $this->request->getVar('point_spendable') : "0",
            'verified_badge' => !empty($this->request->getVar('verified_badge')) ? $this->request->getVar('verified_badge') : "0",
            'featured_member' => !empty($this->request->getVar('featured_member')) ? $this->request->getVar('featured_member') : "0",
            'post_promo' => !empty($this->request->getVar('post_promo')) ? $this->request->getVar('post_promo') : "0",
            'page_promo' => !empty($this->request->getVar('page_promo')) ? $this->request->getVar('page_promo') : "0",
            'status' => !empty($this->request->getVar('status')) ? $this->request->getVar('status') : "disable",
            'duration' => $this->request->getVar('duration'),
            'video_upload_size' => !empty($this->request->getVar('video_upload_size')) ?? 0,
            'longer_post' => $this->request->getVar('longer_post'),
            'edit_post' => $this->request->getVar('edit_post') ?? 0,

        ];

        $res = $this->packageModel->update($id, $data);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.package_updated_success'));
            return redirect('admin/packages');
        } else {
            $this->session->setFlashdata('error', lang('Admin.package_update_failed'));
            return redirect('admin/packages');
        }
    }


    public function delete($id)
    {
        $res = $this->packageModel->delete($id);
        if ($res) {
            $this->session->setFlashdata('success', lang('Admin.package_deleted_success'));
            return redirect('admin/packages');
        } else {
            $this->session->setFlashdata('error', lang('Admin.package_deletion_failed'));
            return redirect('admin/packages');
        }
    }
}
