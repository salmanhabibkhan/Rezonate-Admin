<?php

namespace App\Models;
use CodeIgniter\Model;
    


class Settings extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','value'];

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


    // Function to update setting by name
    public function updateSetting($name, $value) {
        $this->set('value', $value)
             ->where('name', $name)
             ->update();

        // Clear or update the cache
        $cache = \Config\Services::cache();
        $cache->delete('settings');
      
    }

    public function getSettings()
    {
        //$cache = \Config\Services::cache();
        //$settings = $cache->get('settings');
        $settings =null;
        if ($settings === null) {
            $settingsArray = $this->findAll();
            $settings = [];
            foreach ($settingsArray as $setting) {
                $settings[$setting['name']] = $setting['value'];
            }
            // Cache the settings for a certain period, e.g., 1 day
            // $cache->save('settings', $settings, 86400);
        }
        return $settings;
    }


}
