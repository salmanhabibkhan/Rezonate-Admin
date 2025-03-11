<?php

namespace App\Models;

use CodeIgniter\Model;

class PollModel extends Model
{
    protected $table            = 'polls';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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
    public function getCompiledPageData($pollId,$loggedInUserId)
    {
        $poll = $this->find($pollId);
        if(!empty($poll))
        {
            $pollresultModel = New PollResult;
            $polloptionModel = New PollOption();
            $poll_options = $polloptionModel->where('poll_id',$pollId)->findAll();
            $total_votes = 0;
            foreach($poll_options as &$option)
            {   
                $option['no_of_votes'] = $pollresultModel->where(['poll_id'=>$pollId,'option_id'=>$option['id']])->countAllResults();
                $total_votes = $total_votes + $option['no_of_votes'];
            }
            $poll['poll_options'] = $poll_options;
            $poll['poll_total_votes'] = $total_votes;
            
            $is_voted = $pollresultModel->where(['user_id'=>$loggedInUserId,'poll_id'=>$pollId])->first();
            $poll['is_voted'] = (!empty($is_voted))? '1':'0';
            $poll['user_voted_id'] = (!empty($is_voted))? $is_voted['option_id']:'0';
            return $poll;
        }
        return null;
    }
}
