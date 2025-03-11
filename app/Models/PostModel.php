<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\PollModel;
use App\Models\UserModel;
use App\Models\Advertisement;


class PostModel extends Model
{

    protected $db;
    protected $userModel;
    protected $eventModel;
    protected $user_id;
    protected $group_model;
    protected $page_model;
    protected $postsReactionsModel;
    protected $offerModel;
    protected $productModel;
    protected $commentModel;

    public function __construct()
    {
      parent::__construct();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
        $this->userModel = new UserModel();
        $this->eventModel = new Event();
        $this->offerModel = new Offer();
        $this->productModel = new Product();
        $this->group_model = new Group();
        $this->page_model = new Page();
        $this->commentModel = new CommentModel();
        $this->postsReactionsModel = new PostsReactionsModel();
    }


    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields = [];
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


    public function get_post_detail($post_id , $loggendInUserID = 0)
    {
    
      $post = $this->where(['id'=> $post_id,'deleted_at'=>null])->get()->getFirstRow('array');
      $post = $this->compile_post_data($post, $loggendInUserID);
      return $post;
    }

    private function get_postMedia($post_id){
      $builder = $this->db->table('posts_media');
      $builder->select('id,media_path,image_or_video');
      $builder->where('post_id',$post_id);
      $builder->where('is_active',1);
      $query = $builder->get();
      return $query->getResultArray();
    }

    public function compile_post_data($post,$loggendInUserID = 0) {

      if($loggendInUserID == 0 ){
        $loggendInUserID = getCurrentUser()['id'];
      }

      if (!$post) {
          return null;
      }
      // Check if $post is an array of posts
      if (is_array($post) && isset($post[0]) && is_array($post[0])) {
          $compiledPosts = [];
          foreach ($post as $singlePost) {
              $compiledPosts[] = $this->processSinglePost($singlePost,$loggendInUserID);
          }
          return $compiledPosts;
      } else {
          // Process a single post
          return $this->processSinglePost($post,$loggendInUserID);
      }
    }

