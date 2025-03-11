<?php

namespace App\Models;

use CodeIgniter\Model;

class Product extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id','page_id','product_name','product_description','category','sub_category','price','location','status','currency','lon','lat','is_active','type','units'];

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


    public function productsMedia()
    {
        return $this->hasMany('images', 'App\Models\ProductMedia');
        // $this->hasMany('propertyName', 'model', 'foreign_key', 'local_key');
    }

    public function getProduct($product_id){
      $product = $this->where('id', $product_id)->get()->getFirstRow('array');
      if(empty($product)) return [];
      $product = $this->compile_product_data($product);
      return $product;
   
    }

    public function compile_product_data($product){
            
            $productMediaModel = model('ProductMedia');
            $userModel = model('UserModel');
            $productImages = $productMediaModel->select(['id', 'image'])->where('product_id', $product['id'])->findAll();
            $product['images'] = [];
            $product['user_info'] =$userModel->getUserShortInfo($product['user_id']);
            $product['status'] = ($product['units']>0)?'0':'1';
            $product['category'] = $product['category']?PRODUCT_CATEGORIES[$product['category']]:'';
            $product[''] = ($product['units']>0)?'0':'1';
            if(!empty($productImages)){
                foreach ($productImages as &$image) {
                    $image['image'] = getMedia($image['image']);
                }
                $product['images'] = $productImages;
                
                
                
            }
        return $product;
    }




}
