<?php
namespace App\Models;
use stdClass;
use CodeIgniter\Model;

class CommentModel extends Model
{

  protected $table            = 'posts_comments';
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

  public function get_comments($post_id, $limit = 5, $loggendInUserID = 0)
  {
      $dbPrefix = $this->db->DBPrefix;
      $postsReactionsModel = model('PostsReactionsModel');
      $builder = $this->db->table($dbPrefix.'posts_comments as cmt');
      $builder->select('cmt.*,u.first_name,u.last_name,u.avatar,u.username,u.is_verified');
      $builder->where('cmt.post_id', $post_id);
      $builder->where('cmt.deleted_at', null);
      $builder->join($dbPrefix.'users u', 'u.id = cmt.user_id');
      $query = $builder->get();
      $comment_result = $query->getResultArray();
      if (!empty($comment_result)) {
          foreach ($comment_result as &$comment) {
              $comment['avatar'] = getMedia($comment['avatar'],'avatar');
              $comment['created_human'] = HumanTime($comment['created_at']);
              $comment['reaction'] = $postsReactionsModel->getCommentReactionData($comment['id'], $loggendInUserID);
              $comment['comment_id'] = $comment['id'];
              
              $comment['comment_replies'] = [];
              $comment['created_human'] = shortHumanTime($comment['created_at']);
              if ($comment['reply_count'] > 0) {
                  $comment['comment_replies'] = $this->get_comment_replies($comment['id'], $limit, $loggendInUserID);
              }
              else{
                  $comment['comment_replies'] = null;
              }
              $comment['is_comment_liked'] = $this->checkCommentLiked($loggendInUserID, $comment['id']);
          }
          return $comment_result;
      }
      return [];
  }
  
  public function checkCommentLiked($userId, $commentId)
  {
      $dbPrefix = $this->db->DBPrefix;
      $checkComment = $this->db->table($dbPrefix.'posts_comment_likes')
          ->where('user_id', $userId)
          ->where('comment_id', $commentId)
          ->get()
          ->getResultArray();
      return !empty($checkComment);
  }



  public function get_comments_detail($comment_id, $loggendInUserID = 0)
{
    $postsReactionsModel = model('PostsReactionsModel');
    $dbPrefix = $this->db->DBPrefix;
    
    $builder = $this->db->table($dbPrefix.'posts_comments as cmt');
    $builder->select('cmt.*, u.first_name, u.last_name, u.avatar, u.username, u.is_verified');
    $builder->where('cmt.id', $comment_id);
    $builder->where('cmt.deleted_at', null);
    $builder->join($dbPrefix.'users u', 'u.id = cmt.user_id');
    $query = $builder->get();
    $comment_result = $query->getResultArray();
    
    if (!empty($comment_result)) {
        foreach ($comment_result as &$comment) {
            $comment['reaction'] = $postsReactionsModel->getCommentReactionData($comment['id'], $loggendInUserID);
            $comment['avatar'] =  getMedia($comment['avatar']);
            $comment['comment_id'] =  '0';
            $comment['created_human'] = shortHumanTime($comment['created_at']);
            $comment['comment_replies'] = [];
            if ($comment['reply_count'] > 0) {
                $comment['comment_replies'] = $this->get_comment_replies($comment['id'], 3, $loggendInUserID = 0);
            }
            $comment['is_comment_liked'] = $this->checkCommentLiked($loggendInUserID, $comment['id']);
        }

        if(isset($_GET['get_html'])){
            $arr['comments'] = $comment_result;
            return load_view('partials/comment_list',$arr); 
        }
        return $comment_result[0];
    }
    
    return [];
}


  public function insertReply($data)
  {
    $db      = \Config\Database::connect();
    $builder = $db->table('posts_comment_replies');
    $builder->insert($data);
    return $db->insertID();
  }

  public function incrementLikeCount($commentId)
  {
    $this->where('id', $commentId);
    $this->set('like_count', 'like_count + 1', false);
    $this->update();
  }
  public function decrementLikeCount($commentId)
  {
    $this->where('id', $commentId);
    $this->set('like_count', 'like_count - 1', false);
    $this->update();
  }

  public function get_comment_replies($comment_id, $limit, $loggendInUserID)
{
    $postsReactionsModel = model('PostsReactionsModel');
    $dbPrefix = $this->db->DBPrefix;
    
    $builder = $this->db->table($dbPrefix.'posts_comment_replies as cmt');
    $builder->select('cmt.*, u.first_name, u.last_name, avatar, u.is_verified, u.username');
    $builder->where('cmt.comment_id', $comment_id);
    $builder->join($dbPrefix.'users u', 'u.id = cmt.user_id');
    $query = $builder->get();
    $comment_result = $query->getResultArray();
    
    if (!empty($comment_result)) {
        foreach ($comment_result as &$comment_reply) {
            $comment_reply['post_id'] = '0';
            $comment_reply['reply_count'] = '0';
            $comment_reply['comment_count'] = '0';
            $comment_reply['avatar'] = getMedia($comment_reply['avatar']);
            $comment_reply['created_human'] = shortHumanTime($comment_reply['created_at']);
            $comment_reply['updated_at'] = null;
            $comment_reply['deleted_at'] = null;
            $comment_reply['reaction'] = $postsReactionsModel->getCommentRepliesReactionData($comment_reply['id'], $loggendInUserID);
            $comment_reply['comment_replies'] = null;
        }
        return $comment_result;
    }
    
    return [];
}


public function NewCommentReply($comment_id, $loggendInUserID)
{
    $postsReactionsModel = model('PostsReactionsModel');
    $dbPrefix = $this->db->DBPrefix;
    
    $builder = $this->db->table($dbPrefix.'posts_comment_replies as cmt');
    $builder->select('cmt.*, u.first_name, u.last_name, avatar, u.is_verified, u.username');
    $builder->where('cmt.id', $comment_id);
    $builder->join($dbPrefix.'users u', 'u.id = cmt.user_id');
    $query = $builder->get();
    $comment_result = $query->getFirstRow();
    
    $comment_result = (array) $comment_result;
    $newcomment = $comment_result;
    $newcomment['post_id'] = '0';
    $newcomment['reply_count'] = '0';
    $newcomment['comment_count'] = '0';
    $newcomment['avatar'] = getMedia($comment_result['avatar']);
    $newcomment['created_human'] = shortHumanTime($newcomment['created_at']);
    $newcomment['updated_at'] = null;
    $newcomment['deleted_at'] = null;
    $newcomment['reaction'] =  $postsReactionsModel->getCommentRepliesReactionData($newcomment['id'], $loggendInUserID);
    $newcomment['comment_replies'] =  null;
    return $newcomment;
}
 


  public function incrementreplyCount($commentId)
  {
    $this->where('id', $commentId);
    $this->set('reply_count', 'reply_count + 1', false);
    $this->update();
  }
  public function decrementreplyCount($commentId)
  {
    $this->where('id', $commentId);
    $this->set('reply_count', 'reply_count - 1', false);
    $this->update();
  }
  public function deletecomment($postId,$userId)
  {
    $this->where('user_id', $userId)->orWhere('post_id',$postId)->delete();
  }
}
