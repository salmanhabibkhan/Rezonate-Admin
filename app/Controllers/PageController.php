<?php

namespace App\Controllers;

use App\Models\Page;
use App\Models\Block;
use Firebase\JWT\JWT;
use App\Models\LikePage;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class PageController extends BaseController
{
    use ResponseTrait;
    private $validation;

    public function __construct()
    {
        parent::__construct();
        $this->validation = \Config\Services::validation();
    }
    
    public function pageProfile($page_name, $section = "posts")
    {

        $pageModel = new Page();
        $likepageModel = new LikePage();

        // Assuming you have a method to get the page by its name
        $page = $pageModel->where('page_username', $page_name)->first();
        
        if (!$page) {
            // Handle the case where the page doesn't exist
            // Redirect or show an error message
            return; // Adjust as needed
        }
        $user_id = getCurrentUser()['id'];
        $page_user_id = $page['user_id'];
        $blockModel = New Block;
        $is_blocked = $blockModel->checkuserblock($user_id,$page_user_id);
        
        if(!empty($is_blocked))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $page['avatar'] =getMedia($page['avatar']);
        $page['cover'] =!empty($page['cover'])?getMedia($page['cover']):'';
       
        $page['is_page_owner'] = ($page['user_id'] == $user_id) ? true : false;
        $limit = 3;
        $offset = 0;
        
        $checklikepage = $likepageModel->where(['user_id' => $user_id, 'page_id' => $page['id']])->first();
        $page['page_category'] = !empty($page['page_category']) ? PAGE_CATEGORIES[$page['page_category']]: "None";
        $page['is_liked'] = (!empty($checklikepage)) ? true : false;
        $this->data['getUnLikedPages'] = $pageModel->getUnLikedPages($user_id,$limit,$offset);
      
        $this->data['section'] = $section;
        $this->data['page'] = $page;
        $this->data['js_files'] = ['js/posts.js',
                'js/post_plugins.js',
                'vendor/imagepopup/js/lightbox.min.js',
            ];

        $this->data['css_files'] = ['css/posts.css',
                'css/posts_plugins.css',
                'vendor/imagepopup/css/lightbox.min.css'
                ];
        $this->data['getshortmembers'] = $likepageModel->getshortpageuser($page['id']);
        if($section=='followers')
        {
            $this->data['getallusermembers'] = $likepageModel->getallpageuser($page['id']);
        }
        
        echo load_view('pages/pages/page_profile', $this->data);
    }

    public function getAllPages()
    {
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        $offset = !empty($this->request->getVar('offset'))?$this->request->getVar('offset'):0;
        $limit = !empty($this->request->getVar('limit'))?$this->request->getVar('limit'):6;
        $pageModel = New Page;
        $pages = [];
        $pages = $pageModel->where('user_id !=',$user_id)->findAll($limit, $offset);
        if(empty($pages))
        {
            return $this->respond([
                'code' => '400',
                'message' => 'No data found',
                'data' =>$pages
            ], 200);
        }
        foreach($pages as &$page)
        {
  
            $page['avatar'] = getMedia($page['avatar']);
            $page['cover'] = getMedia($page['cover']);
            $page['is_page_owner'] = ($page['user_id']==$user_id)?true:false;
            $page['is_liked'] = false;
            $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
            $pageSlug =  url_title($page['page_username']);
            $page['call_action_type_url'] = site_url('pages/').$pageSlug;
       
        }
        return $this->respond([
                'code' => '200',
                'message' => lang('Api.pages_fetched_successfully'),
                'data' => $pages
            ], 200);
        
    }
    public function userPages()
    {
        $user_data = getCurrentUser();
        $user_id   = $user_data['id'];
        $offset    = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit     = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
        $model     = new Page;
        $pages = [];
        $pages     = $model->where('user_id', $user_id)->findAll($limit, $offset);
        if (!empty($pages)) {

            foreach ($pages as &$page) {
                $page['avatar'] = getMedia($page['avatar']);
                $page['cover'] = getMedia($page['cover']);
                $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
                $pageSlug =  url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/').$pageSlug;
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.pages_fetched_successfully'),
                'data' => $pages
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.no_data_found'),
            'data' => $pages
        ], 200);
    }

    public function myPages()
	{
        $user_data = getCurrentUser();
        $user_id   = $user_data['id'];
        $page = (!empty($this->request->getVar('page'))) ? $this->request->getVar('page') : 1;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 12;
        $offset = ($page - 1) * $limit;
        $model     = new Page;
        $postModel = New PostModel;
        $no_of_pages = $model->where('user_id', $user_id)->countAllResults();
        
        $totalPages = ceil($no_of_pages / $limit);
        $pages     = $model->where('user_id', $user_id)->orderBy('id','desc')->findAll($limit, $offset);
        if (!empty($pages)) {
            foreach ($pages as &$page) {
                $page['avatar'] = getMedia($page['avatar']);
                $page['cover'] = getMedia($page['cover']);
                $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
                $page['post_count'] = $postModel->where(['page_id'=>$page['id'],'privacy'=>'1'])->countAllResults();
                $pageSlug =  url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/').$pageSlug;
            }
        }
     
        $this->data['pages'] = $pages;
        $this->data['currentPage'] = $page;
        $this->data['totalPages'] = $totalPages;
        echo load_view('pages/pages/my-pages',$this->data);
	}

    public function createPage()
	{
        echo load_view('pages/pages/create-page',$this->data);   
	}
    
    public function updateWebPage($pageId)
	{
        $pageModel = new Page();

        // Fetch the page data from the database
        $this->data['pageData'] = $pageModel->find($pageId);

        if (!$this->data['pageData']) {
            // Handle the case where the page does not exist
            // For example, show a 404 error page or set a flash message
            return redirect()->to('/page-not-found'); // Adjust the redirect as needed
        }
        
       
        echo load_view('pages/pages/update-page',$this->data);   
	}


    public function addPage()
    {

        $rules = [
            'page_title' => [
                'label' => 'Page Title',
                'rules' => 'required|min_length[5]|max_length[50]|regex_match[/^[a-zA-Z0-9 ]+$/]',
                'errors' => [
                    'required' => lang('Api.page_title_required'),
                    'min_length' => lang('Api.page_title_min_length'),
                    'max_length' => lang('Api.page_title_max_length'),
                    'regex_match' => lang('Api.page_title_invalid_characters'),
                ],
            ],
            'page_description' => [
                'label' => 'Page Description',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_description_required'),
                ],
            ],
            'page_category' => [
                'label' => 'Page Category',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_category_required'),
                ],
            ],


        ];


        

        if ($this->validate($rules)) {
            $page = new Page;
            $user_data = getCurrentUser();

            $pageTitle = $this->request->getVar('page_title');


            $pageTitle = !empty($this->request->getVar('page_username'))?$this->request->getVar('page_username'):$this->request->getVar('page_title');



            $basePAgeName = url_title($pageTitle, '-', true); 
            $uniqueGroupName = $basePAgeName;
            $counter = 1;
           
            // Check if the group name already exists and modify it if necessary
            while ($page->where('page_username', $uniqueGroupName)->first()) {
                $uniqueGroupName = $basePAgeName.'-'.$counter;
                $counter++;
            }
           
            $pageUserName = !empty($uniqueGroupName)?$uniqueGroupName:$basePAgeName;
            $inserted_data = [
                'user_id' => $user_data['id'],
                'page_username' => $pageUserName,
                'page_title' => $this->request->getVar('page_title'),
                'page_description' => $this->request->getVar('page_description'),
                'page_category' => $this->request->getVar('page_category'),
                'website' => $this->request->getVar('website')??'',
                'facebook' => $this->request->getVar('facebook'),
                'google' => $this->request->getVar('google'),
                'vk' => $this->request->getVar('vk'),
                'twitter' => $this->request->getVar('twitter'),
                'linkedin' => $this->request->getVar('linkedin'),
                'phone' => $this->request->getVar('phone'),
                'address' => $this->request->getVar('address')??'',
                'instgram' => $this->request->getVar('instgram'),
                'youtube' => $this->request->getVar('youtube'),
                'company' => $this->request->getVar('company'),
                'background_image_status' => $this->request->getVar('background_image_status')
            ];
            
            $background_image = $this->request->getFile('background_image');
            $cover = $this->request->getFile('cover');
            if (!empty($cover) && $cover->isValid()) {
                $pagecover = storeMedia($cover, 'cover');
                $inserted_data['cover'] = $pagecover;
            }
            $avatar  = $this->request->getFile('avatar');
            if (!empty($avatar) && $avatar->isValid()){
                $pageavatar = storeMedia($avatar, 'avatar');
                $inserted_data['avatar'] = $pageavatar;
            }
            if (!empty($background_image)) {
                $page_background = storeMedia($background_image, 'background_image');
                $inserted_data['page_background'] = $page_background;
            }
            
            $page->save($inserted_data);
            $pageId= $page->insertID();
            $pagedata = $page->getCompiledPageData($pageId,$user_data['id']);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.page_created_successfully'),
                'data' => $pagedata
            ], 200);
        } else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validation->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'validation_error' => $validationErrors
            ], 400);
            // Send a JSON response or render a view with validation errors
        }
    }


    public function deletePage()
    {

        $validationRules = [
            'page_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_id_required'),
                ],
            ],
        ];

        $this->validation->setRules($validationRules);
        $data = [
            'page_id' => $this->request->getPost('page_id'),
        ];

        if ($this->validation->run($data)) {
            $page = new Page;
            $page_id = $this->request->getPost('page_id');
            $page_data = $this->checkPageownership($page_id);
            if ($page_data == 200) {
                $page->deltePageById($page_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.page_deleted_successfully'),
                    'data' => "success"
                ], 200);
            } elseif ($page_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => "success"
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.page_not_found'),
                    'data' => "not found"
                ], 404);
            }
        }
        else {
            // Validation failed
            $validationErrors = $this->validation->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'validation_errors' => $validationErrors
            ], 400);
        }

    }

    public function updatePage()
    {
        $rules = [
            'page_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_id_required'),
                ],
            ],
        ];
    

        if ($this->validate($rules)) {
            $id = $this->request->getVar('page_id');
            $page_data = $this->checkPageownership($id);

            if ($page_data == 200) {
                $page = new Page;
                $currentUserId = getCurrentUser();
                $pagedata = $page->find($id);
                if ($currentUserId['id'] != $pagedata['user_id']) {
                    return $this->failForbidden(lang('Api.permission_denied'));
                }
                $update_data = [];

                // Loop through all input values and add them to the update array
                foreach ($this->request->getPost() as $key => $value) {
                    // Exclude the 'page_id' from the update array
                    if ($key != 'page_id') {
                        $update_data[$key] = trim($value);
                    }
                }
                $avatar = $this->request->getFile('avatar');
                $cover = $this->request->getFile('cover');

                // Check and update cover if not empty
                if (!empty($cover) && $cover->isValid() && !$cover->hasMoved() && $cover->getSize() > 0) {
                    
                 
                    
                    $pagecover = storeMedia($cover, 'cover');
                    $update_data['cover'] = $pagecover;
                }
                
                // Check and update avatar if not empty
                if (!empty($avatar) && $avatar->isValid() && !$avatar->hasMoved() && $avatar->getSize() > 0) {
                
                   
                    $update_data['avatar'] = storeMedia($avatar, 'avatar');
                } 
                
           
                // if(!empty($background_image) &&  $background_image->isValid() && !$background_image->hasMoved() ){
                //     $page_background = storeMedia($background_image,'background_image');
                //     $update_data['page_background'] =$page_background;
                // }
                
                
                // Validate and update the specified fields
                if (!empty($update_data)) {
                    $page->update($id, $update_data);
                    
                }

                $page_response = $page->getCompiledPageData($id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.page_updated_successfully'),
                    'data' => $page_response
                ], 200);
            } elseif ($page_data == 401) {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.not_allowed'),
                    'data' => 'failed'
                ], 401);
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.page_not_found'),
                    'data' => 'not found'
                ], 404);
            }
        } else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }

    public function checkPageownership($page_id)
    {
        $user_data = getCurrentUser();
        $model = new Page;
        $page_data = $model->where('id', $page_id)->first();

        if (!empty($page_data)) {
            if ($page_data['user_id'] == $user_data['id']) {
                return 200;
            } else {
                return 401;
            }
        } else {
            return 404;
        }
    }

    public function likeUnlikePage()
    {
        $rules = [
            'page_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_id_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $page_id = $this->request->getVar('page_id');
            $pageModel  = new Page;
            $user_data = getCurrentUser();
            $user_id = $user_data['id'];
            $page = $pageModel->find($page_id);
           

            if (!empty($page)) {
                $likes_count = $page['likes_count'];
                $likePageModel = new LikePage;
                $checkoldData = $likePageModel->where(['page_id' => $page_id, 'user_id' => $user_id])->first();
                
                if (empty($checkoldData)) {
                    $likepagedata = [
                        'page_id' => $page_id,
                        'user_id' => $user_id,
                    ];
                    $likePageModel->save($likepagedata);
                    $notificationModel = new NotificationModel();
                    $currentLoggedInUser = getCurrentUser()['id'];
                    
                    $pageModel->incrementLikesCount($page_id);
                    $userModel = New UserModel();
                    $user_device = $userModel->select(['device_id','notify_liked_page','email'])->where('id', $page['user_id'])->first();
                    if(get_setting('chck-emailNotification')==1)
                    {
                        sendmailnotificaiton($user_device['email'],'Liked Page',"liked your page.");
                    }
                    if(!empty($user_device) && $user_device['notify_liked_page'] == 1 && $user_id!= $page['user_id']) 
                    {
                        $notificationdata = [
                            'from_user_id' => $currentLoggedInUser,
                            'to_user_id' => $page['user_id'],
                            'page_id' => $page_id,
                            'type' => 'Like-page',
                            'text' => lang('Api.notification_liked_page'),
                        ];
                        $notificationModel->save($notificationdata);
                        
                        sendPushNotification( $user_device['device_id'], lang('Api.push_notification_liked_page'));
                    }
                    
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.page_successfully_liked'),
                        'data' => 1,
                        'likes_count'=>++$likes_count
                    ], 200);
                } else {
                    $likePageModel->delete($checkoldData['id']);
                    $pageModel->decrementLikesCount($page_id);
                    return $this->respond([
                        'code' => '200',
                       'message' => lang('Api.page_successfully_unliked'),
                        'data' => 0,
                        'likes_count'=>--$likes_count
                    ], 200);
                }


                
            } else {

                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.page_not_found'),
                    'data' => 'not found'
                ], 404);
            }
        } else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 404);
        }
    }


    public function getLikedPages()
    {
        $user_data = getCurrentUser();
        $user_id = $user_data['id'];
        $pageModel = new Page;
        $offset = (!empty($this->request->getVar('offset'))) ? $this->request->getVar('offset') : 0;
        $limit = (!empty($this->request->getVar('limit'))) ? $this->request->getVar('limit') : 6;
        $likedPages = $pageModel->getLikedPagesByUser($user_id, $offset, $limit);
        if (!empty($likedPages)) {
            foreach ($likedPages as &$page) {
                $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
                $page['avatar'] = getMedia($page['avatar']);
                $page['cover'] = getMedia($page['cover']);
                $page['is_page_owner'] = ($page['user_id'] == $user_id) ? true : false;
                $page['is_liked'] = true;
                $pageSlug =  url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/').$pageSlug;
                // Add the modified page to the new array
      
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.fetch_liked_pages_success'),
                'data' => $likedPages
            ], 200);
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.no_liked_pages_found'),
                'data' => $likedPages
            ], 200);
        }
    }


    public function getPageData()
    {
        $rules = [
            'page_id' => 'required',
        ];

        if ($this->validate($rules)) {
            $model = new Page();
            $page_id = $this->request->getVar('page_id');
            $user_id = getCurrentUser()['id'];
            $page = $model->where('id', $page_id)->first();

            if (!empty($page)) {
                $page['avatar'] = !empty($page['avatar']) ? getMedia($page['avatar']) : '';
                $page['cover'] = !empty($page['cover']) ? getMedia($page['cover']) : '';
                $page['is_page_owner'] = ($page['user_id'] == $user_id) ? true : false;

                $likepageModel = new LikePage;
                $checklikepage = $likepageModel->where(['user_id' => $user_id, 'page_id' => $page_id])->first();
                $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
                $page['is_liked'] = (!empty($checklikepage)) ? true : false;
                $pageSlug =  url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/').$pageSlug;
                return $this->respond([
                    'code' => '200',
                    'message' => 'The Page fetches successfully',
                    'data' => $page
                ], 200);
            }
            return $this->respond([
                'code' => '404',
                'message' => 'Page not found',
                'data' => ''
            ], 404);
        } else {

            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON($validationErrors);
        }
    }
    public function allWebPages()
{
    $choice = $this->request->getVar('choice');
    $user_id = getCurrentUser()['id'];
    $likepage = new LikePage();
    $model = new Page();
    $postModel = new PostModel();
    $pager = service('pager');
    $perPage = 10;
    $page = (int) (!empty($this->request->getVar('page'))) ? $this->request->getVar('page') : 1;
    
    $total = $model->where('user_id !=', $user_id)->countAllResults();
    $query = $model->where('user_id !=', $user_id);
    
    if ($choice == null) {
        $query->orderBy('id', 'desc');
    }
    
    if ($choice == 'alpha') {
        $query->orderBy('page_title', 'asc');
    }
    
    $pages = $query->findAll();
    
    if (!empty($pages)) {
        foreach ($pages as &$page) {
            $page['avatar'] = getMedia($page['avatar']);
            $page['cover'] = getMedia($page['cover']);
            $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
            $page['post_count'] = $postModel->where(['page_id' => $page['id'], 'privacy' => '1'])->countAllResults();
            $page['is_liked'] = $likepage->checkpageLike($user_id, $page['id']);
            $pageSlug = url_title($page['page_username']);
            $page['call_action_type_url'] = site_url('pages/') . $pageSlug;
        }
    }
    
    // Calculate total pages for pagination

    $this->data['pages'] = $pages;
    $this->data['choice'] = $choice;
    
    echo load_view('pages/pages/pages', $this->data);
}

    public function deletePageUser()
    {
        $rules = [
            'page_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.page_id_required'),
                ],
            ],
            'deleted_user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.deleted_user_id_required'),
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->response->setJSON($validationErrors);
        }
        $page_id = $this->request->getVar('page_id');
        $deleted_user_id = $this->request->getVar('deleted_user_id');
        $likepageModel = New LikePage;
        $checklike = $likepageModel->find($deleted_user_id);
        $pageModel  = new Page;
        $loggedInUser = getCurrentUser();
        $page = $pageModel->find($page_id);
        if(empty($page))
        {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.page_not_found'),
                'data' => ''
            ], 404);
        }
        if($page['user_id']!=$loggedInUser['id'])
        {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.permission_denied'),
                'data' => ''
            ], 404);
        }
       
        if(empty($checklike))
        {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.user_not_found'),
                'data' => ''
            ], 404);
        }
        $likepageModel->delete($checklike['id']);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.user_removed'),
        ], 200);
    }  
    public function getMyPage()
    {
        $user_id = getCurrentUser()['id'];
        $pageModel = New Page;
        $pages = $pageModel->select(['id','page_title'])->where('user_id',$user_id)->findAll();
        if(!empty($pages))
        {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.pages_fetch_success'),
                'data'=>$pages
            ], 200);
        }
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.page_not_found'), 
            
        ], 200);

    }
}
