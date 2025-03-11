<?php

namespace App\Models;

use CodeIgniter\Model;

class offer extends Model
{
    protected $table            = 'offers';
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


  
    public function getoffer($offer_id){
      $offer = $this->where('id', $offer_id)->get()->getFirstRow('array');
      if(empty($offer)) return [];
      $offer = $this->compile_offer_data($offer);
      return $offer;
   
    }

    public function compile_offer_data($offer){
        if(!empty($offerImages)){
            foreach ($offerImages as &$image) {
                $image['image'] = getMedia($image['image']);
            }
            $offer['images'] = $offerImages;    
        }
        return $offer;
    }

}
