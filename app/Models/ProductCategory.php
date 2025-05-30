<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductCategory extends Model
{
    protected $table            = 'products_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
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
    public function getcategories()
    {
        $categories = $this->select('id, name')->findAll();

        // Convert the result into an associative array like GROUP_CATEGORIES
        $formattedCategories = [];
        foreach ($categories as $category) {
            $formattedCategories[$category['id']] = $category['name'];
        }

        return $formattedCategories;
    }
}
