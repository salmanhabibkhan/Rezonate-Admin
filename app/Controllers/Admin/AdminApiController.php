<?php

namespace App\Controllers\Admin;

use App\Models\Settings;
use Firebase\JWT\JWT;
use App\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use App\Traits\ResponseTrait; //

class AdminApiController extends ResourceController
{


    public function updateSetting()
    {
        $model = new Settings();

        $validationRules = [
            'key'  => 'required|alpha_dash',
            'value' => 'required'
        ];
        if (!$this->validate($validationRules)) {
            //return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            return $this->respond(['error' => 'Error Validating'], 200);
        }

        $key = $this->request->getPost('key');
        $value = $this->request->getPost('value');

        if (IS_DEMO) {
            return $this->respond(['error' => 'You cant do this action in demo.'], 200);
        }
        
        // Validate input
        if (!$key) {
            return $this->respond(['error' => 'Key and value are required'], 200);
        }

        // Update the setting

        $model->set('value', $value);
        $model->where('name', $key);
        $model->update();
        // Clear or update the cache
        $cache = \Config\Services::cache();
        $cache->delete('settings');

        return $this->respond(['success' => 'Setting updated successfully'], 200);
    }


    public function get_users()
    {
        $model = new UserModel();

        $length = $this->request->getVar('length');
        $start = $this->request->getVar('start');
        $order = $this->request->getVar('order');
        $columns = $this->request->getVar('columns');
        $search = $this->request->getVar('search');

        $data = $model->getDataTableData($length, $start, $order, $columns, $search);

        return $this->respond($data);
    }
}
