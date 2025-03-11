<?php

namespace App\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use Firebase\JWT\JWT;
use App\Models\BlogTag;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use CodeIgniter\Pager\PagerRenderer;
use CodeIgniter\RESTful\ResourceController;

class BlogController extends BaseController
{
    use ResponseTrait;

    
    public function all()
    {
        $blogModel = New Blog;
        $user_data = getCurrentUser();
        $offset = (!empty($this->request->getVar('offset')))?$this->request->getVar('offset'):0;
        $limit = (!empty($this->request->getVar('limit')))?$this->request->getVar('limit'):6;
        $user_id = $user_data['id'];
        $blogs = $blogModel->orderBy('id','desc')->findAll($limit, $offset);
        if(!empty($blogs))
        {
            foreach($blogs as &$blog)
            {
                $blog['thumbnail'] =  getMedia($blog['thumbnail']);
                $blog['category'] = ($blog['category']!=0 && $blog['category']<=count(BLOG_CATEGORIES))? BLOG_CATEGORIES[$blog['category']]:'None';
                $blog['link'] = site_url('blog-details/'.$blog['id']);
                
            }
            return $this->respond([
                'code' => 200,
                'message' => lang('Api.blog_fetch_success'),
                'data' => $blogs
            ], 200);
        }
        return $this->respond([
            'code' => 200,
            'message' => lang('Api.no_blog_found'),
            'data' => $blogs
        ], 200);
    }

    public function all_web()
    {
        $blogModel = new Blog;
       
        // Pagination setup
        $pager = service('pager');
        $perPage = 6;
        $this->data['blogs'] = $blogModel->paginate($perPage);
//         $this->data['pager'] = $blogModel->pager;
//         $this->data['totalRows'] = $totalRows;
//  // Assuming $blogs contains your blog data
        // $data['pager'] = $pager;
        $page    = (int) ($this->request->getGet('page') ?? 1);
        
        $total   = $blogModel->countAllResults();

        // Call makeLinks() to make pagination links.
        $this->data['pager_links'] = $pager->makeLinks($page, $perPage, $total, 'socio_custom_pagination');
        echo load_view('pages/blog/blog_main', $this->data);
    
    }

