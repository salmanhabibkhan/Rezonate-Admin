<?php

namespace App\Controllers\Admin;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\BlogTag;

use App\Controllers\Admin\AdminBaseController;

class blogsController extends AdminBaseController
{
    private $blogsModel;
    public  $session;
    public function __construct()
    {
        parent::__construct();
        $this->blogsModel = New Blog();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_blogs'); // Translated string for "All blogs"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_customize_blogs'), 'url' => '']; // Translated string for "Manage Or Customize blogs"
        $this->data['blogs'] = $this->blogsModel->findAll();
        return view('admin/pages/blogs/all-blogs', $this->data);
    }

    public function create()
    {
        $this->data['page_title'] = lang('Admin.create_new_blog'); // Translated string for "Create new blogs"
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.create_blog'), 'url' => '']; // Translated string for "Create Blog"
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        return view('admin/pages/blogs/create', $this->data);
    }

    public function store()
    {
        $rules = [
            'title' => [
                'label' => lang('Admin.blog_message.title_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.title_required')
                ]
            ],
            'category' => [
                'label' => lang('Admin.blog_message.category_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.category_required')
                ]
            ],
            'content' => [
                'label' => lang('Admin.blog_message.content_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.content_required')
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $inserted_data = [
                'title' => $this->request->getVar('title'),
                'category' => $this->request->getVar('category') ?: 0,
                'content' => $this->request->getVar('content'),
            
                // Add more fields as needed
            ];
            $thumbnail = $this->request->getFile('thumbnail');
            if(!empty($thumbnail) && $thumbnail->isValid())
            {
                $thumbnailPath = storeMedia($thumbnail,'thumbnail');
                $inserted_data['thumbnail'] = $thumbnailPath;
            }
            $this->blogsModel->save($inserted_data);
            $blog_id = $this->blogsModel->insertID();
            
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
            $this->session->setFlashdata('success', lang('Admin.blog_message.create_success'));
            return redirect()->to('admin/blogs');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/blogs/create', ['validation' => $validationErrors]);
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
    public function edit($id)
    {
        $blogtagModel = New BlogTag;
        $this->data['page_title'] = lang('Admin.edit_blog');
		$this->data['breadcrumbs'][] = ['name'=>lang('Admin.edit_blog'),'url'=>''];
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['tags'] = $blogtagModel->getTag($id);
		$this->data['blog'] = $this->blogsModel->find($id);
        
		return view('admin/pages/blogs/edit',$this->data);
    }


    public function update($id)
    {
        $rules = [
            'title' => [
                'label' => lang('Admin.blog_message.title_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.title_required')
                ]
            ],
            'category' => [
                'label' => lang('Admin.blog_message.category_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.category_required')
                ]
            ],
            'content' => [
                'label' => lang('Admin.blog_message.content_required'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.blog_message.content_required')
                ]
            ],
        ];

        if ($this->validate($rules)) {
            $inserted_data = [
                'title' => $this->request->getVar('title'),
                'category' => $this->request->getVar('category') ?: 0,
                'content' => $this->request->getVar('content'),
                'active' => $this->request->getVar('active'),
                // Add more fields as needed
            ];

            $thumbnail = $this->request->getFile('thumbnail');
            if(!empty($thumbnail) && $thumbnail->isValid())
            {
                $thumbnailPath = storeMedia($thumbnail,'thumbnail');
                $inserted_data['thumbnail'] = $thumbnailPath;
            }
            $this->blogsModel->update($id, $inserted_data);
            $blogtagModel = New BlogTag;
            $blogtagModel->deleteTagsByBlogId($id);
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
                    $this->insertTag($id,$oldtag['id']);
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
                        $this->insertTag($id,$tag_id);
                    }
                }

            }
            
            $this->session->setFlashdata('success', lang('Admin.blog_message.update_success'));
            return redirect()->to('admin/blogs');
        } else {
            $validationErrors = $this->validator->getErrors();
            return view('admin/pages/blogs/edit', ['validation' => $validationErrors]);
        }
    }

    
    
    public function delete($id)
    {
        $this->blogsModel->delete($id);
        $this->session->setFlashdata('success', lang('Admin.blog_message.delete_success'));
        return redirect()->to('admin/blogs');
    }

}
