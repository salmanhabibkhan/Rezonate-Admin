<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use App\Models\BloodRequest;
use App\Controllers\BaseController;

class BloodController extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_blood_requests'); // Translated string for "All Blood Requests"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_blood_requests'), 'url' => '']; // Translated string for "Manage blood requests"
        $bloodModel = new BloodRequest();
        $perPage = 20;
        $bloodrequests = $bloodModel->paginate($perPage);

        if (!empty($bloodrequests)) {
            $userModel = new UserModel();
            foreach ($bloodrequests as &$bloodrequest) {
                $bloodrequest['user'] = $userModel->getUserShortInfo($bloodrequest['user_id']);
            }
        }
        $this->data['blood_requests'] = $bloodrequests;
        $this->data['pager'] = $bloodModel->pager;

        return view('admin/pages/blood/index', $this->data);

    }
    public function bloodDonors()
    {
        $this->data['page_title'] = lang('Admin.all_blood_donors'); // Translated string for "All Blood Donors"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_blood_donors'), 'url' => '']; // Translated string for "Manage Blood Donors"
        $userModel = new UserModel();
        $perPage = 20;
        $this->data['blood_donors'] = $userModel->select(['username', 'email', 'address', 'gender', 'phone', 'blood_group', 'donation_available'])
            ->where('blood_group IS NOT NULL')
            ->paginate($perPage);
        $this->data['pager'] = $userModel->pager;
        
        return view('admin/pages/blood/donors', $this->data);
    }
    public function delete($id)
    {
      
        $bloodrequest =New BloodRequest();
        $bloodrequest->delete($id);
        $session = \Config\Services::session();
        $session->setFlashdata('success', lang('Admin.bloodrequest_deleted_success'));
        return redirect()->to('admin/blood-requests');

    }
}
