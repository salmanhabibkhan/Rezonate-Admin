<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

$routes->post('uploadImage', 'BackendController::fileUpload');


$routes->group('api', static function ($routes) {
	$routes->post('sendmail', 'UserController::sendmail');
	$routes->post('google-login', 'Auth::apigooglelogin');
	$routes->post('facebook-login', 'Auth::facebookLogin');
	$routes->post('social-login', 'Auth::apiSocialLogin');
	$routes->post('linkedin-login', 'Auth::linkedinLogin');
	$routes->post('check-email', 'Auth::checkEmail');

	
	
	$routes->get('get_site_settings', 'Misc::get_site_settings');
	$routes->post('login', 'Auth::Apilogin');
	$routes->post('register', 'Auth::registerApi');
	$routes->post('forgotpassword', 'Auth::forgotPassword');
	$routes->post('activate/(:num)/(:any)', 'Auth::activateUser/$1/$2');
	$routes->post('resetpassword/(:num)/(:any)', 'Auth::resetPassword/$1/$2');
	$routes->post('updatepassword/(:num)', 'Auth::updatepassword/$1');
	$routes->post('reset-password', 'Auth::reset_password');
	$routes->post('reset-password-confirm', 'Auth::reset_password_confirm');
	
	$routes->post('sendpush', 'BackendController::sendpush');
	
	
	//protected API
	$routes->group('', ['filter' => 'jwtFilter'], function ($routes) {
		$routes->get('dashboard', 'Dashboard::index'); // ADMIN DASHBOARD
		$routes->match(['get', 'post'], 'dashboard/profile', 'Auth::profile');
		$routes->get('get-user-profile', 'UserController::getuserprofile');
		$routes->post('update-user-profile', 'UserController::updateUserProfile');
		$routes->post('search-user', 'UserController::searchUser');
		$routes->post('change-password', 'Auth::changePassword');
		$routes->post('delete-account', 'UserController::deleteAccount');
		$routes->post('search-friend-filter', 'UserController::searchFriendFilter');
		$routes->get('logout', 'Auth::apilogout');
		
		$routes->post('poke-user', 'UserController::pokeUser');
		$routes->post('become-donor', 'UserController::becomeDonor');
		$routes->post('update-donor-info', 'UserController::updateDonorInfo');
		$routes->post('get-donor-list', 'UserController::getDonorList');
		$routes->post('donate', 'WithdrawController::donate');
		$routes->post('add-blood-request', 'UserController::addBloodRequest');
		$routes->post('get-blood-request', 'UserController::getBloodRequest');
		$routes->post('get-pro-users', 'UserController::getProUser');
		$routes->post('delete-bloodrequest', 'BloodBankController::deleteBloodRequest');
		$routes->post('change-language', 'UserController::changeLanguage');
		$routes->post('get-languages', 'UserController::getlanguages');
		
		$routes->post('delete-bloodrequest', 'BloodBankController::deleteBloodRequest');

		// Page Routes
		$routes->group('', ['filter' => 'accessibilityFilter:page'], function ($routes) {
			$routes->get('get-all-pages', 'PageController::getAllPages');
			$routes->get('user-pages', 'PageController::userPages');
			$routes->post('add-page', 'PageController::addPage');
			$routes->post('like-unlike-page', 'PageController::likeUnlikePage');
			$routes->post('get-liked-pages', 'PageController::getLikedPages');
			$routes->post('get-page-data', 'PageController::getPageData');
			$routes->post('delete-page', 'PageController::deletePage');
			$routes->post('update-page', 'PageController::updatePage');
		});
		// Group Apis
		$routes->group('', ['filter' => 'accessibilityFilter:group'], function ($routes) {
			$routes->get('user-groups', 'GroupController::userGroups');
			$routes->post('all-groups', 'GroupController::allGroups');
			$routes->post('add-group', 'GroupController::addGroup');
			$routes->post('get-group-data', 'GroupController::getGroupData');
			$routes->post('get-group-members', 'GroupController::getGroupMembers');
			$routes->post('delete-group', 'GroupController::deleteGroup');
			$routes->post('update-group', 'GroupController::updateGroup');
			$routes->post('join-group', 'GroupController::joinGroup');
			$routes->post('leave-group', 'GroupController::leaveGroup');
			$routes->post('joined-groups', 'GroupController::joinedGroups');
			$routes->post('make-group-admin', 'GroupController::createAdmin');
			$routes->post('dismiss-admin', 'GroupController::dismissAdmin');
			$routes->post('add-group-member', 'GroupController::addGroupMember');
			$routes->post('remove-member', 'GroupController::removeMember');
		});
		// Events
		$routes->group('', ['filter' => 'accessibilityFilter:event'], function ($routes) {
			$routes->post('add-event', 'EventController::addEvent');
			$routes->post('interest-event', 'EventController::createInterest');
			$routes->post('go-to-event', 'EventController::gotoEvent');
			$routes->post('get-events', 'EventController::getEvents');
			$routes->post('delete-event', 'EventController::deleteEvent');
			$routes->post('update-event', 'EventController::updateEvent');
		});
		// Product
		$routes->post('add-product', 'ProductController::addProduct');
		$routes->post('get-products', 'ProductController::getProducts');
		$routes->post('delete-product', 'ProductController::deleteProduct');
		$routes->post('update-product', 'ProductController::updateProduct');
		$routes->post('product-detail/(:num)', 'ProductController::getProductDetail/$1');
		


		// Games
		$routes->group('', ['filter' => 'accessibilityFilter:game'], function ($routes) {
			$routes->post('get-games', 'GameController::allGames');
		});
		// Jobs
		$routes->group('', ['filter' => 'accessibilityFilter:job'], function ($routes) {
			$routes->post('post-job', 'JobController::createJob');
			$routes->post('get-jobs', 'JobController::getJobs');
			$routes->post('apply-for-job', 'JobController::applyJob');
			$routes->post('search-job', 'JobController::searchJob');
			$routes->post('delete-job-post', 'JobController::deleteJob');
			$routes->post('update-job-post', 'JobController::updateJob');
			$routes->get('get-job_categories', 'JobController::getJobCategories');
			$routes->post('applied-candidates', 'JobController::appliedCandidates');
		});
		// Space
		// $routes->group('', ['filter' => 'accessibilityFilter:space'], function ($routes) {
			$routes->post('create-space', 'SpaceController::createSpace');
			$routes->post('get-spaces', 'SpaceController::getSpace');
			$routes->post('update-space', 'SpaceController::updateSpace');
			$routes->post('delete-space', 'SpaceController::deleteSpace');
			$routes->post('join-space', 'SpaceController::joinSpace');
			$routes->post('leave-space', 'SpaceController::leaveSpace');
			$routes->post('make-cohost', 'SpaceController::makeCoHost');
			$routes->post('remove-cohost', 'SpaceController::removeCohost');
			$routes->post('remove-cohost', 'SpaceController::removeCohost');
			$routes->post('get-space-members', 'SpaceController::getSpaceMember');
			$routes->post('search-space', 'SpaceController::searchSpace');
		// });
		// Friend 

		
		$routes->post('make-friend', 'FriendController::makeFriend');
		$routes->post('change-friend-role', 'FriendController::changeFriendRole');
		
		$routes->post('friend-request-action', 'FriendController::friendRequestAction');
		$routes->post('unfriend', 'FriendController::unfriend');
		$routes->post('fetch-recommended', 'FriendController::fetchRecommended');
		$routes->post('friend-requests', 'FriendController::feriendRequest');
		$routes->post('get-friends', 'FriendController::getFriends');
		$routes->post('get-sent-requests', 'FriendController::getSendRequest');

		// Follower 
		$routes->post('create-follower', 'FollowerController::createFollower');

		$routes->post('report-user', 'BlockController::reportUser');

		$routes->post('block-user', 'BlockController::blockuser');
		$routes->get('block-list', 'BlockController::blocklist');
		// Blog Routes
		$routes->group('', ['filter' => 'accessibilityFilter:blog'], function ($routes) {
			$routes->get('all-blogs', 'BlogController::all');
			$routes->post('add-blog', 'BlogController::addBlog');
			$routes->get('edit-blog', 'BlogController::editBlog');
			$routes->post('update-blog', 'BlogController::updateBlog');
			$routes->post('delete-blog', 'BlogController::deleteBlog');
		});
		// Movies Routes
		$routes->post('all-movies', 'MovieController::all');
		$routes->post('add-movie', 'MovieController::addMovie');
		$routes->get('edit-movie', 'MovieController::editMovie');

		//Post
		$routes->post('create-post', 'PostController::addPost');
		$routes->post('delete-post', 'PostController::deletePost');
		$routes->get('user-wallet', 'WithdrawController::userwallet');
		$routes->group('withdraw-requset',['filter' => 'accessibilityFilter:withdraw'], function ($routes) {
			$routes->post('create', 'WithdrawController::create');
			$routes->post('user-wallet', 'WithdrawController::userwallet');
			$routes->post('list', 'WithdrawController::withdrawlist');
		});
		$routes->post('transfer-amount', 'WithdrawController::transferFund');


		$routes->post('trending-hashtags', 'PostController::getTrendingtag');
	
		//post Actions
		$routes->group('post', function ($routes) {
			$routes->post('create', 'PostController::addPost');
			$routes->get('detail', 'PostController::getPostDetail/$1');
			$routes->post('delete-post', 'PostController::deletePost');
			$routes->post('newsfeed', 'PostController::getNewsfeed');
			$routes->get('page_posts/(:num)', 'PostController::getPagePosts/$1');
			$routes->get('group_posts/(:num)', 'PostController::getGroupPosts/$1');
			$routes->get('saved', 'PostController::getSavedPost');
			$routes->post('share','PostController::sharePost');
			$routes->post('delete-share-post','PostController::deleteSharePost');
			$routes->post('action','PostController::postAction');
			$routes->post('get-post-reaction','PostController::getpostReaction');
			$routes->post('great-job','PostController::greatJob');
			$routes->post('cup-of-coffee','PostController::CupOfCoffee');
			$routes->post('ad-request-action','PostController::postAdaction');
			$routes->post('change-privacy','PostController::changePrivacy');
			$routes->post('update','PostController::updatePost');
			$routes->post('add-advertisement', 'PostController::AddPostAdvertisement');
			$routes->post('advertisement-requests', 'PostController::advertisementRequests');
			$routes->post('advertisement-request-action', 'PostController::postAdaction');
			$routes->post('poll-vote', 'PostController::votePoll');
			$routes->post('feed', 'PostController::FeedPost');
			$routes->post('get-post-share-users', 'PostController::GetPostShareUsers');
			
			//commments functionality
			$routes->group('comments', function ($routes) {
				$routes->post('add', 'PostController::addComment');
				$routes->post('update', 'PostController::updateComment');
				$routes->post('reply', 'PostController::replyToComment');
				$routes->post('reply_like', 'PostController::likeCommentReply');
				$routes->get('getcomment', 'PostController::getComments');
				$routes->post('like', 'PostController::likeComment');
				$routes->post('delete', 'PostController::deleteComment');
				$routes->post('get-replies', 'PostController::getReplies');
				$routes->post('add-reply', 'PostController::addCommentReply');
				$routes->post('delete-reply', 'PostController::deleteReply');
				
			});
		});
		$routes->group('story',['filter' => 'accessibilityFilter:story'], function ($routes) {
			$routes->post('create', 'StoryController::addStory');
			$routes->post('get-stories', 'StoryController::getStories');
			$routes->post('mute-unmute-user', 'StoryController::muteUnmuteUser');
			$routes->post('seen-story', 'StoryController::seenStory');
			$routes->post('story-seen-user', 'StoryController::storySeenUser');
			$routes->post('delete-story', 'StoryController::deleteStory');
		});
		$routes->group('chat', function ($routes) {
			$routes->post('send-message', 'ChatController::sendMessage');
			$routes->post('get-user-chat', 'ChatController::getMessages');
			$routes->post('get-chat-by-page', 'ChatController::getChatListByPage');
			$routes->post('delete-message', 'ChatController::deleteMessage');
			$routes->post('get-all-chats', 'ChatController::getuserChat');
		});
		$routes->group('notifications', function ($routes) {
			$routes->post('new', 'NotificationController::showUserNewNotification');
			$routes->post('user-old-notification', 'NotificationController::showOldNotification');
			$routes->post('mark-as-read', 'NotificationController::markAsRead');
			$routes->post('mark-all-as-read', 'NotificationController::markAllAsRead');
			$routes->post('delete-all', 'NotificationController::deleteAllNotifications');
			$routes->post('delete-notification', 'NotificationController::deleteNotification');
			$routes->get('count-notification', 'NotificationController::countNotifications');

		});
		$routes->post('upgrade-to-pro', 'UserController::upgradeToPro');

		$routes->group('deposite', function ($routes) {
			$routes->post('add-fund', 'DepositeController::create');
		});
		$routes->post('generate-agoratoken', 'AgoraTokenController::generateAgoraToken');
		$routes->post('go-live', 'AgoraTokenController::goToLive');
		$routes->post('end-live-stream', 'AgoraTokenController::EndLiveStream');
		$routes->post('get-live-users', 'AgoraTokenController::getLiveUsers');
		$routes->post('join-stream', 'AgoraTokenController::joinstream');
		$routes->post('get-token', 'AgoraTokenController::getToken');
		$routes->post('get-call-history', 'AgoraTokenController::getCallHistory');
		$routes->post('delete-call', 'AgoraTokenController::deleteCall');
		$routes->post('delete-call-history', 'AgoraTokenController::deleteallCall');
		
		$routes->post('decline-call', 'AgoraTokenController::declineCall');
		$routes->post('livestream-request', 'AgoraTokenController::livestreamRequest');
		$routes->post('join-livestream', 'AgoraTokenController::joinLiveStream');
		$routes->post('get-livestream-users', 'AgoraTokenController::getLiveStreamUser');
		$routes->post('live-stream-action', 'AgoraTokenController::LivestreamUserAction');
		$routes->post('get-live-stream-multiusers', 'AgoraTokenController::getmultilivestreamusers');
		$routes->post('get-live-stream-userinfo', 'AgoraTokenController::getMultiLiveStreamUserInfo');
		$routes->post('send-gift', 'AgoraTokenController::sendGift');


		$routes->get('get-random-pro-users', 'UserController::getProUser');
		
		$routes->get('get-sessions', 'UserController::getSessions');
		$routes->post('delete-session', 'UserController::deleteSession');
		$routes->post('get-filters', 'UserController::getFilter');

		$routes->post('logout', 'Auth::apilogout');
	});

	
});




 // LOGOUT