    private function processSinglePost($singlePost,$loggendInUserID) {
       
        
        $PostsAdvertisementModel = New PostsAdvertisementModel;
        $pollModel = New PollModel;
        if (isset($singlePost['user_id']) && !empty($singlePost['user_id'])) {
            $userInfo = $this->userModel->getUserShortInfo($singlePost['user_id']);
            $singlePost['user'] = $userInfo ?: null;
        }
        
        $singlePost['images'] = null;
        $singlePost['video']  = null;
        $singlePost['audio']  = null;
        $singlePost['created_human'] = HumanTime($singlePost['created_at']);
        $this->incrementViewCount($singlePost['id']);  
        
      

        if ($singlePost['image_or_video'] > 0) {
            $postMedia = $this->get_postMedia($singlePost['id']);
            
            // Initialize media types as null
            $singlePost['images'] = null;
            $singlePost['video'] = null;
            $singlePost['audio'] = null;

            foreach ($postMedia as $media) {
                $media['media_path'] = getMedia($media['media_path']);
                
                switch ($media['image_or_video']) {
                    case 1: // Image
                        $singlePost['images'][] = $media;
                        break;
                    case 2: // Video
                        $singlePost['video'] = $media;
                        break;
                    case 3: // Audio
                        $singlePost['audio'] = $media;
                        break;
                }
            }
        }


 
        $default_text="post";
         if($singlePost['image_or_video'] == 1){
             $default_text="Image";
         }elseif($singlePost['image_or_video'] == 2){
             $default_text="Video";
         }elseif($singlePost['image_or_video'] == 2){
            $default_text="Video";
        }

        $postSlug = (!empty($singlePost['post_text'])) ? url_title(substr($singlePost['post_text'], 0, 20), '-', TRUE) : $default_text;

        $singlePost['post_link'] = site_url('posts/').$singlePost['id'].'_'.$postSlug;


        $singlePost['product']=null;

        // Using null coalescing operator to simplify the assignments
        $singlePost['images'] = $singlePost['images'] ?? null;
        $singlePost['video'] = $singlePost['video'] ?? null;
        $singlePost['audio'] = $singlePost['audio'] ?? null;
        $singlePost['view_count'] = $singlePost['view_count'] ?? '0';

        $singlePost['posts_advertisement'] = null;

        // Simplifying the condition check for comments
        if (!empty($singlePost['comment_count'])) {
            $singlePost['comments'] = $this->commentModel->get_comments($singlePost['id'], 3, $loggendInUserID);
        } else {
            $singlePost['comments'] = null;
        }


        $singlePost['event'] = [];
        if (isset($singlePost['event_id']) && $singlePost['event_id'] > 0) {
            $singlePost['event'] = $this->eventModel->getEvent($singlePost['event_id']);
        }else{
            $singlePost['event'] = null;
        }

        $singlePost['offer'] = (object)[];
        if (isset($singlePost['offer_id']) && $singlePost['offer_id'] > 0) {
            $singlePost['offer'] = $this->offerModel->getoffer($singlePost['event_id']);
        }else{
            $singlePost['offer'] = null;
        }

         $singlePost['product'] = [];
        if (isset($singlePost['product_id']) && $singlePost['product_id'] > 0) {
            $singlePost['product'] = $this->productModel->getProduct($singlePost['product_id']);
        }else{
            $singlePost['product']=null;
        }
        $singlePost['group'] = [];
        if (isset($singlePost['group_id']) && $singlePost['group_id'] > 0) {
           $group = $this->group_model->getCompiledGroupData($singlePost['group_id'],$loggendInUserID);
           $singlePost['group'] = $group;
        }else{
            $singlePost['group'] = null;
        }

        
        $singlePost['page'] = [];
        if (isset($singlePost['page_id']) && $singlePost['page_id'] > 0) {
           $page = $this->page_model->getCompiledPageData($singlePost['page_id'],$loggendInUserID);
           $singlePost['page'] = $page;
        }else{
            $singlePost['page'] = null;
        }

        if (isset($singlePost['parent_id']) && $singlePost['parent_id'] > 0) {
            $singlePost['shared_post'] =  $this->get_post_detail($singlePost['parent_id'],$loggendInUserID);
            if(!empty($singlePost['shared_post']))
            {
                $singlePost['image_or_video'] =  $singlePost['shared_post']['image_or_video'];
            }
        }else{
            $singlePost['shared_post'] = null;
        }
        
        $singlePost['reaction'] = $this->postsReactionsModel->getPostReactionData($singlePost['id'],$loggendInUserID);
        // $singlePost['tags_list'] = "";
        if (!empty($singlePost['video_thumbnail'])) {
            $singlePost['video_thumbnail'] = getMedia($singlePost['video_thumbnail']);
        }

        $singlePost['is_saved'] = $this->isPostSavedByUser($singlePost['id'],$loggendInUserID);
        $singlePost['poll'] = [];
        if (isset($singlePost['poll_id']) && $singlePost['poll_id'] > 0) {
           $poll = $pollModel->getCompiledPageData($singlePost['poll_id'],$loggendInUserID);
           $singlePost['poll'] = $poll;
        }else{
            $singlePost['poll'] = null;
        }

        $singlePost['tagged_users'] = [];
        $postUserTagModel = New PostUserTag;
        $userModel = New UserModel;
        $postUserTag = $postUserTagModel->where('post_id',$singlePost['id'])->findAll();

        if (!empty($postUserTag) && count($postUserTag)>0) {
            $users = [];
            foreach($postUserTag as $user)
            {   
               $userdata = $userModel->getUserShortInfo($user['user_id']);
                if(!empty($userdata))
                {
                    $users[] = $userdata;
                }
            }
            $singlePost['tagged_users'] = $users;
        }else{
            $singlePost['tagged_users'] = null;
        }
        $singlePost['mentioned_users'] = [];
        $postusermentionModel = New PostUserMention;
        $userModel = New UserModel;
        $postUserMention = $postusermentionModel->where('post_id',$singlePost['id'])->findAll();
        $singlePost['mentioned_users'] = $postUserMention;
        if (!empty($postUserMention) && count($postUserMention)>0) {
            $users = [];
            foreach($postUserMention as $user)
            {   
                $userdata = $userModel->getUserShortInfo($user['user_id']);
                if(!empty($userdata))
                {
                    $users[] = $userdata;
                }
            }
            $singlePost['mentioned_users'] = $users;
        }else{
            $singlePost['mentioned_users'] = null;
        }
        $singlePost['donation'] = [];
        if (isset($singlePost['fund_id']) && $singlePost['post_type']=='donation') {
            $fundModel =New FundingModel;
            
           $fund = $fundModel->processFundData($singlePost['fund_id']);
           $singlePost['donation'] = $fund;
        }else{
            $singlePost['donation'] = null;
        }
        // Add advertisement data to the single post if available
        $advertisementData = $PostsAdvertisementModel->getPostAdvertisement($singlePost['id']);
        $singlePost['post_advertisement'] = $advertisementData ?: null;


        // Update Last seen of the user 
        updateLastSeen();
        return $singlePost;
    }

    protected function incrementViewCount($postId) {
        $this->db->table($this->table)
                 ->where('id', $postId)
                 ->set('view_count', 'view_count+1', FALSE)
                 ->update();
    }

    public function addComment($postId, $userId, $commentText){
        $data = [
            'post_id' => $postId,
            'user_id' => $userId,
            'comment' => $commentText,
        ];
        return $this->db->table('posts_comments')->insert($data);
    }

    public function deleteComment($commentId){
        return $this->db->table('posts_comments')->delete(['id' => $commentId]);
    }

