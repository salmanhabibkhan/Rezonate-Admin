<?php

namespace App\Controllers;

use DateTime;

use Google_Client;
use \Firebase\JWT\JWT;
use GuzzleHttp\Client;
use App\Models\UserModel;
use Hybridauth\Hybridauth;
use CodeIgniter\Files\File;
use App\Libraries\AuthLibrary;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use Hybridauth\Exception\Exception;


class Auth extends BaseController
{

	use ResponseTrait;

	private  $AuthModel;
	private  $Session;
	private  $Auth;
	private  $config;
	private  $session;
	private  $userModel;
	private  $db;

	public function __construct()
	{
		$this->session = \Config\Services::session();

		$this->Session = session();
		$this->Auth = new AuthLibrary;
		$this->config = config('Auth');
		$this->userModel = new UserModel();
		$this->db = \Config\Database::connect();
		require_once APPPATH . 'Config/Autoload.php';
	}

	public function index()
	{

		//return redirect()->to('/login');
	}

	public function login()
	{
		$auth = new AuthLibrary;
		// Check if cookie is set
		$auth->checkCookie();

		// If it's a POST request, process the login, else show the login view
		if ($this->request->is('post')) {

			if (get_setting('chck-reCaptcha') == '1') {

				// Step 1: Verify reCAPTCHA first
				$recaptchaResponse = $this->request->getVar('g-recaptcha-response');
				// $secretKey = '6Ldq564pAAAAAJdlXig9K53C0pmrqCIQ684a-9w9';//TODO: replace this with settings recaptcha secret key

				$client = \Config\Services::curlrequest();
				$response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
					'form_params' => [
						'secret' => get_setting('recaptcha_secret_key'),
						'response' => $recaptchaResponse,
						'remoteip' => $this->request->getIPAddress()
					]
				]);

				$result = json_decode($response->getBody());

				if (!$result->success) {
					// If reCAPTCHA verification fails, set an error message and reload the login view
					$this->session->setFlashdata('msg', 'reCAPTCHA verification failed. Please try again.');
					return load_view('auth/login');
				}
			}
			$userModel = new UserModel;
			$email = $this->request->getVar('email');
			$user = $userModel->where('email', $email)->first();
			if (!empty($user) && $user['is_imported'] == 1) {
				$this->Auth->ForgotPassword($email);
				$this->Session->setFlashData('success', lang('Auth.resetSent'));
				return load_view('auth/login');
			}

