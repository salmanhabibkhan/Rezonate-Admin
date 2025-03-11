<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\LikePage;

class Page extends Model
{

    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'page_username',
        'page_title',
        'page_description',
        'avatar',
        'cover',
        'page_category',
        'sub_category',
        'website',
        'facebook',
        'google',
        'company',
        'address',
        'phone',
        'call_action_type',
        'call_action_type_url',
        'background_image',
        'is_verified',
        'is_active',
        'likes_count'
    ];
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



    public function getCompiledPageData($pageId, $loggedInUserId = 0)
    {

        $page = $this->where('id', $pageId)->first();

        if (!$page) {
            return null;
        }

        $page['avatar'] = getMedia($page['avatar']);
        $page['cover'] = getMedia($page['cover']);
        $page['is_page_owner'] = ($page['user_id'] == $loggedInUserId);
        $page['page_category'] = PAGE_CATEGORIES[$page['page_category']];
        $pageSlug =  url_title($page['page_username']);

        $page['call_action_type_url'] = site_url('pages/').$pageSlug;
        $likePageModel = new \App\Models\LikePage();
        $isLiked = $likePageModel->where([
            'user_id' => $loggedInUserId,
            'page_id' => $pageId
        ])->first();

        $page['is_liked'] = !empty($isLiked);

        return $page;
    }






    public function incrementLikesCount($pageId)
    {
        $builder = $this->builder();

        return $builder
            ->where($this->primaryKey, $pageId)
            ->set('likes_count', 'likes_count + 1', false)
            ->update();
    }

    public function decrementLikesCount($pageId)
    {
        $builder = $this->builder();

        return $builder
            ->where($this->primaryKey, $pageId)
            ->set('likes_count', 'likes_count - 1', false)
            ->update();
    }
    public function getLikedPagesByUser($userId, $offset, $limit)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
    
        return $this->select($dbPrefix.'pages.*')
            ->join($dbPrefix.'like_pages', $dbPrefix.'like_pages.page_id = '.$dbPrefix.'pages.id')
            ->where($dbPrefix.'like_pages.user_id', $userId)
            ->where($dbPrefix.'pages.deleted_at IS NULL', null, false)
            ->where($dbPrefix.'like_pages.deleted_at', null)
            ->orderBy($dbPrefix.'pages.id', 'desc')
            ->findAll($limit, $offset);
    }
    


    public function getLikedPagesByUserByGroup($userId)
    {
        $pageIDs = $this->select('like_pages.id')
            ->join('like_pages', 'like_pages.page_id = pages.id')
            ->where('like_pages.user_id', $userId)
            ->where('pages.deleted_at',null)
            ->where('like_pages.deleted_at', null)
            ->orderBy('pages.id', 'desc')
            ->findAll();

        return array_column($pageIDs, 'id');
    }
    public function getSearchPages($search_string, $limit, $offset)
    {
        
        $user_id = getCurrentUser()['id'];
        $pages = $this->like('page_title', $search_string)->where('deleted_at',null )->orderBy('id', 'desc')->findAll($limit, $offset);
        if (!empty($pages)) {
            foreach ($pages as &$page) {

                $page['avatar'] = !empty($page['avatar']) ? getMedia($page['avatar']) : '';
                $page['cover'] = !empty($page['cover']) ? getMedia($page['cover']) : '';
                $page['is_liked'] = $this->checlikepage($user_id, $page['id']);
                $pageSlug =  url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/').$pageSlug;
            }
        }

        return $pages;
    }
    public function checlikepage($user_id, $page_id)
    {
        $likedPage = new LikePage();
        $checklike = $likedPage->where('user_id', $user_id)->where('page_id', $page_id)->first();


        if (!empty($checklike)) {
            return '1';
        } else {
            return '0';
        }
    }

 

    public function getUnLikedPages($userId,$limit,$offset)
    {
        $db = $this->db;
        $dbPrefix = $db->DBPrefix;
        $pages = $this
            ->distinct()
            ->where('user_id !=', $userId)
            ->orderBy('RAND()')
            ->findAll($limit,$offset);

        foreach ($pages as &$page) {
            $page['is_liked'] = $this->checlikepage($userId, $page['id']);
            $page['avatar'] = getMedia($page['avatar']);
            $page['cover'] = getMedia($page['cover']);
            $pageSlug =  url_title($page['page_username']);
            $page['call_action_type_url'] = site_url('pages/').$pageSlug;
            
        }

        return $pages;
    }
    public function getWebSearchPages($search_string, $user_id)
    {
        $pages = $this->select('page_username, page_title, cover, likes_count, id')
            ->where('deleted_at', null) // Exclude soft deleted data
            ->groupStart()
                ->like('page_title', $search_string)
                ->orLike('page_username', $search_string)
            ->groupEnd()
            ->orderBy('id', 'desc')
            ->findAll();
      


        if (!empty($pages)) {
            $likepageModel = New LikePage;
            foreach ($pages as &$page) {
                $page['cover'] = !empty($page['cover']) ? getMedia($page['cover']) : '';
                $page['is_liked'] = $likepageModel->checkpageLike($user_id, $page['id']);
                $pageSlug = url_title($page['page_username']);
                $page['call_action_type_url'] = site_url('pages/') . $pageSlug;
            }
        }

        return $pages;
    }
    
    public function deltePageById($page_id)
    {
        $postModel = New PostModel;
        $commentModel = New CommentModel;
        $reactionModel =  New PostsReactionsModel;
        $posts = $postModel->where('page_id',$page_id)->findALL();
        foreach($posts as $post)
        {
            $commentModel->where('post_id',$post['id'])->delete();
            $reactionModel->where('post_id',$post['id'])->delete();
        }
        $postModel->where('page_id',$page_id)->delete();

        $this->delete($page_id);
    }
    public function getNewPages($userId,$limit,$offset)
    {
        $pages = [];
        $builder = $this->builder();
        $builder->select('p.*')
        ->distinct()
        ->from('pages as p')
        ->join('like_pages', 'p.id = like_pages.page_id', 'left')
        ->where('p.user_id !=', $userId) // User is not the owner of the page
        ->groupStart() // Start grouping the 'or' conditions
            ->where('like_pages.user_id IS NULL') // User has not liked the page
            ->orWhere('like_pages.user_id !=', $userId)
        ->groupEnd() // End grouping
        ->where('p.deleted_at IS NULL') // Exclude soft-deleted pages
        ->limit($limit, $offset);

        $query = $builder->get();
        $pages = $query->getResult();
        if (!empty($pages)) {
            foreach ($pages as &$page) {
                $page->avatar = !empty($page->avatar) ? getMedia($page->avatar) : '';
                $page->cover = !empty($page->cover) ? getMedia($page->cover) : '';
                $page->is_liked = $this->checlikepage($userId, $page->id);
                $pageSlug =  url_title($page->page_username);
                $page->call_action_type_url = site_url('pages/').$pageSlug;
            }
        };
        return $pages;
    }
    
    
}
