<?php

namespace App\Models;

use CodeIgniter\Model;

class HashTagModel extends Model
{
    protected $table            = 'hash_tags';
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
    public function hashtagposts($hashtag)
    {
        $hashtagdata = $this->where('name',$hashtag)->first();
     
        if(!empty($hashtagdata))
        {
            $postTagModel = New PostTagModel;
            $posts  = $postTagModel->where('tag_id',$hashtagdata['id'])->findAll();
            $columnValues = array_column($posts, 'post_id');
            $columnValuesStr = implode(',',$columnValues);
            return $columnValuesStr;
        }
        return null;
    }
    public function getTrendingtag($limit=10)
    {
        return $this->select('hash_tags.id, hash_tags.name, COUNT(pt.tag_id) AS tag_count')
                ->join('post_tags pt', 'hash_tags.id = pt.tag_id')
                ->where('hash_tags.deleted_at', null) // Assuming you're using soft deletes
                ->groupBy('hash_tags.id, hash_tags.name') // Group by id as well to avoid the error
                ->orderBy('tag_count', 'DESC')
                ->limit($limit)
                ->findAll();
    }
}
