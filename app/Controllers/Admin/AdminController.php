<?php

namespace App\Controllers\Admin;


use DateTime;
use App\Models\Job;
use App\Models\Page;
use App\Models\Event;
use App\Models\Group;
use App\Models\Space;
use App\Models\Friend;
use App\Models\Settings;
use App\Models\AutoModel;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\GoingEvent;
use App\Models\GroupMember;
use CodeIgniter\Controller;
use App\Models\DepositModel;
use App\Models\PostTagModel;
use App\Models\Advertisement;
use App\Models\InterestedEvent;
use App\Models\WithdrawRequest;
use App\Models\NotificationModel;
use App\Controllers\Admin\AdminBaseController;

class AdminController extends AdminBaseController
{

	public function __construct()
	{
		parent::__construct();
		$this->data['breadcrumbs'] = [['name' => lang('Admin.dashboard'), 'url' => site_url()]];
		//get files
		//$data['css_files'] = ['page_specific.css'];
		//$data['js_files'] = ['page_specific.js'];
	}

	public function dashboard()
	{
		
		$withdrawModel = new WithdrawRequest();
		$jobModel = new Job();
		$userModel = new UserModel();
		$postModel = new PostModel();
		$groupModel = new Group();
		$pageModel = new Page();
		$depositModel = new DepositModel();
		
		$this->data['total_users'] = $userModel->countAllResults();
		$this->data['pending_withdraws'] = $withdrawModel->where('status', 1)->countAllResults();
		$this->data['total_jobs'] = $jobModel->countAllResults();
		$this->data['total_posts'] = $postModel->countAllResults();
		$this->data['total_groups'] = $groupModel->countAllResults();
		$this->data['total_pages'] = $pageModel->countAllResults();
		$this->data['page_title'] = lang('Admin.user_dashboard'); // Translated string for "User Dashboard"
		$this->data['withdraw_requests'] = $withdrawModel->getadminwithdrawrequest(10);
		$this->data['deposite_requests'] = $depositModel->getDepositDetails(10);
		
		return view('admin/dashboard', $this->data);
	}
	
	public function general_settings()
	{
		$settings = new Settings();
		$allSettings = $settings->getSettings();
	
		$this->data['page_title'] = lang('Admin.general_settings'); // Translated string for "General Settings"
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.general_settings'), 'url' => ''];
		$this->data['settings'] = $allSettings;
		
		return view('admin/pages/general_settings', $this->data);
	}
	
