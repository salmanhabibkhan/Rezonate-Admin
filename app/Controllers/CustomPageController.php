<?php
 namespace App\Controllers;
 use App\Models\CustomPage;

class CustomPageController extends BaseController
{

    
	 public function __construct()
     {
         parent::__construct();
     }
 
   
     public function getPage($page_name)
     {
         $custom_page = new CustomPage();
         $page_data = $custom_page->where('page_name', $page_name)->first();
     
         // Check if the page data was not found
         if (!$page_data) {
             // Throw a 404 Page Not Found exception
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
         }
         $this->data['title'] =  $page_data['page_title'];
         
         // If the record is found, continue to load the view with the data
         $this->data['custompage'] = $page_data;
         echo load_view('pages/custom_page/page_detail', $this->data);
     }


    
}