			// Define validation rules and error messages
			$rules = [
				'email' => [
					'label' => lang('Auth.email_required'),
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => lang('Auth.email_required'),
						'valid_email' => lang('Auth.email_invalid'),
					],
				],
				'password' => [
					'label' => lang('Auth.password_required'),
					'rules' => 'required|min_length[6]|max_length[255]|validateUser[email,password]',
					'errors' => [
						'required' => lang('Auth.password_required'),
						'min_length' => lang('Auth.password_min_length'),
						'validateUser' => lang('Auth.login_failed'),
					],
				],
			];

			if (!$this->validate($rules, )) {
				// Log failed login attempt
				$auth->loginlogFail($this->request->getVar('email'));

				// Set flashdata message
				$this->session->setFlashdata(
					'msg',
					$auth->errors(implode("<br/>", $this->validator->getErrors()))
				);

				// Load the login view
				return load_view('auth/login');
			} else {
				// Login successful, get email and remember me from POST data
				$email = $this->request->getVar('email');
				$rememberMe = $this->request->getVar('rememberme');

				// Attempt to login the user 
				if ($auth->Loginuser($email, $rememberMe)) {
					// Redirect on successful login

					$user_id = $this->Session->get('id');
					$userModel = new UserModel;
					$user = $userModel->select('is_profile_complete')->where('id', $user_id)->first();
					check_purchase_code();
					if ($user['is_profile_complete'] == 0) {
						return redirect()->to('start');
					} else {
						return redirect()->to($auth->autoRedirect());
					}
				} else {
					// Set flashdata message for failed login
					$this->session->setFlashdata('msg', $auth->errors(lang('Auth.wrong_credentials')));
                	return load_view('auth/login');
				}
			}
		} else {
			// Show the login view for non-POST requests
			check_purchase_code();
			return load_view('auth/login');
		}
	}

	public function Apilogin()
	{
		$db = \config\Database::connect();

		$this->Auth->checkCookie();

		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->is('post')) {

			//SET RULES
			$rules = [
				'email' => [
					'label' => lang('Api.email_required'),
					'rules' => 'required|valid_email',
					'errors' => [
						'required' => lang('Api.email_required'),
						'valid_email' => lang('Api.email_invalid'),
					],
				],
				'password' => [
					'label' => lang('Api.password_required'),
					'rules' => 'required|min_length[6]|max_length[255]|validateUser[email,password]',
					'errors' => [
						'required' => lang('Api.password_required'),
						'min_length' => lang('Api.password_min_length'),
						'validateUser' => lang('Api.email_password_mismatch'),
					],
				],
			];
	
			if (!$this->validate($rules)) {
				$this->Auth->loginlogFail($this->request->getVar('email'));
				$errors = $this->validator->getErrors();
				$firstError = reset($errors);
				return $this->fail($firstError, 409);
			}else {
				// GET EMAIL & REMEMBER ME FROM POST
				$email = $this->request->getVar('email');

				$rememberMe = $this->request->getVar('rememberme');

				// PASS TO LIBRARY

				$userModel  =  new UserModel;
				if (!empty($userModel->where('email', $email)->first())) {


					$response = $this->Auth->Loginuser($email, $rememberMe);
					
					if ($response == 0) {
						$message['error'] = lang('Api.account_verification');
							return $this->respond([
								'status' => 409,
								'error' => '409',
								'messages' => $message,
							], 200);
					}
					if ($response) {

						$userModel  =  new UserModel;

						$device_id = $this->request->getVar('device_id');
						$device_type = $this->request->getVar('device_type');
						$device_model = $this->request->getVar('device_model');
						$lat = $this->request->getVar('lat');
						$lon = $this->request->getVar('lon');
						$devicedata = [
							'device_id' => $device_id,
							'device_type' => $device_type,
							'device_model' => $device_model,
						];
						$userdata = [
							'device_id' => $device_id,
							'device_type' => $device_type,
							'device_model' => $device_model,
							'lat' => $lat,
							'lon' => $lon
						];

						$userModel->update($response['id'], $userdata);
						$devicedata['session_id'] = session_id();
						$devicedata['user_id'] = $response['id'];
						$devicedata['created_at'] = date('Y-m-d H:i:s');
						$devicedata['ip_address'] = $this->request->getIPAddress();

						$token = getSignedJWTForUser($response['email'], $response['id']);
						$devicedata['token'] = $token;
						$userlocation = [
							'user_id' => $response['id'],
							'lat' => $lat,
							'lon' => $lon
						];
						$db->table('user_location')->insert($userlocation);
						$db->table('app_sessions')->insert($devicedata);
						return $this->respond([
							'status' => 200,
							'message' => 'Login Successfully',
							'token' => $token,
							'user_id' => $response['id']
						], 200);
					} else {
						$errors = $this->validator->getErrors();
						$firstError = reset($errors);
						return $this->fail($firstError, 409);
					}
				} else {

					$message['error'] = "Email or Password do not match";
					return $this->respond([
						'status' => '409',
						'error' => '409',
						'messages' => $message
					], 409);
				}
			}
		}
	}

	public function WebgoogleLogin()
	{
		// Define Hybridauth configuration
		$config = [
			'callback' => base_url('google-login/callback'),
			'providers' => [
				'Google' => [
					'enabled' => true,
					'keys' => [
						'id' => 'YOUR_CLIENT_ID',
						'secret' => 'YOUR_CLIENT_SECRET',
					],
				],
			],
		];

		// Initialize Hybridauth
		$hybridauth = new Hybridauth($config);

		// Get Google adapter and authenticate
		$adapter = $hybridauth->getAdapter('Google');
		$adapter->authenticate();

		// Get user profile from Google
		$userProfile = $adapter->getUserProfile();

		// Extract user information
		$googleId = $userProfile->identifier;
		$email = $userProfile->email;
		$name = $userProfile->displayName;
		$avatar = $userProfile->photoURL;

		// Load UserModel
		$userModel = new UserModel();

		// Check if user exists in the database
		$user = $userModel->where('email', $email)->first();

		if ($user) {
			// User exists, log them in
			return $this->loginUser($user);
		} else {
			// User does not exist, register them
			$newUser = [
				'first_name' => $name,
				'email' => $email,
				'google_id' => $googleId,
				'avatar' => $avatar,
				'last_seen' => date('Y-m-d H:i:s')
			];
			$userId = $userModel->insert($newUser);
			$user = $userModel->find($userId);

			// Log the new user in
			return $this->loginUser($user);
		}
	}

	public function apigooglelogin()
	{



		$token = $this->request->getPost('token'); // Google token sent from the client

		if (!$token) {
			return $this->response->setJSON(['status' => 'error', 'message' => 'Token is missing']);
		}

		try {

			$Hybridconfig = new \Config\HybridAuth();
			$hybridauth = new Hybridauth($Hybridconfig->config);

			// Set the provider with token
			$adapter = $hybridauth->getAdapter('Google');

			$adapter->setAccessToken(['access_token' => $token]);
		

			// Authenticate and get user profile
			$userProfile = $adapter->getUserProfile();
		
			$email = $userProfile->email;
			$name = $userProfile->displayName;
			$profilePicture = $userProfile->photoURL;
			$imageContent = file_get_contents($profilePicture);
			$savePath = 'uploads/social_login_profile/'.date("Y").'/'.date("m");
			$fileName = $name.'.jpg';

			// Create the directory if it doesn't exist
			if (!is_dir($savePath)) {
				mkdir($savePath, 0755, true);
			}

			// Save the image to the server
			file_put_contents($savePath . $fileName, $imageContent);
			// if (file_exists($savePath . $fileName)) {
			// 	// echo "Image saved successfully to: " . $savePath . $fileName . "<br>";	
			// } 
			// $imgsrc =  base_url().$savePath.''.$fileName;

			$fileObject = new File($savePath . $fileName);

			// Pass the File object to the storeMedia function
			$imagesource = storeMedia($fileObject, 'avatar');
		
			$userModel = new UserModel();
			$user = $userModel->where('email', $email)->first();

			if ($user) {
				// User exists, log them in
				$this->session->set('user_id', $user['id']);
				$this->session->set('user_email', $user['email']);
				$this->session->set('user_name', $user['username']);
				$this->session->set('user_profile_picture', $user['avatar']);

				return $this->loginUser($user);
			} else {
				// User does not exist, register them
				$newUser = [
					'email' => $email,
					'username' => $name,
					'avatar' => $imagesource,
					'created_at' => date('Y-m-d H:i:s'),
					'device_type'=>$this->request->getVar('device_type')??'',
					'device_id'=>$this->request->getVar('device_id')??'',	
				];
				$userModel->save($newUser);
				$userId = $userModel->getInsertID();
				// $user = $userModel->find($userId);
				
				// Log in the newly registered user
				$this->session->set('user_id', $userId);
				$this->session->set('user_email', $email);
				$this->session->set('user_name', $name);
				$this->session->set('user_profile_picture', $profilePicture);

				return $this->loginUser($newUser);
			}
		} catch (Exception $e) {
			return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}


	public function facebookLogin()
	{
		// Validation rules for the incoming request
		$rules = [
			'token' => 'required',
			'device_type' => 'required',
			'device_id' => 'required',
			'lat' => 'decimal',
			'lon' => 'decimal'
		];

		// Run the validation
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			return $this->fail($errors, 400);
		}

		// Get the validated inputs
		$token = $this->request->getPost('token'); // Facebook token sent from the client

		try {
			$Hybridconfig = new \Config\HybridAuth();
			$hybridauth = new Hybridauth($Hybridconfig->config);
			// Set the provider with token
			$adapter = $hybridauth->getAdapter('Facebook');
			$adapter->setAccessToken(['access_token' => $token]);
			$userProfile = $adapter->getUserProfile();
		
			$clean_url = str_replace("http://", "", base_url());
			
			$adapter->disconnect();
			if(!empty($userProfile))
			{
				$firstName = $userProfile->firstName;
				$lastName = $userProfile->lastName;
				$avatar = $userProfile->photoURL;
				$email = (empty($userProfile->emailVerified))? $userProfile->emailVerified:$userProfile->identifier."@".$clean_url;
				$user = $this->userModel->where('email', $email)->first();

			if ($user) {
				// User exists, log them in
				return $this->loginUser($user);
			} else {
				// User does not exist, register them
				$newUser = [
					'first_name' => $firstName,
					'last_name' => $lastName,
					'email' => $email,
					'avatar' => $avatar,
					'username'=>$firstName."".$lastName,
					'device_type' => $this->request->getVar('device_type'),
					'device_id' => $this->request->getVar('device_id'),
					'last_seen' => date('Y-m-d H:i:s')
				];

				// Register the new user
				$userId = $this->userModel->insert($newUser);
				$user = $this->userModel->find($userId);
				return $this->loginUser($user);
			}
				
			}

			// Extract user details from Facebook profile
			

			// Check if the user exists in the database
			
		} catch (Exception $e) {
			return $this->fail($e->getMessage(), 500);
		}
	}

	public function apiSocialLogin()
	{
		$rules = [
			'token' => 'required',
			'device_type' => 'required',
			'device_id' => 'required',
			'lat' => 'required|decimal',
			'lon' => 'required|decimal',
			'provider'=>'required'
		];

		// Run the validation
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			return $this->fail($errors, 400);
		}
		$token = $this->request->getVar('token');
		$provider = $this->request->getVar('provider');
		if($provider=='Google')
		{
			try {

				$Hybridconfig = new \Config\HybridAuth();
				$hybridauth = new Hybridauth($Hybridconfig->config);
	
				// Set the provider with token
				$adapter = $hybridauth->getAdapter('Google');
	
				$adapter->setAccessToken(['access_token' => $token]);
			
	
				// Authenticate and get user profile
				$userProfile = $adapter->getUserProfile();
			
				
				$email = $userProfile->email;
				$username =  strtok($email, "@");
				$name = $userProfile->displayName;
				$profilePicture = $userProfile->photoURL;
				$imageContent = file_get_contents($profilePicture);
				$savePath = 'uploads/social_login_profile/'.date("Y").'/'.date("m");
				$fileName = $name.'.jpg';
	
				// Create the directory if it doesn't exist
				if (!is_dir($savePath)) {
					mkdir($savePath, 0755, true);
				}
				file_put_contents($savePath . $fileName, $imageContent);
				$fileObject = new File($savePath . $fileName);
	
				$imagesource = storeMedia($fileObject, 'avatar');
				$userModel = new UserModel();
				$user = $userModel->where('email', $email)->first();
	
				if ($user) {
					// User exists, log them in
					$this->session->set('user_id', $user['id']);
					$this->session->set('user_email', $user['email']);
					$this->session->set('user_name', $user['username']);
					$this->session->set('user_profile_picture', $user['avatar']);
	
					return $this->loginUser($user);
				} else {
					// User does not exist, register them
					$newUser = [
						'email' => $email,
						'first_name'=>strtolower($userProfile->firstName)??'',
						'last_name'=>strtolower($userProfile->lastName)??'',
						'username' => strtolower($username),
						'avatar' => $imagesource,
						'created_at' => date('Y-m-d H:i:s'),
						'device_type'=>$this->request->getVar('device_type')??'',
						'device_id'=>$this->request->getVar('device_id')??'',
						'activated'=>1
						
					];
					$userModel->save($newUser);
					$userId = $userModel->getInsertID();
					$user = $userModel->find($userId);
					
					// Log in the newly registered user
					$this->session->set('user_id', $userId);
					$this->session->set('user_email', $email);
					$this->session->set('user_name', $name);
					$this->session->set('user_profile_picture', $profilePicture);
	
					return $this->loginUser($user);
				}
			} catch (Exception $e) {
				return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
			}
		}
		elseif($provider=='facebook')
		{
			try {
				$Hybridconfig = new \Config\HybridAuth();
				$hybridauth = new Hybridauth($Hybridconfig->config);
				// Set the provider with token
				$adapter = $hybridauth->getAdapter('Facebook');
				$adapter->setAccessToken(['access_token' => $token]);
				$userProfile = $adapter->getUserProfile();
				
				$clean_url = str_replace("http://", "", base_url());
				
				$adapter->disconnect();
				if(!empty($userProfile))
				{
					$firstName = $userProfile->firstName;
					$lastName = $userProfile->lastName;
					$username = $firstName.''.$lastName;
					$email = (!empty($userProfile->emailVerified))? $userProfile->emailVerified:$userProfile->identifier."@".$clean_url;
					$user = $this->userModel->where('email', $email)->first();
					$getusername = strtok($email,'@');
					$duplicateusername = $this->userModel->where('username', $getusername)->first();
					$username = empty($duplicateusername)?$getusername:$getusername.rand(0,9);
					$avatar = $userProfile->photoURL;
					$imageContent = file_get_contents($avatar);
					$savePath = 'uploads/social_login_profile/'.date("Y").'/'.date("m");
					$fileName = strtolower($username).'.jpg';
					
				// Create the directory if it doesn't exist
					if (!is_dir($savePath)) {
						mkdir($savePath, 0755, true);
					}
					file_put_contents($savePath . $fileName, $imageContent);
					$fileObject = new File($savePath . $fileName);
		
					$imagesource = storeMedia($fileObject, 'avatar');
	
					if ($user) {
						// User exists, log them in
						return $this->loginUser($user);
					} else {
						// User does not exist, register them
						$newUser = [
							'first_name' => $firstName,
							'last_name' => $lastName,
							'email' => $email,
							'avatar' => $imagesource,
							'username'=>$username,
							'device_type' => $this->request->getVar('device_type'),
							'device_id' => $this->request->getVar('device_id'),
							'last_seen' => date('Y-m-d H:i:s'),
							'activated'=>1
						];
		
						// Register the new user
						$userId = $this->userModel->insert($newUser);
						$user = $this->userModel->find($userId);
						return $this->loginUser($user);
					}
					
				}
	
				// Extract user details from Facebook profile
				
	
				// Check if the user exists in the database
				
			} catch (Exception $e) {
				return $this->fail($e->getMessage(), 500);
			}
		}
		elseif($provider=='linkedin')
		{
			$accessToken = $this->request->getVar('token');
			$url = 'https://api.linkedin.com/v2/userinfo';

			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"Authorization: Bearer $accessToken",
			]);

			$response = curl_exec($ch);

			if(curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			} else {
				$userProfile = json_decode($response);
				$email = $userProfile->email;
				$name = strtok($email, "@");
				$username1 = str_replace('.', '', $name);
				$userModel = new UserModel();
				$user = $userModel->where('email', $email)->first();
				$duplicateusername = $userModel->where('username', $username1)->first();
				$username = empty($duplicateusername)?$username1:$username1.rand(0,9);
				if(!empty($user))
				{
					return $this->loginUser($user);
				}

				$profilePicture = $userProfile->picture;
					$imageContent = file_get_contents($profilePicture);

					$savePath = 'uploads/social_login_profile/'.date("Y").'/'.date("m").'/';  // Add the trailing slash
					$fileName = $name.'.jpg';

					// Create the directory if it doesn't exist
					if (!is_dir($savePath)) {
						if (!mkdir($savePath, 0755, true)) {
							die('Failed to create folders...');  // Add error handling in case directory creation fails
						}
					}

					// Save the file
					if (file_put_contents($savePath . $fileName, $imageContent) === false) {
						die('Failed to save the image...');  // Add error handling in case the file saving fails
					}

					
				$fileObject = new File($savePath . $fileName);
				
				$imagesource = storeMedia($fileObject, 'avatar');
				
				$newUser = [
					'email' => $email,
					'first_name'=>strtolower($userProfile->given_name)??'',
					'last_name'=>strtolower($userProfile->family_name)??'',
					'username' => strtolower($username),
					'avatar' => $imagesource,
					'created_at' => date('Y-m-d H:i:s'),
					'device_type'=>$this->request->getVar('device_type')??'',
					'device_id'=>$this->request->getVar('device_id')??'',
					'activated'=>1
					
				];
				$userModel->save($newUser);
				$userId = $userModel->getInsertID();
				$user = $userModel->find($userId);
				return $this->loginUser($user);
			}
		}
	}

	public function twitterLogin()
	{
		// Validation rules for the incoming request
		$rules = [
			'token' => 'required',
			'token_secret' => 'required', // Twitter requires both token and token secret
			'device_type' => 'required',
			'device_id' => 'required',
			'lat' => 'required|decimal',
			'lon' => 'required|decimal'
		];

		// Run the validation
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			return $this->fail($errors, 400);
		}

		// Get the validated inputs
		$token = $this->request->getPost('token'); // Twitter token sent from the client
		$tokenSecret = $this->request->getPost('token_secret'); // Twitter token secret sent from the client

		try {
			$Hybridconfig = new \Config\HybridAuth();
			$hybridauth = new Hybridauth($Hybridconfig->config);

			$adapter = $hybridauth->getAdapter('Twitter');
			$adapter->setAccessToken(['oauth_token' => $token, 'oauth_token_secret' => $tokenSecret]);
			$userProfile = $adapter->getUserProfile();
			$adapter->disconnect();

			
			$email = $userProfile->email ?? null; 
			$firstName = $userProfile->firstName;
			$lastName = $userProfile->lastName;
			$avatar = $userProfile->photoURL;

			// Handle the case where Twitter doesn't provide an email
			if (is_null($email)) {
				return $this->fail("Twitter did not provide an email address. Registration is not possible without an email.", 400);
			}

			// Check if the user exists in the database
			$user = $this->userModel->where('email', $email)->first();

			if ($user) {
				// User exists, log them in
				return $this->loginUser($user);
			} else {
				// User does not exist, register them
				$newUser = [
					'first_name' => $firstName,
					'last_name' => $lastName,
					'email' => $email,
					'twitter_id' => $userProfile->identifier,
					'avatar' => $avatar,
					'device_type' => $this->request->getVar('device_type'),
					'device_id' => $this->request->getVar('device_id'),
					'lat' => $this->request->getVar('lat'),
					'lon' => $this->request->getVar('lon'),
					'last_seen' => date('Y-m-d H:i:s')
				];

				// Register the new user
				$userId = $this->userModel->insert($newUser);
				$user = $this->userModel->find($userId);
				return $this->loginUser($user);
			}
		} catch (Exception $e) {
			return $this->fail($e->getMessage(), 500);
		}
	}

	public function linkedinLogin()
	{
		$accessToken = $this->request->getVar('token');
		$url = 'https://api.linkedin.com/v2/userinfo';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer $accessToken",
		]);

		$response = curl_exec($ch);

		if(curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		} else {
			$userProfile = json_decode($response);
			$email = $userProfile->email;
			$name = strtok($email, "@");
			$username = str_replace('.', '', $name);
			$userModel = new UserModel();
			$user = $userModel->where('email', $email)->first();
			
			if(!empty($user))
			{
				return $this->loginUser($user);
			}

			$profilePicture = $userProfile->picture;
			$imageContent = file_get_contents($profilePicture);
			$savePath = 'uploads/social_login_profile/'.date("Y").'/'.date("m");
			$fileName = $name.'.jpg';

			// Create the directory if it doesn't exist
			if (!is_dir($savePath)) {
				mkdir($savePath, 0755, true);
			}
			file_put_contents($savePath . $fileName, $imageContent);
			$fileObject = new File($savePath . $fileName);
			$imagesource = storeMedia($fileObject, 'avatar');
			$newUser = [
				'email' => $email,
				'first_name'=>strtolower($userProfile->given_name)??'',
				'last_name'=>strtolower($userProfile->family_name)??'',
				'username' => strtolower($username),
				'avatar' => $imagesource,
				'created_at' => date('Y-m-d H:i:s'),
				'device_type'=>$this->request->getVar('device_type')??'',
				'device_id'=>$this->request->getVar('device_id')??'',
				'activated'=>1
				
			];
			$userModel->save($newUser);
			$userId = $userModel->getInsertID();
			$user = $userModel->find($userId);
			return $this->loginUser($user);
			
		}

		curl_close($ch);
	}


	private function loginUser($user)
	{
		$deviceData = [
			'device_id' => $this->request->getVar('device_id')??'',
			'device_type' => $this->request->getVar('device_type')??'',
			'device_model' => $this->request->getVar('device_model')??'',
			'user_id' => $user['id'],
			'session_id' => session_id(),
			'created_at' => date('Y-m-d H:i:s'),
			'ip_address' => $this->request->getIPAddress(),
		];

		$token = getSignedJWTForUser($user['email'], $user['id']);
		$deviceData['token'] = $token;
		
		// Update user device data
		$this->userModel->update($user['id'], [
			'device_id' => $deviceData['device_id'],
			'device_type' => $deviceData['device_type'],
			'device_model' => $deviceData['device_model'],
			'lat' =>  $this->request->getVar('lat')??'',
			'lon' => $this->request->getVar('lon')??''
		]);

		// Insert session data
		$this->db->table('app_sessions')->insert($deviceData);

		// Save user location
		$this->db->table('user_location')->insert([
			'user_id' => $user['id'],
			'lat' =>  $this->request->getVar('lat')??'',
			'lon' => $this->request->getVar('lon')??''
		]);

		return $this->respond([
			'status' => 200,
			'message' => lang('Api.login_success'),
			'token' => $token,
			'user_id' => $user['id']
		], 200);
	}

	private function generateJWT($email, $userId)
	{
		 $key = "LinkON"; // Your JWT secret key
		
		$payload = [
			'iat' => time(),
			'exp' => time() + 3600, // 1 hour expiration
			'email' => $email,
			'user_id' => $userId,
		];

		return JWT::encode($payload, $key, 'HS256');
	}

	public function registerApi()
	{

        $db = \Config\Database::connect();
        $db_prefix = $db->DBPrefix;
		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->is('post')) {

			// PREVENT REGISTRATION ATTEMPT WHEN ALLOW-REGISTER IS TURNED OFF
			// if ($this->config->allowRegister === false) {
			// 	return redirect()->to('/register');
			// }

			// SET RULES
			$rules = [
				'email' => [
					'label' => lang('Api.email_required'),
					'rules' => 'required|valid_email|is_unique[' . $db_prefix . 'users.email]',
					'errors' => [
						'required' => lang('Api.email_required'),
						'valid_email' => lang('Api.email_invalid'),
						'is_unique' => lang('Api.email_unique'),
					],
				],
				'password' => [
					'label' => lang('Api.password_required'),
					'rules' => 'required|min_length[6]|max_length[255]',
					'errors' => [
						'required' => lang('Api.password_required'),
						'min_length' => lang('Api.password_min_length'),
					],
				],
				'password_confirm' => [
					'label' => lang('Api.password_confirm_mismatch'),
					'rules' => 'matches[password]',
					'errors' => [
						'matches' => lang('Api.password_confirm_mismatch'),
					],
				],
				// 'date_of_birth' => [
				// 	'label' => lang('Api.date_of_birth_required'),
				// 	'rules' => 'required',
				// 	'errors' => [
				// 		'required' => lang('Api.date_of_birth_required'),
				// 	],
				// ],
				'gender' => [
					'label' => lang('Api.gender_required'),
					'rules' => 'required',
					'errors' => [
						'required' => lang('Api.gender_required'),
					],
				],
			];
	
			// VALIDATE RULES
			if (!$this->validate($rules)) {
				$errors = $this->validator->getErrors();
				$firstError = reset($errors);
	
				return $this->fail($firstError, 409);
			}else {
				// SET USER DATA

				$randNum = rand(1, 4);
				$avatar = "uploads/placeholder/avatar-" . $randNum . ".png";
				$gender = $this->request->getVar('gender');
				if (!empty($gender) && $gender == "Female") {
					$avatar = 'uploads/placeholder/avatar-f1.png';
				}

				$email = $this->request->getVar('email');
				$usernameparts = explode('@', $email);
				$userModel = New UserModel();
				$getuserdata= $userModel->where('username',$usernameparts[0])->first();
				$username = empty($getuserdata)?$usernameparts[0]: $getuserdata['username'].rand(100,999); 
				
				// if (empty($username)) {
					// 	$username = $this->generateUniqueUsername($this->request->getVar('email'), $this->request->getVar('first_name'), $this->request->getVar('last_name'));
					// } else {
						// 	$username = strtolower($username);
						// }
				$fullname = $this->request->getVar('full_name');
				$fullname_lastName = '';
				if(!empty($fullname))
				{
					$name_parts = explode(' ',$this->request->getVar('full_name') );
					$fullname_lastName = count($name_parts) > 1 ? implode(' ', array_slice($name_parts, 1)) : '';
				}
				$lastname =	$this->request->getVar('last_name')??  $fullname_lastName;

				$now = new DateTime();
				$userData = [
					'first_name' => $this->request->getVar('first_name')??$name_parts[0],
					'last_name' =>$lastname,
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
					'username' => $username,
					'avatar' => $avatar,
					'gender' => $this->request->getVar('gender'),
					'device_id' => $this->request->getVar('device_id'),
					'device_type' => $this->request->getVar('device_type'),
					'date_of_birth' => $this->request->getVar('date_of_birth'),
					'last_seen' => $now->format('Y-m-d H:i:s')
				];

				// PASS TO LIBRARY
				$result = $this->Auth->RegisterUser($userData);

				// CHECK RESULT
				if ($result) {
					$message = lang('Api.registration_success');
					if (get_setting('chck-verify_email') == '1') {
						$message = lang('Api.account_verification');
					}
					return $this->respond(['status' => '200', 'message' => $message, 'data' => $result], 200);
				} else {
					$errors = $this->validator->getErrors();
					$firstError = reset($errors);
					return $this->fail($firstError, 409);
				}
			}
		}
	}

	private function generateUniqueUsername($email, $firstName, $lastName)
	{
		// Start with username from email
		$baseUsername = strtolower(substr($email, 0, strpos($email, '@')));
		$username = $baseUsername;
		$counter = 1;

		// First check for uniqueness of the base username
		if (!$this->isUniqueUsername($username)) {
			// If not unique, then try using a combination of email, first name, and last name
			$baseUsername = strtolower(substr($email, 0, strpos($email, '@')) . substr($firstName, 0, 1) . substr($lastName, 0, 1));
			$username = $baseUsername;

			// Check for uniqueness again, this time with the new base
			while (!$this->isUniqueUsername($username)) {
				$username = $baseUsername . $counter;
				$counter++;
			}
		}
		return $username;
	}

	public function isUniqueUsername($username)
	{
		$userModel  =  new UserModel;
		$query = $userModel->where('username', $username)->first();
		return $query === null;
	}

	public function register()
	{
	    $db = \Config\Database::connect();
        $db_prefix = $db->DBPrefix;

		// IF IT'S A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->is('post')) {

			// PREVENT REGISTRATION ATTEMPT WHEN ALLOW-REGISTER IS TURNED OFF
			if (get_setting('chck-user_registration') === 0) {
				return redirect()->to('/register');
			}


			// SET RULES
			$rules = [
				'first_name' => 'required|min_length[3]|max_length[25]',
				'last_name' => 'required|min_length[3]|max_length[25]',
				'email' => 'required|valid_email|is_unique[' . $db_prefix . 'users.email]',
				'password' => 'required|min_length[6]|max_length[255]',
				'password_confirm' => 'matches[password]',
				'gender' => 'required',
				'date_of_birth' => 'required'
			];

			//VALIDATE RULES
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
				return load_view('auth/register', $data);
			} else {
				// SET USER DATA

				$username = $this->request->getVar('username');
				if (empty($username)) {
					$username = $this->generateUniqueUsername($this->request->getVar('email'), $this->request->getVar('first_name'), $this->request->getVar('last_name'));
				} else {
					$username = strtolower($username);
				}

				$randNum = rand(1, 4);
				$avatar = "uploads/placeholder/avatar-" . $randNum . ".png";
				$gender = $this->request->getVar('gender');

				if (!empty($gender) && $gender == "female") {
					$avatar = 'uploads/placeholder/avatar-f1.png';
				}


				$userData = [
					'first_name' => ucwords($this->request->getVar('first_name')),
					'last_name' => ucwords($this->request->getVar('last_name')),
					'email' => $this->request->getVar('email'),
					'password' => $this->request->getVar('password'),
					'username' => $username,
					'avatar' => $avatar,
					'gender' => $this->request->getVar('gender'),
					'device_type' => "web",
					'date_of_birth' => $this->request->getVar('date_of_birth'),
				];

				// PASS TO LIBRARY
				$result = $this->Auth->RegisterUser($userData);

				// CHECK RESULT
				if ($result) {

					// Set flashdata message
					$this->session->setFlashdata(
						'success',
						"Registered successfully. Please log in your account to continue"
					);
					return redirect()->to('/login');
				} else {
					$data['error'] = 'Invalid Inputs';
					return load_view('auth/register', $data);
				}
			}
		}

		return load_view('auth/register');
	}


	/*
	|--------------------------------------------------------------------------
	| RESEND ACTIVATION EMAIL
	|--------------------------------------------------------------------------
	|
	| If user needs to resend activation email  
	|
	*/
	public function resendactivation($id)
	{


		// PASS TO LIBRARY
		$this->Auth->ResendActivation($id);


		return redirect()->to('/login');
	}


	/*
	|--------------------------------------------------------------------------
	| ACTIVATE USER
	|--------------------------------------------------------------------------
	|
	| Activate user account from email link 
	|
	*/
	public function activateUser($id, $token)
	{

		// PASS TO LIBRARY
		$this->Auth->activateuser($id, $token);

		return redirect()->to('/');
	}

	/*
	|--------------------------------------------------------------------------
	| REGISTER USER
	|--------------------------------------------------------------------------
	|
	| Get post data from profile.php view
	| Set and Validate rules
	| Save to DB
	| Set session data
	|
	*/
	public function profile()
	{

		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->is('post')) {

			// SET UP RULES
			$rules = [
				'first_name' => 'required|min_length[3]|max_length[25]',
				'last_name' => 'required|min_length[3]|max_length[25]',
				'email' => 'required|valid_email',
			];

			// SET MORE RULES IF PASSWORD IS BEING CHANGED
			if ($this->request->getPost('password') != '') {
				$rules['password'] = 'required|min_length[6]|max_length[255]';
				$rules['password_confirm'] = 'matches[password]';
			}

			// VALIDATE RULES
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				// SET USER DATA
				$user = [
					'id' => $this->Session->get('id'),
					'first_name' => $this->request->getVar('first_name'),
					'last_name' => $this->request->getVar('last_name'),
					'email' => $this->request->getVar('email'),
					'role'	=> $this->Session->get('role'),
				];

				// IF PASSWORD IS LEFT EMPTY DO NOT CHANGE IT
				if ($this->request->getPost('password') != '') {
					$user['password'] = $this->request->getVar('password');
				}

				// PASS TO LIBRARY
				$this->Auth->editProfile($user);

				return redirect()->to($this->Auth->autoRedirect() . '/profile');
			}
		}

		echo view('templates/header');
		echo view('profile');
		echo view('templates/footer');
	}



	/*
	|--------------------------------------------------------------------------
	| REGISTER USER
	|--------------------------------------------------------------------------
	|
	| Get post data from forgotpassword.php view
	| Set and Validate rules
	| Save to DB
	| Set session data
	|
	*/
	public function forgotPassword()
	{
		if ($this->request->is('post')) {

			// SET UP RULES
			$rules = [
				'email' => 'required|valid_email|validateExists[email]',
			];

			// SET UP ERRORS
			$errors = [
				'email' => [
					'validateExists' => lang('Auth.noUser'),
				]
			];

			// CHECK VALIDATION
			if (!$this->validate($rules, $errors)) {

				$data['validation'] = $this->validator;
			}

			// VALIDATED
			else {
				// PASS TO LIBRARY
				$this->Auth->ForgotPassword($this->request->getVar('email'));
			}
		}

		return load_view('auth/forgotpassword');
	}

	/*
	|--------------------------------------------------------------------------
	| RESET PASSWORD
	|--------------------------------------------------------------------------
	|
	| Takes the response from a a rest link from users reset email
	| Pass the user id and token to Library resetPassword();
	|
	*/
	public function resetPassword($id, $token)
	{
		// PASS TO LIBRARY
		$id = $this->Auth->resetPassword($id, $token);

		// REDIRECT PASSING USER ID TO UPDATE PASSWORD FORM
		$this->updatepassword($id);
	}

	/*
	|--------------------------------------------------------------------------
	| UPDATE PASSWORD
	|--------------------------------------------------------------------------
	|
	| Get post data from resetpassword.php view
	| Save new password to DB 
	|
	*/
	public function updatepassword($id)
	{
		// IF ITS A POST REQUEST DO YOUR STUFF ELSE SHOW VIEW
		if ($this->request->is('post')) {

			//SET RULES
			$rules = [
				'password' => 'required|min_length[6]|max_length[255]',
				'password_confirm' => 'matches[password]',
			];

			// VALIDATE RULES
			if (!$this->validate($rules)) {
				$data['validation'] = $this->validator;
			} else {

				// RULES PASSED
				$user = [
					'id' => $id,
					'password' => $this->request->getVar('password'),
					'reset_expire' => NULL, // RESET EXPIRY 
					'reset_token' => NULL, // CLEAR OLD TOKEN
					'is_imported' => 0
				];

				// PASS TO LIBRARY
				$this->Auth->updatepassword($user);

				return redirect()->to('/login');
			}
		}

		// SET USER ID TO PASS TO VIEW AS THERE IS NO SESSION DATA TO ACCESS
		$data = [
			'id' => $id,
		];

		// echo view('templates/header');
		// echo view('resetpassword', $data);
		// echo view('templates/footer');

		// Show the login view for non-POST requests
		echo load_view('auth/resetpassword', $data);
	}

	/*
	|--------------------------------------------------------------------------
	| LOG USER OUT
	|--------------------------------------------------------------------------
	|
	| Destroy session
	|
	*/
	public function logout()
	{
		$this->Auth->logout();

		return redirect()->to('/');
	}


	public function reset_password()
	{
		$rules = [
			'email' => 'required|valid_email',
		];
		if (!$this->validate($rules)) {
			$validationErrors = $this->validator->getErrors();
			return $this->respond([
				'status' => 200,
				'message' => 'Validation Error',
				'errors' => $validationErrors
			]);
		}
		$usermail = $this->request->getVar('email');
		$userModel = new UserModel();
		$userRecord = $userModel->where('email', $usermail)->first();

		if (empty($userRecord)) {
			return $this->respond([
				'status' => 404,
				'message' => 'Email not found',
			]);
		}
		$randomCode = rand(100000, 999999);
		$time = new DateTime();
		$now = $time->format('Y-m-d H:i:s');
		$code_expire = $time->modify('+1 day ');
		$expire_time = $code_expire->format('Y-m-d H:i:s');
		$data = [
			'reset_code' => $randomCode,
			'reset_code_expire' => $expire_time
		];
		$userModel->update($userRecord['id'], $data);

		// Prepare email content and options
		$subject = 'OTP to Recover the password';
		$message = "Your OTP to recover the password " . $randomCode;
		$options = []; // No additional options needed for this example

		// Send the email using the send_app_mail helper function
		if (send_app_mail($usermail, $subject, $message, $options)) {
			return $this->respond([
				'status' => 200,
				'message' => 'OTP is sent on your email address ',
			]);
		} else {
			// Handle email sending failure
			return $this->respond([
				'status' => 500,
				'message' => 'Failed to send OTP. Please try again later.',
			]);
		}
	}

	public function reset_password_confirm()
	{
		$rules = [
			'email' => 'required|valid_email',
			'reset_code' => 'required',
			'password' => 'required',
			'confirm_password' => 'required|matches[password]',
		];
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$firstError = reset($errors);
			return $this->respond([
				'code' => '400',
				'message' => $firstError,

			]);
		}
		$email = $this->request->getVar('email');
		$password = $this->request->getVar('password');
		$reset_code = $this->request->getVar('reset_code');
		$encryptedPasssword = password_hash($password, PASSWORD_ARGON2ID);
		$userModel = new UserModel();
		$user = $userModel->where('email', $email)->first();
		if (empty($user)) {
			return $this->respond([
				'code' => '400',
				'message' => 'Email not found'
			]);
		}
		$time = new DateTime();
		$now = $time->format('Y-m-d H:i:s');
		if ($reset_code != $user['reset_code']) {
			return $this->respond([
				'code' => '400',
				'message' => ' Code is invalid',
			]);
		}
		if ($now > $user['reset_code_expire']) {
			return $this->respond([
				'code' => '400',
				'message' => 'Your code is expire please enter email again to get new Code ',
			]);
		}
		$datatoupdate = [
			'password' => $encryptedPasssword,
			'reset_code' => null,
			'reset_code_expire' => null
		];
		$userModel->update($user['id'], $datatoupdate);
		return $this->respond([
			'code' => '200',
			'message' => 'Password Updated Successfully',
		]);
	}
	public function apilogout()
	{
		$request = request();
		$user = getCurrentUser();
		$userModel = new UserModel;
		$userModel->update($user['id'], ['device_id' => '', 'device_model' => '', 'device_type' => '']);

		$authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
		$token = str_replace('Bearer ', '', $authenticationHeader);
		$db = \Config\Database::connect();
		$query = $db->table('app_sessions')
			->where('token', $token)
			->get();

		if ($query->getResult()) {
			// Record found, delete it
			$db->table('app_sessions')
				->where('token', $token)
				->delete();

			return $this->response->setJSON([
				'code'    => 200,
				'message' => 'User Logout Successfully',
			], 200);
		}

		// Record not found

	}
	public function changePassword()
	{
		$rules = [
			'old_password'     => 'required',
			'new_password'     => 'required|min_length[8]',
			'confirm_password' => 'required|matches[new_password]',
		];


		// Run validation
		if (!$this->validate($rules)) {

			$errors = $this->validator->getErrors();
			$firstError = reset($errors);
			return $this->respond([
				'code' => '400',
				'message' => $firstError,
			]);
		}
		$userdata = getCurrentUser();
		$userModel = new UserModel;
		if (!isset($userdata['password'])) {
			$userdata = $userModel->find($userdata['id']);
		}

		$old_password = $this->request->getVar('old_password');
		$new_password = $this->request->getVar('new_password');

		if (!password_verify($old_password, $userdata['password'])) {
			return $this->respond([
				'code'    => '400',
				'message' => 'Old password not matched',
			]);
		}
		$newEncryptedPassword = password_hash($new_password, PASSWORD_ARGON2ID);
		$userModel = new UserModel;
		$datatoupdate = [
			'password' => $newEncryptedPassword,
		];
		$userModel->update($userdata['id'], $datatoupdate);
		return $this->respond([
			'code' => '200',
			'message' => 'Password updated Successfully',
		]);
	}



	public function sociallogin($provider)
	{

		$config = new \Config\HybridAuth();
		$hybridauth = new \Hybridauth\Hybridauth($config->config);
		$adapter = $hybridauth->authenticate($provider);
		print_r($adapter);
		die;
		$userProfile = $adapter->getUserProfile();

		echo '<pre>';
		print_r($userProfile);
		echo '</pre>';

		// Handle login, typically redirect or output a success message
	}

	public function callback()
	{
		// Handle the callback from the provider
	}
	public function checkEmail()
	{
		$rules = [
			'email' => 'required|valid_email',
		];
		if (!$this->validate($rules)) {
			$errors = $this->validator->getErrors();
			$firstError = reset($errors);
			return $this->respond([
				'code' => '400',
				'message' => $firstError,
			]);
		}
		$userModel = New UserModel();
		$email = $this->request->getVar('email');
		$user = $userModel->where('email',$email)->first();
		if(!empty($user))
		{
			return $this->respond([
				'code' => '200',
				'message' => 'Email already Exist',
				'data'=>true
			]);
		}
		return $this->respond([
			'code' => '200',
			'message' => '',
			'data'=>false
		]);
	}
}
