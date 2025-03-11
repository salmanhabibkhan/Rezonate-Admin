<?php

namespace App\Models;

use CodeIgniter\Model;

class Job extends Model
{
    protected $table            = 'jobs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','job_title','job_description','job_location','lat','lon','minimum_salary','maximum_salary','job_type','category','company_name','is_urgent_hiring','experience_years',	'expiry_date','job_image','is_active','salary_date','currency'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
    
    public function getAllJobs()
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'jobs.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'jobs.user_id')
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll();
    }
    
    public function getSearchJobs($search_string,$limit,$offset)
    {
        $jobs = $this->like('job_title',$search_string)->findAll($limit, $offset);
        if(!empty($jobs))
        {
            $jobapplicationModel  = New JobApplication;
            foreach($jobs as &$job)
            {
                $job['category'] = JOB_CATEGORIES[$job['category']];
                $job['is_applied']  = $jobapplicationModel->checkApplied($job['id'],getCurrentUser()['id']);
            }
           return $jobs;
        }
    }
    public function getNewJob($userId,$limit,$offset)
    {
        $user_id = getCurrentUser()['id'];
        $builder = $this->builder();
        $builder->select('j.*')
        ->distinct()
            ->from('jobs as j')
            ->join('job_applications', 'j.id = job_applications.job_id', 'left')
            ->where('j.user_id !=', $userId) // User is not the owner of the job
            ->groupStart() // Start grouping the OR conditions
                ->where('job_applications.user_id IS NULL') // User has not applied for the job
                ->orWhere('job_applications.user_id !=', $userId) // Or user applied but isn't the same user
            ->groupEnd() // End grouping
            ->where('j.deleted_at IS NULL') // Exclude soft-deleted jobs
        ->limit($limit, $offset);

        $query = $builder->get();
        $jobs = $query->getResult();
        if(!empty($jobs))
        {
            $jobapplicationModel  = New JobApplication;
            foreach($jobs as &$job)
            {
                $job->category = JOB_CATEGORIES[$job->category];
                $job->is_applied = $jobapplicationModel->checkApplied($job->id,$user_id);
                
            }
            return $jobs;
        }
        
    }
    
    
}
