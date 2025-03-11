<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PostModel;
use App\Models\PostsAdvertisementModel;
use App\Models\UserModel;

class AdvertisementController extends BaseController
{
    public function index()
    {
        $adsModel = new PostsAdvertisementModel;

        $this->data['ads'] = $adsModel
            ->select('posts_advertisement.*,users.username,users.email ,posts.post_link , posts.post_text,posts.image_or_video')
            ->join('users', 'posts_advertisement.from_user_id = users.id')
            ->join('posts', 'posts.id = posts_advertisement.post_id')
            ->where('posts_advertisement.deleted_at', null)
            ->where('posts_advertisement.status', 1)
            ->where('posts_advertisement.to_user_id', $this->data['user_data']['id'])
            ->findAll();
        echo load_view('pages/ads/index', $this->data);
    }
    public function viewDetail($id)
    {
        $adsModel = new PostsAdvertisementModel;
        $userModel = New UserModel;
        $postModel = New PostModel;
        $ad = $adsModel->find($id);
        if(!empty($ad))
        {
            $this->data['userdata'] = $userModel->getUserShortInfo($ad['from_user_id']);
            $post = $postModel->select(['post_link','post_text','image_or_video','id'])->where('id',$ad['post_id'])->first();
            $default_text="post";
            if($post['image_or_video'] == 1){
                $default_text="Image";
            }elseif($post['image_or_video'] == 2){
                $default_text="Video";
            }elseif($post['image_or_video'] == 2){
               $default_text="Video";
           }
   
           $postSlug = (!empty($post['post_text'])) ? url_title(substr($post['post_text'], 0, 20), '-', TRUE) : $default_text;
   
            $this->data['post_link'] = site_url('posts/').$ad['post_id'].'_'.$postSlug;
            $this->data['ad'] = $ad;
            
            echo load_view('pages/ads/details', $this->data);
        }
      
    }
}
