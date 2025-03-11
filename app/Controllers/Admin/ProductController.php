<?php

namespace App\Controllers\Admin;

use App\Models\Product;
use App\Models\UserModel;
use App\Models\ProductMedia;
use App\Controllers\BaseController;

class ProductController extends AdminBaseController
{
    private $productModel;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_products');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_products'), 'url' => ''];
        $perPage = 20;
        $this->data['products'] = $this->productModel->paginate($perPage);
        $this->data['pager'] = $this->productModel->pager;
        return view('admin/pages/products/index', $this->data);
    }

    public function view($id)
    {
        $this->data['page_title'] = lang('Admin.product_detail');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.product_detail'), 'url' => ''];
        $productMediaModel = new ProductMedia();
        $userModel = new UserModel();
        
        $product = $this->productModel->find($id);
        $this->data['product_media'] = $productMediaModel->where('product_id', $id)->findAll();
        $this->data['product_user'] = $userModel->getUserShortInfo($product['user_id']);
        $this->data['product'] = $product;
        return view('admin/pages/products/details', $this->data);
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        $this->session = \Config\Services::session();
        $this->session->setFlashdata('success', lang('Admin.product_deleted_successfully'));
        return redirect('admin/products');
    }
}

