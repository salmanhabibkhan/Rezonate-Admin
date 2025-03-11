<?php
namespace App\Controllers;
use App\Models\Page;
use App\Models\GiftModel;

use App\Models\JobCategory;
use App\Models\GatewayModel;
use App\Models\PackageModel;
use App\Models\GroupCategory;
use CodeIgniter\Config\Services;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\ProductCategory;

class Misc extends BaseController
{
    use ResponseTrait;
    public function get_site_settings()
    {
       
       $settings = [];
        $settingModel = new \App\Models\Settings();
        $allsettings= $settingModel->where('flag','public')->findAll();
        foreach ($allsettings as  &$setting) {
          if($setting['name']=='site_logo')
          {
            $settings[$setting['name']] = getMedia($setting['value']);
          }
          else
          {
            $settings[$setting['name']] = $setting['value'];
          }
        }
        $groupCategoryModel = New GroupCategory();
        $JobCategoryModel = New JobCategory();
        $ProductCategoryModel = New ProductCategory();
        $settings['currecy_array'] = CURRECY_ARRAY;
        $settings['page_categories'] = PAGE_CATEGORIES;
        $settings['group_categories'] = $groupCategoryModel->getcategories();
        $settings['job_categories'] = $JobCategoryModel->getcategories();
        $settings['product_categories'] = $ProductCategoryModel->getcategories();
        $settings['movie_genres'] = MOVIE_GENRES;
        $packageModel = New PackageModel();
       
        $settings['packages'] = $packageModel->findAll();
        $giftModel = New GiftModel();
      
        
        $gifts = $giftModel->select(['id','name','image','price'])->findAll();
        if(!empty($gifts))
        {
            foreach ($gifts as  &$gift) {
                $gift['image'] = getMedia($gift['image']);
            }
        }
        $settings['gifts'] = $gifts;
        return $this->respond(
                [
                    'status'=>'200',
                    'message' => 'success',
                    'data' => $settings
                ], 200);
    }

    public function test(){
        header('Content-Type: application/json; charset=utf-8');
        echo view('test.php');
    }
  
  
}
