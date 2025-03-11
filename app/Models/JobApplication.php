<?php

namespace App\Models;

use CodeIgniter\Model;

class JobApplication extends Model
{
    protected $table            = 'job_applications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','job_id','phone','position','previous_work','cv_file','description','location'];

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
    public function deleterecordByjobId($jobId)
    {
        return $this->where('job_id',$jobId)->delete();
    }
    public function getApplicants($job_id)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select([$dbPrefix.'users.username', $dbPrefix.'users.email', $dbPrefix.'users.avatar', $dbPrefix.'users.gender', $dbPrefix.'job_applications.*'])
            ->join($dbPrefix.'users', $dbPrefix.'users.id = '.$dbPrefix.'job_applications.user_id')
            ->where($dbPrefix.'job_applications.job_id', $job_id)
            ->where($dbPrefix.'users.deleted_at', null)
            ->findAll();
    }
    
    public function checkApplied($job_id,$user_id){
        $appliedjob = $this->where(['user_id'=>$user_id,'job_id'=>$job_id])->first();
        if(!empty($appliedjob))
        {
            return true;
        }
        else{
            return false;
        }
    }
}
