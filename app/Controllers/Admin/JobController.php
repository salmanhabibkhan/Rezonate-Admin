<?php

namespace App\Controllers\Admin;

use App\Models\Job;
use App\Models\JobApplication;

use App\Controllers\Admin\AdminBaseController;

class JobController extends AdminBaseController
{
    private $jobModel;
    private $session;
    public function __construct()
    {
        parent::__construct();
        $this->session = \Config\Services::session();
        $this->jobModel = new job();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_jobs');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.all_jobs'), 'url' => ''];
        $this->data['jobs'] = $this->jobModel->getAllJobs();
        return view('admin/pages/jobs/index', $this->data);
    }



    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_job');;
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_job'), 'url' => ''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['job'] = $this->jobModel->find($id);
        return view('admin/pages/jobs/edit', $this->data);
    }


    public function update($id)
    {
        $rules = [
            'job_title' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.job_title_required'),
                ],
            ],
            'job_description' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.job_description_required'),
                ],
            ],
            'job_location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.job_location_required'),
                ],
            ],
            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.category_required'),
                ],
            ],
            'minimum_salary' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.minimum_salary_required'),
                ],
            ],
            'maximum_salary' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.maximum_salary_required'),
                ],
            ],
            'currency' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.currency_required'),
                ],
            ],
            'salary_date' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.salary_date_required'),
                ],
            ],
            'experience_years' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.job_message.experience_years_required'),
                ],
            ],
        ];

        if ($this->validate($rules)) {
            $inserted_data = [
                'job_title' => $this->request->getVar('job_title'),
                'job_description' => $this->request->getVar('job_description'),
                'job_location' => $this->request->getVar('job_location'),
                'category' => $this->request->getVar('category'),
                'minimum_salary' => $this->request->getVar('minimum_salary'),
                'maximum_salary' => $this->request->getVar('maximum_salary'),
                'lon' => $this->request->getVar('lon'),
                'salary_date' => $this->request->getVar('salary_date'),
                'currency' => $this->request->getVar('currency'),
                'lat' => $this->request->getVar('lat'),
                'is_urgent_hiring' => $this->request->getVar('is_urgent_hiring'),
                'experience_years' => $this->request->getVar('experience_years'),
                'company_name' => $this->request->getVar('company_name'),
                'expiry_date' => $this->request->getVar('expiry_date'),
            ];

            $avatar  = $this->request->getFile('avatar');
            $background_image = $this->request->getFile('background_image');
            $cover = $this->request->getFile('cover');

            $this->jobModel->update($id, $inserted_data);
            $this->session->setFlashdata('success', lang('Admin.job_is_updated'));

            return redirect('admin/jobs');
        } else {
            $validationErrors = $this->validator->getErrors();
            $job = $this->jobModel->find($id);
            return view('admin/pages/jobs/edit', ['validation' => $validationErrors, 'job' => $job]);
        }
    }



    public function delete($id)
    {
        $this->jobModel->delete($id);
        $this->session->setFlashdata('success', lang('Admin.job_is_deleted'));

        return redirect('admin/jobs');
    }
    public function applicants($id)
    {

        $jobApplicationModel = new JobApplication();
        $this->data['page_title'] = lang('Admin.job_applicants');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.job_applicants'), 'url' => ''];
        $this->data['applicants'] = $jobApplicationModel->getApplicants($id);
        return view('admin/pages/jobs/details', $this->data);
    }
}