    public function updateComment($commentId, $commentText)
    {
        $data = ['comment' => $commentText];
        return $this->db->table('posts_comments')->update($data, ['id' => $commentId]);
    }


    public function likeComment($commentId, $userId)
    {
        $data = [
            'user_id' => $userId,
            'comment_id' => $commentId,
        ];

        return $this->db->table('posts_comment_likes')->insert($data);
    }


    public function replyToComment($commentId, $userId, $replyText)
    {
        $data = [
            'comment_id' => $commentId,
            'user_id' => $userId,
            'comment' => $replyText,
        ];

        return $this->db->table('posts_comment_replies')->insert($data);
    }

    public function likeCommentReply($replyId, $userId)
    {
        $data = [
            'user_id' => $userId,
            'comment_reply_id' => $replyId,
        ];

        return $this->db->table('posts_comment_replies_likes')->insert($data);
    }

    /**
     * Checks if a user has saved a specific posts.
     *
     * @param int $postId
     * @param int $userId
     * @return bool
     */
    public function isPostSavedByUser($postId, $userId)
    {
        $builder = $this->db->table('posts_saved');
        $builder->where('post_id', $postId);
        $builder->where('user_id', $userId);
        return $builder->countAllResults() > 0;
    }


    public function getSavedPosts($postId, $userId)
    {

        $builder = $this->db->table('posts_saved');
        $builder->where('post_id', $postId);
        $builder->where('user_id', $userId);
        return $builder->countAllResults() > 0;
    }
    public function incrementColumn($postId, $columnName, $amount = 1)
    {
        $this->set($columnName, "$columnName + $amount", false)
             ->where('id', $postId)
             ->update();
    }
    public function decrementColumn($postId, $columnName, $amount = 1)
    {
        $this->set($columnName, "$columnName - $amount", false)
             ->where('id', $postId)
             ->update();
    }
    public function decrementCommentCount($postId) {
        $this->where('id', $postId);
        $this->set('comment_count', 'comment_count - 1', false);
        $this->update();
    }
    public function getAllPost()
    {
        $dbPrefix = $this->db->DBPrefix;
        
        return $this->select([$dbPrefix . 'users.username', $dbPrefix . 'posts.*'])
            ->join($dbPrefix . 'users', $dbPrefix . 'users.id = ' . $dbPrefix . 'posts.user_id')
            ->where($dbPrefix . 'users.deleted_at', null)
            ->orderBy($dbPrefix . 'posts.id', 'desc')
            ->findAll();
    }

    
  

    public function  getPostById($postId) {
         return $this->db->table('posts')
            ->select('*')
            ->where('id', $postId)
            ->get()
            ->getRow();
    }
    public function getuserPhoto($userId, $limit, $type)
    {
        $dbPrefix = $this->db->DBPrefix;

        return $this->select($dbPrefix . 'posts_media.media_path')
            ->join($dbPrefix . 'posts_media', $dbPrefix . 'posts_media.post_id = ' . $dbPrefix . 'posts.id', 'left')
            ->where($dbPrefix . 'posts.image_or_video', $type)
            ->where($dbPrefix . 'posts.user_id', $userId)
            ->where($dbPrefix . 'posts.privacy', 1)
            ->findAll($limit);
    }

    public function getuserallphotos($userId, $type, $limit = 24, $offset = 0)
    {
        $dbPrefix = $this->db->DBPrefix;

        return $this->select($dbPrefix . 'posts_media.media_path')
            ->join($dbPrefix . 'posts_media', $dbPrefix . 'posts_media.post_id = ' . $dbPrefix . 'posts.id', 'left')
            ->where($dbPrefix . 'posts.image_or_video', $type)
            ->where($dbPrefix . 'posts.user_id', $userId)
            ->where($dbPrefix . 'posts.privacy', 1)
            ->orderBy($dbPrefix . 'posts.id', 'desc')
            ->findAll($limit, $offset);
    }

    public function deletePostsByUserId($userId)
    {
        $commentModel = New CommentModel;
        $posts = $this->where('user_id',$userId)->findAll();
        foreach($posts as $post)
        {
            $commentModel->deletecomment($post['user_id'],$userId);
            $this->delete($post['id']);
        }
    }
    public function getPostLink($id)
    {
        $singlePost = $this->find($id);
        if(!empty($singlePost))
        {
            $default_text="post";
            if($singlePost['image_or_video'] == 1){
                $default_text="Image";
            }elseif($singlePost['image_or_video'] == 2){
                $default_text="Video";
            }elseif($singlePost['image_or_video'] == 2){
                $default_text="Video";
            }
            $postSlug = (!empty($singlePost['post_text'])) ? url_title(substr($singlePost['post_text'], 0, 20), '-', TRUE) : $default_text;
            return site_url('posts/').$singlePost['id'].'_'.$postSlug;
        }
        return null;

    }
}
