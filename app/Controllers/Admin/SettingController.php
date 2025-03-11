<?php

namespace App\Controllers\Admin;

use App\Models\Settings;
use App\Controllers\BaseController;

class SettingController extends AdminBaseController
{
    public function mailConfiguration()
    {
        $settings = new Settings();
        $this->data['settings'] = $settings->getSettings();
        $this->data['page_title'] = lang('Admin.mail_configuration');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.mail_configuration'), 'url' => ''];
        return view('admin/pages/settings/mailconfiguration', $this->data);
    }

    public function gatewayIntigration()
    {
        $settings = new Settings();
        $this->data['settings'] = $settings->getSettings();
        $this->data['page_title'] = lang('Admin.payment_gateway_integration');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.payment_gateway_integration'), 'url' => ''];
        return view('admin/pages/settings/gatewayintigration', $this->data);
    }

    public function storageConfiguration()
    {
        $settings = new Settings();
        $this->data['settings'] = $settings->getSettings();
        $this->data['page_title'] = lang('Admin.storage_configuration');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.storage_configuration'), 'url' => ''];
        return view('admin/pages/settings/storageConfiguration', $this->data);
    }

    public function socialLoginIntegration()
    {
        $settings = new Settings();
        $this->data['settings'] = $settings->getSettings();
        $this->data['page_title'] = lang('Admin.social_login_integration');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.social_login_integration'), 'url' => ''];
        return view('admin/pages/settings/socialLoginIntegration', $this->data);
    }

    public function updateAwsStorage()
    {
        $session = \Config\Services::session();
        if (IS_DEMO) {
            $session->setFlashdata('error', lang('Admin.demo_mode_error'));
            return redirect('admin/settings/storage-configuration');
        }

        $amazone_s3_settings = [
            'region' => $this->request->getVar('region'),
            'amazone_s3_key' => $this->request->getVar('amazone_s3_key'),
            'amazone_s3_s_key' => $this->request->getVar('amazone_s3_s_key'),
            'bucket_name' => $this->request->getVar('bucket_name')
        ];
        $amazone_s3_settings_json = json_encode($amazone_s3_settings);
        $settingModel = new Settings();
        $settingModel->where('name', 'amazone_s3_settings')->set(['value' => $amazone_s3_settings_json])->update();
        
        $session->setFlashdata('success', lang('Admin.aws_storage_updated'));
        return redirect('admin/settings/storage-configuration');
    }

    public function updateWasabiStorage()
    {
        $session = \Config\Services::session();
        if (IS_DEMO) {
            $session->setFlashdata('error', lang('Admin.demo_mode_error'));
            return redirect('admin/settings/storage-configuration');
        }

        $wasabi_storage = [
            'wasabi_bucket_name' => $this->request->getVar('wasabi_bucket_name'),
            'wasabi_access_key' => $this->request->getVar('wasabi_access_key'),
            'wasabi_secret_key' => $this->request->getVar('wasabi_secret_key'),
            'wasabi_bucket_region' => $this->request->getVar('wasabi_bucket_region')
        ];
        $wasabi_storage_json = json_encode($wasabi_storage);
        $settingModel = new Settings();
        $settingModel->where('name', 'wasabi_settings')->set(['value' => $wasabi_storage_json])->update();
        
        $session->setFlashdata('success', lang('Admin.wasabi_storage_updated'));
        return redirect('admin/settings/storage-configuration');
    }

    public function updateFtpStorage()
    {
        $session = \Config\Services::session();
        if (IS_DEMO) {
            $session->setFlashdata('error', lang('Admin.demo_mode_error'));
            return redirect('admin/settings/storage-configuration');
        }

        $ftp_settings = [
            'ftp_host' => $this->request->getVar('ftp_host'),
            'ftp_username' => $this->request->getVar('ftp_username'),
            'ftp_password' => $this->request->getVar('ftp_password'),
            'ftp_port' => $this->request->getVar('ftp_port'),
            'ftp_path' => $this->request->getVar('ftp_path')
        ];
        $ftp_settings_json = json_encode($ftp_settings);
        $settingModel = new Settings();
        $settingModel->where('name', 'ftp_settings')->set(['value' => $ftp_settings_json])->update();
        
        $session->setFlashdata('success', lang('Admin.ftp_storage_updated'));
        return redirect('admin/settings/storage-configuration');
    }

    public function updateSpaceStorage()
    {
        $session = \Config\Services::session();
        if (IS_DEMO) {
            $session->setFlashdata('error', lang('Admin.demo_mode_error'));
            return redirect('admin/settings/storage-configuration');
        }

        $space_settings = [
            'space_key' => $this->request->getVar('space_key'),
            'spaces_secret' => $this->request->getVar('spaces_secret'),
            'space_name' => $this->request->getVar('space_name'),
            'space_region' => $this->request->getVar('space_region')
        ];
        $space_setting_json = json_encode($space_settings);
        $settingModel = new Settings();
        $settingModel->where('name', 'space_settings')->set(['value' => $space_setting_json])->update();
        
        $session->setFlashdata('success', lang('Admin.space_storage_updated'));
        return redirect('admin/settings/storage-configuration');
    }
}

