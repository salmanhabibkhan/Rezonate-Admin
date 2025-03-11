<?php

namespace App\Controllers;

use DateTime;

use DateInterval;

use App\Models\Friend;
use App\Models\UserModel;
use App\Models\StoryModel;
use App\Models\NotificationModel;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;

class StoryController extends BaseController
{
    use ResponseTrait;
    private $user_id;
    public $storyModel;
    public function __construct()
    {
        $this->storyModel  =  new StoryModel;
        $this->user_id = getCurrentUser()['id'];
    }

    public function addStory()
    {


        $story = new StoryModel;

        $db = \Config\Database::connect();
        try {
            $data = [
                'user_id' => $this->user_id,
                'description' => $this->request->getVar('description'),
                'type' => $this->request->getVar('type'),
                'duration' => $this->request->getVar('duration'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $db->transStart();

            $storyID = $story->getInsertID();
            $db->transComplete();
            if ($db->transStatus() === false) {
                $db->transRollback();
                log_message('error', 'Transaction failed in addPost');
                throw new \Exception('There was a problem creating the post.');
            }

            $type = $this->request->getVar('type');
            if ($type == 'video') {
                $thumbnail = $this->request->getFile('thumbnail');
                if (!empty($thumbnail)) {
                    $data['thumbnail'] = storeMedia($thumbnail, 'story_thumbnail');
                }
                $media = $this->request->getFile('media');
                if (!empty($media)) {
                    $data['media'] = storeMedia($media, 'media');
                }
            }
            if ($type == 'image') {

                $media = $this->request->getFile('media');
                if (!empty($media)) {
                    $data['media'] = storeMedia($media, 'media');
                }
            }
            $story->save($data);

            return $this->respond([
                'code' => '200',
                'message' => lang('Api.story_created_successfully'),
                'data' => ''
            ], 200);
        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return $this->respond([
                'code' => '500',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function createStory()
    {
        $loggedInUser  = getCurrentUser();
        $storyModel = new StoryModel();
        $this->data['stories'] = $storyModel->getallStories($loggedInUser['id']);
        $this->data['user_data'] = $loggedInUser;
        echo load_view('pages/stories/create-story', $this->data);
    }
    public function getStories()
    {
        $friendModel = new Friend();
        $storyModel = new StoryModel();
        $modifiedfriends = [];
        $offset = $this->request->getVar('offset') ?? 0;
        $limit = $this->request->getVar('limit') ?? 6;
        $friends = $friendModel->userFriendList($this->user_id, $limit, $offset);
        $loggedInUser = getCurrentUser();
        $loggedInUserData = [
            'id' => $this->user_id,
            'username' => $loggedInUser['username'],
            'avatar' => $loggedInUser['avatar'],
            'first_name' => $loggedInUser['first_name'],
            'last_name' => $loggedInUser['last_name'],
            'is_verified' => $loggedInUser['is_verified'],
        ];
        array_unshift($friends, $loggedInUserData);

        foreach ($friends as $friend) {
            $modifiedfriend = $friend;
            $modifiedstories = [];
            $stories = $storyModel->getallStories($friend['id']);

            if (!empty($stories)) {
                foreach ($stories as $story) {
                    $modifiedstory = $story;
                    $modifiedstory['is_owner'] = ($this->user_id == $story['user_id']) ? 1 : 0;
                    $modifiedstory['thumbnail'] = !empty($story['thumbnail']) ? getMedia($story['thumbnail']) : '';
                    $modifiedstory['media'] = !empty($story['media']) ? getMedia($story['media']) : '';
                    $modifiedstories[] = $modifiedstory;
                }

                if ($friend['id'] != $this->user_id) {
                    $modifiedfriend['avatar'] = !empty($friend['avatar']) ? getMedia($friend['avatar']) : '';
                }
                $modifiedfriend['stories'] = $modifiedstories;
                $modifiedfriends[] = $modifiedfriend;
            }
        }

        return $this->respond([
            'code' => '200',
            'message' => lang('Api.stories_fetched_successfully'),
            'data' => $modifiedfriends
        ], 200);
    }

    public function muteUnmuteUser()
    {
        $rules = [
            'story_user_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Validation.story_user_id_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $story_user_id = $this->request->getVar('story_user_id');
            $checkOldData = $this->storyModel->checkoldmutedata($this->user_id, $story_user_id);
            if ($checkOldData == 'mute') {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.user_muted_successfully'),
                    'data' => ''
                ], 200);
            } else {
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.user_unmuted_successfully'),
                    'data' => ''
                ], 200);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
    }
    public function seenStory()
    {
        $rules = [
            'story_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Validation.story_id_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $story_id = $this->request->getVar('story_id');
            $story = $this->storyModel->find($story_id);
            $checkOldData = $this->storyModel->checkstoryOldView($this->user_id, $story_id);
            $userData = getCurrentUser();
            if (!empty($checkOldData)) {
                $message = ($checkOldData === 2) 
                ? lang('Api.own_story')
                : lang('Api.story_seen_successfully');

                if ($checkOldData == 1) {
                    $userModel = new UserModel();
                    $user_device = $userModel->select(['device_id', 'notify_view_story', 'email'])->where('id', $story['user_id'])->first();
                    if ($user_device['notify_view_story'] == 1 && $userData['id'] !=  $story['user_id']) {
                        $notificationModel = new NotificationModel();
                        $notificationdata = [
                            'from_user_id' => $this->user_id,
                            'to_user_id' => $story['user_id'],
                            'type' => 'Viewed_Story',
                            'text' => lang('Api.viewed_story_notification'),
                        ];
                        $notificationModel->save($notificationdata);
                        if (get_setting('chck-emailNotification') == 1) {
                            sendmailnotificaiton($user_device['email'], lang('Api.viewed_story_email_subject'), lang('Api.viewed_story_email_body'));
                        }
    
                        sendPushNotification($user_device['device_id'], lang('Api.viewed_story_notification'));
                    }
                }
                return $this->respond([
                    'code' => '200',
                    'message' => $message,
                    'data' => ''
                ], 200);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.story_already_seen'),
                'data' => ''
            ], 200);
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 200);
        }
    }
    public function storySeenUser()
    {
        $rules = [
            'story_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.story_id_required'),
                ],
            ],
        ];
        
