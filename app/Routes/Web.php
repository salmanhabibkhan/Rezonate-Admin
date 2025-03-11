<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// $routes->get('activate-account', 'Home::activateAccount');

$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get( 'verify-purchase-code', 'Auth::verifyPurchaseCode');
$routes->post( 'verifypurchasecode', 'Auth::verifyPurchaseCodeData');
$routes->get('access-denied', 'Home::access_denied');

$routes->get('set-language/(:any)', 'Home::setLanguage/$1');

 $routes->get('page/(:any)', 'CustomPageController::getPage/$1');
// $routes->get('listings/people/(:any)', 'FrontDashboardController::people/$1/$2');
// $routes->get('listings/pages/(:any)', 'FrontDashboardController::pages/$1/$2');


// $routes->match(['get', 'post'], 'register', 'Auth::register');
$routes->match(['get', 'post'], 'forgotpassword', 'Auth::forgotPassword'); // FORGOT PASSWORD
$routes->get('logout', 'Auth::logout');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/resendactivation/(:num)', 'Auth::resendactivation/$1');

$routes->get('social_login/(:segment)', 'Auth::sociallogin/$1');
$routes->get('social_login/callback', 'Auth::callback');



$routes->group('', ['filter' => 'auth:Role,1,2'],  function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/updates', 'Home::updates');

    $routes->get('video_timeline', 'Home::videoTimeline');


    $routes->get('start', 'Home::start');
    $routes->get('start', 'Home::start');

    $routes->get('home', 'Home::index');
    $routes->get('js_language.js', 'Home::js_language');
    $routes->get('notifications', 'NotificationController::notifcations_list');
    $routes->get('notification/(:num)', 'NotificationController::details/$1');
    $routes->get('games', 'GameController::index');
    
      // Detailed Post View Route
    $routes->get('posts/(:any)', 'PostController::postDetails/$1');
    $routes->group('', ['filter' => 'webaccessibilityFilter:package'], function ($routes) {
        $routes->get('packages', 'UserController::packages');
    });
    $routes->group('', ['filter' => 'webaccessibilityFilter:friend'], function ($routes) {
        $routes->get('friends', 'FriendController::friends');
    });
   
    //pages
    $routes->group('', ['filter' => 'webaccessibilityFilter:page'], function ($routes) {
        $routes->get('pages', 'PageController::allWebPages');
        $routes->get('my-pages', 'PageController::myPages');
        $routes->get('create-page', 'PageController::createPage');
        $routes->get('update-page/(:num)', 'PageController::updateWebPage/$1');
        $routes->get('pages/(:any)', 'PageController::pageProfile/$1/$2');
        $routes->post('like-unlike-page', 'PageController::likeUnlikePage');
    });
    $routes->post('jobapply', 'JobController::applyjob/$1');
    //groups
    $routes->group('', ['filter' => 'webaccessibilityFilter:group'], function ($routes) {
        $routes->get('groups', 'GroupController::allWebGroups');
        $routes->get('my-groups', 'GroupController::myGroups');
        $routes->get('create-group', 'GroupController::createGroup');
        $routes->get('edit-group/(:num)', 'GroupController::editWebGroup/$1');
        $routes->get('group-details/(:num)', 'GroupController::groupWebDetails/$1');
        $routes->get('group/(:any)', 'GroupController::groupProfile/$1/$2');

    });
    $routes->group('', ['filter' => 'webaccessibilityFilter:blood'], function ($routes) {
        $routes->get('blood-bank', 'BloodBankController::index');
        $routes->get('find-donors', 'BloodBankController::findDonors');
        $routes->get('blood-requests', 'BloodBankController::blood-requests');
        $routes->get('become-donor', 'BloodBankController::becomeDonor');
        $routes->get('blood-request', 'BloodBankController::bloodRequest');
        $routes->get('add-blood-request', 'BloodBankController::addBloodRequest');

    });
    $routes->get('search', 'UserController::search');
    $routes->group('', ['filter' => 'webaccessibilityFilter:blog'], function ($routes) {
        $routes->get('blogs', 'BlogController::all_web');
        $routes->get('blog-tags/(:num)', 'BlogController::blogTags/$1');
        $routes->get('blog-details/(:num)', 'BlogController::blogDetails/$1');
    });
    //events
    $routes->group('' ,['filter' => 'webaccessibilityFilter:event'], function ($routes) {
        $routes->get('events', 'EventController::getWebEvents');
        $routes->get('events/create-event', 'EventController::createWebevent');
        $routes->get('events/edit-event/(:num)', 'EventController::editWebevent/$1');
        $routes->get('events/my-events', 'EventController::getMyWebEvents');
        $routes->get('events/event-details/(:num)', 'EventController::geteventWebDetials/$1');
    });

    //movies
    $routes->group('' ,['filter' => 'webaccessibilityFilter:movie'], function ($routes) {
        $routes->get('movies', 'MovieController::get_movies');
        $routes->get('movies/(:any)', 'MovieController::show/$1');
    });
    //jobs
    
     $routes->group('jobs', ['filter' => 'webaccessibilityFilter:job'],  function ($routes) {
        $routes->get('', 'JobController::getWebJobs');
        $routes->get('my-jobs', 'JobController::getWebmyJobs');
        $routes->get('apply/(:num)', 'JobController::applyWebJob/$1');
        $routes->get('applicants/(:num)', 'JobController::applicants/$1');
        $routes->get('detail/(:any)', 'JobController::jobDetail/$1');
        $routes->get('create', 'JobController::addJob');
        $routes->get('update/(:any)', 'JobController::edit/$1');

        $routes->get('(:any)', 'JobController::show/$1');
    });

    $routes->group('real-estate', function ($routes) {
        $routes->get('rent', 'RealEstateController::listRentProperties');
        $routes->get('buy', 'RealEstateController::listBuyProperties');
        $routes->get('sell', 'RealEstateController::listSellProperties');
        // Additional routes for details, add, update, delete, etc.
    });



    //Wallet
    $routes->group('', ['filter' => 'webaccessibilityFilter:withdraw'], function ($routes) {

        $routes->get('wallet', 'WalletController::getuserwallet');
        $routes->get('create-withdraw', 'WalletController::create_withdraw');
        $routes->get('withdraw-requests', 'WalletController::withdrawrequest');
        $routes->get('transfer-amount', 'WalletController::transferAmount');
        $routes->get('deposit-amount', 'DepositeController::depositAmount');
        $routes->get('deposit-amount', 'DepositeController::depositAmount');
        
        $routes->post('payment-checkout', 'DepositeController::paymentCheckout');
    
    });
    
    

    $routes->get('post-ads', 'AdvertisementController::index');
    $routes->get('ad-details/(:num)', 'AdvertisementController::viewDetail/$1');
    


    //settings
    $routes->group('settings',  function ($routes) {
        $routes->get('general-settings', 'SettingsController::generalSettings');
        $routes->get('profile-settings', 'SettingsController::profileSettings');
        $routes->get('social-settings', 'SettingsController::socialSettings');
        $routes->get('privacy-settings', 'SettingsController::privacySettings');
        $routes->get('notification-settings', 'SettingsController::notificationSettings');
        $routes->get('password-settings', 'SettingsController::passwordSettings');
        $routes->get('blocked-users', 'SettingsController::blockedUser');
        $routes->get('manage-sessions', 'SettingsController::manageSessions');
        $routes->group('' ,['filter' => 'webaccessibilityFilter:deleteaccount'], function ($routes) {
            $routes->get('delete-account', 'SettingsController::deleteAccount');
        });
    });

    $routes->group('products',['filter' => 'webaccessibilityFilter:product'], function ($routes) {
        $routes->get('', 'ProductController::getProductsWeb');
        $routes->get('create-product', 'ProductController::createProduct');
        $routes->get('my-products', 'ProductController::getMyProductsWeb');
        $routes->post('get-products', 'ProductController::getproducts');
        $routes->post('delete-product', 'ProductController::deleteproduct');
        $routes->get('edit/(:num)', 'ProductController::editProduct/$1');
        $routes->get('details/(:num)', 'ProductController::productDetails/$1');
        
    });
    $routes->get('create-story', 'StoryController::createStory');
    $routes->get('saved-post', 'Home::savedpost');
    
    



});