	public function website_information()
	{
		$this->data['languages'] = get_available_languages();
		$this->data['page_title'] = lang('Admin.website_information'); // Translated string for "Website Information"
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.website_information'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/website_information', $this->data);
	}
	
	public function enable_disable_features()
	{
		$this->data['page_title'] = lang('Admin.enable_disable_features'); // Translated string for "Enable/Disable Features"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.enable_disable_features'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		
		return view('admin/pages/enable_disable_features', $this->data);
	}
	
	public function posts_settings()
	{
		$this->data['page_title'] = lang('Admin.post_settings'); // Translated string for "Post Settings"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.post_settings'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/posts_settings', $this->data);
	}
	
	public function social_login_settings()
	{
		$this->data['page_title'] = lang('Admin.social_login_settings'); // Translated string for "Social Login Settings"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.social_login_settings'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/social_login_settings', $this->data);
	}
	
	public function add_new_game()
	{
		$this->data['page_title'] = lang('Admin.add_new_game'); // Translated string for "Add New Game"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.add_new_game'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/add_new_game', $this->data);
	}
	
	public function add_new_movies()
	{
		$this->data['page_title'] = lang('Admin.add_new_movies'); // Translated string for "Add New Movies"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.add_new_movies'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/add_new_movies', $this->data);
	}
	
	public function auto_delete()
	{
		$this->data['page_title'] = lang('Admin.auto_delete'); // Translated string for "Auto Delete"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.auto_delete'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/auto_delete', $this->data);
	}
	
	public function fake_users()
	{
		$this->data['page_title'] = lang('Admin.fake_users'); // Translated string for "Fake Users"
		$this->data['js_files'] = ['/js/datatables.min.js'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.fake_users'), 'url' => ''];
		$settings = new Settings();
		$allSettings = $settings->getSettings();
		$this->data['settings'] = $allSettings;
		return view('admin/pages/fake_users', $this->data);
	}
	
	public function auto_join()
	{
		$this->data['page_title'] = lang('Admin.manage_auto_join_group'); // Translated string for "Manage Auto Join Group"
		$this->data['js_files'] = ['/plugins/select2/select2.min.js'];
		$this->data['css_files'] = ['/plugins/select2/select2.min.css'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_auto_join_group'), 'url' => ''];
		$autoModel = new AutoModel();
		$groupModel = new Group();
		$groups = [];
		$this->data['groups'] = $groups;
		$groupIds = $autoModel->where('type', 'group')->select('entity_id')->findAll();
		if (!empty($groupIds)) {
			foreach ($groupIds as $groupId) {
				$group = $groupModel->select('id,group_title')->where('id', $groupId)->first();
				if (!empty($group)) {
					$groups[] = $group;
				}
			}
			$this->data['groups'] = $groups;
		}
		return view('admin/pages/auto_join', $this->data);
	}
	

	public function auto_like()
	{
		$this->data['page_title'] = lang('Admin.auto_like_pages');
		$this->data['js_files'] = ['/plugins/select2/select2.min.js'];
		$this->data['css_files'] = ['/plugins/select2/select2.min.css'];
		$this->data['breadcrumbs'][] = ['name' =>lang('Admin.auto_like_pages'), 'url' => ''];
		$pageModel = new Page();
	

		$autoModel = new AutoModel();
		$pages = [];
		$this->data['pages'] = $pages;

		$pageIds = $autoModel->where('type', 'page')->select('entity_id')->findAll();
		if(!empty($pageIds))
		{
			foreach($pageIds as $page_id)
			{
				$page = $pageModel->select(['id','page_title'])->where('id',$page_id)->first();
				if(!empty($page))
				{
					$pages[] = $page;
				}
			}
			$this->data['pages'] = $pages;
		}

		return view('admin/pages/auto_like', $this->data);
	}

	public function auto_friend()
	{
		$this->data['page_title'] = lang('Admin.auto_friends');
		$this->data['js_files'] = ['/plugins/select2/select2.min.js'];
		$this->data['css_files'] = ['/plugins/select2/select2.min.css'];
		$this->data['breadcrumbs'][] = ['name' => lang('Admin.auto_friends'), 'url' => ''];

		$userModel = new UserModel();
		$autoModel = new AutoModel();
		$users = [];
		$this->data['users'] = $users;
		$userIds = $autoModel->where('type', 'user')->select('entity_id')->findAll();
		if(!empty($userIds))
		{
			foreach($userIds as $user_id)
			{
				$user = $userModel->select(['id','username'])->where('id',$user_id)->first();
				if(!empty($user))
				{
					$users[] = $user;
				}
			}
			$this->data['users'] = $users;
		}
		return view('admin/pages/auto_friend', $this->data);
	}
	public function updateAutoFriend()
	{
		
		$users = $this->request->getVar('users');
		$autoModel = new AutoModel();
		$userModel= new UserModel();
		$autoModel->where('type', 'user')->delete();
		foreach ($users as $user) {
			$pagedata = $userModel->find($user);
			if (!empty($pagedata)) {
				$data = [
					'entity_id' => $user,
					'type' => 'user',
				];
				$autoModel->save($data);
			}
		}
		$session = \Config\Services::session();
		$session->setFlashdata('success', lang('Admin.auto_user_friends_updated'));

		return redirect('admin/auto-friend');

	}
	public function updateAutoLike()
	{
		$pages = $this->request->getVar('pages');
		$autoModel = new AutoModel();
		$pageModel = new Page();
		$autoModel->where('type', 'page')->delete();
		foreach ($pages as $page) {
			$pagedata = $pageModel->find($page);
			if (!empty($pagedata)) {
				$data = [
					'entity_id' => $page,
					'type' => 'page',
				];
				$autoModel->save($data);
			}
		}
		$session = \Config\Services::session();
		$session->setFlashdata('success', lang('Admin.auto_pages_updated'));

		return redirect('admin/auto-like');
	}
	public function updateAutoJoin()
	{
		$groups = $this->request->getVar('groups');
		$autoModel = new AutoModel();
		$groupModel = new Group();
		$autoModel->where('type', 'group')->delete();
		foreach ($groups as $group) {
			$groupdata = $groupModel->find($group);
			if (!empty($groupdata)) {
				$data = [
					'entity_id' => $group,
					'type' => 'group',
				];
				$autoModel->save($data);
			}
		}
		$session = \Config\Services::session();
		$session->setFlashdata('success', lang('Admin.auto_join_group_updated'));

		return redirect('admin/auto-join');
	}
	public function maintenance()
	{
		return view('admin/');
	}
	public function manageFakeUser()
	{
		$userModel = New UserModel();
		$action = $this->request->getPost('action');
		$session = \Config\Services::session();
		$user_limit = $this->request->getVar('user_limit');
		if($action=='generate')
		{
			$firstNames = ["John", "Emma", "Michael", "Sophia", "William", "Olivia", "James", "Ava", "Alexander", "Mia", "Daniel", "Charlotte", "David", "Amelia", "Joseph", "Ella", "Matthew", "Emily", "Samuel", "Abigail"];
			$lastNames = ["Smith", "Johnson", "Brown", "Jones", "Garcia", "Miller", "Davis", "Rodriguez", "Martinez", "Hernandez", "Lopez", "Gonzalez", "Wilson", "Anderson", "Thomas", "Taylor", "Moore", "Jackson", "Martin", "Lee"];
			$emailDomains = ["gmail.com", "yahoo.com", "hotmail.com"];
			$genderArray  = ["Male",'Female'];
			
			$password = !empty($this->request->getVar('password'))?? "12345678";
			$newEncryptedPassword = password_hash($password, PASSWORD_ARGON2ID);
			for($i=0;$i<$user_limit;$i++)
			{
				$first_name = $firstNames[array_rand($firstNames)];
				$last_name = $lastNames[array_rand($lastNames)];
				$username =  strtolower($first_name).strtolower($last_name).rand(100,999);
				$userdata = [
					'first_name'=>$first_name,
					'last_name'=>$last_name,
					'username'=>$username,
					'email'=>$username."@".$emailDomains[array_rand($emailDomains)],
					'password'=>$newEncryptedPassword,
					'date_of_birth'=> '2009-03-09',
					'gender'=> $genderArray[array_rand($genderArray)],
					'is_fake_user'=>1
				];
				$userModel->save($userdata);
			}
			$session->setFlashdata('success', 'Fake Users are created');
        	return redirect('admin/fake-user');
		}
		else
		{
			$userModel->where('is_fake_user',1)->limit($user_limit)->delete();
			$session->setFlashdata('success', 'Fake users are deleted');
        	return redirect('admin/fake-user');
		}
	}
	public function fetchAllUser(){
		$request = \Config\Services::request(); // Get the request object
        $data = [];

        if ($request->getVar('q')) { 
            $q = $request->getVar('q');

            $userModel = new UserModel();
            $data = $userModel->select('username,first_name,last_name, id')
					->like('username', $q)
				
			->findAll(50);
        }

        return $this->response->setJSON($data);
	}
	public function fetchAllGroups(){
		$request = \Config\Services::request(); // Get the request object
        $data = [];

        if ($request->getVar('q')) { 
            $q = $request->getVar('q');

            $groupModel = new Group();
            $data = $groupModel->select('group_title, id')
					->like('group_title', $q)
					
			->findAll(50);
        }

        return $this->response->setJSON($data);
	}
	public function fetchAllPages(){
		$request = \Config\Services::request(); // Get the request object
        $data = [];

        if ($request->getVar('q')) { 
            $q = $request->getVar('q');

            $groupModel = new Page();
            $data = $groupModel->select('page_title, id')
					->like('page_title', $q)
			
			->findAll(50);
        }
        return $this->response->setJSON($data);
	}
	public function deleteAutoData()
	{
		$session = \Config\Services::session();
		$data_type = $this->request->getVar('data_type');
		$now = new DateTime();

		switch ($data_type) {
			case 2:
				$now->modify('-1 week');
				$this->deleteUser($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.users_not_logged_in_one_week'); // "Users not logged in more than one week deleted successfully"
				break;
			case 3:
				$now->modify('-1 month');
				$this->deleteUser($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.users_not_logged_in_one_month'); // "Users not logged in more than one month deleted successfully"
				break;
			case 4:
				$now->modify('-1 year');
				$this->deleteUser($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.users_not_logged_in_one_year'); // "Users not logged in more than one year deleted successfully"
				break;
			case 5:
				$now->modify('-1 week');
				$this->deletepost($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.posts_not_logged_in_one_week'); // "Posts not logged in more than one week deleted successfully"
				break;
			case 6:
				$now->modify('-1 month');
				$this->deletepost($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.posts_not_logged_in_one_month'); // "Posts not logged in more than one month deleted successfully"
				break;
			case 7:
				$now->modify('-1 year');
				$this->deletepost($now->format('Y-m-d H:i:s'));
				$message = lang('Admin.posts_not_logged_in_one_year'); // "Posts not logged in more than one year deleted successfully"
				break;
			default:
				$session->setFlashdata('error', lang('Admin.invalid_choice')); // "Invalid Choice"
				return redirect('admin/auto-delete');
		}

		$session->setFlashdata('success', $message);
		return redirect('admin/auto-delete');
	}

	public function deletepost($timelimit)
	{
		$postModel = new PostModel();
		$posts = $postModel->where('created_at <', $timelimit)->findAll();        
		$postTagModel = new PostTagModel();

		if (!empty($posts)) {    
			foreach ($posts as $post) {
				$postModel->delete($post['id']);
				$postTagModel->deleteposttags($post['id']);
			}
		}
	}

	public function deleteUser($time)
	{
		$userModel = new UserModel();
		$postModel = new PostModel();
		$groupModel = new Group();
		$eventModel = new Event();
		$interestedEventModel = new InterestedEvent();
		$goingEventModel = new GoingEvent();
		$groupMemeberModel = new GroupMember();
		$friendModel = new Friend();
		$advertisement = new Advertisement();
		$notificationModel = new NotificationModel();
		$db = \Config\Database::connect();

		$users = $userModel->where('last_logintime', $time)->findAll();

		if (!empty($users)) {
			foreach ($users as $user) {
				$userId = $user['id'];
				$postModel->deletePostsByUserId($userId);
				$groupModel->deleteGroupsByUserId($userId);
				$groupMemeberModel->deleteGroupMembersByUserId($userId);
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

				$userModel->update($userId, ['email' => $newemail, 'deleted_at' => $currentDateTime]);
			}
		}
	}

}
