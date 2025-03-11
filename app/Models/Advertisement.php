<?php

namespace App\Models;

use CodeIgniter\Model;

class Advertisement extends Model
{
    protected $table            = 'advertisements';
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
    public function getPostAdvertisement($id)
    {
        $advertisement = $this->where('post_id',$id)->where('status',2)->orderBy('RAND()') 
        ->limit(1)
        ->first();
        if(!empty($advertisement))
        {
            if(!empty($advertisement['image']))
            {
                $advertisement['image'] = getMedia($advertisement['image']);
            }
        }
        return $advertisement;
    }
}