$routes->group('web_api', ['filter' => 'auth:Role,1,2'],  function ($routes) {

    
    $routes->post('fetch-recommended', 'FriendController::fetchRecommended');
    $routes->post('make-friend', 'FriendController::makeFriend');
    $routes->post('change-password', 'Auth::changePassword');
    $routes->post('upgrade-to-pro', 'UserController::upgradeToPro');
    $routes->post('leave-group', 'GroupController::leaveGroup');
    $routes->group('' ,['filter' => 'webaccessibilityFilter:event'], function ($routes) {
        $routes->post('events/gotoevent', 'EventController::gotoEvent');
        $routes->post('events/createinterest', 'EventController::createInterest');
    });
    $routes->post('create-withdraw', 'WithdrawController::create');
	$routes->post('poke-user', 'UserController::pokeUser');
    
    $routes->post('delete-session', 'UserController::deleteWebSession');

    $routes->post('share-post', 'PostController::sharePost');
    $routes->post('get-balance', 'BackendController::checkBalance');
    $routes->group('', ['filter' => 'webaccessibilityFilter:page'], function ($routes) {
        $routes->post('add-page', 'PageController::addPage');
        $routes->post('update-page', 'PageController::updatePage');
        $routes->post('like-page', 'PageController::likeUnlikePage');
        $routes->post('delete-page', 'PageController::deletePage');
        $routes->post('remove-page-user', 'PageController::deletePageUser');
        $routes->post('get-my-pages', 'PageController::getMyPage');
        
    });
    $routes->post('add-bloodrequest', 'UserController::addBloodRequest');
    $routes->post('delete-bloodrequest', 'BloodBankController::deleteBloodRequest');
    
    $routes->post('recent-tags', 'BlogController::recentTags');
  
    $routes->group('', ['filter' => 'webaccessibilityFilter:group'], function ($routes) {
        $routes->post('remove-member', 'GroupController::removeMember');
        $routes->post('add-group', 'GroupController::addGroup');
        $routes->post('update-group', 'GroupController::updateGroup');
        $routes->post('join-group', 'GroupController::joinGroup');
        $routes->post('remove-admin', 'GroupController::dismissAdmin');
        $routes->post('make-admin', 'GroupController::createAdmin');
        $routes->post('delete-group', 'GroupController::deleteGroup');
        $routes->post('get-my-group', 'GroupController::getMyGroup');
    });
    $routes->post('add-product', 'ProductController::addProduct');
    $routes->post('update-product', 'ProductController::updateProduct');
    $routes->post('delete-product', 'ProductController::deleteProduct');

    
    $routes->group('story',['filter' => 'accessibilityFilter:story'], function ($routes) {
        $routes->post('create', 'StoryController::addStory');
        $routes->post('get-stories', 'StoryController::getStories');
        $routes->post('mute-unmute-user', 'StoryController::muteUnmuteUser');
        $routes->post('seen-story', 'StoryController::seenStory');
        $routes->post('story-seen-user', 'StoryController::storySeenUser');
        $routes->post('delete-story', 'StoryController::deleteStory');
    });

    $routes->group('notifications', function ($routes) {
        $routes->post('new', 'NotificationController::showUserNewNotification');
        $routes->post('user-old-notification', 'NotificationController::showOldNotification');
        $routes->post('mark-all-as-read', 'NotificationController::markAllAsRead');
        $routes->post('delete-all-notifications', 'NotificationController::deleteAllNotifications');
        $routes->get('count-notification', 'NotificationController::countNotifications');
        $routes->post('delete', 'NotificationController::deleteNotification');
        
    });

    $routes->group('chat', function ($routes) {
        $routes->post('send-message', 'ChatController::sendMessage');
        $routes->post('get-user-chat', 'ChatController::getMessages');
        $routes->post('get-chat-by-page', 'ChatController::getChatListByPage');
        $routes->post('delete-message', 'ChatController::deleteMessage');
        $routes->post('get-all-chats', 'ChatController::getuserChat');
    });


    $routes->post('fetch-recommended', 'FriendController::fetchRecommended');
    $routes->post('friend-requests', 'FriendController::feriendRequest');
    $routes->post('get-friends', 'FriendController::getFriends');
    $routes->post('change-friend-role', 'FriendController::changeFriendRole');

    $routes->post('friend-request-action', 'FriendController::friendRequestAction');
    $routes->post('unfriend', 'FriendController::unfriend');
    $routes->post('get-sent-requests', 'FriendController::getSendRequest');

    $routes->group('', ['filter' => 'webaccessibilityFilter:job'], function ($routes) {
        $routes->post('store-job', 'JobController::createJob');
        $routes->post('update-job', 'JobController::updateJob');
        $routes->post('delete-job', 'JobController::deleteJob');
    });

    $routes->group('post', function ($routes) {
        $routes->get('newsfeed', 'PostController::getNewsfeed');

        $routes->post('get-post-reaction','PostController::getpostReaction');

        $routes->post('ad-action', 'PostController::postAdaction');
        $routes->post('add-advertisement', 'PostController::AddPostAdvertisement');
        $routes->post('update-post', 'PostController::updatePost');

        $routes->post('create', 'PostController::addPost');
        $routes->get('detail', 'PostController::getPostDetail/$1');
        $routes->post('delete-post', 'PostController::deletePost');

        $routes->get('page_posts/(:num)', 'PostController::getPagePosts/$1');
        $routes->get('group_posts/(:num)', 'PostController::getGroupPosts/$1');
        $routes->get('saved', 'PostController::getSavedPost');
        $routes->post('share', 'PostController::sharePost');
        $routes->post('action', 'PostController::postAction');
        $routes->post('change-privacy','PostController::changePrivacy');
        $routes->post('great-job', 'PostController::greatJob');
        $routes->post('cup-of-coffee', 'PostController::CupOfCoffee');
        $routes->post('poll-vote', 'PostController::votePoll');
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
            $routes->post('replies/delete', 'PostController::deleteReply');
        });
    });
    
   
    $routes->post('block-user', 'BlockController::blockuser');

    $routes->group('events' ,['filter' => 'webaccessibilityFilter:event'], function ($routes) {
        $routes->post('add-event', 'EventController::addEvent');
        $routes->post('interest-event', 'EventController::createInterest');
        $routes->post('go-to-event', 'EventController::gotoEvent');
        $routes->post('get-events', 'EventController::getEvents');
        $routes->post('delete-event', 'EventController::deleteEvent');
        $routes->post('update-event', 'EventController::updateEvent');
    });
    
    $routes->post('transfer-amount', 'WithdrawController::transferFund');
	$routes->post('donate', 'WithdrawController::donate');

    $routes->post('report-user','BlockController::reportUser');

    $routes->group('settings',  function ($routes) {
        $routes->post('update-user-profile', 'UserController::updateUserProfile');
    });
    $routes->group('' ,['filter' => 'webaccessibilityFilter:deleteaccount'], function ($routes) {
        $routes->post('deleteaccount', 'UserController::deleteAccount');
    });
});

