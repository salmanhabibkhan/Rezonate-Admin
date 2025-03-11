<?php

namespace App\Controllers;

use App\Models\FundingModel;
use App\Models\HashTagModel;
use App\Models\PostTagModel;
use App\Models\TransactionActionModel;
use DateTime;
use App\Models\Page;
use App\Models\Block;
use App\Models\Group;
use App\Models\Friend;
use App\Models\PollModel;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\PollOption;
use App\Models\PollResult;
use App\Models\GroupMember;
use App\Models\PostUserTag;
use App\Models\CommentModel;
use App\Models\Advertisement;
use App\Models\TransactionModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\PostsReactionsModel;
use App\Models\PostsAdvertisementModel;

class PostController extends BaseController
{
    use ResponseTrait;
    private $validation;
    private $userObj; 
    private $postLimit = 6;

    public function __construct()
    {
        parent::__construct();
        $this->validation = \Config\Services::validation();
    }

    public function addPost(){
        // $rules = [
        //     'post_text' => 'required', 
        // ];

        // if (!$this->validate($rules)) {
        //     return $this->response->setJSON($this->validation->getErrors())->setStatusCode(400);
        // }

        $post_text = $this->request->getVar('post_text');
 

        $db = \Config\Database::connect();

        $images = $this->request->getFiles('images');
        $video = $this->request->getFile('video');
        $audio = $this->request->getFile('audio');

     
    
        // Check if at least one required input is provided
        $isInputProvided = !empty($post_text) || (isset($images['images']) && count($images['images']) > 0) || ($video && $video->isValid()) || ($audio && $audio->isValid());
    
        if (!$isInputProvided) {
            // Return error response if none of the required inputs are provided
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.input_required')
            ])->setStatusCode(400);
        }

        $post = new PostModel();
        $userData = getCurrentUser();
        $page_id =  $this->request->getVar('page_id');
        
        if(!empty($page_id))
        {
            $pageModel = New Page;
            $page = $pageModel->find($page_id);
            if(empty($page))
            {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.page_not_found')
                ])->setStatusCode(400);

            }
            if($page['user_id']!=$userData['id'])
            {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.unauthorized_access')
                ])->setStatusCode(400);
            }
        }
        $group_id =  $this->request->getVar('group_id');
        if(!empty($group_id))
        {
            $groupModel = New Group;
            $group = $groupModel->find($group_id);
            if(empty($group))
            {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.group_not_found')
                ])->setStatusCode(400);

            }
            if(empty($groupModel->checkMemberStatus($group_id,$userData['id'])))
            {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.not_a_group_member')
                ])->setStatusCode(400);
            }
        }

        
        $post_text = $this->request->getVar('post_text');

        $post_text = $this->request->getVar('post_text');

        if (!empty($post_text)) {
            // Fetching censored words from settings
            $censored_words = get_setting('censored_words');
            if (!empty($censored_words)) {
                helper('text');
                $censored_words_array = array_map('trim', explode(',', $censored_words));
                $post_text = word_censor($post_text, $censored_words_array);
            }
            
            // Regex to find YouTube and Vimeo URLs
            preg_match_all('/\bhttps?:\/\/\S+(?:youtube\.com|youtu\.be|vimeo\.com)\/\S+\b/', $post_text, $matches);
            $youtube_url = '';
            $vimeo_url = '';
        
            foreach ($matches[0] as $url) {
                if (empty($youtube_url) && (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false)) {
                    $youtube_url = $url;
                } elseif (empty($vimeo_url) && strpos($url, 'vimeo.com') !== false) {
                    $vimeo_url = $url;
                }
        
                // Stop searching if both URLs are found
                if (!empty($youtube_url) && !empty($vimeo_url)) {
                    break;
                }
            }
        }
        
        $insertedData = [
            'user_id' => $userData['id'],
            'post_text' => $post_text,
            'youtube_urls' => $youtube_url?? '',
            'vimeo_urls' => $vimeo_url??"",
            'privacy' => $this->request->getVar('privacy')?: 1,
            'feeling_type' => $this->request->getVar('feeling_type'),
            'bg_color' => !empty($this->request->getVar('bg_color'))?$this->request->getVar('bg_color'):null,
            'feeling' => $this->request->getVar('feeling'),
            'ip' => $this->request->getIPAddress(),
            'post_location' => $this->request->getVar('post_location') ?: '',
            'post_color_id' => $this->request->getVar('post_color_id') ?: 0,
            'width' => $this->request->getVar('width') ?: 0,
            'height' => $this->request->getVar('height') ?: 0,
            'page_id' => $this->request->getVar('page_id') ?: 0,
            'group_id' => $this->request->getVar('group_id') ?: 0,
            'event_id' => $this->request->getVar('event_id') ?: 0,
            'product_id' => $this->request->getVar('product_id') ?: 0,
            'poll_id' => $this->request->getVar('poll_id') ?: 0,
            // Add other optional fields here if necessary
        ];

        $db = \Config\Database::connect();
        try {
            $db->transStart();
            $post->save($insertedData);
            $postID = $post->getInsertID();
           
            //post is inserted. lets insert its images,videos,files and update post
            $postUpdateData = [];
            $images = $this->request->getFiles();
            if (isset($images['images'])) {
                $dataToInsert = [];

                foreach ($images['images'] as $image) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $mediaPath = storeMedia($image, 'post');

                        $dataToInsert[] = [
                            'post_id'       => $postID,
                            'user_id'       => $userData['id'],
                            'image_or_video' => '1',
                            'media_path'    => $mediaPath,
                        ];
                    }
                }

                if (!empty($dataToInsert)) {
                    $builder = $db->table('posts_media');
                    $builder->insertBatch($dataToInsert);
                    $postUpdateData['image_or_video'] = 1;
                }
            }
            $hashtagModel = New HashTagModel;
            $postTagModel = New PostTagModel;
            $pattern = "/#(\w+)/";
            preg_match_all($pattern, $post_text, $hashtags);
            $all_hashtags = $hashtags[0];                 
            if(count($all_hashtags)>0 )
            {
                $existingTags = $hashtagModel->whereIn('name', $all_hashtags)->findAll();
                $columnValues = array_column($existingTags, 'name');
                foreach ($all_hashtags as $hashtag) {
                    if (!in_array($hashtag, $columnValues)) {
                        // Create a new hashtag if it doesn't exist
                        $newHashtag = $hashtagModel->save(['name' => $hashtag]);
                        $insertedID = $hashtagModel->insertID();
                        
                        $postTagModel->save(['post_id' => $postID, 'tag_id' => $insertedID]);
                    } else {
                        $tag = $hashtagModel->where(['name' => $hashtag])->first();
                        !empty($tag)?$postTagModel->save(['post_id' => $postID, 'tag_id' => $tag['id']]):'';
                    }
                }
            }
            $images = $this->request->getFiles();
            if (isset($images['images'])) {
                $dataToInsert = [];

                foreach ($images['images'] as $image) {
                    if ($image->isValid() && !$image->hasMoved()) {
                        $mediaPath = storeMedia($image, 'post');

                        $dataToInsert[] = [
                            'post_id'       => $postID,
                            'user_id'       => $userData['id'],
                            'image_or_video' => '1',
                            'media_path'    => $mediaPath,
                        ];
                    }
                }

                if (!empty($dataToInsert)) {
                    $builder = $db->table('posts_media');
                    $builder->insertBatch($dataToInsert);
                    $postUpdateData['image_or_video'] = 1;
                }
            }
            $post_type =$this->request->getVar('post_type');
            $poll_option = $this->request->getVar('poll_option');
           
            if(!empty($post_type) && $post_type=='poll' && !empty($poll_option))
            {
                $pollModel = new PollModel();
                $polldata = [
                    'poll_title' => $post_text,
                    'is_active' =>1,
                ];
                
                if ($pollModel->save($polldata)) {
                    // Data inserted successfully
                    $pollID = $pollModel->getInsertID();
                    $poll_options = explode(",", $poll_option);
                    $batchData = [];
                    foreach ($poll_options as $option) {
                        if(!empty($option))
                        {
                            $batchData[] = [
                                'poll_id' => $pollID,
                                'option_text' => $option,
                            ];
                        }
                    }

                    if(!empty($batchData))
                    {
                        $polloption = $db->table('poll_options');
                        $polloption->insertBatch($batchData);
                        $postUpdateData['post_type'] = 'poll';
                        $postUpdateData['poll_id'] = $pollID;
                    }          
                } 
              
            }
            $tagged_usersStr = $this->request->getVar('tagged_users');
            if(!empty($tagged_usersStr))
            {
                $tagged_users = explode(",", $tagged_usersStr);
                $taguserbatchdata = [];
                $userdata = [];
                foreach ($tagged_users as $user) {
                    $taguserbatchdata[] = [
                        'user_id' => $user,
                        'post_id' => $postID,
                    ];
                    $userdevicedata = [];
                    $text = 'tagged you in a post.';
                    $userModel = New UserModel;
                    $user_device = $userModel->select(['device_id','email'])->where('id', $user)->first();
                    if($user!=$userData['id'])
                    {
                        $notificationModel = New NotificationModel();
                        $notificationdata = [
                            'from_user_id'=>$userData['id'],
                            'to_user_id'=>$user,
                            'type'=>'tag-user',
                            'post_id'=>$postID,
                            'text'=>$text,
                        ];
                    $notificationModel->save($notificationdata);
                    // if(get_setting('chck-emailNotification')==1)
                    // {
                    //     sendmailnotificaiton($user_device['email'],'Share Post',$text);
                    // }
                    $userdevicedata[] =  $user_device['device_id'];
                    
                    }
                    sendPushNotification($userdevicedata,$text);
                }
                if(!empty($taguserbatchdata))
                    {
                        $polloption = $db->table('post_user_tags');
                        $polloption->insertBatch($taguserbatchdata); 
                    }   
            }
            $mention_users = $this->request->getVar('mentioned_users');
            
            if(!empty($mention_users))
            {
                $mentioned_users = explode(",", $mention_users);
                
                $mentionuserbatchdata = [];
             
                foreach ($mentioned_users as $user) {
                    $mentionuserbatchdata[] = [
                        'user_id' => $user,
                        'post_id' => $postID,
                    ];
                    $userdevicedata = [];
                    $text = ' mentioned you in a post.';
                    $userModel = New UserModel;
                    $user_device = $userModel->select(['device_id','email'])->where('id', $user)->first();
                    if($user!=$userData['id'])
                    {
                        $notificationModel = New NotificationModel();
                        $notificationdata = [
                            'from_user_id'=>$userData['id'],
                            'to_user_id'=>$user,
                            'type'=>'mention-user',
                            'post_id'=>$postID,
                            'text'=>$text,
                        ];
                    $notificationModel->save($notificationdata);
                    // if(get_setting('chck-emailNotification')==1)
                    // {
                    //     sendmailnotificaiton($user_device['email'],'Share Post',$text);
                    // }
                    $userdevicedata[] =  $user_device['device_id'];
                    
                    }
                    sendPushNotification($userdevicedata,$text);
                }
                if(!empty($mentionuserbatchdata))
                    {
                        $polloption = $db->table($db->DBPrefix.'post_user_mentions');
                        $polloption->insertBatch($mentionuserbatchdata); 
                    }   
            }
            
            if($post_type=="donation")
            {
                $image = $this->request->getFile('donation_image'); 
                if(!empty($image))
                {
                    $image = storeMedia($image, 'donation_image');
                }
                $fundingModel = New FundingModel;
                $donationData = [
                    'user_id'=>$userData['id'],
                    'title'=>$post_text,
                    'description'=>$this->request->getVar('description'),
                    'amount'=>$this->request->getVar('amount'),
                    'image'=>(!empty($image))?$image:'',
                ];
                $fundingModel->save($donationData);
                $postUpdateData['post_type'] = 'donation';
                $postUpdateData['fund_id'] =$fundingModel->getInsertID();
            }

        
            //Only video or images could be uploaded at a time.
            if(!isset($postUpdateData['image_or_video'])){
                $video = $this->request->getFile('video'); 
                if ($video && $video->isValid() && !$video->hasMoved()) {
                    $mediaPath = storeMedia($video, 'post', 'video');

                     $dataToInsert[] = [
                        'post_id'     => $postID,
                        'user_id'      => $userData['id'],
                        'image_or_video'      => '2',
                        'media_path' => $mediaPath,
                    ];
                    $postUpdateData['image_or_video'] = 2;
                } 
                $audio = $this->request->getFile('audio'); 
                if ($audio && $audio->isValid() && !$audio->hasMoved()) {
                    $mediaPath = storeMedia($audio, 'post', 'audio');

                     $dataToInsert[] = [
                        'post_id'     => $postID,
                        'user_id'      => $userData['id'],
                        'image_or_video'      => '3',
                        'media_path' => $mediaPath,
                    ];
                    $postUpdateData['image_or_video'] = 3;
                }

                if(!empty($dataToInsert)){
                    $builder = $db->table('posts_media');
                    $builder->insertBatch($dataToInsert);
                    // $postUpdateData['image_or_video'] = 2;    
                }
                

                 // video_thumbnail uploading and set it to post 
                $video_thumbnail = $this->request->getFile('video_thumbnail'); 
                if ($video_thumbnail && $video_thumbnail->isValid() && !$video_thumbnail->hasMoved()) {
                    $mediaPath = storeMedia($video_thumbnail, 'post');
                    $postUpdateData['video_thumbnail'] = $mediaPath;
                }
            }
            if(!empty($postUpdateData)){
              
                $post->set($postUpdateData);
                $post->where('id', $postID);
                $post->update();
            }

            $get_html = $this->request->getVar('get_html');


             $postData = $post->get_post_detail($postID);
            if($get_html == 1){
                $this->data['posts'][0] = $postData;
                $this->data['loggendInUserId'] =$userData['id'];
               
                $postData =  load_view('partials/posts.php',$this->data);
                                                                                            
                }
        
                $db->transComplete();
         
                if ($db->transStatus() === false) {
                    $error = $db->error(); // Get the database error information
                     echo "Data not inserted. Error: " . $error['message'];
                 
                    // $db->transRollback();
                   // log_message('error', 'Transaction failed in addPost');
                    // throw new \Exception('There was a problem creating the post.');
                }
                if(get_setting('chck-notify_new_post')!='0')
                {
                    $friendModel = New Friend;
                    $friends = $friendModel->userFriends($userData['id']);
                    if(!empty($friends) && count($friends))
                    {
                        $notificationModel = New NotificationModel;
                        $notificationBatchData = [];
                        $devices = [];
                        $newpost_text = "added a new post";
                        foreach($friends  as $friend)
                        {
                            if($friend['notify_friends_newpost']==1)
                            {
                                $notificationdata = [
                                    'from_user_id'=>$userData['id'],
                                    'to_user_id'=>$friend['id'],
                                    'post_id'=>$postID,
                                    'type'=>'new_post',
                                    'text'=>"added a new post", 
                                ];
                                $notificationBatchData[] = $notificationdata;
                                if(!empty($friend['device_id']))
                                {
                                    $devices[] = $friend['device_id'];
                                }  
                            }
        
                            // if(get_setting('chck-emailNotification')==1)
                            // {
                            //     sendmailnotificaiton($user_device['email'],'Post Comment',$text);
                            // }                  
                        }
                        if(!empty($notificationBatchData))
                        {
                            $notificationModel->insertBatch($notificationBatchData);
                        }
                        if(!empty($devices))
                        {
                            sendPushNotification($devices,$newpost_text);
                        }
                    }
                }
                
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.post_created_success'),
                'data' =>  $postData
            ], 200);
        } catch (\Exception $e) {
           // log_message('error', $e->getMessage());
           $db->transRollback();
           
            return $this->respond([
                'code' => '500',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getNewsfeed() {
        $loggendInUserID = getCurrentUser()['id']??0;
    
        $last_post_id = $this->request->getVar('last_post_id');
        $provided_user_id = $this->request->getVar('user_id');
        $page_id = $this->request->getVar('page_id');
        $group_id = $this->request->getVar('group_id');
        $post_id = $this->request->getVar('post_id');
        $get_html = $this->request->getVar('get_html');
        $post_type = $this->request->getVar('post_type');
        $limit = $this->request->getVar('limit');
        $hashtag = $this->request->getVar('hashtag');
        $post_ids = '';
        if(!empty($hashtag))
        {
            $hashTagModel = New HashTagModel;
            $post_ids = $hashTagModel->hashtagposts($hashtag);
        }
        
      
        if (!empty($limit)) {
            $this->postLimit = $limit;
        }
    
        // Getting pages, groups, and friends
        $pages_list = model('Page')->getLikedPagesByUserByGroup($loggendInUserID);
        $groups_list = model('Group')->getJoinedGroupsIds($loggendInUserID);
        $friends_list = [];
        if (!empty($loggendInUserID)) {
            $friends_list = model('Friend')->getFriendsIDByGroup($loggendInUserID);
            array_push($friends_list, $loggendInUserID);
        }
    
        // Getting blocked users
        $block = new Block;
        $blockedUserIds = $block->getblockuser($loggendInUserID);
        $blockedUserIdsStr = implode(',', $blockedUserIds);
    
        $db = \Config\Database::connect();
        $query = "SELECT * FROM `{$db->DBPrefix}posts` pst   WHERE `status` = 1 AND pst.`deleted_at` IS NULL ";
    
        // Exclude posts from blocked users
        if (!empty($blockedUserIds)) {
            $query .= " AND `user_id` NOT IN (" . $blockedUserIdsStr . ")";
        }

        if (!empty($blockedUserIds)) {
            $query .= " AND `user_id` NOT IN (" . $blockedUserIdsStr . ")";
        }

        if (!empty($post_type) && $post_type=='2') {
            $query .= " AND `image_or_video` = " . (int)$post_type . " AND `parent_id` = 0 ";
        }

        if (!empty($hashtag) && !empty($post_ids) ) {
            $query .= " AND `id` in ($post_ids)";
        }
        if (!empty($post_type) && $post_type=='5' ) {
            $query .= " AND `id` in (select post_id from {$db->DBPrefix}posts_saved where user_id = $loggendInUserID)";
        }

        if(!empty($page_id)){
            $query .= " AND `page_id` = " . $page_id . " ";
        }elseif(!empty($group_id)){
            $query .= " AND `group_id` = " . $group_id . " ";
        } else {
            if (!empty($provided_user_id)) {
                $query .= " AND `user_id` = " . $provided_user_id . " ";
            }
            
            if(!empty($post_id)){ //single post
                $query .= " AND `id` = " . $post_id . " ";
            }

            // Apply general filters
            $query .= " AND (";
            
            if($loggendInUserID){
                $query .= " (`user_id` = " . $loggendInUserID . " OR `privacy` != 3)";
            }else{
                $query .= " (`privacy` = 1)";
            }



            if (!empty($friends_list)) {
                $query .= " OR (`user_id` IN (" . implode(',', $friends_list) . ") AND `privacy` = 3)";
            }
            if (!empty($pages_list)) {
                $query .= " OR `page_id` IN (" . implode(',', $pages_list) . ")";
            }
            if (!empty($groups_list)) {
                $query .= " OR `group_id` IN (" . implode(',', $groups_list) . ")";
            }
            $query .= " ) ";

            if($loggendInUserID){
                // Apply privacy settings
                $query .= " AND (";
                $query .= " pst.user_id = " . $loggendInUserID; // User's own posts
                $query .= " OR pst.privacy = 1";  // Public
                $query .= " OR (pst.privacy = 3 AND pst.user_id = ".$loggendInUserID.")";  // Only me

                    // Friends, Family, Business
                    $query .= " OR (";
                    $query .= "    EXISTS (";
                    $query .= "        SELECT 1 FROM {$db->DBPrefix}friends frnd";
                    $query .= "        WHERE (frnd.friend_one = pst.user_id AND frnd.friend_two = ".$loggendInUserID.")";
                    $query .= "        OR (frnd.friend_two = pst.user_id AND frnd.friend_one = ".$loggendInUserID.")";
                    $query .= "        AND ((pst.privacy = 2 AND frnd.role = '2')";  // frnd
                    $query .= "            OR (pst.privacy = 4 AND frnd.role = '4')";  // Family
                    $query .= "            OR (pst.privacy = 5 AND frnd.role = '5')";  // Business
                    $query .= "        ) AND frnd.status = 1"; // Ensure the friendship is accepted
                    $query .= "    )";
                    $query .= ")";
                $query .= ")";
            }

        }
        
        // Additional conditions for last_post_id and ordering
        if (!empty($last_post_id)) {
            $query .= " AND pst.id < " . $last_post_id;
        }
        $query .= "   ORDER BY pst.`id` DESC LIMIT {$this->postLimit}";
       
        $db = \Config\Database::connect();
        
        $postData = $db->query($query)->getResultArray();
        
        if (!empty($postData)) {
            $postBuilder = new PostModel();
            $postData = $postBuilder->compile_post_data($postData, $loggendInUserID);
    
            if ($get_html == 1) {
                $this->data['posts'] = $postData;
                $this->data['loggendInUserId'] = $loggendInUserID;
                $this->data['last_post_id'] = $last_post_id;
                
                $postData = load_view('partials/posts.php', $this->data);
            }
        }
    
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.post_data'),
            'data' => $postData
        ], 200);
    }

    public function getSavedPost(){

        $loggendInUserID = getCurrentUser()['id'];

        //query start
        $postBuilder = new PostModel();
        
        $postBuilder->select('posts.*');

        $postBuilder->where('status', 1);
        // Join with the posts_saved table
        $postBuilder->join('posts_saved', 'posts_saved.post_id = posts.id', 'inner');
         // Additional conditions like status
        $postBuilder->where('posts.status', 1);
        $postBuilder->where('posts_saved.user_id', $loggendInUserID);
        
        $postBuilder->orderBy('posts.id', 'desc');
        $postBuilder->limit($this->postLimit);

        $postData = $postBuilder->findAll();
     
        if(!empty($postData)){
           $postData =  $postBuilder->compile_post_data($postData,$loggendInUserID);
        }
        
        return $this->respond([
            'code' => '200',
            'message' => 'Posts saved List',
            'data' => $postData 
        ], 200);
    }

    public function getPagePosts($page_id){

        

        $postBuilder = new PostModel();

        $postBuilder->where('status', 1);
        $postBuilder->where('page_id', $page_id);
        $postBuilder->orderBy('id', 'dsc');
        $postBuilder->limit($this->postLimit);
        $postData = $postBuilder->findAll();
        if(!empty($postData)){
           $postData =  $postBuilder->compile_post_data($postData);
        }

        return $this->respond([
            'code' => '200',
            'message' => 'Success',
            'data' => $postData 
        ], 200);
    }

    public function getGroupPosts($group_id){

        $postBuilder = new PostModel();

        $postBuilder->where('status', 1);
        $postBuilder->where('group_id', $group_id);
        $postBuilder->orderBy('id', 'dsc');
        $postBuilder->limit($this->postLimit);
        $postData = $postBuilder->findAll();
        if(!empty($postData)){
           $postData =  $postBuilder->compile_post_data($postData);
        }

        return $this->respond([
            'code' => '200',
            'message' => 'Success',
            'data' => $postData 
        ], 200);
    }

    public function getPostDetail(){

        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required')
                ]
            ]
        ];
        if(!$this->validate($rules))
        {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $post_id = $this->request->getVar('post_id'); 
        $get_html = $this->request->getVar('get_html'); 

        $post = new PostModel();
        $postData = $post->get_post_detail($post_id);
        if($get_html == 1){
            $this->data['posts'] = $postData;
            $userData = getCurrentUser();
             $this->data['loggendInUserId'] =$userData['id'];
            $postData =  load_view('partials/posts.php', $this->data);
          
       }
       if($postData==null)
       {
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.post_not_found'),
            'data' => null
        ], 400);
       }
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.post_detail_fetched'),
            'data' => $postData 
        ], 200);
     
    }

    public function postDetails($post_slug) {
       

        // Explode the slug to separate the ID from the rest of the slug
        $parts = explode('_', $post_slug);

        // Assuming the ID is the first part of the slug
        $post_id = $parts[0];
      



        $postModel = new PostModel();
    
        // Check if the post exists and is not deleted
        $post = $postModel->find($post_id);
       
        if (!$post || $post['deleted_at'] != null) {
          
            // Post does not exist or is deleted, show 404 error page
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("The requested post does not exist or has been deleted.");
        }
    
        // Proceed with the rest of the function if the post is found
        $this->data['post_id'] = $post_id;
        $this->data['js_files'] = ['js/posts.js',
									'js/post_plugins.js',
									'vendor/imagepopup/js/lightbox.min.js',
								];

		$this->data['css_files'] = ['css/posts.css',
									'css/posts_plugins.css',
									'vendor/imagepopup/css/lightbox.min.css'
									];

        echo load_view('pages/single_post', $this->data);
    }

    public function deletePost(){   
        $validationRules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required')
                ]
            ],
        ];

        $this->validation->setRules($validationRules);
        $data = [  
            'post_id' => $this->request->getPost('post_id'),    
        ];

        if ($this->validation->run($data)) {
            $model = new PostModel();
            $postTagModel = new PostTagModel();
            
            $post_id = $this->request->getPost('post_id');
            $user_data = getCurrentUser();
            $currentUserId = $user_data['id']; 
            $post = $model->find($post_id);

            if ($post && $post['user_id'] == $currentUserId) {
                // The current user is the owner of the post
                $model->delete($post_id);
                $postTagModel->deleteposttags($post_id);
                return $this->response->setJSON([
                    'status' => '200',
                    'message' => lang('Api.post_deleted_successfully')
                ], 200);
            } else {
                // The current user is not the owner of the post
                return $this->response->setJSON(['status' => '403',   'message' => lang('Api.unauthorized_to_delete_post')], 403);
            }
        }  else {
            // Validation failed
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.invalid_request'),
                'errors' => $this->validation->getErrors()
            ], 400);
        }
    }

    public function editPost(){   
        $validationRules = [
            'post_id' => 'required', // Ensure you validate the post_id
        ];

        $this->validation->setRules($validationRules);
        $data = [  
            'post_id' => $this->request->getPost('post_id'),    
        ];

        if ($this->validation->run($data)) {
            $model = new PostModel();
            $post_id = $this->request->getPost('post_id');
            $user_data = getCurrentUser();
            $currentUserId = $user_data['id']; 
            $post = $model->find($post_id);

            if ($post && $post['user_id'] == $currentUserId) {
                // The current user is the owner of the post
                $model->delete($post_id);
                return $this->response->setJSON(['status' => '200', 'message' => 'Post deleted successfully'], 200);
            } else {
                // The current user is not the owner of the post
                return $this->response->setJSON(['status' => '403', 'message' => 'Unauthorized to delete this post'], 403);
            }
        } else {
            // Validation failed
            return $this->response->setJSON(['status' => '400', 'message' => 'Invalid request'], 400);
        }
    }


    public function AddPostAdvertisement() {
      
        $rules = [
        'post_id' => [
            'label' => lang('Api.post_id'),
            'rules' => 'required|numeric',
            'errors' => [
                'required' => lang('Api.post_id_required'),
                'numeric' => lang('Api.post_id_numeric')
            ]
        ],
        'title' => [
            'label' => lang('Api.ad_title'),
            'rules' => 'required|string|max_length[150]',
            'errors' => [
                'required' => lang('Api.title_required'),
                'max_length' => lang('Api.title_max_length')
            ]
        ],
        'link' => [
            'label' => lang('Api.ad_link'),
            'rules' => 'required|string|max_length[200]',
            'errors' => [
                'required' => lang('Api.link_required'),
                'max_length' => lang('Api.link_max_length')
            ]
        ],
        'body' => [
            'label' => lang('Api.ad_body'),
            'rules' => 'required|string|max_length[250]',
            'errors' => [
                'required' => lang('Api.body_required'),
                'max_length' => lang('Api.body_max_length')
            ]
        ],
    ];

    // Validate inputs
    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }
    
        $userData = getCurrentUser(); 
        $userId = $userData['id'];
        $postModel = New PostModel;
        $post_id = $this->request->getVar('post_id');
        $post = $postModel->select('user_id')->where('id',$post_id)->first();
        $data = [
            'post_id' => $this->request->getVar('post_id'),
            'from_user_id' => $userId,
            'to_user_id' => $post['user_id'],
            'title' => $this->request->getVar('title'),
            'link' => $this->request->getVar('link'),
            'body' => $this->request->getVar('body'),
            'status' => 1, //pending
        ];
    
        $images = $this->request->getFiles();
        if (isset($images['image']) && $images['image']->isValid() && !$images['image']->hasMoved()) {
            $mediaPath = storeMedia($images['image'], 'advertisement');
            if ($mediaPath) {
                $data['image'] = $mediaPath;
            } else {
                return $this->respond([
                    'code' => '400',
                    'message' => lang('Api.image_upload_failed'),
                ], 200);
            }
        }
    
        $PostsAdvertisementModel = new PostsAdvertisementModel();
        $result = $PostsAdvertisementModel->insert($data);
        $advertisementId = $PostsAdvertisementModel->getInsertID();
    
        if ($result) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.advertisement_added_successfully'),
                'data' => $PostsAdvertisementModel->find($advertisementId)
            ], 200);
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.failed_to_add_advertisement')
            ], 200);
        }
    }


    public function addComment(){
        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                    'numeric' => lang('Api.post_id_numeric')
                ]
            ],
            'comment_text' => [
                'label' => lang('Api.comment_text'),
                'rules' => 'required|string',
                'errors' => [
                    'required' => lang('Api.comment_text_required')
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = getCurrentUser();
        $userId = $userData['id'];
        $postId = $this->request->getVar('post_id');
        $commentText = $this->request->getVar('comment_text');

        $postModel = New PostModel();
        $userModel = New UserModel();
        $post = $postModel->find($postId);
        if (empty($post)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.post_not_found')
            ], 200);
        }
    
       // $postowner = $userModel->find($post['user_id']);
        $data = [
            'post_id' => $postId,
            'user_id' => $userId,
            'comment' => $commentText
        ];

        // Insert comment data into the database
        $comment = new CommentModel();
        $result = $comment->insert($data);
        $comment_id = $comment->getInsertID();
        
        // Increment the comment count in the posts table
        $postModel = new PostModel(); // Ensure this model is properly set up
        $postModel->incrementColumn($postId,'comment_count');
        $text = 'commented on your post.';
      
        
        createtransactions($userId,$post['user_id'],$post['id'],'comment','C',$comment_id,0);
        $userModel = New UserModel();
        $user_device = $userModel->select(['device_id','notify_comment','email'])->where('id', $post['user_id'])->first();
        if(!empty($user_device) && $user_device['notify_comment']==1 && $post['user_id']!=$userId)
        {
            $notificationModel = New NotificationModel();
            $notificationdata = [
                'from_user_id'=>$userId,
                'to_user_id'=>$post['user_id'],
                'post_id'=>$postId,
                'type'=>'comment',
                'text'=>$text,
            ];
            $notificationModel->save($notificationdata);
            if(get_setting('chck-emailNotification')==1)
            {
                sendmailnotificaiton($user_device['email'],'Post Comment',$text);
            }
            sendPushNotification( $user_device['device_id'],$text);
        }
       
        if ($result) {   
            $result = $comment->get_comments_detail($comment_id,$userId);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.comment_added_successfully'),
                'data' => $result 
            ], 200);
        
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.failed_to_add_comment')
            ], 200);
        }
    }

    public function getComments(){
    
        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                    'numeric' => lang('Api.post_id_numeric')
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = getCurrentUser();
        $userId = $userData['id'];
        
        $post_id = $this->request->getVar('post_id');
        

        $comment = new CommentModel();

        // Call the model method to add a comment
        $result = $comment->get_comments($post_id,5,$userId);

        if ($result) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.comments_fetched'),
                'data' => $result 
            ], 200);
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.comments_not_found'),
                'data' => $result 
            ], 200);
        }
    }

    public function likeComment(){
        $rules = [
            'comment_id' => [
                'label' => lang('Api.comment_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.comment_id_required'),
                    'numeric' => lang('Api.comment_id_numeric')
                ]
            ],
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                    'numeric' => lang('Api.post_id_numeric')
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }
        $commentModel = new CommentModel(); 
        $userData = getCurrentUser();
        $userId = $userData['id'];
        $commentId = $this->request->getVar('comment_id');
        $postId = $this->request->getVar('post_id');
        
        $db = \Config\Database::connect();
        $builder = $db->table('posts_comment_likes');

        // Check if the user already liked the comment
        $builder->where('user_id', $userId);
        $builder->where('comment_id', $commentId);
        $existingLike = $builder->get()->getFirstRow();

        if ($existingLike) {
            $builder->where('id', $existingLike->id); 

            $builder->delete();
            
            $commentModel->decrementLikeCount($commentId);
            return $this->respond([
                'code' => '200',
               'message' => lang('Api.comment_unliked')
            ], 200);
        }

        $data = [
            'user_id' => $userId,
            'post_id' => $postId,
            'comment_id' => $commentId
        ];

        // Insert like data into the database
        $result = $builder->insert($data);
        
        if ($result) {
            // Increment the like count in the posts_comments table
            // Ensure this model is properly set up
            $commentModel->incrementLikeCount($commentId);

            return $this->respondCreated(['code' => '200','message' => lang('Api.comment_liked')]);
        } else {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.like_failed')
            ], 200);
        }
    }

    public function updateComment() {
        $rules = [
            'comment_id' => [
                'label' => lang('Api.comment_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.comment_id_required'),
                    'numeric' => lang('Api.comment_id_numeric')
                ]
            ],
            'new_comment_text' => [
                'label' => lang('Api.new_comment_text'),
                'rules' => 'required|string',
                'errors' => [
                    'required' => lang('Api.new_comment_text_required'),
                    'string' => lang('Api.new_comment_text_string')
                ]
            ],
        ];
    

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = getCurrentUser();
        $userId = $userData['id'];
        $commentId = $this->request->getVar('comment_id');
        $newCommentText = $this->request->getVar('new_comment_text');

        $commentModel = new CommentModel();

        // Check if the comment exists
        $comment = $commentModel->find($commentId);
        if (!$comment) {
            return $this->failNotFound(lang('Api.comment_not_found'));
        }

        // Authorization check: ensure the user is allowed to update this comment
        if ($comment['user_id'] !== $userId) {
            return $this->failForbidden(lang('Api.comment_update_permission_denied'));
        }

        // Proceed with updating the comment
        try {
            $commentModel->update($commentId, ['comment' => $newCommentText]);
            return $this->respondUpdated(['message' => lang('Api.comment_updated_success')]);
        } catch (\Exception $e) {
            // Log the exception message and return a server error
            log_message('error', $e->getMessage());
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.comment_update_failed')
            ], 200);
        }
    }

    public function replyToComment() {
        $rules = [
            'comment_id' => [
                'label' => lang('Api.comment_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.comment_id_required'),
                    'numeric' => lang('Api.comment_id_numeric')
                ]
            ],
            'reply_text' => [
                'label' => lang('Api.reply_text'),
                'rules' => 'required|string',
                'errors' => [
                    'required' => lang('Api.reply_text_required'),
                    'string' => lang('Api.reply_text_string')
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = getCurrentUser();
        $userId = $userData['id'];
        $commentId = $this->request->getVar('comment_id');
        $replyText = $this->request->getVar('reply_text');

        $commentModel = new CommentModel();

        // Check if the original comment exists
        $originalComment = $commentModel->find($commentId);
        if (!$originalComment) {
            return $this->failNotFound(lang('Api.comment_not_found'));
        }

        $replyData = [
            'comment_id' => $commentId,
            'user_id' => $userId,
            'comment' => $replyText
        ];

       
        try {
            $reply_id = $commentModel->insertReply($replyData);

            $commentModel->incrementReplyCount($commentId);

            $comments = $commentModel->NewCommentReply($reply_id,$userId);
            return $this->respondCreated([
                'message' => lang('Api.reply_added_successfully'),
                'data' => $comments
            ]);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->failServerError(lang('Api.reply_failed'));
        }
    }

    public function likeCommentReply() {
        $rules = [
            'comment_reply_id' => [
                'label' => lang('Api.comment_reply_id'),
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => lang('Api.comment_reply_id_required'),
                    'numeric' => lang('Api.comment_reply_id_numeric')
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $userData = getCurrentUser();
        $userId = $userData['id'];
        $commentReplyId = $this->request->getVar('comment_reply_id');

        $db = \Config\Database::connect();
        $builder = $db->table('posts_comment_replies_likes');

        // Check if the user already liked the comment reply
        $builder->where('user_id', $userId);
        $builder->where('comment_reply_id', $commentReplyId);
        $existingLike = $builder->get()->getFirstRow();

        if ($existingLike) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.already_liked_comment_reply')
            ], 200);
        }

        $data = [
            'user_id' => $userId,
            'comment_reply_id' => $commentReplyId
        ];

        // Insert like data into the database
        $result = $builder->insert($data);

        if ($result) {
            return $this->respondCreated([
                'message' => lang('Api.comment_reply_liked_successfully')
            ]);
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.comment_reply_like_failed')
            ], 200);
        }
    }

    public function sharePost(){
        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON($this->validation->getErrors())->setStatusCode(400);
        }
    
        $userData = getCurrentUser();
        $page_id = $this->request->getVar('page_id');
        if (!empty($page_id)) {
            $pageModel = new Page();
            $page = $pageModel->find($page_id);
            if (empty($page)) {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.page_not_found')
                ])->setStatusCode(400);
            }
            if ($page['user_id'] != $userData['id']) {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.unauthorized_access')
                ])->setStatusCode(400);
            }
        }
    
        $group_id = $this->request->getVar('group_id');
        if (!empty($group_id)) {
            $groupModel = new Group();
            $group = $groupModel->find($group_id);
            if (empty($group)) {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.group_not_found')
                ])->setStatusCode(400);
            }
            if (empty($groupModel->checkMemberStatus($group_id, $userData['id']))) {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.not_a_group_member')
                ])->setStatusCode(400);
            }
        }
    
        $userId = $userData['id'];
        $post_id = $this->request->getVar('post_id');
        $postModel = new PostModel();
        $existingPost = $postModel->find($post_id);
    
        if ($existingPost) {
            $post_text = $this->request->getVar('shared_text');
            if ($existingPost['parent_id'] != 0 && $existingPost['parent_id'] != null) {
                $parent_post_id = $existingPost['parent_id'];
                $existingPost = $postModel->find($parent_post_id);
            }
    
            $data = [
                'parent_id' => $existingPost['id'],
                'post_text' => $post_text,
                'image_or_video' => 0,
                'user_id' => $userId,
                'ip' => $this->request->getIPAddress(),
                'post_location' => '',
                'post_color_id' => 0,
                'width' => 0,
                'height' => 0,
                'page_id' => !empty($this->request->getVar('page_id')) ? $this->request->getVar('page_id') : 0,
                'group_id' => !empty($this->request->getVar('group_id')) ? $this->request->getVar('group_id') : 0,
                'event_id' => 0,
            ];
    
            $db = \Config\Database::connect();
            try {
                $db->transStart();
                $postModel->save($data);
                $share_post_id = $postModel->insertID();
                createtransactions($userId, $existingPost['user_id'], $existingPost['id'], 'share', 'C', 0, $share_post_id);
                $db->transComplete();
    
                if ($db->transStatus() === false) {
                    $db->transRollback();
                    log_message('error', 'Transaction failed in Share Post');
                    throw new \Exception(lang('Api.transaction_failed'));
                }
    
                $userModel = new UserModel();
                $user_device = $userModel->select(['device_id', 'notify_share_post', 'email'])->where('id', $existingPost['user_id'])->first();
    
                if (!empty($user_device) && ($user_device['notify_share_post'] == 1) && ($userId != $existingPost['user_id'])) {
                    $text = lang('Api.shared_your_post');
                    $notificationModel = new NotificationModel();
                    $notificationdata = [
                        'from_user_id' => $userId,
                        'to_user_id' => $existingPost['user_id'],
                        'post_id' => $post_id,
                        'type' => 'share-post',
                        'text' => $text,
                    ];
                    $notificationModel->save($notificationdata);
    
                    if (get_setting('chck-emailNotification') == 1) {
                        sendmailnotificaiton($user_device['email'], lang('Api.share_post_subject'), $text);
                    }
                    sendPushNotification($user_device['device_id'], $text);
                }
    
                $postModel->incrementColumn($existingPost['id'], 'share_count');
                $postData = $postModel->get_post_detail($postModel->getInsertID());
    
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.post_shared_success'),
                    'data' => $postData,
                ], 200);
            } catch (\Exception $e) {
                return $this->failServerError(lang('Api.server_error'));
            }
        } else {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.post_not_found')
            ], 400);
        }
    }
    

    public function deleteComment()
    {
        $rules = [
            'comment_id' => [
                'label' => lang('Api.comment_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.comment_id_required'),
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON($this->validation->getErrors())->setStatusCode(400);
        }

        $postModel = new PostModel();
        $commentModel = new CommentModel();
        $comment_id = $this->request->getVar('comment_id');
        $comment = $commentModel->find($comment_id);
        $user_id = getCurrentUser()['id'];

        if (!empty($comment)) {
            if ($comment['user_id'] == $user_id) {
                $post = $postModel->find($comment['post_id']);
                createtransactions($user_id, $post['user_id'], $post['id'], 'comment', '', $comment_id, 0);       
                $commentModel->delete($comment_id);
                $postModel->decrementColumn($post['id'], 'comment_count');

                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.comment_deleted_success')
                ], 200);
            } else {
                return $this->respond([
                    'code' => '401',
                    'message' => lang('Api.unauthorized_access')
                ], 401);
            }
        } else {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.comment_not_found')
            ], 404);
        }
    }


    public function saveUserPost()
    {
        $db = \Config\Database::connect();
        
        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON($this->validation->getErrors())->setStatusCode(400);
        }

        $post_id = $this->request->getVar('post_id');
        $user_id = getCurrentUser()['id'];

        $checkOldData = $db->table('posts_saved')
            ->where('post_id', $post_id)
            ->where('user_id', $user_id)
            ->get()
            ->getFirstRow();

        if (empty($checkOldData)) {
            $data = [
                'user_id' => $user_id,
                'post_id' => $post_id
            ];
            $db->table('posts_saved')->insert($data);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.post_saved_success')
            ], 200);
        } else {
            $db->table('posts_saved')->delete(['id' => $checkOldData->id]);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.saved_post_deleted_success')
            ], 200);
        }
    }


    public function postAction()
    {
        $rules = [
            'post_id' => [
                'label' => lang('Api.post_id'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                ]
            ],
            'action' => [
                'label' => lang('Api.action'),
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.action_required'),
                ]
            ],
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $this->validation->getErrors()
            ], 400);
        }
        $db = \Config\Database::connect();
        $postModel = New PostModel();
        $post_id = $this->request->getVar('post_id');
        $post = $postModel->where('id',$post_id)->first();
        $action = $this->request->getVar('action');
        $user_id = getCurrentUser()['id'];
      
        if(!empty($post))
        {
           
            if($action=='save')
            {
                $checkOldData = $db->table('posts_saved')
                                ->where('post_id',$post_id)
                                ->where('user_id',$user_id)
                                ->get()
                                ->getFirstRow();
                if(empty($checkOldData))
                {
                    $data = [
                        'user_id'=>$user_id,
                        'post_id'=>$post_id
                    ];
                    $db->table('posts_saved')->insert($data);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.post_saved_success'),
                        'action' => 'saved_post',
                        'type'=>1
                    ], 200);
                }
                else
                {
                $db->table('posts_saved')->delete(['id' => $checkOldData->id]);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.saved_post_deleted_success'),
                    'action' => 'saved_post',
                    'type'=>0
                ], 200);
                }
            }
            elseif($action=='delete')
            {

                $currentUserId = getCurrentUser()['id'];
                $is_allowe_to_delete = 0;
                if($post['user_id'] == $currentUserId){
                    $is_allowe_to_delete = 1;
                }
                if($post['group_id'] >0){
                    $groupMemberModel  = New GroupMember;
                    if($groupMemberModel->checkGroupAdmin($post['group_id'],$currentUserId)==1){
                        $is_allowe_to_delete = 1;
                    }
                }
                else
                {
                    $is_allowe_to_delete = 1;
                }
                if ($post && $is_allowe_to_delete==1) {
                    if($post['parent_id']!=0)
                    {
                        $postModel->decrementColumn($post['parent_id'],'share_count');
                    }
                    $notificationModel = New NotificationModel;
                    $notificationModel->where('post_id',$post_id)->delete();
                    $postModel->delete($post_id);
                    $postTagModel = New PostTagModel;
                    $postTagModel->deleteposttags($post_id);
                    return $this->response->setJSON(['code' => '200',     'message' => lang('Api.post_deleted_success')], 200);
                } else {
                    return $this->response->setJSON(['code' => '403','message' => lang('Api.unauthorized_delete')], 403);
                }
                if ($post && $post['user_id'] == $currentUserId) {
                    
                    $postModel->delete($post_id);
                    return $this->response->setJSON(['code' => '200', 'message' => lang('Api.post_deleted_success'), 'action' => 'delete'], 200);
                } else {
                   
                    return $this->response->setJSON(['code' => '403','message' => lang('Api.unauthorized_delete')], 403);
                }
            }
            elseif($action=='report')
            {
                $checkreportOldData = $db->table('posts_report')
                                ->where('post_id',$post_id)
                                ->where('user_id',$user_id)
                                ->get()
                                ->getFirstRow();
                if(empty($checkreportOldData))
                {
                    $data = [
                        'user_id'=>$user_id,
                        'post_id'=>$post_id
                    ];
                    $db->table('posts_report')->insert($data);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.post_reported_success'),
                        'action' => 'report_post',
                        'type'=>1
                    ], 200);
                }
                else
                {
                
                    return $this->respond([
                        'code' => '200',
                      'message' => lang('Api.post_already_reported'),
                        'action' => 'report_post',
                        'type'=>1
                    ], 200);
                }
            }
            elseif($action=='disablecomments')
            {
                $currentUserId = getCurrentUser()['id'];
                if ($post && $post['user_id'] == $currentUserId) {
                    if($post['comments_status']==1)
                    {
                        $postModel->update($post_id,['comments_status'=>0]);
                        return $this->response->setJSON(['code' => '200', 'message' => lang('Api.comments_disabled_success'),'action'=>'disablecomments','type'=>0], 200);
                    }
                    else{
                        $postModel->update($post_id,['comments_status'=>1]);
                        return $this->response->setJSON(['code' => '200',  'message' => lang('Api.comments_enabled_success'),'action'=>'disablecomments','type'=>1], 200);
                    }
                    
                } else {
                 
                    return $this->response->setJSON(['code' => '403',  'message' => lang('Api.unauthorized_action')], 403);
                } 
            }
            elseif($action=='reaction')
            {
                
                $userModel = New UserModel;
                $postuser = $userModel->find($post['user_id']); 
                $reaction_type = $this->request->getVar('reaction_type');
                $oldReaction = $db->table('posts_reactions')
                    ->where('post_id', $post_id)
                    ->where('user_id', $user_id)
                    ->get()
                    ->getFirstRow();
                $reaction_type = (empty($reaction_type))?1:$reaction_type;
                
                if (!empty($oldReaction)) {
                    if ($oldReaction->reaction==$reaction_type) {
                        $db->table('posts_reactions')->delete(['id' => $oldReaction->id]);
                        createtransactions($user_id,$post['user_id'],$post['id'],'like',0,0);
                        return $this->respond([
                            'code' => '200',
                            'message' => lang('Api.reaction_removed_success')
                        ], 200);
                        
                    } else {
                        if($reaction_type == 0){ $reaction_type = 1; }
                        $db->table('posts_reactions')
                        ->where('post_id', $post_id)
                        ->where('user_id', $user_id)
                        ->update(['reaction' => $reaction_type]);
                        if($user_id!=$post['user_id'] && !empty($postuser) && $postuser['notify_like']==1)
                        {
                            $this->createpostreactionNotification($user_id,$post['user_id'],$post_id,$reaction_type);
                        }
                        
                        return $this->respond([
                            'code' => '200',
                            'message' => lang('Api.reaction_updated_success')
                        ], 200);
                    }
                }
                if($reaction_type == 0){ $reaction_type = 1; }
                $reactiondata = [
                    'post_id' => $post_id,
                    'user_id' => $user_id,
                    'reaction' => $reaction_type
                ];
               
                if($user_id!=$post['user_id'] && !empty($postuser) && $postuser['notify_like']==1)
                {
                    $this->createpostreactionNotification($user_id,$post['user_id'],$post_id,$reaction_type);
                }
                $db->table('posts_reactions')->insert($reactiondata);
                createtransactions($user_id,$post['user_id'],$post['id'],'like','C');
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.post_reaction_added_success')
                ], 200);
            }
         }
        else{
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.post_not_found')
            ], 404);
        }
       

    }

    public function createpostreactionNotification($fromuserid,$toUserId,$postId,$reaction_type)
    {
        $notificationModel = New NotificationModel();
        $oldReaction = $notificationModel->where([
            'from_user_id'=>$fromuserid,
            'to_user_id'=>$toUserId,
            'post_id'=>$postId,   
        ])->first();
    

        $notificationdata = [
            'from_user_id'=>$fromuserid,
            'to_user_id'=>$toUserId,
            'post_id'=>$postId,
            'type'=>'post-reaction',
            'text' => lang('Api.reacted_on_your_post'), 
            'type2'=>$reaction_type
        ];

        
       
        if(empty($oldReaction)){
            
            $notificationModel->save($notificationdata);
        }
        else
        {
            $notificationModel->update($oldReaction['id'],$notificationdata);
        }
        $userModel = New UserModel();
        $userData = getCurrentUser();
        $user_device = $userModel->select(['device_id','notify_like','email'])->where('id', $toUserId)->first();
        if(get_setting('chck-emailNotification')==1)
        {
            sendmailnotificaiton(
                $user_device['email'],
                lang('Api.share_post_subject'), // Translatable string
                lang('Api.reacted_on_your_post') // Translatable string
            );
        }
        if(!empty($user_device) && $user_device['notify_like']==1 && $toUserId!=$fromuserid)
        {           
            sendPushNotification(
                $user_device['device_id'],
                lang('Api.reacted_on_your_post') // Translatable string
            );
        }
        
    }

    public function getpostReaction()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if(!$this->validate($rules))
        {
            $this->validation->getErrors();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'data'    => $this->validation->getErrors()
            ], 200);
        }
        $modiefiedreactions= [];
        $userModel = New UserModel();
        $postReactionModel  = New PostsReactionsModel();
        $db = \config\Database::connect();
        $post_id = $this->request->getVar('post_id');
        $offset = !empty($this->request->getVar('offset'))?$this->request->getVar('offset'):0;
        $limit = !empty($this->request->getVar('limit'))?$this->request->getVar('limit'):20;
        $reactionArray  =  [1,2,3,4,5,6];
        foreach($reactionArray as $reaction)
        {
            $modiefiedreaction[$reaction] = $postReactionModel->getpostreaction($post_id,$reaction,$limit,$offset);
        }
        return $this->respond([
            'code' => '200',
           'message' => lang('Api.post_reaction_not_found'),
            'data'    => $modiefiedreaction
        ], 200);

    }

    public function deleteSharePost()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ], 200);
        }
        $post_id = $this->request->getVar('post_id');
        $loggedInUserId = getCurrentUser()['id'];
        $postModel =  New PostModel;
        
        $post = $postModel->find($post_id);
        $originalpost = $postModel->find($post['parent_id']);
        $postModel->decrementColumn($originalpost['id'],'share_count');
        if(!empty($post))
        {
            if($post['user_id'] == $loggedInUserId)
            {
                createtransactions($loggedInUserId,$originalpost['user_id'],$originalpost['id'],'share','',0,$post['id']);
                $postModel->delete($post_id);
                return $this->respond([
                    'status' => '200',
                    'message' => lang('Api.shared_post_deleted'), // Translatable string
                ], 200);
            } else {
                return $this->respond([
                    'status' => '401',
                    'message' => lang('Api.not_allowed'), // Translatable string
                ], 401);
            }
        }
    
        return $this->respond([
            'code' => '404',
            'message' => lang('Api.post_not_found'), // Translatable string
        ], 404);
    }

    public function deleteReply()
    {
        $rules = [
            'reply_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.reply_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ], 200);
        }

        $reply_id = $this->request->getVar('reply_id');
        $user_id = getCurrentUser()['id'];
        $db = \Config\Database::connect();
        $commentExists = $db->table('posts_comment_replies')->where('id', $reply_id)->get()->getRow();
       
        if (!empty($commentExists)) {
            if($commentExists->user_id == $user_id){
                $db->table('posts_comment_replies')
                ->where('id', $reply_id)
                ->delete();
                $commentModel = new CommentModel();
                $commentModel->decrementreplyCount($commentExists->comment_id);
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.reply_deleted_success'), // Translatable string
                ], 200);
            } else {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.not_allowed'), // Translatable string
                ], 200);
            }
        }
    
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.comment_not_found'), // Translatable string
        ], 200);
    }

    public function addCommentReply()
    {
        $rules = [
            'comment_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.comment_id_required') // Translatable string for validation message
                ]
            ],
            'comment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.comment_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'code' => 400,
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ])->setStatusCode(400);
        }
        $comment_id =  $this->request->getVar('comment_id');  
        $user_id = getCurrentUser()['id'];
        $data = [
            'comment_id'=>$this->request->getVar('comment_id'),
            'comment'=>$this->request->getVar('comment'), 
            'user_id'=>$user_id
        ];
        $db = \Config\Database::connect();
        $builder = $db->table('posts_comment_replies');
        $builder->insert($data);
        $insertedID = $db->insertID();
        
        
        $commentModel = new CommentModel();
        $commentModel->incrementreplyCount($comment_id);
        $commentData = $commentModel->NewCommentReply($insertedID,$user_id);
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.comment_reply_created_success'), // Translatable string
            'data' => $commentData
        ], 200);
    }

    public function getReplies()
    {
        $rules = [
            'comment_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.comment_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ], 200);
        }
            $comment_id = $this->request->getVar('comment_id');
            $commentModel  =  New CommentModel();
            $limit = 20;
            $user_id = getCurrentUser()['id'];  
            $comment_replies = $commentModel->get_comment_replies($comment_id,$limit,$user_id);
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.comment_replies_success'), // Translatable string
                'data' => $comment_replies
            ], 200);
    }

    public function greatJob()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ], 200);
        }
        $user_id =getCurrentUser()['id'];
        $post_id = $this->request->getVar('post_id');
        $postModel = New PostModel();
        $post = $postModel->find($post_id);
        if(empty($post))   
        {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.post_not_found'), // Translatable string
            ], 200);
        }
        $db = \Config\Database::connect();
        $checkOldGreatJob = $db->table('great_jobs')
                            ->where('post_id',$post_id)
                            ->where('user_id',$user_id)
                            ->get()
                            ->getFirstRow();
        if(!empty($checkOldGreatJob))
        {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.great_job_already_assigned'), // Translatable string
            ], 200);
        }
        if($user_id == $post['user_id'])
        {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.own_post_great_job'), // Translatable string
            ], 200);
        }
        $gj = get_setting('great_job');
        $userbalance  = getuserwallet($user_id);
        if($gj>$userbalance)
        {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.insufficient_balance_great_job'), // Translatable string
            ], 200);
        }
        $pogj_share = get_setting('gj_postowner_share')/100 * $gj;
        $user_id = getCurrentUser()['id'];
        $date = New DateTime;
        $datetime = $date->format("Y-m-d H:i: s");
        $great_jobdata = [
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'created_at'=>$datetime
        ];
        $db->table('great_jobs')->insert($great_jobdata);
        $transactionModel = New TransactionModel();
        $loggedInUser_deduction = [
            'user_id'=>$user_id,
            'post_id'=>$post_id,
            'flag'=>'D',
            'amount'=>$gj,
            'action_type'=>8
        ]; 
        $transactionModel->save($loggedInUser_deduction);
        $pogj_transaction = [
            'user_id'=>$post['user_id'],
            'post_id'=>$post_id,
            'flag'=>'C',
            'amount'=>$pogj_share,
            'action_type'=>8
        ]; 
        $transactionModel->save($pogj_transaction);
        $admin_share = $gj-$pogj_share;
        $admin_transaction = [
            'user_id'=>1,
            'post_id'=>$post_id,
            'flag'=>'C',
            'amount'=>$admin_share,
            'action_type'=>8
        ]; 
        $transactionModel->save($admin_transaction);
        return $this->respond([
            'status' => '200',
            'message' => lang('Api.great_job_awarded_success'), // Translatable string
        ], 200);
    }

    public function CupOfCoffee()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required') // Translatable string for validation message
                ]
            ]
        ];
    
        if (!$this->validate($rules)) {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.validation_error'), // Translatable string
                'data' => $this->validation->getErrors()
            ], 200);
        }
        $coc = get_setting('cup_of_coffee');
        $user_id =getCurrentUser()['id'];
        $post_id = $this->request->getVar('post_id');
        $postModel = New PostModel();
        $post = $postModel->find($post_id);
        if(empty($post))   
        {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.post_not_found'), // Translatable string
            ], 200);
        }
    
        $userbalance = getuserwallet($user_id);
    
        if ($coc > $userbalance) {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.insufficient_balance_coc'), // Translatable string
            ], 200);
        }
    
        $db = \Config\Database::connect();
        $checkOldCoffee = $db->table('cup_of_coffee')
            ->where('post_id', $post_id)
            ->where('user_id', $user_id)
            ->get()
            ->getFirstRow();
    
        if (!empty($checkOldCoffee)) {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.coc_already_assigned'), // Translatable string
            ], 200);
        }
    
        if ($user_id == $post['user_id']) {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.cannot_award_own_post_coc'), // Translatable string
            ], 200);
        }
    
        $pococ_share = get_setting('coc_postowner_share') / 100 * $coc;
        $cocdata = [
            'user_id' => $user_id,
            'post_id' => $post_id
        ];
        $db->table('cup_of_coffee')->insert($cocdata);
    
        $transactionModel = new TransactionModel();
        $loggedInUser_deduction = [
            'user_id' => $user_id,
            'post_id' => $post_id,
            'flag' => 'D',
            'amount' => $coc,
            'action_type' => 8
        ];
        $transactionModel->save($loggedInUser_deduction);
    
        $pogj_transaction = [
            'user_id' => $post['user_id'],
            'post_id' => $post_id,
            'flag' => 'C',
            'amount' => $pococ_share,
            'action_type' => 8
        ];
        $transactionModel->save($pogj_transaction);
    
        $admin_share = $coc - $pococ_share;
        $admin_transaction = [
            'user_id' => 1,
            'post_id' => $post_id,
            'flag' => 'C',
            'amount' => $admin_share,
            'action_type' => 8
        ];
        $transactionModel->save($admin_transaction);
    
        return $this->respond([
            'status' => '200',
            'message' => lang('Api.cup_of_coffee_awarded_success'), // Translatable string
        ], 200);
    }
    public function postAdaction()
    {
        $rules = [
            'ad_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.ad_id_required') // Translatable string for validation message
                ]
            ],
            'action' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.action_required') // Translatable string for validation message
                ]
            ]
        ];
        $ad_id = $this->request->getVar('ad_id');
        $action = $this->request->getVar('action');
        $adsModel = New PostsAdvertisementModel;
        $transactionModel = New TransactionModel;
        

        $ad = $adsModel->find($ad_id);
        if(empty($ad))
        {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.ad_not_found'), // Translatable string
            ], 200);
        }

        $userWallet = getuserwallet($ad['from_user_id']);

        $ad_amount = get_setting('ad-price');
        $admin_share = ($ad_amount* get_setting('ad-admin_share'))/100;
        $postownershare = ($ad_amount* get_setting('ad-post_owner_share'))/100;
        $key = 0;
        if($action=='approve')
        {
            if($userWallet>=$ad_amount)
            {
                $advertiser_deduction = [
                    'user_id'=>$ad['from_user_id'],
                    'post_id'=>$ad['post_id'],
                    'amount'=>$ad_amount,
                    'flag'=>'D',
                    'action_type'=>10
                ];
                $transactionModel->save($advertiser_deduction);
                $admin_credit = [
                    'user_id'=>1,
                    'post_id'=>$ad['post_id'],
                    'amount'=>$admin_share,
                    'flag'=>'C',
                    'action_type'=>10
                ];
                $transactionModel->save($admin_credit);
                $post_owner_share = [
                    'post_id'=>$ad['post_id'],
                    'user_id'=>$ad['to_user_id'],
                    'amount'=>$postownershare,
                    'flag'=>'C',
                    'action_type'=>10
                ];
                $transactionModel->save($post_owner_share);
                $adsModel->update($ad_id,['status'=>2]);
                $text = lang('Api.ad_approved');
                $message = lang('Api.ad_approve_success');
            }
            else
            {
                $text = lang('Api.ad_not_approved_balance');
                $message = lang('Api.ad_approve_fail_balance');
                $key = 'balance';
            }
        } else {
            $adsModel->update($ad_id, ['status' => 3]);
            $text = lang('Api.ad_rejected_text'); // Translatable string
            $message = lang('Api.ad_rejected_success'); // Translatable string
        }
    
        $notificationModel = New NotificationModel;
        $notification = [
            'from_user_id'=>$ad['to_user_id'],
            'to_user_id'=>$ad['from_user_id'],
            'post_id'=>$ad['post_id'],
            'type'=>'ad-action',
            'text'=>$text,        
            ];
            $notificationModel->save($notification);
            return $this->respond([
                'status' => '200',
                'message' => $message,
                'key'=>$key
            ], 200);

    }
    public function changePrivacy()
    {
        $rules  =  [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required')
                ]
            ],
            'privacy' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.privacy_required')
                ]
            ]
        ];
        
        if(!$this->validate($rules))
        {
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.error'),
                'data' => $this->validation->getErrors()
            ], 200);
        }
        $postModel = New PostModel;
        $post_id = $this->request->getVar('post_id');
        $privacy = $this->request->getVar('privacy');
        $user_id = getCurrentUser()['id'];
        $post = $postModel->find($post_id);
        if(empty($post))
        {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.error'),
                'data' => lang('Api.post_not_found')
            ], 200);
        }
        if($user_id!=$post['user_id'])
        {
            return $this->respond([
                'status' => '400',
                'message'=> lang('Api.not_allowed')
            ], 200);
        }
        $privacyArray = [
            '1' => lang('Api.privacy_public'),
            '2' => lang('Api.privacy_friends'),
            '3' => lang('Api.privacy_only_me'),
            '4' => lang('Api.privacy_family'),
            '5' => lang('Api.privacy_business')
        ];
        $postModel->update($post_id,['privacy'=>$privacy]);
        return $this->respond([
            'status' => '200',
            'message'=> lang('Api.privacy_changed', ['privacy' => $privacyArray[$privacy]])
        ], 200);
    }
    public function updatePost()
    {
        $rules  =  [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required')
                ]
            ]
        ];
        
        if (!$this->validate($rules))
        {
            return $this->respond([
                'status' => '400',
                'message' => $this->validation->getErrors(),
            ], 400);
        }
        $user = getCurrentUser();
        $post_id = $this->request->getVar('post_id');
        $post_text = trim($this->request->getVar('post_text'));
        $postModel = New PostModel;
        $post = $postModel->find($post_id);
        if (empty($post))
        {
            return $this->respond([
                'status' => '400',
                'message' => lang('Api.post_not_found'),
            ], 400);
        }
    
        if ($post['user_id'] != $user['id'])
        {
            return $this->respond([
                'status' => '401',
                'message' => lang('Api.unauthorized'),
            ], 401);
        }
        $postModel->update($post_id,['post_text'=>$post_text]);
        return $this->respond([
            'status' => '200',
            'message' => lang('Api.post_updated'),
        ], 200);
    }
    public function advertisementRequests()
    {
        $postadvertisementModel = New PostsAdvertisementModel;
        $user_id = getCurrentUser()['id'];
        $limit = $this->request->getVar('limit')??10;
        $offset = $this->request->getVar('offset')??0;
        $postadvertisements = $postadvertisementModel->where('to_user_id',$user_id)->where('status',1)->findAll($limit,$offset);
        if(!empty($postadvertisements))
        {
            $statusArry = [
                1 => lang('Api.status_pending'),
                2 => lang('Api.status_approved'),
                3 => lang('Api.status_rejected'),
            ];
            $userModel = New UserModel;
            foreach($postadvertisements as &$advertisement)
            {
                $advertisement['image'] = getMedia($advertisement['image']);
                $advertisement['status'] = $statusArry[$advertisement['status']];
                $advertisement['user_data'] = $userModel->getUserShortInfo($advertisement['from_user_id']);
            }
            return $this->respond([
                'status' => '200',
                'message' => lang('Api.advertisement_request_fetch_success'),
                'data' => $postadvertisements
            ], 200);
        }
        return $this->respond([
            'status' => '200',
            'message' => lang('Api.advertisement_request_not_found'),
        ], 200);
    }
    public function votePoll()
    {   
        $rules = [
            'poll_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.poll_id_required'),
                    'integer' => lang('Api.poll_id_integer')
                ]
            ],
            'poll_option_id' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => lang('Api.poll_option_id_required'),
                    'integer' => lang('Api.poll_option_id_integer')
                ]
            ]
        ];
    
        if(!$this->validate($rules))
        {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
    
        $pollModel = New PollModel;
        $polloptionModel = New PollOption;
        $pollresultModel  = New PollResult;
        $user =getCurrentUser(); 
        $poll_id = $this->request->getVar('poll_id');
        $poll_option_id = $this->request->getVar('poll_option_id');

        $poll = $pollModel->find($poll_id);
        if(empty($poll))
        {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.poll_not_found'),
            ]);
        }
        $poll_option = $polloptionModel->find($poll_option_id);
        if(empty($poll_option))
        {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.poll_option_not_found'),
            ]);
        }
        $poll_result = $pollresultModel->where(['user_id'=>$user['id'],'poll_id'=>$poll_id])->first(); 
        if(!empty($poll_result))
        {
            return $this->response->setJSON([
                'status' => '400',
                'message' => lang('Api.already_voted'),
            ]);
        }    
        $votedata = [
            'user_id'=>$user['id'],
            'poll_id'=>$poll_id,
            'option_id'=>$poll_option_id
        ];
        $pollresultModel->save($votedata);
        return $this->response->setJSON([
            'status' => '200',
            'message' => lang('Api.vote_successful'),
        ]);
    }   
    public function getTrendingTag()
    {
        $hashTagModel = New HashTagModel;
        $hashtags = $hashTagModel->getTrendingtag(10);
        if(!empty($hashtags) || count($hashtags)>0)
        {
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.trending_hashtags_found'),
                'data' => $hashtags
            ]);
        }
        return $this->response->setJSON([
            'code' => '400',
            'message' => lang('Api.trending_hashtags_not_exist'),
        ]);

    }
    public function feedPost()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                ]
            ],
            'amount' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.amount_required'),
                ]
            ]
        ];
    
        if(!$this->validate($rules))
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $loggedInUser = getCurrentUser();
        $postModel = New PostModel();
        $post_id = $this->request->getVar('post_id');
        $amount = $this->request->getVar('amount');
        $post = $postModel->find($post_id);
        if($post['user_id'] ==$loggedInUser['id'])
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.cannot_feed_own_post'),
            ]);
        }
        $userbalance =  getuserwallet($loggedInUser['id']);
        if($amount>$userbalance)
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.insufficient_balance'),
            ]);
        }
        $transactionActionModel = New TransactionActionModel();
        $transactionActionData = [
            'user_id'=>$loggedInUser['id'],
            'post_id'=>$post_id,
            'action_type'=> 16,
            'post_or_product'=>1
        ];
        $transactionActionModel->save($transactionActionData);
        $insertedID = $transactionActionModel->getInsertID();
        $transactionModel = New TransactionModel();
        $userdeduction = [
            'user_id'=>$loggedInUser['id'],
            'flag'=>'D',
            'amount'=> $amount,
            'action_type'=>$insertedID,
            'post_id'=>$post_id,
        ];
        $transactionModel->save($userdeduction);
        $productcredit = [
            'user_id'=>0,
            'flag'=>'D',
            'amount'=> $amount,
            'action_type'=>$insertedID,
            'post_id'=>$post_id,
        ];
        $transactionModel->save($productcredit);
        $postNewBudget = $amount + $post['post_budget'];
        
        $postModel->update($post_id,['post_budget'=>$postNewBudget]);
        
        return $this->response->setJSON([
            'code' => '200',
            'message' => "Post Feeded Successfully",
        ]);
    }
    public function GetPostShareUsers()
    {
        $rules = [
            'post_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.post_id_required'),
                ]
            ],
          
        ];
    
        if(!$this->validate($rules))
        {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $post_id = $this->request->getVar('post_id');
        $postModel = New PostModel();
        $users = [];
        $posts = $postModel->select('user_id')->where('parent_id',$post_id)->findAll();
        if(count($posts))
        {
            $userModel = New UserModel();
            foreach($posts as $post)
            {
                $userdata = $userModel->getUserShortInfo($post['user_id']);
                if(!empty($userdata))
                {
                    $users[] = $userdata;
                }
            }
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.user_fetch_successfully'),
                'data'  => $users
            ]);
        } 
        return $this->response->setJSON([
            'code' => '400',
            'message' => lang('Api.user_not_found'),
        ]);
    }
}   
