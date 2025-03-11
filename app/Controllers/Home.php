<?php
 namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\Page;
 use App\Models\UserModel;
 use CodeIgniter\API\ResponseTrait;
 use App\Controllers\BaseController;

class Home extends BaseController
{
	use ResponseTrait;

	 public function __construct()
    {
		parent::__construct();
		
    }

	public function index(){
		$user = getCurrentUser();
        
        if(!is_profile_completed($user))
        {
             return redirect('start');
        }
		$this->data['js_files'] = ['js/posts.js',
									'js/post_plugins.js',
									'vendor/imagepopup/js/lightbox.min.js',
								];

		$this->data['css_files'] = ['css/posts.css',
									'css/posts_plugins.css',
									'vendor/imagepopup/css/lightbox.min.css'
									];
		
		if(get_setting('directory_landing_page')=='home') {
			echo load_view('newsfeed',$this->data);
		} else if(empty(getCurrentUser())){
			return redirect('login');
		}
		// echo load_view('newsfeed',$this->data);
	}

	public function setLanguage($language)
    {
        // Ensure the language exists in the available languages
        $availableLanguages = get_available_languages();

        // Check if the selected language is valid
        if (in_array($language, array_keys($availableLanguages))) {
            // Set the language in session
            session()->set('lang', $language);

            // Redirect back to the previous page or home
            return redirect()->back()->with('message', 'Language updated successfully');
        }

        // If the language is not valid, return with an error
        return redirect()->back()->with('error', 'Invalid language selected');
    }

	public function savedpost()
    {
        $this->data['js_files'] = ['js/posts.js',
									'js/post_plugins.js',
									'vendor/imagepopup/js/lightbox.min.js',
								];

		$this->data['css_files'] = ['css/posts.css',
									'css/posts_plugins.css',
									'vendor/imagepopup/css/lightbox.min.css'
									];
        echo load_view('pages/saved_posts', $this->data);   

    }

	public function updates()
	{
		$user_id = getCurrentUser()['id'];
		$responseData = [];
		$notificationModel = New NotificationModel();
		$responseData['unseen_notifications'] = $notificationModel->where('to_user_id',$user_id)->where('seen',0)->countAllResults();

		return $this->respond([
			'code' => '200',
			'message' => 'Success',
			'data' => $responseData
		], 200);


	}

	public function videoTimeline()
	{
		$this->data['js_files'] = ['js/posts.js',
									'js/post_plugins.js',
									'vendor/imagepopup/js/lightbox.min.js',
								];

		$this->data['css_files'] = ['css/posts.css',
									'css/posts_plugins.css',
									'vendor/imagepopup/css/lightbox.min.css'
									];
		
		
		echo load_view('videoTimeline',$this->data);
		

		//echo load_view('newsfeed',$this->data);
	}

	public function savedPosts()
	{
		$this->data['js_files'] = ['js/posts.js',
									'js/post_plugins.js',
									'vendor/imagepopup/js/lightbox.min.js',
								];

		$this->data['css_files'] = ['css/posts.css',
									'css/posts_plugins.css',
									'vendor/imagepopup/css/lightbox.min.css'
									];
		
		
		echo load_view('videoTimeline',$this->data);
		

		//echo load_view('newsfeed',$this->data);
	}
	
	// complete profile
	public function start()
	{
		$this->data['css_files'] = ['css/welcome.css'];
		
		$this->data['is_full_layout'] =1;
		$userModel = New UserModel;
		$user = getCurrentUser();
		$this->data['userdata'] = $userModel->select(['phone','twitter','instagram','facebook','date_of_birth','youtube','linkedin','phone','first_name','last_name','cover','avatar','gender'])->where('id',$user['id'])->first();
		echo load_view('pages/welcome/start',$this->data);
	}


	public function myGroups()
	{
		echo load_view('my-groups',$this->data);
	}


	public function login()
	{
		
		echo load_view('login');
		
	}

	public function js_language()
	{
		
		header('Content-Type: application/javascript');
		echo load_view('lang');
		
	}



	public function access_denied(){
		return view('errors/html/access_denied'); 
	}
	// public function activateAccount()
	// {
	// 	return view('emails/activateaccount'); 
	// }

	//--------------------------------------------------------------------

}
