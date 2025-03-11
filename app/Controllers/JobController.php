<?php

namespace App\Controllers;

use App\Models\Job;
use Firebase\JWT\JWT;
use App\Models\JobCategory;
use App\Models\JobApplication;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class JobController extends BaseController
{

    use ResponseTrait;

   

    public function createJob()
    {
        $rules = [
            'job_title' => [
                'label' => 'Job Title',
                'rules' => 'required|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => lang('Api.job_title_required'),
                    'regex_match' => lang('Api.job_title_invalid'),
                ],
            ],
            'job_description' => [
                'label' => 'Job Description',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_description_required'),
                ],
            ],
            'job_location' => [
                'label' => 'Job Location',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_location_required'),
                ],
            ],
            'category' => [
                'label' => 'Category',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.category_required'),
                ],
            ],
            'minimum_salary' => [
                'label' => 'Minimum Salary',
                // 'rules' => 'required|less_than_maximum[maximum_salary]',
                'errors' => [
                    'required' => lang('Api.minimum_salary_required'),
                    // 'less_than_maximum' => lang('Api.minimum_less_than_maximum'),
                ],
            ],
            'maximum_salary' => [
                'label' => 'Maximum Salary',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.maximum_salary_required'),
                ],
            ],

            'currency' => [
                'label' => 'Currency',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.currency_required'),
                ],
            ],
            'salary_date' => [
                'label' => 'Salary Date',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.salary_date_required'),
                ],
            ],
            'experience_years' => [
                'label' => 'Experience Years',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.experience_years_required'),
                ],
            ],
            // Uncomment and add rules for other fields if needed
            // 'lon' => [
            //     'label' => 'Longitude',
            //     'rules' => 'required',
            // ],
            // 'lat' => [
            //     'label' => 'Latitude',
            //     'rules' => 'required',
            // ],
            // 'is_urgent_hiring' => [
            //     'label' => 'Urgent Hiring',
            //     'rules' => 'required',
            // ],
            // 'expiry_date' => [
            //     'label' => 'Expiry Date',
            //     'rules' => 'required',
            // ],
            // 'is_active' => [
            //     'label' => 'Active Status',
            //     'rules' => 'required',
            // ],
        ];
        if ($this->validate($rules)) {
        $job = New Job;              
        $user_data = getCurrentUser();
        $data = [
            'user_id'=>$user_data['id'],
            'job_title'=> $this->request->getVar('job_title'),
            'job_description'=> $this->request->getVar('job_description'),
            'job_location'=> $this->request->getVar('job_location'),
            'category'=> $this->request->getVar('category'),
            'minimum_salary'=> $this->request->getVar('minimum_salary'),
            'maximum_salary'=> $this->request->getVar('maximum_salary'),
            'lon'=> $this->request->getVar('lon'),
            'salary_date'=> $this->request->getVar('salary_date'),
            'currency'=> $this->request->getVar('currency'),
            
            'lat'=> $this->request->getVar('lat'),
            'is_urgent_hiring'=> !empty($this->request->getVar('is_urgent_hiring'))?$this->request->getVar('is_urgent_hiring'):0,
            'experience_years'=>$this->request->getVar('experience_years'),
            'company_name'=>$this->request->getVar('company_name'),
            'job_type'=>$this->request->getVar('job_type'),
            'expiry_date'=>$this->request->getVar('expiry_date'),
        ];
        $job->save($data);
        $job_id = $job->insertID();
        $jobdata = $job->find($job_id);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.job_created_successfully'),
            'data' => $jobdata
        ], 200);
        }
        else
        {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'validation_error' => $validationErrors
            ], 200);
        }
    }
    public function edit($id)
    {
        $jobModel = New Job;
        $job = $jobModel->find($id);
        
        if($job['user_id']==$this->data['user_data']['id'])
        {
            $categoriesModel  = New JobCategory();
            $this->data['categories'] = $categoriesModel->findAll();
            $this->data['job'] = $job;
            echo load_view('pages/jobs/update-job', $this->data);   


        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

    }
    public function addJob()
    {
        $categoriesModel  = New JobCategory();
        $this->data['categories'] = $categoriesModel->findAll();
        echo load_view('pages/jobs/create-job', $this->data);   

    }
    public function deleteJob()
    {
        $rules = [
            'job_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_id_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {



            $job_id = $this->request->getVar('job_id');

            $database = \Config\Database::connect(); 
            $job_data = $this->checkOwnership($job_id);
            if($job_data==200)
            {
                 try {
                   
                    $job_id = $this->request->getVar('job_id');
                    $jobApplicationModel  = New JobApplication;
                    $jobApplicationModel->deleterecordByjobId($job_id);
                    $jobModel = New Job;
                    $jobModel->delete($job_id);

                    $database->transCommit();
    
                    return $this->respond([
                        'code' => '200',
                    'message' => lang('Api.job_deleted_successfully'),
                        'data' => "success"
                    ], 200);
                } catch (\Exception $e) {
                    // An error occurred, rollback the transaction
                    $database->transRollback();
                
                    echo 'Transaction failed: ' . $e->getMessage();
                }

            }
            elseif($job_data==401)
            {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => "success"
                ], 401);
            }
            else{
                return $this->respond([
                    'code' => '404',
                   'message' => lang('Api.job_not_found'),
                    'data' => "not found"
                ], 404);
            }
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }    

    }
    public function checkOwnership($blog_id)
    {
        $user_data = getCurrentUser();
        $model = New Job;
        $blog_data = $model->where('id',$blog_id)->first();
        
        if(!empty($blog_data))
        {
            if($blog_data['user_id']==$user_data['id'])
            {
                return 200;
            }
            else{
                return 401;
            }
            
        }
        else{
           return 404;
        }
    }

    public function getWebJobs()
    {
        $user_id = getCurrentUser()['id'];
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;
        $jobapplicationModel = New JobApplication;
    
        $jobModel = new Job;              
        $type = $this->request->getVar('type');
        

        $sort = $this->request->getVar('sort');
        if(!empty($sort)){
            switch($sort) {
                case 'latest':
                    $jobModel->orderBy('created_at', 'DESC');
                    break;
                case 'salary-high':
                    $jobModel->orderBy('maximum_salary', 'DESC');
                    break;
                case 'salary-low':
                    $jobModel->orderBy('maximum_salary', 'ASC');
                    break;
            }
        }
        $search = $this->request->getVar('search');
        if (!empty($search)) {
            $jobModel->groupStart();
            $jobModel->like('job_title', $search)
                     ->orLike('job_description', $search);
            $jobModel->groupEnd();
        }
        $categoryFilter = $this->request->getVar('category');

        if (!empty($categoryFilter)) {
            $jobModel->where('category', $categoryFilter);
        }
    
       


        // Check if fetching user's own jobs or all jobs
        if ($type == 'my') {
            $jobs = $jobModel->where('user_id', $user_id)->orderBy('id','desc')->findAll($limit, $offset);
        } else {
            $jobs = $jobModel->where('user_id !=', $user_id)->orderBy('id','desc')->findAll($limit, $offset);
        }
    
        // echo $jobModel->getLastQuery();
        // die;


        // Check if jobs are found and set category names
        if (!empty($jobs)) {
            foreach ($jobs as &$job) {
                $job['category'] = JOB_CATEGORIES[$job['category']] ?? 'Unknown';
                $job['is_applied'] = $jobapplicationModel->checkApplied($job['id'],$user_id); 
            }
            $this->data['jobs'] = $jobs;
        } else {
            $this->data['jobs'] = [];
        }
        $this->data['is_full_layout'] =1;
        $this->data['categories'] = JOB_CATEGORIES;
        $this->data['search'] = $search;
        // Load the view with jobs data
        $this->data['css_files'] = ['css/welcome.css'];

        echo load_view('pages/jobs/jobs', $this->data);   
    }

    public function jobDetail($id)
    {
        $current_user = getCurrentUser();
        $jobModel = new Job();
        $job = $jobModel->find($id);

       
        if (!$job) {
            // Job not found, redirect or show an error
            return redirect()->to(site_url('jobs'))->with('error', 'Job not found');
        }
        $jobapplicationModel = New JobApplication;
        $job['is_applied'] = $jobapplicationModel->checkApplied($job['id'],$current_user['id']); 
        $this->data['job'] = $job;
        // If you have categories or additional data, load them here as well.
        $this->data['categories'] = JOB_CATEGORIES;
        // Load the view with job data
        echo load_view('pages/jobs/jobs-detail', $this->data);
    }


    public function getJobs()
    {
      
        $user_id = getCurrentUser()['id'];
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        
        $jobModel = New Job;              
        $type = $this->request->getVar('type');
        if($type=='my')
        {
            $jobs =$jobModel->where('user_id',$user_id)->findAll($limit,$offset); 
            if(!empty($jobs))
            {
                foreach($jobs as &$job)
                {
                    $job['category'] = JOB_CATEGORIES[$job['category']];
                    $job['is_applied'] = false; 
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.my_jobs_fetched_successfully'),
                    'data' =>$jobs
                ], 200);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.no_job_found'),
                'data' =>$jobs
            ], 200);

        }
        else
        {
            $jobs =$jobModel->where('user_id!=',$user_id)->findAll($limit,$offset); 
            $jobapplicationModel = New JobApplication;
            if(!empty($jobs))
            {
                foreach($jobs as &$job)
                {
                    $job['category'] = JOB_CATEGORIES[$job['category']];
                    $job['is_applied'] = $jobapplicationModel->checkApplied($job['id'],$user_id); 
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.all_jobs_fetched_successfully'),
                    'data' =>$jobs
                ], 200);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.no_job_found'),
                'data' =>$jobs
            ], 200);
        }    
    }
    public function checkempty($jobs)
    {
        if(!empty($jobs))
        {
            return true;
        }
        return false;
    }
    public function applyJob()
    {
        
        $rules = [
            'job_id' => [
                'label' => 'Job ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_id_required'),
                ],
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.phone_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $jobApplicationModel = New JobApplication;              
            $user_id = getCurrentUser()['id'];
            $job_id = $this->request->getVar('job_id');
            $checkOldData = $jobApplicationModel->where(['user_id'=>$user_id,'job_id'=>$job_id])->first();
            if(empty($checkOldData))
            {
                $data = [
                    'job_id'=>$job_id,
                    'user_id'=>$user_id,
                    'phone'=>$this->request->getVar('phone'),
                    'position'=>$this->request->getVar('position'),
                    'previous_work'=>$this->request->getVar('previous_work'),
                    'description'=>$this->request->getVar('description'),
                    'location'=>$this->request->getVar('location'),
                ];
                $cv_file = $this->request->getFile('cv_file');
                if(!empty($cv_file))
                {
                    $data['cv_file'] = storeMedia($cv_file, 'cv_file','doc');
                }
                $jobApplicationModel->save($data);
                return $this->respond([
                    'code' => '200',
                   'message' => lang('Api.applied_successfully'),
                    'data' =>''
                ], 200);
            }
            else{
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.already_applied_for_job'),
                    'data' =>''
                ], 200);
            }
        }
        else
        {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'validation_error' => $validationErrors,
            ], 200);
        }
    }
    public function searchJob()
    {
        $type = $this->request->getVar('type');
        $user_id = getCurrentUser()['id'];
        $title = $this->request->getVar('title');
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $jobModel = New Job;
        if(empty($title)&& empty($type))
        {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.search_parameters_missing'),
                'data' =>''
            ], 400);
        }
        if(!empty($title) && !empty($type))
        {
            $jobs = $jobModel->like('job_title',$title)->where('job_type',$type)->findAll($limit,$offset);
        }
        elseif(!empty($title))
        {
            $jobs = $jobModel->like('job_title',$title)->findAll($limit,$offset);
        }
        elseif(!empty($type))
        {
            $jobs = $jobModel->where('job_type',$type)->findAll($limit,$offset);
        }
        if(!empty($jobs))
        {
            $jobapplicationModel = New JobApplication;
            foreach($jobs as &$job)
            {
                $job['category'] = JOB_CATEGORIES[$job['category']];
                $job['is_applied'] = $jobapplicationModel->checkApplied($job['id'],$user_id); 
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.search_success'),
                'data' =>$jobs
            ], 200);
        }
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.no_jobs_found'),
            'data' =>$jobs
        ], 200);
        
    }
    public function updateJob()
    {
        $rules = [
            'job_id' => [
                'label' => 'Job ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_id_required'),
                ],
            ],
        ];
    
        if ($this->validate($rules)) {
            $job = new Job; // Use Job instead of Group
            $user_data = getCurrentUser();
            $job_id = $this->request->getVar('job_id'); // Change 'group_id' to 'job_id'
    
            // Check ownership
            $job_data = $this->checkOwnership($job_id); // Change 'group_data' to 'job_data'
    
            if ($job_data == 200) {
                // Get all input data
                $data = [];
    
                // Loop through all input values and add them to the update array
                foreach ($this->request->getPost() as $key => $value) {
                    // Exclude the 'job_id' from the update array
                    if ($key != 'job_id') {
                        $data[$key] = $value;
                    }
                }
    
                // Handle file upload for cover or avatar if needed
    
                // Corrected the object name to $job instead of $group
                $job->update($job_id, $data); // Change 'group' to 'job'
    
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.job_update_success'),
                    'data' => $data
                ], 200);
            } elseif ($job_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.unauthorized'),
                    'data' => ''
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                   'message' => lang('Api.job_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }
    public function getJobCategories()
    {
        $JobCategoryModel = New JobCategory;
        $job_categories = $JobCategoryModel->findAll();
        if(!empty($job_categories))
        {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.job_categories_fetch_success'),
                'data' =>$job_categories
            ], 200);
        }
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.no_job_category_found'),
            'data' =>''
        ], 200);

    }
    public function appliedCandidates()
    {
        $rules = [
            'job_id' => [
                'label' => 'Job ID',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.job_id_required'),
                ],
            ],
        ];
    
        if($this->validate($rules))
        {
            $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
            $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
            $jobApplicationModel = new JobApplication;
           
            $job_id = $this->request->getVar('job_id');
           
            
            $appliedCandidates = $jobApplicationModel
                ->select(['job_applications.*', 'users.email', 'users.username', 'users.avatar'])
                ->join('users', 'job_applications.user_id = users.id')
                ->where('job_applications.job_id', $job_id)
                ->where('job_applications.deleted_at', null)
                ->where('users.deleted_at', null)
                ->offset($offset)
                ->limit($limit)
                ->get()
                ->getResult();

        if (!empty($appliedCandidates)) {
            $modifiedcandidates = [];

            foreach ($appliedCandidates as $candidate) {
                // Cast the object to an array
                $candidateArray = (array)$candidate;

                // Check if 'cv_file' and 'avatar' properties exist before modification
                if (isset($candidateArray['cv_file'])) {
                    $candidateArray['cv_file'] = getMedia($candidateArray['cv_file']);
                }

                if (isset($candidateArray['avatar'])) {
                    $candidateArray['avatar'] = getMedia($candidateArray['avatar']);
                }

                
                $modifiedcandidates[] = $candidateArray;
            }

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.fetch_applied_candidates_success'),
                'data' => $modifiedcandidates
            ], 200);
        }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.candidates_not_found'),
                'data' => ''
            ], 200);
            
            
        }
        else
        {
             $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }
    public function applyWebJob($id)
    {
        $jobModel = New Job;
        $this->data['user_data'] = getCurrentUser();

        $this->data['categories'] = JOB_CATEGORIES;
    
        $this->data['job'] = $jobModel->find($id);
      
        // Load the view with jobs data
        echo load_view('pages/jobs/apply-job', $this->data);   
    }
    public function getWebmyJobs()
    {
        $jobModel = New Job;
        $this->data['user_data'] = getCurrentUser();
        $userid = $this->data['user_data']['id'];
        $this->data['categories'] = JOB_CATEGORIES;
    
        $jobs = $jobModel->where('user_id',$userid)->findAll();
        if (!empty($jobs)) {
            foreach ($jobs as &$job) {
                $job['category'] = JOB_CATEGORIES[$job['category']] ?? 'Unknown';
                
            }
            $this->data['jobs'] = $jobs;
        } else {
            $this->data['jobs'] = [];
        }

        
        echo load_view('pages/jobs/my-jobs', $this->data);   
    }
    public function applicants($id)
    {
        $jobApplicationModel = New JobApplication();
        $this->data['categories'] = JOB_CATEGORIES;
        $this->data['user_data'] = getCurrentUser(); 
        $jobModel = New Job;
        $job =  $jobModel->find($id);
        if($job['user_id']==$this->data['user_data']['id'])
        {
            $this->data['applicants'] = $jobApplicationModel->getApplicants($id);
            echo load_view('pages/jobs/applicants', $this->data); 
        }
        else
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        

    }
}
