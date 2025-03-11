<?php

namespace App\Controllers\Admin;


use App\Models\Event;
use App\Models\Group;

// use App\Models\Report;


use App\Models\Space;
use App\Models\Friend;
use App\Models\Report;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\GoingEvent;
use App\Models\GroupMember;
use App\Models\CommentModel;
use App\Models\Advertisement;
use App\Models\InterestedEvent;
use App\Models\UserReportModel;
use App\Models\NotificationModel;
use App\Controllers\Admin\AdminBaseController;

class ReportsController extends AdminBaseController
{
    private $reportsModel;
    public $session;
    public $postModel;

    public function __construct()
    {
        parent::__construct();
        $this->reportsModel = new Report();
        $this->postModel = new PostModel();
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        $this->data['page_title'] = lang('Admin.all_reports');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.post_report'), 'url' => ''];

        $this->data['reports'] = $this->reportsModel
            ->select('posts_report.id, users.username ,posts.view_count , posts.post_text, posts_report.status')
            ->join('users', 'users.id = posts_report.user_id')
            ->join('posts', 'posts.id = posts_report.post_id')
            ->where('posts_report.status', 1)
            ->where('posts_report.deleted_at', null) // Assuming soft delete
            ->orderBy('posts_report.created_at', 'DESC')
            ->findAll();

        return view('admin/pages/all-reports', $this->data);
    }

    public function action()
    {
        $reportId = $this->request->getPost('report_id');
        $action = $this->request->getPost('action');
        $report = $this->reportsModel->find($reportId);

        if ($action === 'approve') {
            $this->postModel->delete($report['post_id']);
        } elseif ($action === 'reject') {
            $this->reportsModel->update($reportId, ['status' => 3]);
        } elseif ($action === 'delete') {
            $this->reportsModel->delete($reportId);
        }

        $this->session->setFlashdata('success', lang('Admin.report_action_success', ['action' => $action]));
        return redirect('admin/report/reported-user');
    }

    public function getUserReport()
    {
        $this->data['page_title'] = lang('Admin.all_reported_users');
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.user_report'), 'url' => ''];
        $userReportModel = new UserReportModel();
        $reportusers = $userReportModel->where('status', 1)->paginate(10);
        $userModel = new UserModel();

        if (!empty($reportusers)) {
            foreach ($reportusers as &$reportuser) {
                $reportuser['report_user'] = $userModel->getUserShortInfo($reportuser['report_user_id']);
                $reportuser['from_user'] = $userModel->getUserShortInfo($reportuser['user_id']);
            }
            $this->data['pager'] = $userReportModel->pager;
        }

        $this->data['report_users'] = $reportusers;

        return view('admin/pages/all-user-reports', $this->data);
    }

    public function userAction()
    {
        $reportId = $this->request->getPost('report_id');
        $action = $this->request->getPost('action');
        $userReportModel = new UserReportModel();
        $report = $userReportModel->find($reportId);

        if ($action === 'approve') {
            $this->deleteUser($report['report_user_id']);
        } elseif ($action === 'reject') {
            $userReportModel->update($reportId, ['status' => 3]);
        } elseif ($action === 'delete') {
            $userReportModel->delete($reportId);
        }

        $this->session->setFlashdata('success', lang('Admin.report_action_success', ['action' => $action]));
        return redirect('admin/report/reported-user');
    }

    public function deleteUser($userId)
    {
        $user = getCurrentUser();
        $userId = $user['id'];
        $userModel = new UserModel();
        $postModel = new PostModel();
        $groupModel = new Group();
        $eventModel = new Event();
        $spaceModel = new Space();
        $interestedEventModel = new InterestedEvent();
        $goingEventModel = new GoingEvent();
        $groupMemeberModel = new GroupMember();
        $friendModel = new Friend();
        $advertisement = new Advertisement();
        $notificationModel = new NotificationModel();
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Delete user's posts
            $postModel->deletePostsByUserId($userId);

            // Delete user's groups
            $groupModel->deleteGroupsByUserId($userId);
            $groupMemeberModel->deleteGroupMembersByUserId($userId);

            $eventModel->where('user_id', $userId)->delete();
            $goingEventModel->where('user_id', $userId)->delete();
            $interestedEventModel->where('user_id', $userId)->delete();
            $friendModel->where('friend_one', $userId)->orWhere('friend_two', $userId)->delete();
            $advertisement->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->delete();
            $notificationModel->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->delete();

            $number = rand(100, 999);
            $currentDateTime = date('Y-m-d H:i:s');
            $newemail = $user['email'] . '_' . $number;

            $userModel->update($userId, ['email' => $newemail, 'deleted_at' => $currentDateTime]);

            // Commit the transaction if everything is successful
            $db->transCommit();
            return 1;

        } catch (\Exception $e) {
            return lang('Admin.user_deletion_error', ['error' => $e->getMessage()]);
        }
    }
}

