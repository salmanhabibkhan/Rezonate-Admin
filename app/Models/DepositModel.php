<?php

namespace App\Models;

use CodeIgniter\Model;

class DepositModel extends Model
{
    protected $table            = 'deposites';
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
    public function getDepositDetails($limit)
    {
        $dbPrefix = $this->db->DBPrefix;
        
        return $this->select($dbPrefix.'deposites.*, '.$dbPrefix.'gateways.name, '.$dbPrefix.'users.username')
            ->join($dbPrefix.'gateways', $dbPrefix.'deposites.gateway_id = '.$dbPrefix.'gateways.id')
            ->join($dbPrefix.'users', $dbPrefix.'deposites.user_id = '.$dbPrefix.'users.id')
            ->orderBy($dbPrefix.'deposites.id','desc')
            ->findAll($limit);
    }
    public function getDepositRequestData()
    {
        $builder = $this->db->table('deposites as d');
        $builder->select('d.*, u.username,gw.name'); // Add the columns you need   g.*
        $builder->join('users as u', 'u.id = d.user_id', 'left');
        $builder->join('gateways as gw', 'gw.id = d.gateway_id', 'left');
        // $builder->join('gateway as g', 'g.id = d.gateway_id', 'left');
        
        $builder->where('d.deleted_at', null);

        $query = $builder->get();
        $result = $query->getResultArray();

        return $result;
    }
    public function getdepositRequest($id)
    {
        $dbPrefix = $this->db->DBPrefix;
        
        return $this->select($dbPrefix.'deposites.*, '.$dbPrefix.'gateways.name as gateway_name, '.$dbPrefix.'users.username')
            ->join($dbPrefix.'gateways', $dbPrefix.'deposites.gateway_id = '.$dbPrefix.'gateways.id')
            ->join($dbPrefix.'users', $dbPrefix.'deposites.user_id = '.$dbPrefix.'users.id')
            ->orderBy($dbPrefix.'deposites.id','desc')
            ->where($dbPrefix.'deposites.id',$id)
            ->first();
      
    }

}
