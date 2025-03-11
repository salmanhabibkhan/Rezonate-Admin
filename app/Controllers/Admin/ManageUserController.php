<?php

namespace App\Controllers\Admin;
use DateTime;
use App\Models\Event;
use App\Models\Group;
use App\Models\Space;
use App\Models\Friend;
use App\Models\PostModel;
use App\Models\UserModel;
use App\Models\GoingEvent;
use CodeIgniter\I18n\Time;
use App\Models\GroupMember;
use App\Models\Advertisement;
use App\Models\InterestedEvent;
use App\Models\NotificationModel;
use App\Controllers\BaseController;
use App\Controllers\Admin\AdminBaseController;

class ManageUserController extends AdminBaseController
{
    public $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Set page information and load necessary JS files
        $this->data['page_title'] = lang('Admin.manage_users');
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_users'), 'url' => ''];

        // Initialize the UserModel for database operations
        $userModel = new UserModel();

        // Retrieve query parameters for pagination, search, and filter
        $page = $this->request->getVar('page') ?? 1; // Default to first page if not specified
        $filter = $this->request->getVar('filter');
        $search = $this->request->getVar('search');

        // Begin query with base user selection
        $query = $userModel->select('id, username, first_name, last_name, email, ip_address, status, avatar,role');

        // Apply search filter if provided
        if (!empty($search)) {
            $query->groupStart() // Begin a grouping for OR conditions
                ->like('username', $search)
                ->orLike('email', $search)
                ->orLike('first_name', $search)
                ->orLike('last_name', $search)
                ->groupEnd(); // Close the grouping
        }

        // Apply status filter if 'active' or 'inactive' is provided
        if ($filter === 'active' || $filter === 'inactive') {
            $status = ($filter === 'active') ? 1 : 0;
            $query->where('status', $status);
        }
        $this->data['search'] =$search;
        $this->data['filter'] =$filter;

        // Define the number of records per page
        $perPage = 20;

        // Execute pagination on the query
        $this->data['users'] = $query->paginate($perPage);

        // Assign the pager object for pagination links
        $this->data['pager'] = $userModel->pager;
      