$routes->group('', ['filter' => 'auth:Role,1,2'],  function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('/updates', 'Home::updates');

    $routes->get('video_timeline', 'Home::videoTimeline');


    $routes->get('start', 'Home::start');
    $routes->get('start', 'Home::start');

    $routes->get('home', 'Home::index');
    $routes->get('notifications', 'NotificationController::notifcations_list');
    $routes->get('notification/(:num)', 'NotificationController::details/$1');
    $routes->get('games', 'GameController::index');
    
      // Detailed Post View Route
    $routes->get('posts/(:any)', 'PostController::postDetails/$1');
    $routes->group('', ['filter' => 'webaccessibilityFilter:package'], function ($routes) {
        $routes->get('packages', 'UserController::packages');
    });
    $routes->group('', ['filter' => 'webaccessibilityFilter:friend'], function ($routes) {
        $routes->get('friends', 'FriendController::friends');
    });
    $routes->get('load-image', 'UserController::loadImages');

    //pages
    $routes->group('', ['filter' => 'webaccessibilityFilter:page'], function ($routes) {
        $routes->get('pages', 'PageController::allWebPages');
        $routes->get('my-pages', 'PageController::myPages');
        $routes->get('create-page', 'PageController::createPage');
        $routes->get('update-page/(:num)', 'PageController::updateWebPage/$1');
        
        $routes->post('like-unlike-page', 'PageController::likeUnlikePage');
       
    });
    $routes->post('jobapply', 'JobController::applyjob/$1');
    //groups
    $routes->group('', ['filter' => 'webaccessibilityFilter:group'], function ($routes) {
        $routes->get('groups', 'GroupController::allWebGroups');
        $routes->get('my-groups', 'GroupController::myGroups');
        $routes->get('create-group', 'GroupController::createGroup');
        $routes->get('edit-group/(:num)', 'GroupController::editWebGroup/$1');
        $routes->get('group-details/(:num)', 'GroupController::groupWebDetails/$1');
        $routes->get('group/(:any)', 'GroupController::groupProfile/$1/$2');

    });
    $routes->group('', ['filter' => 'webaccessibilityFilter:blog'], function ($routes) {
        $routes->get('blogs', 'BlogController::all_web');
        $routes->get('blog-tags/(:num)', 'BlogController::blogTags/$1');
        $routes->get('blog-details/(:num)', 'BlogController::blogDetails/$1');
    });
    //events
    $routes->group('' ,['filter' => 'webaccessibilityFilter:event'], function ($routes) {
        $routes->get('events', 'EventController::getWebEvents');
        $routes->get('events/create-event', 'EventController::createWebevent');
        $routes->get('events/edit-event/(:num)', 'EventController::editWebevent/$1');
        $routes->get('events/my-events', 'EventController::getMyWebEvents');
        $routes->get('events/event-details/(:num)', 'EventController::geteventWebDetials/$1');
    });

    //movies
    $routes->group('' ,['filter' => 'webaccessibilityFilter:movie'], function ($routes) {
        $routes->get('movies', 'MovieController::get_movies');
        $routes->get('movies/(:any)', 'MovieController::show/$1');
    });
    //jobs
    
     $routes->group('jobs', ['filter' => 'webaccessibilityFilter:job'],  function ($routes) {
        $routes->get('', 'JobController::getWebJobs');
        $routes->get('my-jobs', 'JobController::getWebmyJobs');
        $routes->get('apply/(:num)', 'JobController::applyWebJob/$1');
        $routes->get('applicants/(:num)', 'JobController::applicants/$1');
        $routes->get('detail/(:any)', 'JobController::jobDetail/$1');
        $routes->get('create', 'JobController::addJob');
        $routes->get('update/(:any)', 'JobController::edit/$1');

        $routes->get('(:any)', 'JobController::show/$1');
    });

    $routes->group('real-estate', function ($routes) {
        $routes->get('rent', 'RealEstateController::listRentProperties');
        $routes->get('buy', 'RealEstateController::listBuyProperties');
        $routes->get('sell', 'RealEstateController::listSellProperties');
        // Additional routes for details, add, update, delete, etc.
    });



    //Wallet
    $routes->group('', ['filter' => 'webaccessibilityFilter:withdraw'], function ($routes) {

        $routes->get('wallet', 'WalletController::getuserwallet');
        $routes->get('create-withdraw', 'WalletController::create_withdraw');
        $routes->get('withdraw-requests', 'WalletController::withdrawrequest');
        $routes->get('transfer-amount', 'WalletController::transferAmount');
        $routes->get('deposit-amount-via-stripe', 'DepositeController::depositAmount');
        $routes->get('deposit-amount-via-paypal', 'DepositeController::depositAmountViaPaypal');
        $routes->get('deposit-amount-via-paystack', 'DepositeController::depositAmountViaPaystack');
        
        $routes->post('payment-checkout', 'DepositeController::paymentCheckout');
    });
    $routes->post('paypal/create', 'PayPalController::createPayment');
    $routes->get('paypal/success', 'PayPalController::paymentSuccess');
    $routes->get('paypal/cancel', 'PayPalController::paymentCancel');
    $routes->post('paystack/create', 'PaystackController::pay');
    $routes->get('paystack/callback', 'PaystackController::callback');

    $routes->get('post-ads', 'AdvertisementController::index');


    //settings
    $routes->group('settings',  function ($routes) {
        $routes->get('general-settings', 'SettingsController::generalSettings');
        $routes->get('profile-settings', 'SettingsController::profileSettings');
        $routes->get('social-settings', 'SettingsController::socialSettings');
        $routes->get('privacy-settings', 'SettingsController::privacySettings');
        $routes->get('notification-settings', 'SettingsController::notificationSettings');
        $routes->get('password-settings', 'SettingsController::passwordSettings');
        $routes->get('blocked-users', 'SettingsController::blockedUser');
        $routes->get('manage-sessions', 'SettingsController::manageSessions');
        $routes->get('change-language', 'SettingsController::changeLanguage');
        
    });

    $routes->group('products',['filter' => 'webaccessibilityFilter:product'], function ($routes) {
        $routes->get('', 'ProductController::getProductsWeb');
        $routes->get('create-product', 'ProductController::createProduct');
        $routes->get('my-products', 'ProductController::getMyProductsWeb');
        $routes->post('get-products', 'ProductController::getproducts');
        $routes->post('delete-product', 'ProductController::deleteproduct');
        $routes->get('edit/(:num)', 'ProductController::editProduct/$1');
        $routes->get('details/(:num)', 'ProductController::productDetails/$1');
        
    });
    $routes->get('create-story', 'StoryController::createStory');
});

$routes->group('public_api', function ($routes) {
    $routes->post('recent-blogs', 'BlogController::recentblogs');
    $routes->get('public_newsfeed', 'PostController::getNewsfeed');
    $routes->get('load-image', 'UserController::loadImages');

});

$routes->get('pages/(:any)', 'PageController::pageProfile/$1/$2');
$routes->get('(:any)', 'UserController::profileLookup/$1/$2');


$routes->set404Override();
