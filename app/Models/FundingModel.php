<?php

namespace App\Models;

use CodeIgniter\Model;

class FundingModel extends Model
{
    protected $table            = 'fund';
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
    public function processFundData($id)
    {
        $donation = $this->find($id);

        if(!empty($donation))
        {
            $donation['image'] = getMedia($donation['image']);
            $db =\Config\Database::connect();
            $query = $db->table('raise_fund')
             ->selectSum('amount', 'total_amount')
             ->where('fund_id', $id)
             ->get();
             $no_of_users = $db->table('raise_fund')
                ->select('COUNT(DISTINCT user_id) as num_donors')
                ->where('fund_id', $id)
                ->where('amount >', 0) // To count users who donated an amount (assuming amount > 0 means donation)
            ->get();
            $donation['collected_amount'] = ($query->getRow()->total_amount!=null || !empty($query->getRow()->total_amount))?(string)$query->getRow()->total_amount:'0';
            $donation['participated_users'] = ($no_of_users->getNumRows() > 0)?intval($no_of_users->getRow()->num_donors):0;
            return $donation;
        }
        return null;
    }
}