        if ($this->validate($rules)) {
            $story_id = $this->request->getVar('story_id');

            $users = $this->storyModel->getseenusers($story_id);
            if (!empty($users)) {
                foreach ($users as $user) {
                    $modifieduser = $user;
                    $modifieduser['avatar'] = (!empty($user['avatar'])) ? getMedia($user['avatar']) : '';
                    $modifieduser['cover'] = (!empty($user['cover'])) ? getMedia($user['cover']) : '';
                    $modifiedusers[] = $modifieduser;
                }
                return $this->respond([
                    'code' => '200',
                    'message' => lang('Api.story_seen_user_fetch_successfully'),
                    'data' => $modifiedusers
                ], 200);
            }
            return $this->respond([
                'code' => '200',
                'message' => lang('Api.no_views_found'),
                'data' => ''
            ], 200);
        } else {
            $validationErrors = $this->validator->getErrors();
        return $this->respond([
            'code' => '400',
            'message' => lang('Api.validation_error'),
            'data' => $validationErrors
        ], 400);
        }
    }
    public function deleteStory()
    {
        $rules = [
            'story_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Api.story_id_required'),
                ],
            ],
        ];
        if ($this->validate($rules)) {
            $story_id = $this->request->getVar('story_id');
            $story = $this->storyModel->find($story_id);
            if (!empty($story)) {
                if ($story['user_id'] == $this->user_id) {
                    $this->storyModel->delete($story_id);
                    return $this->respond([
                        'code' => '200',
                        'message' => lang('Api.story_deleted_successfully'),
                        'data' => ''
                    ], 200);
                } else {
                    return $this->respond([
                        'code' => '401',
                        'message' => lang('Api.not_allowed'),
                        'data' => ''
                    ], 401);
                }
            } else {
                return $this->respond([
                    'code' => '404',
                    'message' => lang('Api.story_not_found'),
                    'data' => ''
                ], 404);
            }
        } else {
            $validationErrors = $this->validator->getErrors();
            return $this->respond([
                'code' => '400',
                'message' => lang('Api.validation_error'),
                'data' => $validationErrors
            ], 400);
        }
    }
}
