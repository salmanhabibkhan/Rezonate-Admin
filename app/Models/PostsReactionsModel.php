<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsReactionsModel extends Model
{
    protected $table            = 'posts_reactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

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


   

     public function getPostReactionData($postId, $userId) {
        
        $builder = $this->db->table($this->table);

        // Count total reactions on the post
        $totalReactions = $builder->where('post_id', $postId)->countAllResults(false);

        // if there is no reaction on this post then no need to check user action query
        if( $totalReactions > 0){
            $userReaction = $builder->where('post_id', $postId)->where('user_id', $userId)->get()->getRowArray();
        }else{
            $userReaction = 0;        
        }
        
        return [
            'is_reacted' => !empty($userReaction)?true:false,
            'reaction_type' => $userReaction['reaction'] ?? '0',
            'count' => $totalReactions,
            'image' => '',
            'color'=>'',
            'text'=> ''
        ];
    }

    public function getCommentReactionData($comment_id, $userId) {
        $builder = $this->db->table($this->table);

        // Count total reactions on the post
        $totalReactions = $builder->where('comment_id', $comment_id)->countAllResults(false);

        // if there is no reaction on this post then no need to check user action query
        if( $totalReactions > 0){
            $userReaction = $builder->where('comment_id', $comment_id)->where('user_id', $userId)->get()->getRowArray();
        }else{
            $userReaction = 0;        
        }
        
        return [
            'is_reacted' => !empty($userReaction),
            'reaction_type' => $userReaction['reaction'] ?? '0',
            'count' => $totalReactions,
            'image' => '',
            'color'=>''
        ];
    }

    public function getCommentRepliesReactionData($comment_reply_id, $userId) {
      
        $builder = $this->db->table('posts_comment_replies_likes');

        // Count total reactions on the post
        $totalReactions = $builder->where('comment_reply_id', $comment_reply_id)->countAllResults(false);

        // if there is no reaction on this post then no need to check user action query
        if( $totalReactions > 0){
            $userReaction = $builder->where('comment_reply_id', $comment_reply_id)->where('user_id', $userId)->get()->getRowArray();
            
        }else{
            $userReaction = 0;        
        }
      
        return [
            'is_reacted' => !empty($userReaction),
            'reaction_type' => $userReaction['reaction'] ?? '0',
            'count' => $totalReactions,
            'image' => '',
            'color'=>''
        ];
    }
    public function getpostreaction($post_id, $reaction, $limit, $offset)
{
    $dbPrefix = $this->db->DBPrefix;
    $modifiedUsers = [];

    $users = $this->select([$dbPrefix . 'users.id', $dbPrefix . 'users.is_verified', $dbPrefix . 'users.username', $dbPrefix . 'users.first_name', $dbPrefix . 'users.last_name', $dbPrefix . 'users.avatar', $dbPrefix . 'users.cover', $dbPrefix . 'users.gender', $dbPrefix . 'users.level', $dbPrefix . 'users.role'])
        ->join($dbPrefix . 'users', $dbPrefix . 'users.id = ' . $dbPrefix . 'posts_reactions.user_id')
        ->where($dbPrefix . 'posts_reactions.reaction', $reaction)
        ->where($dbPrefix . 'posts_reactions.post_id', $post_id)
        ->where($dbPrefix . 'users.deleted_at', null)
        ->findAll($limit, $offset);

    foreach ($users as $user) {
        $modifiedUser = $user;
        $defaultAvatar = base_url('uploads/user_placeholder.webp');
        $modifiedUser['avatar'] = !empty($user['avatar']) ? base_url($user['avatar']) : $defaultAvatar;
        $modifiedUser['cover'] = !empty($user['cover']) ? base_url($user['cover']) : $defaultAvatar;
        $modifiedUsers[] = $modifiedUser;
    }

    return $modifiedUsers;
}



}