    public function recentblogs()
    {
        helper('text');
        $blogModel =  New Blog;
        $blogs = $blogModel->select('id,title,created_at')->limit(5)->findAll();
        if(!empty($blogs))
        {
            foreach($blogs as &$blog)
            {
                $blog['created_at'] = HumanTime($blog['created_at']);
                $blog['title'] = word_limiter($blog['title'], 4);
            }
        }

        return $this->respond([
            'code' => '200',
            'message' => lang('Api.blog_fetch_success'),
            'data' => $blogs
        ], 200);
    }
    public function blogTags($id)
    {
        $blogModel = new Blog;
        $blogTagModel = New BlogTag;
        $blogIds = $blogTagModel->where('tag_id',$id)->findAll();
        if(!empty($blogIds))
        {
            $totalBlogs = array_column($blogIds, 'blog_id');
            $limit = $this->request->getVar('limit') ?? 6;
            $currentPage = $this->request->getVar('page') ?? 1; // Use 'page' query string
            $offset = ($currentPage - 1) * $limit;
         
          
            $blogs = $blogModel->whereIn('id',$totalBlogs)->findAll($limit, $offset);
          
            // Process blogs
            foreach ($blogs as &$blog) {
                $blog['thumbnail'] = !empty($blog['thumbnail']) ? getMedia($blog['thumbnail']) : getMedia('');
                
                
            }
            $pager = service('pager');
            $pager->makeLinks($currentPage, $limit, count($totalBlogs));
            // Load the pagination library and configure
            
        }
        else{
         
            $userModel = new UserModel;
          
            
            // Pagination configuration
            $limit = $this->request->getVar('limit') ?? 6;
            $currentPage = $this->request->getVar('page') ?? 1; // Use 'page' query string
            $offset = ($currentPage - 1) * $limit;
    
            $totalBlogs = $blogModel->countAllResults(); // Get total count of blogs
    
            $blogs = $blogModel->findAll($limit, $offset);
    
            // Process blogs
            foreach ($blogs as &$blog) {
                $blog['thumbnail'] = !empty($blog['thumbnail']) ? getMedia($blog['thumbnail']) : getMedia('');
                
                
            }
            $pager = service('pager');
     
            $pager->makeLinks($currentPage, $limit, $totalBlogs);
        }
        
        
        $this->data['blogs'] = $blogs;
        $this->data['pager'] = $pager;
        
        echo load_view('pages/blog/blog_main', $this->data);
        

    }
    public function recentTags()
    {
        $tagModel  =  New Tag;
        $tags = $tagModel->select(['id','name'])->orderBy('RAND()')->findAll(5);
        
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.tags_fetch_success'),
            'data' => $tags
        ], 200);
    }
    public function blogDetails($id)
    {
        $blogModel = New Blog;
        $this->data['blog'] = $blogModel->find($id);
        
        echo load_view('pages/blog/blog_details', $this->data);
    }

    public function addBlog()
    {
        $rules =  [
            'title'=>'required|min_length[10]',
            'content'=>'required|min_length[32]',
            'description'=>'required|min_length[32]',
            'category'=>'required',
            'active'=>'required',
        ];
        if ($this->validate($rules)) {
            $database = \Config\Database::connect(); // Get the database instance

            try {
                // Start the transaction
                $database->transStart();


                $blog = New Blog;
                $user_data = getCurrentUser();
                $blog_data = [
                    'user_id'=>$user_data['id'],
                    'title'=> $this->request->getVar('title'),
                    'content'=> $this->request->getVar('content'),
                    'description'=> $this->request->getVar('description'),
                    'category'=> $this->request->getVar('category'),
                    'active'=> $this->request->getVar('active'),
                    
                ];
                if(!empty($this->request->getFile('thumbnail'))){
                    $blogthumbnail = $this->request->getFile('thumbnail');
                    $name = $blogthumbnail->getName();
                    $ext = $blogthumbnail->getClientExtension();
                    $blogthumbnailname = $blogthumbnail->getRandomName(); 
                    $blogthumbnail->move('uploads/blog/thumbnail', $blogthumbnailname);
                    $blog_data['thumbnail'] = $blogthumbnailname;
                }
                $blog->save($blog_data);
                $blog_id = $blog->insertID();
                
                $tags = $this->request->getVar('tags');
                $tag_array = explode(',', $tags);
                if(!empty($tag_array))
                {
                    $tagmodel  = New Tag;
                    $checkOldTags =$tagmodel->whereIn('name',$tag_array)->findAll();
                    $tagNamesArray = array_column($checkOldTags, 'name');
                
                    if(!empty($checkOldTags))
                    {
                        foreach($checkOldTags as $oldtag)
                        {   
                        $this->insertTag($blog_id,$oldtag['id']);
                        }
                    }
                    $nonExistingTags = array_diff($tag_array, $tagNamesArray);
                    foreach($nonExistingTags as $nonExistingTag)
                    {
                        if(!empty($nonExistingTag))
                        {
                            $tagModel = New Tag;
                            $tagModel->save(['name'=>$nonExistingTag]);
                            $tag_id = $tagModel->insertID();
                            $this->insertTag($blog_id,$tag_id);
                        }
                    }

                }
                $database->transCommit();

                return $this->respond([
                    'code' => '200',
                    'message' => 'Blog Created successfully',
                    'data' => ''
                ], 200);
            } catch (\Exception $e) {
                // An error occurred, rollback the transaction
                $database->transRollback();
            
                echo 'Transaction failed: ' . $e->getMessage();
            }
            
         
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
        }
    }
    public function editBlog()
    {
        $rules = [
            'blog_id'=>'required',
        ];

        if ($this->validate($rules)) {
            $model = new Blog();
            $blog_id = $this->request->getGet('blog_id');
            $blog = $model->find($blog_id);
            $blog['thumbnail'] = base_url().'uploads/blog/thumbnail/'.$blog['thumbnail'];
            $blog_tag_model = New BlogTag;
            $blog_tag_ids = $blog_tag_model->where('blog_id',$blog['id'])->findAll();
            $tagNamesArray = array_column($blog_tag_ids, 'tag_id');
            if(!empty($tagNamesArray))
            {
                $tagModel = New Tag;
                $data['tags'] = $tagModel->select(['id','name'])->whereIn('id',$tagNamesArray)->findAll();
            }
           
            $data['blog'] = $blog;
            return $this->respond([
                'code' => '403',
                'message' => '',
                'data' => $data
            ], 200);
            
            
            
            
             
        }
        else {
            // Data did not meet the validation rules
            // Handle validation errors
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
            // Send a JSON response or render a view with validation errors
        }
    }
    public function updateBlog()
    {
        
        $rules =  [
            'title'=>'required|min_length[10]',
            'content'=>'required|min_length[32]',
            'description'=>'required|min_length[32]',
            'category'=>'required',
            'active'=>'required',
            'blog_id'=>'required'
        ];
        if ($this->validate($rules)) {
            $database = \Config\Database::connect(); // Get the database instance
            
            
            
            try {

                // Start the transaction
                $database->transStart();
                $blog_id = $this->request->getVar('blog_id');
                $tagModel = New BlogTag;
                $tagModel->deleteTagsByBlogId($blog_id);

                $blog = New Blog;
                
                $blog_data = [
                    'title'=> $this->request->getVar('title'),
                    'content'=> $this->request->getVar('content'),
                    'description'=> $this->request->getVar('description'),
                    'category'=> $this->request->getVar('category'),
                    'active'=> $this->request->getVar('active'),  
                ];
                if(!empty($this->request->getFile('thumbnail'))){
                    $blogthumbnail = $this->request->getFile('thumbnail');
                    $name = $blogthumbnail->getName();
                    $ext = $blogthumbnail->getClientExtension();
                    $blogthumbnailname = $blogthumbnail->getRandomName(); 
                    $blogthumbnail->move('uploads/blog/thumbnail', $blogthumbnailname);
                    $blog_data['thumbnail'] = $blogthumbnailname;
                }
                
                
            
                $blog->update($blog_id,$blog_data);
            
                $tags = $this->request->getVar('tags');
                $tag_array = explode(',', $tags);
                if(!empty($tag_array))
                {
                    $tagmodel  = New Tag;
                    $checkOldTags =$tagmodel->whereIn('name',$tag_array)->findAll();
                    $tagNamesArray = array_column($checkOldTags, 'name');
                
                    if(!empty($checkOldTags))
                    {
                        foreach($checkOldTags as $oldtag)
                        {   
                        $this->insertTag($blog_id,$oldtag['id']);
                        }
                    }
                    $nonExistingTags = array_diff($tag_array, $tagNamesArray);
                    foreach($nonExistingTags as $nonExistingTag)
                    {
                        if(!empty($nonExistingTag))
                        {
                            $tagModel = New Tag;
                            $tagModel->save(['name'=>$nonExistingTag]);
                            $tag_id = $tagModel->insertID();
                            $this->insertTag($blog_id,$tag_id);
                        }
                    }

                }
                $database->transCommit();

                return $this->respond([
                    'code' => '200',
                    'message' => 'Blog Updated successfully',
                    'data' => ''
                ], 200);
            } catch (\Exception $e) {
                // An error occurred, rollback the transaction
                $database->transRollback();
            
                echo 'Transaction failed: ' . $e->getMessage();
            }
            
            
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
        }
        
    }
    public function deleteBlog()
    {
        $rules = [
            'blog_id'=>'required'
        ];
        if ($this->validate($rules)) {
            $database = \Config\Database::connect(); 
            
            $blog_id = $this->request->getVar('blog_id');
            $blog_data = $this->checkOwnership($blog_id);
            if($blog_data==200)
            {
                 try {
                    $tagModel = New BlogTag;
                    $tagModel->deleteTagsByBlogId($blog_id);
                    // Start the transaction
                    $blog = New Blog;
                  
                    $database->transStart();
                   
                   
                    return $this->respond([
                        'code' => '400',
                        'message' => 'The Blog is deleted successfully',
                        'data' => "success"
                    ], 200);
                   
                    
                
                    $database->transCommit();
    
                    return $this->respond([
                        'code' => '200',
                        'message' => 'Blog Updated successfully',
                        'data' => ''
                    ], 200);
                } catch (\Exception $e) {
                    // An error occurred, rollback the transaction
                    $database->transRollback();
                
                    echo 'Transaction failed: ' . $e->getMessage();
                }

            }
            elseif($blog_data==401)
            {
                return $this->respond([
                    'code' => '401',
                    'message' => 'You are not allowed',
                    'data' => "success"
                ], 401);
            }
            else{
                return $this->respond([
                    'code' => '404',
                    'message' => 'Blog Not found',
                    'data' => "not found"
                ], 404);
            }
            
            
            
            
        }
        else{
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '403',
                'message' => 'Validation error message',
                'validation_errors' => $validationErrors
            ], 403);
        }

    }
    public function checkOwnership($blog_id)
    {
        $user_data = getCurrentUser();
        $model = New Blog;
        $blog_data = $model->where('id',$blog_id)->first();
        
        if(!empty($blog_data))
        {
            if($blog_data['user_id']==$user_data['id'])
            {
                return 200;
            }
            else{
                return 401;
            }
            
        }
        else{
           return 404;
        }
    }
    public function insertTag($blog_id,$tag_id)
    {
        $blogtag = New BlogTag;
        $blogtagdata = [
            'blog_id'=>$blog_id,
            'tag_id'=>$tag_id
        ];
        return $blogtag->save($blogtagdata);
        
    }
    
}
