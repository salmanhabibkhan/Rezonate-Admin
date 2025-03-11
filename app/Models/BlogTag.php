<?php

namespace App\Models;

use CodeIgniter\Model;

class BlogTag extends Model
{
    protected $table            = 'blog_tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['blog_id','tag_id'];

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
    public function deleteTagsByBlogId($blogId)
    {
        return $this->where('blog_id', $blogId)->delete();
    }
    public function getTag($blogId)
    {
        $dbPrefix = $this->db->DBPrefix;
    
        $result = $this->select("$dbPrefix" . 'tags.name')
            ->join("$dbPrefix" . 'tags', "$dbPrefix" . 'tags.id = ' . "$dbPrefix" . 'blog_tags.tag_id')
            ->where("$dbPrefix" . 'tags.deleted_at', null)
            ->where("$dbPrefix" . 'blog_tags.blog_id', $blogId)
            ->findAll();
    
        return array_column($result, 'name');
    }
    
}
