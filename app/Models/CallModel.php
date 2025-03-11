<?php

namespace App\Models;

use CodeIgniter\Model;

class CallModel extends Model
{
    protected $table            = 'calls';
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
    public function getUserCallHistory($userId,$limit,$offset)
    {
        // Retrieve call history for the user, excluding live_stream type
        return $this->where('type!=','live_stream')
        ->withDeleted()
        ->where('is_deleted',0)
        ->groupStart()
            ->where('user_id',$userId)
            ->orWhere('to_user_id',$userId)
        ->groupEnd()

        ->orderBy('id','desc')
        ->findAll($limit,$offset);

    }
}
