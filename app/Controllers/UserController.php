<?php

namespace App\Controllers;

use App\Models\BloodDonation;
use App\Models\Filter;
use DateTime;
use stdClass;
use App\Models\Job;
use App\Models\Page;
use App\Models\Block;
use App\Models\Event;
use App\Models\Group;
use App\Models\Space;
use App\Models\Friend;

use App\Models\Follower;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\GoingEvent;
use CodeIgniter\I18n\Time;
use App\Models\GroupMember;
use App\Models\UserPackage;
use App\Models\PackageModel;
use CodeIgniter\Email\Email;
use App\Models\Advertisement;
use App\Models\InterestedEvent;
use App\Models\TransactionModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\BloodRequest;

class UserController extends BaseController
{
    private $userModel;
    private $currentuser;

    use ResponseTrait;
    public function __construct()
    {
        parent::__construct();
        $this->userModel  = new UserModel;
        $userData = getCurrentUser();
        $this->currentuser = 0;
        if (!empty($userData)) {
            $this->currentuser = $userData['id'];
        }
    }

    public function profileLookup($username, $section = "posts")
    {
        $userdata  = $this->userModel->where('username', $username)->first();
        $loggedInUserId = getCurrentUser()['id'] ?? 0;
        if (!empty($userdata)) {
            $blockModel = new Block;
            $is_blocked = $blockModel->checkuserblock($loggedInUserId, $userdata['id']);
            
            if (!empty($is_blocked)) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            $followModel  =  new Follower;
            $friendModel = new Friend;

            $postModel = new PostModel;
            $userdata['avatar'] = getMedia($userdata['avatar'], 'avatar');
            $userdata['cover'] =  getMedia($userdata['cover'], 'cover');
            $userdata['details']['followers_count'] = $followModel->where('follower_id', $userdata['id'])->countAllResults();
            $userdata['details']['mutualFriendCount'] = $friendModel->countMutualFriends($userdata['id'], $loggedInUserId);
            $userdata['isFollowingMe'] = 0;
            $userdata['isFollowing'] = 0;
            $userdata['isPending '] = 0;

            $this->data['user_id'] = $userdata['id'];
            $this->data['isFriend'] = $friendModel->checkFriends($loggedInUserId, $userdata['id']);
            $this->data['isPending'] = $friendModel->checkrequestStaus($loggedInUserId, $userdata['id']);

            $friendscount = $friendModel->getFriendCount($userdata['id']);

            $userdata['isAdmin'] = 0;
            $userdata['total_post_count'] = $postModel->where(['user_id' => $userdata['id'], 'deleted_at' => null])->countAllResults();
            $this->data['userphotos'] = $postModel->getuserPhoto($userdata['id'], 3, 1);

            $this->data['friends'] = $friendModel->getFriendList($userdata['id'], 4, 0);

            $notificationModel = new NotificationModel;
            if ($loggedInUserId != 0 && $userdata['id'] != $loggedInUserId && $userdata['notify_profile_visit'] == 1) {
                $profile_notificaiton = $notificationModel->getRecentNotifications($loggedInUserId, $userdata['id']);
                if (empty($profile_notificaiton)) {
                    $notificationdata = [
                        'from_user_id' => $loggedInUserId,
                        'to_user_id' => $userdata['id'],
                        'type' => 'view_profile',
                        'text' => "viewed your profile",
                    ];
                    $notificationModel->save($notificationdata);
                    sendPushNotification($userdata['device_id'], 'viewed your profile');
                    if (get_setting('chck-emailNotification') == 1) {
                        sendmailnotificaiton($userdata['email'], 'View Profile', "view your profile ");
                    }
                }
            }


            if ($section == "photos") {
                $this->data['userallphotos'] = $postModel->getuserallphotos($userdata['id'], 1);
            }

            if($section=="videos"){
                $this->data['userallvideos'] = $postModel->getuserallphotos($userdata['id'],2);

            }

            if ($section == "about") {
            }
            if ($section == "friends") {

                $this->data['friends'] = $friendModel->getFriendList($userdata['id'], $friendscount, 0);
                if (!empty($this->data['friends'])) {
                    foreach ($this->data['friends'] as &$friend) {
                        $friend['countMutualFriend'] = $friendModel->countMutualFriends($friend['id'], $loggedInUserId);
                    }
                }
            }
            if ($section == "videos") {
                $postModel = new PostModel;
                $videos = $postModel->select(['id', 'video_thumbnail'])->where(['user_id' => $userdata['id'], 'image_or_video' => 2, 'privacy' => 1])->findAll();
                if (!empty($videos)) {
                    foreach ($videos as &$video) {
                        $video['video_thumbnail'] = (!empty($video['video_thumbnail'])) ? getMedia($video['video_thumbnail']) : getMedia('uploads/placeholder/video-thumbnail.png');
                    }
                    $this->data['videos'] = $videos;
                }
            }
            $this->data['friendscount'] = $friendscount;
            $this->data['section'] = $section;
            $this->data['user'] = $userdata;
            $packageModel  = new PackageModel;
            $this->data['package'] = $packageModel->find($userdata['level']);
            $this->data['loggedInUser'] = $loggedInUserId;

            $this->data['js_files'] = [
                'js/posts.js',
                'js/post_plugins.js',
                'vendor/imagepopup/js/lightbox.min.js',
            ];

            $this->data['css_files'] = [
                'css/posts.css',
                'css/posts_plugins.css',
                'vendor/imagepopup/css/lightbox.min.css'
            ];
            
            echo load_view('pages/profile/user_profile', $this->data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    public function profileEdit()
    {
        $loggendInUserID = getCurrentUser()['id'];
        $userdata  = $this->userModel->where('id', $loggendInUserID)->first();

        if (!empty($userdata)) {
            $followModel  =  new Follower;
            $userdata['avatar'] = getMedia($userdata['avatar'], 'avatar');
            $userdata['cover'] =  getMedia($userdata['cover'], 'cover');
            $userdata['details']['followers_count'] = $followModel->where('follower_id', $userdata['id'])->countAllResults();
            $userdata['details']['mutualFriendCount'] = 0;
            $userdata['isFollowingMe'] = 0;
            $userdata['isFollowing'] = 0;
            $userdata['isPending '] = 0;
            $userdata['isAdmin'] = 0;

            $this->data['user'] = $userdata;


            echo load_view('pages/profile/settings', $this->data);
        } else {
            return $this->respond([
                'code' => '404',
                'message' => 'Profile Not found '
            ], 404);
        }
    }


    public function getUserProfile()
    {
        $rules = [
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $user_id = $this->request->getVar('user_id');
        $loggedInUserId = getCurrentUser()['id'];
        $userdata  = $this->userModel->find($user_id);
        $user = [];
        $blockModel = new Block;
        $is_blocked = $blockModel->checkuserblock($loggedInUserId, $user_id);

        if (!empty($is_blocked)) {
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.blocked_user'),
                'data' => null
            ], 200);
        }
        if (!empty($userdata)) {
            $friendModel = new Friend;
            $followModel  =  new Follower;
            $userdata['avatar'] = getMedia($userdata['avatar'], 'avatar');
            $userdata['cover'] =  getMedia($userdata['cover'], 'cover');
            $userdata['details']['followers_count'] = $followModel->where('follower_id', $userdata['id'])->countAllResults();
            $userdata['details']['mutualFriendCount'] = $friendModel->countMutualFriends($user_id, $loggedInUserId);
            $isFriend = ($user_id != $loggedInUserId) ? $friendModel->checkFriend($loggedInUserId, $user_id) : '0';
            $userdata['friends_count'] = $friendModel->getFriendCount($userdata['id']);
            $userdata['isFriend'] = !empty($isFriend) ? '1' : '0';
            $userdata['friend_role'] = !empty($isFriend) ? $isFriend['role'] : 0;

            $userdata['isPending'] = $friendModel->checkrequestStaus($loggedInUserId, $user_id);
            $userdata['isRequestReceieved'] = $friendModel->checkincomingrequestStatus($loggedInUserId, $user_id);
            $userdata['isAdmin'] = 0;
            if($user_id!=$loggedInUserId)
            {
                $userdata['address_bytes'] = null;
                $userdata['hex'] = null;
                $userdata['wallet_address'] = null;
            }
            $userdata['is_wallet_exist'] = ($userdata['address_bytes'] != null && $userdata['hex'] != null && $userdata['wallet_address'] != null )?1:0;
            $packageModel = new PackageModel;
            $userdata['user_level'] = $packageModel->find($userdata['level']);
            $notificationModel = new NotificationModel;
            if ($loggedInUserId != 0 && $userdata['id'] != $loggedInUserId && $userdata['notify_profile_visit'] == 1) {
                $profile_notificaiton = $notificationModel->getRecentNotifications($loggedInUserId, $userdata['id']);
                if (empty($profile_notificaiton)) {
                    $notificationdata = [
                        'from_user_id' => $loggedInUserId,
                        'to_user_id' => $userdata['id'],
                        'type' => 'view_profile',
                       'text' => lang('Api.viewed_your_profile'),
                    ];
                    $notificationModel->save($notificationdata);
                    $notificationModel->save($notificationdata);
                    sendPushNotification($userdata['device_id'], lang('Api.viewed_your_profile'));
                    if (get_setting('chck-emailNotification') == 1) {
                        sendmailnotificaiton($userdata['email'], lang('Api.view_profile_subject'), lang('Api.view_profile_text'));
                    }
                }
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.user_profile_fetch_successfully'),
                'data' => $userdata
            ], 200);
        } else {
            return $this->respond([
                'code' => '404',
                'message' => lang('Api.profile_not_found'),
                'data' => null
            ], 404);
        }
    }


    public function updateUserProfile()
    {
        $user_id = getCurrentUser()['id'];
        $data = [];

        foreach ($this->request->getPost() as $key => $value) {
            // Exclude the 'page_id' from the update array
            if ($key != 'cover' || $key != 'avatar') {
                $data[$key] = $value;
            }
            if ($key == 'is_profile_complete' &&  isset($_SESSION['is_profile_complete'])) {
                $_SESSION['is_profile_complete'] = 1;
            }
        }
        if (get_setting('chck-profile_back') == 1) {
            $cover = $this->request->getFile('cover');
            if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
                $data['cover'] = storeMedia($cover, 'cover');
                $this->createPost($data['cover'], 'cover');
                if (isset($_SESSION['cover'])) {
                    $_SESSION['cover'] = getMedia($data['cover']);
                }
            }
        }
        $avatar = $this->request->getFile('avatar');
        if (!empty($avatar)  && $avatar->isValid() && !$avatar->hasMoved()) {
            $data['avatar'] = storeMedia($avatar, 'avatar');
            $this->createPost($data['avatar'], 'avatar');
            if (isset($_SESSION['avatar'])) {
                $_SESSION['avatar'] = getMedia($data['avatar']);
            }
        }
        $res = $this->userModel->update($user_id, $data);

        // Update session data



        return $this->respond([
            'code'      => '200',
            'message'   => lang('Api.profile_updated_successfully'),
            'data'      => $data,
        ], 200);
    }

