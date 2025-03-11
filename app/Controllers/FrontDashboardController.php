<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Controllers\BaseController;
use App\Models\Page;

class FrontDashboardController extends BaseController
{
    public function people($startWord='A',$page=1)
    {
        $userModel = New UserModel;
        $pager = service('pager');
        $total = $userModel->like('username', $startWord, 'after')->countAllResults();
        $perPage = 20;
        $users = $userModel->select(['username','first_name','last_name'])->like('username', $startWord, 'after')->paginate($perPage);
        $totalPages = ceil($total / $perPage);
    
    // Check if the current page is within valid range
        if ($page < 1 || $page > $totalPages) {
            $page = 1; // Set default to first page if out of range
        }
        $data['pager'] = $pager;
        $data['users'] = $users;
        $data['start_word'] = $startWord;
        echo load_view('public/all-users',$data);
    }
    public function pages($startWord='A',$page=1)
    {
        $userModel = New Page;
        $pager = service('pager');
        $total = $userModel->like('page_username', $startWord, 'after')->countAllResults();
        $perPage = 8;
        $pages = $userModel->select(['page_username','page_title'])->like('page_username', $startWord, 'after')->paginate($perPage);
        $totalPages = ceil($total / $perPage);
    
    // Check if the current page is within valid range
        if ($page < 1 || $page > $totalPages) {
            $page = 1; // Set default to first page if out of range
        }
        $data['pager'] = $pager;
        $data['pages'] = $pages;
        $data['start_word'] = $startWord;
        echo load_view('public/all-pages',$data);
    }
}