        // Render the view with supplied data
        return view('admin/pages/manage_users', $this->data);
    }

    
    public function edit($id)
    {
        $this->data['page_title'] = lang('Admin.edit_user');
        $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.edit_user'), 'url' => ''];
        $this->data['user'] = $this->userModel->find($id);
        return view('admin/pages/users/edit', $this->data);
    }

    public function update($id)
    {
        $rules = [
            'first_name' => [
                'label' => 'First Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.first_name_required')
                ]
            ],
            'last_name' => [
                'label' => 'Last Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.last_name_required')
                ]
            ],
            'gender' => [
                'label' => 'Gender',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.gender_required')
                ]
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.phone_required')
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            $this->data['validation'] = $this->validator->getErrors();
            $this->data['page_title'] = "Edit user";
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
            $this->data['user'] = $this->userModel->find($id);
            return view('admin/pages/users/edit', $this->data);
        }

        $updateData = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name' => $this->request->getVar('last_name'),
            'address' => $this->request->getVar('address'),
            'gender' => $this->request->getVar('gender'),
            'phone' => $this->request->getVar('phone'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'status' => $this->request->getVar('status'),
        ];
        $avatar = $this->request->getFile('avatar');
        if (!empty($avatar) && $avatar->isValid() && !$avatar->hasMoved()) {
            $updateData['avatar'] = storeMedia($avatar, 'avatar');
        }
        $cover = $this->request->getFile('cover');
        if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
            $updateData['cover'] = storeMedia($cover, 'cover');
        }

        $res = $this->userModel->update($id, $updateData);
        $session = \Config\Services::session();
        if ($res) {
            $session->setFlashdata('success', lang('Admin.user_update_success'));
            return redirect('admin/users');
        } else {
            $session->setFlashdata('error', lang('Admin.user_update_failed'));
            return redirect('admin/users');
        }
    }
    public function store()
    {
        $rules = [
            'first_name' => [
                'label' => 'First Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.first_name_required')
                ]
            ],
            'last_name' => [
                'label' => 'Last Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.last_name_required')
                ]
            ],
            
            'email' => [
                'label' => 'Last Name',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.email_required')
                ]
            ],
            
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.password_required')
                ]
            ],
            'gender' => [
                'label' => 'Gender',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.gender_required')
                ]
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'required',
                'errors' => [
                    'required' => lang('Admin.phone_required')
                ]
            ],
        ];
        if (!$this->validate($rules)) {
            $this->data['validation'] = $this->validator->getErrors();
            $this->data['page_title'] = "Edit user";
            $this->data['js_files'] = ['assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Website Information', 'url' => ''];
            return view('admin/pages/users/edit', $this->data);
        }
        $username = strstr($this->request->getVar('email'), '@', true);
        $username = $username.rand(100,999);
        $updateData = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name' => $this->request->getVar('last_name'),
            'address' => $this->request->getVar('address'),
            'username'=>$username,
            'gender' => $this->request->getVar('gender'),
            'email' =>$this->request->getVar('email'),
            'password'=>password_hash($this->request->getVar('password'), PASSWORD_ARGON2ID),
            'phone' => $this->request->getVar('phone'),
            'date_of_birth' => $this->request->getVar('date_of_birth'),
            'status' => $this->request->getVar('status'),
            'activated' =>1,
            'role'=>2
            
        ];
        $avatar = $this->request->getFile('avatar');
        if (!empty($avatar) && $avatar->isValid() && !$avatar->hasMoved()) {
            $updateData['avatar'] = storeMedia($avatar, 'avatar');
        }
        $cover = $this->request->getFile('cover');
        if (!empty($cover) && $cover->isValid() && !$cover->hasMoved()) {
            $updateData['cover'] = storeMedia($cover, 'cover');
        }

        $res = $this->userModel->save($updateData);
        $session = \Config\Services::session();
        if ($res) {
            $session->setFlashdata('success', lang('Admin.admin_create_success'));
            return redirect('admin/manage-admins');
        } else {
            $session->setFlashdata('error', lang('Admin.admin_create_failed'));
            return redirect('admin/manage-admins');
        }
    }

    public function delete($id)
    {
        $session = \Config\Services::session();
        if ($this->userModel->delete($id)) {
            $postModel = new PostModel();
            $groupModel = new Group();
            $eventModel = new Event();
            $spaceModel = new Space;
            $interestedEventModel = new InterestedEvent;
            $goingEventModel = new GoingEvent;
            $groupMemeberModel = new GroupMember;
            $friendModel = new Friend;
           
            $notificationModel = new NotificationModel;
            $db = \Config\Database::connect();
            $userId  = $id;
            $postModel->deletePostsByUserId($userId);
            $user = $this->userModel->find($userId);

            // Delete user's groups
            $groupModel->deleteGroupsByUserId($userId);
            $groupMemeberModel->deleteGroupMembersByUserId($userId);
            // Delete user's events
            $eventModel->where('user_id', $userId)->delete();
            $goingEventModel->where('user_id', $userId)->delete();
            $interestedEventModel->where('user_id', $userId)->delete();
            $friendModel->where('friend_one', $userId)->orWhere('friend_two', $userId)->delete();
            $db->table('app_sessions')->where('user_id', $userId)->delete();
           
            $notificationModel->where('from_user_id', $userId)->orWhere('to_user_id', $userId)->delete();
            $number = rand(100, 999);
            $currentDateTime = date('Y-m-d H:i:s');
            $newemail = $user['email'] . '_' . $number;
            $newusername = $user['username'] . '_' . rand(100, 999);
            $this->userModel->update($userId, ['email' => $newemail, 'username' => $newusername, 'deleted_at' => $currentDateTime]);
            $db->table('ci_sessions')->where('user_id', $userId)->delete();
            $db = \Config\Database::connect();
            $builder = $db->table('ci_sessions'); // Your session table name
            $builder->where('user_id', $id);
            $builder->delete();
            $session->setFlashdata('success', lang('Admin.user_delete_success'));
        } else {
            $session->setFlashdata('error', lang('Admin.user_delete_failed'));
        }
        return redirect('admin/users');
    }

    public function onlineUsers()
    {

        $this->data['page_title'] = lang('Admin.online_users');
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.online_users'), 'url' => ''];
        $userModel = new UserModel();
        $page = $this->request->getVar('page') ?? 1;
        $currentTime = Time::now();
        $fiveMinutesAgo = $currentTime->subMinutes(5);
        $query = $userModel->select('id, username, first_name, last_name, email, ip_address, status, avatar,role')->where('last_seen >=', $fiveMinutesAgo->toDateTimeString());

        $this->data['pager'] = $userModel->pager;

        $perPage = 6; // Number of records per page 
        $this->data['users'] = $query->paginate($perPage);

        $this->data['pager'] = $userModel->pager;

        return view('admin/pages/manage_users', $this->data);
    }
    public function manageAdmins()
    {
        $this->data['page_title'] = lang('Admin.manage_admins');
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.manage_admins'), 'url' => ''];

        // Initialize the UserModel for database operations
        $userModel = new UserModel();

        // Retrieve query parameters for pagination, search, and filter
        $page = $this->request->getVar('page') ?? 1; // Default to first page if not specified
        $filter = $this->request->getVar('filter');
        $search = $this->request->getVar('search');

        // Begin query with base user selection
        $query = $userModel->select('id, username, first_name, last_name, email, ip_address, status, avatar,role')->where('role',2);

        // Apply search filter if provided
        if (!empty($search)) {
            $query->groupStart() // Begin a grouping for OR conditions
                ->like('username', $search)
                ->orLike('email', $search)
                ->orLike('first_name', $search)
                ->orLike('last_name', $search)
                ->groupEnd(); // Close the grouping
        }

        // Apply status filter if 'active' or 'inactive' is provided
        if ($filter === 'active' || $filter === 'inactive') {
            $status = ($filter === 'active') ? 1 : 0;
            $query->where('status', $status);
        }
        $this->data['search'] =$search;
        $this->data['filter'] =$filter;

        // Define the number of records per page
        $perPage = 20;

        // Execute pagination on the query
        $this->data['users'] = $query->paginate($perPage);

        // Assign the pager object for pagination links
        $this->data['pager'] = $userModel->pager;

        return view('admin/pages/manage_users', $this->data);
    }
    
    public function verifiedUser()
    {
        $this->data['page_title'] = lang('Admin.verified_users');
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.verified_users'), 'url' => ''];
        $userModel = new UserModel();
        $page = $this->request->getVar('page') ?? 1;
      
        $query = $userModel->select('id, username, first_name, last_name, email, ip_address, status, avatar,role')->where('activated', 1);
        $this->data['pager'] = $userModel->pager;
        $perPage = 20; // Number of records per page
        $this->data['users'] = $query->paginate($perPage);
        $this->data['pager'] = $userModel->pager;
        return view('admin/pages/manage_users', $this->data);
    }

    public function unVerifiedUser()
    {
        $this->data['page_title'] = lang('Admin.unverified_users');
        $this->data['js_files'] = ['/js/datatables.min.js'];
        $this->data['breadcrumbs'][] = ['name' => lang('Admin.unverified_users'), 'url' => ''];
        $userModel = new UserModel();
        $page = $this->request->getVar('page') ?? 1;
        $query = $userModel->select('id, username, first_name, last_name, email, ip_address, status, avatar,role')->where('activated', 0);
        $this->data['pager'] = $userModel->pager;
        $perPage = 20; // Number of records per page
        $this->data['users'] = $query->paginate($perPage);
        $this->data['pager'] = $userModel->pager;
        return view('admin/pages/manage_users', $this->data);
    }
    public function assignRole()
    {
        $user_id = $this->request->getVar('user_id');
        $role = $this->request->getVar('role');
        $session = \Config\Services::session();
      
        $res = $this->userModel->update($user_id, ['role'=>$role]);
        if($res) {
            $session->setFlashdata('success', lang('Admin.role_assign_success'));
        } else {
            $session->setFlashdata('error', lang('Admin.role_assign_failure'));
        }
        return redirect()->back();
    }
    public function changePassword($id)
    {
        $this->data['page_title'] = lang('Admin.change_password');
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
        $this->data['breadcrumbs'][] = ['name' =>lang('Admin.change_password') , 'url' => ''];
        $userModel = New UserModel();
        $user = $userModel->getUserShortInfo($id);
        if(empty($user))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['user'] = $user;
        return view('admin/pages/change_password', $this->data);
    }
    public function updatePassword($id)
    {
        if(IS_DEMO)
        {
            $session = \Config\Services::session();
            $session->setFlashdata('error', 'Password Changed not available in demo');
            return redirect('admin/users');
        }
        $rules = [
			'password'     => 'required|min_length[8]',
			'confirm_password' => 'required|matches[password]',
		];

        $userModel = New UserModel();
		// Run validation
		if (!$this->validate($rules)) {

			$this->data['validation'] = $this->validator->getErrors();
			$this->data['page_title'] = "Change Password";
            $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
            $this->data['breadcrumbs'][] = ['name' => 'Change Password', 'url' => ''];
            
            $user = $userModel->getUserShortInfo($id);
            if(empty($user))
            {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }
            $this->data['user'] = $user;
            return view('admin/pages/change_password', $this->data);
        }
        $session = \Config\Services::session();
        $password= $this->request->getVar('password');
        $newEncryptedPassword = password_hash($password, PASSWORD_ARGON2ID);
        $userModel->update($id,['password'=>$newEncryptedPassword]);
        $session->setFlashdata('success', 'Password Changed successfully');
        return redirect('admin/users');
    }
    public function changeAdminPassword()
    {
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
		$this->data['page_title'] = lang('Admin.change_password');
        $this->data['breadcrumbs'][] = ['name' =>lang('Admin.change_password') , 'url' => ''];
        $userModel = New UserModel();
        $user = $userModel->getUserShortInfo(getCurrentUser()['id']);
        if(empty($user))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['user'] = $user;
        return view('admin/pages/change_admin_password', $this->data);
    
    }
    public function addNewAdmin()
    {
        $this->data['js_files'] = ['/assets/js/jquery.validate.min.js'];
		$this->data['page_title'] = lang('Admin.add_new_admin');
        $this->data['breadcrumbs'][] = ['name' =>lang('Admin.add_new_admin') , 'url' => ''];
        $userModel = New UserModel();
        $user = $userModel->getUserShortInfo(getCurrentUser()['id']);
        if(empty($user))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $this->data['user'] = $user;
        return view('admin/pages/users/adduser', $this->data);
    }
}