    public function createPost($postImagePath, $type = "post")
    {
        $db = \Config\Database::connect();
        $postModel = new PostModel;
        $postdata = [
            'user_id' => $this->currentuser,
            'post_text' => '',
            'post_type' => $type,
            'image_or_video' => 1,
            'privacy' =>  1,
            'ip' => $this->request->getIPAddress(),
            'post_location' =>  '',
            'post_color_id' =>  0,
            'width' =>  0,
            'height' =>  0,
            'page_id' =>  0,
            'group_id' =>  0,
            'event_id' =>  0,

        ];

        $postModel->save($postdata);

        $post_id = $postModel->getInsertID();

        $postMedia = [
            'post_id' => $post_id,
            'user_id' => $this->currentuser,
            'media_path' => $postImagePath,
            'image_or_video' => 1,
            'is_active' => 1,
        ];
        return $db->table('posts_media')->insert($postMedia);
    }



    public function searchUser()
    {
        $followerModel = new Follower;
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;
        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 10;
        $modiefiedusers = [];
        $loggedInUserId = getCurrentUser()['id'];
        $search_string = $this->request->getVar('search_string');

        $type = $this->request->getVar('type');
        if (!empty($search_string)) {
            $searchWords = explode(' ', $search_string);
            if ($type == 'people') {
                $usersQuery = $this->userModel
                    ->select(['id', 'is_verified', 'username', 'first_name', 'last_name', 'avatar', 'gender', 'level'])
                    ->where('id !=', $loggedInUserId);

                if (count($searchWords) > 1) {
                    // Handle searching by first and last name
                    $usersQuery->groupStart()
                        ->like('first_name', $searchWords[0])
                        ->like('last_name', $searchWords[1])
                        ->groupEnd();
                } else {
                    // Original LIKE conditions for single word searches
                    $usersQuery->groupStart()
                        ->like('username', $search_string)
                        ->orLike('first_name', $search_string)
                        ->orLike('last_name', $search_string)
                        ->orLike('email', $search_string)
                        ->groupEnd();
                }
                $users = $usersQuery->where('deleted_at', null)->findAll($limit, $offset);
                $friendModel = new Friend();
                if (!empty($users)) {
                    $blockModel = new Block();
                    foreach ($users as $user) {
                        $isBlocked = $blockModel->checkuserblock($user['id'], $loggedInUserId);
                        if (empty($isBlocked)) {
                            $modifiedUser = $user;
                            $modifiedUser['avatar'] = !empty($user['avatar']) ? getMedia($user['avatar']) : '';
                            $modifiedUser['details']['mutualFriendCount'] = $this->countMutualFriends($user['id'], $loggedInUserId, $limit, $offset);
                            $modifiedUser['details']['followers_count'] = $followerModel->where('following_id', $user['id'])->countAllResults();
                            $modifiedUser['isFollowing'] = ($followerModel->where('following_id', $user['id'])->where('follower_id', $loggedInUserId)->countAllResults() > 0) ? '1' : '0';
                            $modifiedUser['isFriend'] = $friendModel->checkFriends($loggedInUserId, $user['id']);
                            $modifiedUser['isPending'] = $friendModel->checkrequestStaus($loggedInUserId, $user['id']);
                            $modifiedUser['isRequestReceived'] = $friendModel->checkincomingrequestStatus($loggedInUserId, $user['id']);
                            $modifiedUsers[] = $modifiedUser;
                        }
                    }
                    return $this->respond([
                        'code' => '200',
                        'type' => 'people',
                        'message' => 'Search User Fetch Successfully',
                        'data' => $modifiedUsers
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'message'   => 'User Not Found',
                        'data'   => $modiefiedusers,
                    ], 200);
                }
            } elseif ($type == 'group') {

                $groupModel  = new Group();
                $groups = $groupModel->getSearchedGroups($search_string, $limit, $offset);
                if (!empty($groups)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'group',
                        'message'   => 'Search Group Fetch Successfully',
                        'data'      => $groups
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'group',
                        'message'   => 'Group Not Found',
                        'data'      => $groups
                    ], 200);
                }
            } elseif ($type == 'page') {

                $pageModel  =  new Page;
              
                $pages = $pageModel->getSearchPages($search_string, $limit, $offset);
                if (!empty($pages)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'page',
                        'message'   => 'Search Pages Successfully ',
                        'data'      => $pages
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'page',
                        'message'   => 'Page not found',
                        'data'      => $pages,
                    ], 200);
                }
            } elseif ($type == 'event') {

                $eventModel  =  new Event;
                $emptyevents = [];
                $events = $eventModel->getSearchEvents($search_string, $limit, $offset);
                if (!empty($events)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'event',
                        'message'   => 'Search Events Successfully ',
                        'data'      => $events
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'event',
                        'message'   => 'Event not found',
                        'data'      => $emptyevents,
                    ], 200);
                }
            } elseif ($type == 'job') {
                $emptyjobs = [];
                $jobModel  =  new Job;
                $jobs = $jobModel->getSearchJobs($search_string, $limit, $offset);
                if (!empty($jobs)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'job',
                        'message'   => 'Search jobs Successfully ',
                        'data'      => $jobs
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'job',
                        'message'   => 'Job not found',
                        'data'      => $emptyjobs,
                    ], 200);
                }
            }
        } else {
            if ($type == 'people') {
                $users = $this->userModel->getUsersNotInFriends($loggedInUserId, $limit, $offset);
                $friendModel = new Friend;
                if (!empty($users)) {
                    $blockModel = new Block;
                    foreach ($users as $user) {
                        $is_blocked = $blockModel->checkuserblock($user->id, $loggedInUserId);
                        if (empty($is_blocked)) {
                            $modiefieduser = $user;
                            $modiefieduser->avatar = !empty($user->avatar) ? getMedia($user->avatar) : '';
                            $details = new stdClass();
                            $details->mutualFriendCount = $this->countMutualFriends($user->id, $loggedInUserId, $limit, $offset);
                            $details->followers_count = $followerModel->where('following_id', $user->id)->countAllResults();
                            $modiefieduser->details = $details;
                            $modiefieduser->isFriend = $friendModel->checkFriends($loggedInUserId, $user->id);
                            $modiefieduser->isPending = $friendModel->checkrequestStaus($loggedInUserId, $user->id);
                            $modiefieduser->isRequestReceieved = $friendModel->checkincomingrequestStatus($loggedInUserId, $user->id);
                            $modiefiedusers[] = $modiefieduser;
                        }
                    }
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'people',
                        'message'   => lang('Api.search_user_fetch_successfully'),
                        'data'      => $modiefiedusers
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'message'   => lang('Api.user_not_found'),
                        'data'   => null,
                    ], 200);
                }
            } elseif ($type == 'group') {
                $groupModel  = new Group();
                $groups = $groupModel->getnewGroup($loggedInUserId, $limit, $offset);
                if (!empty($groups)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'group',
                        'message'   => lang('Api.search_group_fetch_successfully'),
                        'data'      => $groups
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'group',
                        'message'   => lang('Api.group_not_found'),
                        'data'      => null
                    ], 200);
                }
            } elseif ($type == 'page') {
                $pageModel  =  new Page;
                $pages = $pageModel->getNewPages($loggedInUserId, $limit, $offset);
                if (!empty($pages)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'page',
                        'message'   => lang('Api.search_pages_successfully'),
                        'data'      => $pages
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'page',
                        'message'   => lang('Api.page_not_found'),
                        'data'      => null,
                    ], 200);
                }
            } elseif ($type == 'event') {
                $eventModel  =  new Event;
                $events = $eventModel->getSearchEvents($search_string, $limit, $offset);
                if (!empty($events)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'event',
                        'message'   => lang('Api.search_events_successfully'),
                        'data'      => $events
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'event',
                        'message'   => lang('Api.event_not_found'),
                        'data'      => null,
                    ], 200);
                }
            } elseif ($type == 'job') {
                $jobModel  =  new Job;
                $jobs = $jobModel->getNewJob($loggedInUserId, $limit, $offset);
                if (!empty($jobs)) {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'job',
                        'message'   => lang('Api.search_jobs_successfully'),
                        'data'      => $jobs
                    ], 200);
                } else {
                    return $this->respond([
                        'code'      => '200',
                        'type'      => 'job',
                        'message'   => lang('Api.job_not_found'),
                        'data'      => null,
                    ], 200);
                }
            }
        }
    }

    public function search()
    {
        $term = $this->request->getGet('term');
        $is_verified = $this->request->getGet('is_$is_verified');
        $gender = $this->request->getGet('gender');
        $avatar = $this->request->getGet('avatar');

        $userModel = new UserModel;
        $pageModel = new Page;
        $groupModel = new Group;
        $eventModel = new Event;
        $loggedInUserId = getCurrentUser()['id'];

        $this->data['users'] =  $userModel->getsearchUsers($term, $loggedInUserId, $is_verified, $gender, $avatar);
        $this->data['pages'] =  $pageModel->getWebSearchPages($term, $loggedInUserId);
        $this->data['groups'] =  $groupModel->getWebSearchGroups($term, $loggedInUserId);
        $this->data['events'] =  $eventModel->getWebSearchEvents($term, $loggedInUserId);

        // $this->data['is_verified'] = $is_verified;
        // $this->data['gender'] = $gender;
        // $this->data['avatar'] = $avatar;
        
        echo load_view('pages/search/search', $this->data);
    }

    public function countMutualFriends($user_id, $loggedInUserId, $limit, $offset)
    {
        $friendModel = new Friend;
        $friends = $friendModel->getFriendList($user_id, $limit, $offset);
        $loggendPersonfriends = $friendModel->getFriendList($loggedInUserId, $limit, $offset);
        $friends = array_column($friends, 'id');
        $myfriends = array_column($loggendPersonfriends, 'id');
        $commonfriends = array_intersect($friends, $myfriends);
        return count($commonfriends);
    }
    public function getSessions()
    {
        $db = \config\Database::connect();
        $user_id = getCurrentUser()['id'];
        $sessions = $db->table('app_sessions')
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')->get()->getResultArray();

        return $this->respond([
            'code'      => '200',
            'message'   => 'Session Fetch Successfully',
            'data' => $sessions
        ], 200);
    }
    public function deleteSession()
    {
        $rules = [
            'session_id' => 'required'
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $user_id = getCurrentUser()['id'];
        $db = \config\Database::connect();
        $session_id = $this->request->getVar('session_id');


        $builder = $db->table('app_sessions');
        $builder->where('id', $session_id);
        $session = $builder->get()->getFirstRow();


        if (!empty($session)) {
            if ($session->user_id == $user_id) {
                $builder->where('id', $session_id)->delete();
                return $this->response->setJSON([
                    'code' => '200',
                    'message' => 'Session is deleted',

                ]);
            } else {
                return $this->response->setJSON([
                    'code' => '200',
                    'message' => 'You are not allowed',

                ]);
            }
        } else {
            return $this->response->setJSON([
                'code' => '200',
                'message' => 'Session not found',

            ]);
        }
    }
    public function upgradeToPro()
    {
        $rules = [
            'package_id' => [
                'label'  => lang('Api.package_id_label'),
                'rules'  => 'required',
                'errors' => [
                    'required' => lang('Api.package_id_required'),
                ],
            ],
        ];
    
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $user = getCurrentUser();

        $package_id = $this->request->getVar('package_id');
        $packageModel =  new PackageModel();
        $package = $packageModel->find($package_id);
        if ($user['level'] > $package_id) {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.package_upgrade_not_allowed'),
            ]);
        }
        if (!empty($package) && $user['level'] != $package_id) {
            $userwallet = getuserwallet($user['id']);
            if ($userwallet >= $package['package_price']) {
                $userPackage  =  new UserPackage;

                $time = new DateTime();
                $subscriptionDate = $time->format('Y-m-d');
                $now = clone $time;

                $duration = $package['duration'];
                $now->modify('+1' . $duration);
                $expires_at =  $now->format('Y-m-d') . '';

                $newpackage = [
                    'user_id' => $user['id'],
                    'package_id' => $package_id,
                    'subscription_date' => $subscriptionDate,
                    'expires_at' => $expires_at
                ];
                $userPackage->save($newpackage);
                $transactionModel = new TransactionModel();
                $userdeduction = [
                    'user_id' => $user['id'],
                    'flag' => 'D',
                    'action_type' => 6,
                    'amount' => $package['package_price'],
                ];
                $transactionModel->save($userdeduction);
                $creditAdmin = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 6,
                    'amount' => $package['package_price'],
                ];
                $transactionModel->save($creditAdmin);
                $userModel = new UserModel;
                $is_verified = $package['verified_badge'];
                $userModel->update($user['id'], ['level' => $package_id,'is_verified'=>$is_verified]);
                if (isset($_SESSION['level'])) {
                    $_SESSION['level'] = $package_id;
                }
                return $this->response->setJSON([
                    'code' => '200',
                    'message' => lang('Api.package_subscription_success'),
                    'data'=>$package
                ]);
            }
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.insufficient_balance'),
            ]);
        } else {
            if (!empty($package)) {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.package_already_subscribed'),
                    
                ]);
            } else {
                return $this->response->setJSON([
                    'code' => '400',
                    'message' => lang('Api.package_not_exist'),
                ]);
            }
        }
    }

    public function packages()
    {
        $packageModel = new PackageModel;
        $this->data['packages'] = $packageModel->findAll();
        $this->data['user'] = getCurrentUser();

        echo load_view('pages/wallet/packages', $this->data);
    }

    public function sendmail()
    {
        $email = getMailConfiguration();
        // Email content

        $email->setTo('msaifrehmangetgroup@gmail.com');
        $email->setSubject('Subject of the Email');
        $email->setMessage('Body of the Email');

        // Send the email
        if ($email->send()) {
            echo 'Email sent successfully.';
        } else {
            echo 'Error sending email: ' . $email->printDebugger();
        }
    }
    public function loadImages()
    {

        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 12;
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;

        $user_id = $this->request->getVar('user_id');
        $postModel  = new PostModel;
        $userallphotos = $postModel->getuserallphotos($user_id, 1, $limit, $offset);
        if (count($userallphotos)) {
            return $this->response->setJSON([
                'code' => '200',
                'message' => 'Package not exist ',
                'data' => $userallphotos
            ]);
        } else {
            echo "images  not found ";
        }
    }
    public function deleteAccount()    
    {
        if (get_setting('chck-deleteAccount') != "1") {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.account_deletion_not_available'),
            ]);
        }
        
        if (IS_DEMO) {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.account_deletion_not_available'),
            ]);
        }
        
        $rules = [
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'code' => '400',
                'message' => lang('Api.validation_failed'),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $user  = getCurrentUser();
        $password = $this->request->getVar('password');
        $userModel = new UserModel();
        $userId = $user['id'];
        $userdata = $userModel->find($userId);

        if (!password_verify($password, $userdata['password'])) {
            return $this->respond([
                'code'    => '400',
                'message' => 'Incorrect Password',
            ]);
        }

        $postModel = new PostModel();
        $groupModel = new Group();
        $eventModel = new Event();
        $spaceModel = new Space;
        $interestedEventModel = new InterestedEvent;
        $goingEventModel = new GoingEvent;
        $groupMemeberModel = new GroupMember;
        $friendModel = new Friend;
        $advertisement = new Advertisement;
        $notificationModel = new NotificationModel;
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Delete user's posts
            $postModel->deletePostsByUserId($userId);

            // Delete user's groups
            $groupModel->deleteGroupsByUserId($userId);
            $groupMemeberModel->deleteGroupMembersByUserId($userId);
            // Delete user's events
            $eventModel->where('user_id', $userId)->delete();
            $goingEventModel->where('user_id', $userId)->delete();
            $interestedEventModel->where('user_id', $userId)->delete();
            $friendModel->where('friend_one', $userId)->orWhere('friend_two', $userId)->delete();
            $db->table('app_sessions')->where('user_id', $userId)->delete();
            $advertisement->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->delete();
            $notificationModel->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->delete();
            $number = rand(100, 999);
            $currentDateTime = date('Y-m-d H:i:s');
            $newemail = $user['email'] . '_' . $number;
            $newusername = $user['username'] . '_' . rand(100, 999);
            $userModel->update($userId, ['email' => $newemail, 'username' => $newusername, 'deleted_at' => $currentDateTime]);
            $db->table('ci_sessions')->where('user_id', $userId)->delete();

            $db->transCommit();
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.account_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'code' => '500',
                'message' => lang('Api.account_deletion_failed') . ': ' . $e->getMessage(),
            ]);
        }
    }

    public function searchFriendFilter()
    {
        $userModel = new UserModel;
        $user_id = getCurrentUser()['id'];
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;
        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 10;
        $userModel->select(['id', 'is_verified', 'username', 'first_name', 'email', 'last_name', 'avatar', 'cover', 'gender', 'level', 'role', 'relation_id', 'city', 'last_seen', 'privacy_active_status'])->where('id !=', $user_id);
        $gender = $this->request->getVar('gender');
        $status = $this->request->getVar('status');

        $lat = $this->request->getVar('lat');
        $lon = $this->request->getVar('lon');
        $distance = $this->request->getVar('distance');

        $relation_id = $this->request->getVar('relation_id');


        if (!empty($gender)) {
            $userModel->where('gender', $gender);
        }
        if (!empty($relation_id) || $relation_id == 0) {
            $userModel->where('relation_id', $relation_id);
        }
        if (!empty($status) && $status == 'online') {
            $currentTime = Time::now();
            $fiveMinutesAgo = $currentTime->subMinutes(3);
            $userModel->where('last_seen >=', $fiveMinutesAgo->toDateTimeString());
        }
        if (!empty($status) && $status == 'offline') {
            $currentTime = Time::now();
            $fiveMinutesAgo = $currentTime->subMinutes(3);
            $userModel->where('last_seen <=', $fiveMinutesAgo->toDateTimeString());
        }

        if (!empty($distance) && !empty($lat) && !empty($lon)) {
            $radius = 6371; // Earth's radius in kilometers

            $distanceSelect = "*, ({$radius} * acos(cos(radians({$lat})) * cos(radians(lat)) * cos(radians(lon) - radians({$lon})) + sin(radians({$lat})) * sin(radians(lat)))) AS distance";

            $userModel->select($distanceSelect)
                ->having('distance <=', $distance)
                ->orderBy('distance', 'asc');
        }


        $users = $userModel->findAll($limit, $offset);

        foreach ($users as &$user) {
            $user['avatar'] = getMedia($user['avatar']);
            $user['cover'] = getMedia($user['cover']);
            $user['relation_id'] = getuserrelation($user['relation_id']);
            $currentTime = new DateTime();
            $timestampFromDatabase = $user['last_seen'];
            $databaseTime = new DateTime($timestampFromDatabase);
            $interval = $currentTime->diff($databaseTime);

            $user['online_status'] = ($interval->i < 3) ? '1' : '0';
        }

        return $this->response->setJSON([
            'code' => '200',
            'message' => lang('Api.user_fetch_successfully'),
            'users' => $users
        ], 200);
    }
    public function getProUser()
    {
        $loggedInUser = getCurrentUser();
        $limit = !empty($this->request->getVar('limit')) ? $this->request->getVar('limit') : 8;
        $offset = !empty($this->request->getVar('offset')) ? $this->request->getVar('offset') : 0;

        $userModel =  new UserModel;
        $users = $userModel->select('id')->where('level >', 1)->where('id!=', $loggedInUser['id'])->orderBy('id','desc')->findAll($limit,$offset);
        if (!empty($users)) {
            foreach ($users as &$user) {
                $user = $userModel->getUserShortInfo($user['id']);
            }
            return $this->response->setJSON([
                'code' => '200',
                'message' => lang('Api.user_fetch_successfully'),
                'data' => $users
            ]);
        }
        return $this->response->setJSON([
            'code' => '200',
            'message' => lang('Api.pro_user_not_found'),
        ]);
    }
    public function deleteWebSession()
    {
        $rules = [
            'session_id' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $db = \Config\Database::connect(); // Get the datab
        $session_id = $this->request->getVar('session_id');
        $db->table('ci_sessions')->where('id', $session_id)->delete();
        return $this->response->setJSON([
            'code' => '200',
            'message' => "Session is deleted",

        ]);
    }
    public function pokeUser()
    {
        $rules = [
            'user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.user_id_required'),
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => 'Validation Error',
                'data' => $validationErrors
            ], 200);
        }
        $user_id = $this->request->getVar('user_id');
        $loggedInUserId = getCurrentUser()['id'];
        $userModel = New UserModel;
        $user_device = $userModel->select(['device_id','email'])->where('id', $user_id)->first();
               
        if(!empty($user_device) && ($user_id!=$loggedInUserId)   )
        {
            
            $text = lang('Api.poked_you');
            $notificationModel = New NotificationModel();
                $notificationdata = [
                    'from_user_id'=>$loggedInUserId,
                    'to_user_id'=>$user_id,
                    'type'=>'poked-user',
                    'text'=>$text,
                ];
            $notificationModel->save($notificationdata);
            if(get_setting('chck-emailNotification')==1)
            {
                sendmailnotificaiton($user_device['email'],lang('Api.poked_you'),$text);
            }     
            sendPushNotification($user_device['device_id'],$text);
        }

       
        return $this->respond([
            'code' => '200',
            'message' => lang('Api.poke_successfully'),
        ], 200);
    }
    public function becomeDonor()
    {
        $rules = [
            'location' => 'required',
            'last_donation' => 'required',
            'blood_group' => 'required',
            'phone_no' => 'required',
        

        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validationErrors
            ], 200);
           
        }
        $user_id  = getCurrentUser()['id'];
        $bloodDonationModel = New BloodDonation;
        $getOldData = $bloodDonationModel->where('user_id',$user_id)->first();
        if(!empty($getOldData))
        {
            return $this->respond([
                'code' => 400,
                'message' => 'Info not exist create info first ',
            ], 200);
        }
        $bloodDonationData=[
            'user_id'=>$user_id,
            'phone_no'=>$this->request->getVar('phone_no'),
            'blood_group'=>$this->request->getVar('blood_group'),
            'location'=>$this->request->getVar('location'),
            'last_donation'=>!empty($this->request->getVar('last_donation'))?$this->request->getVar('last_donation'):null,
        ];
        $bloodDonationModel->save($bloodDonationData);
        return $this->respond([
            'code' => 200,
            'message' => 'Info inserted successfully ',
        ], 200);

    }
    public function updateDonorInfo()
    {
        $rules = [
            'location' => 'required',
            'blood_group' => 'required',
            'phone_no' => 'required',
        ];
        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => 'Validation Error',
                'data' => $validationErrors
            ], 200);
           
        }
        $user_id  = getCurrentUser()['id'];
        $bloodDonationModel = New BloodDonation;
        $getOldData = $bloodDonationModel->where('user_id',$user_id)->first();
        if(empty($getOldData))
        {
            return $this->respond([
                'code' => 400,
                'message' => 'Info not exist please create info ',
            ], 200);
        }
        $bloodDonationData=[
            'user_id'=>$user_id,
            'phone_no'=>$this->request->getVar('phone_no'),
            'blood_group'=>$this->request->getVar('blood_group'),
            'location'=>$this->request->getVar('location'),
            'last_donation'=>!empty($this->request->getVar('last_donation'))?$this->request->getVar('last_donation'):null,

        ];
        $bloodDonationModel->update($getOldData['id'],$bloodDonationData);
        return $this->respond([
            'code' => 200,
            'message' => 'Blood donor info updated successfully ',
        ], 200);

    }
    public function getDonorList()
    {
        $limit = $this->request->getVar('limit')?? 6;
        $offset = $this->request->getVar('offset')?? 0;
        $userModel  = New UserModel;
        $user_id = getCurrentUser()['id'];
        $blood_group = $this->request->getVar('blood_group');
        $query = $userModel->select('id')->where('id!=',$user_id)->where('blood_group!=',null)->where('donation_available',1);
        if(!empty($blood_group))
        {
            $query->where('blood_group',$blood_group);
        }
        $blood_users = $query->findAll($limit,$offset);
       
        if(!empty($blood_users))
        {
            $userModel = New UserModel;
            $users = [];
            $userfields = ['blood_group','phone','donation_date','address','donation_available','date_of_birth'];
            foreach($blood_users as &$user)
            {
                $users[] =  $userModel->getUserShortInfo($user['id'],$userfields);
   
            }
            return $this->respond([
                'code' => 200,
                'message' => 'Blood Doner found successfully',
                'data' =>   $users
            ], 200);   
        }
        return $this->respond([
            'code' => 400,
            'message' => 'Blood Donor not found',
            
        ], 200);   
        
    } 
    public function addBloodRequest()
    {
        $rules = [
            'location' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.location_required'),
                ],
            ],
            'blood_group' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.blood_group_required'),
                ],
            ],
            'phone' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.phone_required'),
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => 400,
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }

        $user_id = getCurrentUser()['id'];
        $bloodrequestModel = new BloodRequest();
        $blood_data = [
            'user_id' => $user_id,
            'blood_group' => $this->request->getVar('blood_group'),
            'location' => $this->request->getVar('location'),
            'phone' => $this->request->getVar('phone'),
            'is_urgent_need' => !empty($this->request->getVar('is_urgent_need')) ? $this->request->getVar('is_urgent_need') : 0,
        ];

        $bloodrequestModel->save($blood_data);

        return $this->respond([
            'code' => 200,
            'message' => lang('Api.blood_request_added_successfully'),
        ], 200);
    }

    public function getBloodRequest()
    {
        $limit = $this->request->getVar('limit')?? 6;
        $offset = $this->request->getVar('offset')?? 0;
        $user_id = getCurrentUser()['id'];
        $bloodrequestModel = New BloodRequest;
        $blood_group = $this->request->getVar('blood_group');
        $is_urgent_need =!empty($this->request->getVar('is_urgent_need'))?  1:0;
        if(!empty($blood_group))
        {
            $bloodrequestModel->where('blood_group',$blood_group);
        }
        if(!empty($is_urgent_need))
        {
            $bloodrequestModel->where('is_urgent_need',$is_urgent_need);
        }
        
        $blood_request = $bloodrequestModel->findAll($limit,$offset);
        if(!empty($blood_request))
        {
            $userModel = New UserModel;
            foreach($blood_request as &$request)
            {
                $request['user'] = $userModel->getUserShortInfo($request['user_id']);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.blood_request_found_successfully'),
                'data' =>   $blood_request
            ], 200);   
        }
        return $this->respond([
            'code' => '400',
           'message' => lang('Api.blood_request_not_found'),
        ], 200);
    }
    public function getFilter()
    {
        $limit = $this->request->getVar('limit')??10;
        $offset = $this->request->getVar('offset')??0;
        $filterModel = New Filter();
        $filters = $filterModel->findAll($limit,$offset);
        if(!empty($filters))
        {
            foreach($filters as &$filter)
            {
                $filter['image'] = getMedia($filter['image']);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.filter_found_successfully'),
                'data' => $filters
            ], 200);
        } 
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.filter_not_found'),
        ], 200);
    }
    public function hangoutUsers()
    {
        $usergender = getCurrentUser()['gender'];
        $userModel = New UserModel;
       
    }

    public function getlanguages()
    {
        $directoryPath = APPPATH . 'Language'; // Change to your directory path
        $directories = [];

        // Check if the directory exists
        if (is_dir($directoryPath)) {
            // Get all files and directories in the given path
            $items = scandir($directoryPath);

            // Filter out '.' and '..'
            $items = array_diff($items, ['.', '..']);

            // Loop through the items and check if they are directories
            foreach ($items as $item) {
                $fullPath = $directoryPath . DIRECTORY_SEPARATOR . $item;
                if (is_dir($fullPath)) {
                    $directories[] = $item;
                }
            }

            // Return the list of directories as JSON
            return $this->respond(['languages' => $directories], 200);
        } else {
            // Return an error message as JSON
            return $this->respond(['error' => 'Directory does not exist.'], 404);
        }
    }
}

