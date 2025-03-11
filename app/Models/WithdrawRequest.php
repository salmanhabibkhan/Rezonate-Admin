<?php

namespace App\Models;

use CodeIgniter\Model;

class WithdrawRequest extends Model
{
    protected $table            = 'withdraw_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
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
    public function getWithdrawRequestData()
    {
        $builder = $this->db->table('withdraw_requests as wr');
        $builder->select('wr.*, u.username,'); // Add the columns you need   g.*
        $builder->join('users as u', 'u.id = wr.user_id', 'left');
        // $builder->join('gateway as g', 'g.id = wr.gateway_id', 'left');
        
        $builder->where('wr.deleted_at', null);

        $query = $builder->get();
        $result = $query->getResultArray();

        return $result;
    }
    public function getwithdrawrequest($id)
    {
        return $this->select('withdraw_requests.*, users.username,users.email')
        ->join('users', 'users.id = withdraw_requests.user_id', 'left')
        ->where('withdraw_requests.id', $id)
        ->where('withdraw_requests.deleted_at', null)
        ->first();
      
    }
    public function getadminwithdrawrequest($limit)
    {
        
        $result_withdraw=base_urls();
        return $this->select('withdraw_requests.*, users.username,users.avatar')
            ->join('users', 'users.id = withdraw_requests.user_id', 'left')
            ->where('withdraw_requests.deleted_at', null)
            ->orderBy('withdraw_requests.id','desc')
        ->findAll($limit);
    }
}
