<?php
namespace Config;


// Create a new instance of our RouteCollection class.
$routes = Services::routes();
$routes->get('maintenance-mode', 'Admin\AdminController::maintenance'); // Adjusted namespace

$routes->get('test', 'Misc::test');
$routes->group('admin', ['filter' => 'auth:Role,2'],  static function ($routes) {
    // 
    
    $routes->get('', 'Admin\AdminController::dashboard'); // Adjusted namespace
    $routes->get('dashboard', 'Admin\AdminController::dashboard'); // Adjusted namespace
    $routes->get('general_settings', 'Admin\AdminController::general_settings'); // Adjusted namespace
    $routes->get('website_information', 'Admin\AdminController::website_information'); 
    $routes->get('change-password', 'Admin\ManageUserController::changeAdminPassword'); 

    
    $routes->get('enable_disable_features', 'Admin\AdminController::enable_disable_features'); 




    $routes->get('posts_settings', 'Admin\AdminController::posts_settings'); 
    $routes->get('social-login-settings', 'Admin\AdminController::social_login_settings'); 
    $routes->get('add-new-game', 'Admin\AdminController::add_new_game'); 
    $routes->get('add-new-movies', 'Admin\AdminController::add_new_movies');
        //Auto routes 
    $routes->get('auto-delete', 'Admin\AdminController::auto_delete');
    $routes->post('deleteautodata', 'Admin\AdminController::deleteAutoData');
    $routes->get('auto-join', 'Admin\AdminController::auto_join');
    $routes->get('database-backup', 'Admin\AdminController::databaseBackup');
    $routes->get('createDatabaseBackaup', 'Admin\AdminController::createDatabaseBackaup');
    $routes->post('update-auto-join', 'Admin\AdminController::updateAutoJoin');
    $routes->get('auto-like', 'Admin\AdminController::auto_like'); 
    $routes->post('update-auto-like', 'Admin\AdminController::updateAutoLike'); 
    $routes->get('fake-user', 'Admin\AdminController::fake_users'); 
    $routes->post('manage-fake-users', 'Admin\AdminController::manageFakeUser');

    $routes->get('auto-friend', 'Admin\AdminController::auto_friend');
    $routes->get('fetch-alluser', 'Admin\AdminController::fetchAllUser');
    $routes->get('fetch-allgroups', 'Admin\AdminController::fetchAllGroups');
    $routes->get('fetch-allpages', 'Admin\AdminController::fetchAllPages');
    
    $routes->post('update-auto-friend', 'Admin\AdminController::updateAutoFriend');
// Manage Advertisement
    $routes->get('manage-advertisements', 'Admin\AdvertisementController::index');
    $routes->post('update-ad', 'Admin\AdvertisementController::updateAd');
    $routes->post('change-ad-share', 'Admin\AdvertisementController::changeshare');
    $routes->get('online-user', 'Admin\ManageUserController::onlineUsers');
    $routes->get('verified-user', 'Admin\ManageUserController::verifiedUser');
    $routes->get('unverified-user', 'Admin\ManageUserController::unVerifiedUser');
    $routes->get('manage-admins', 'Admin\ManageUserController::manageAdmins');
    $routes->get('add-new-admin', 'Admin\ManageUserController::addNewAdmin');
    

    $routes->group('users', function ($routes) { 
        $routes->get('', 'Admin\ManageUserController::index');
        $routes->post('assign-role', 'Admin\ManageUserController::assignRole');
        $routes->get('change-password/(:num)', 'Admin\ManageUserController::changePassword/$1');
        $routes->post('update-password/(:num)', 'Admin\ManageUserController::updatePassword/$1');
        // $routes->get('create', 'Admin\ManageUserController::create');
        $routes->post('store', 'Admin\ManageUserController::store');
        $routes->get('edit/(:num)', 'Admin\ManageUserController::edit/$1');
        $routes->post('update/(:num)', 'Admin\ManageUserController::update/$1');
        $routes->get('delete/(:num)', 'Admin\ManageUserController::delete/$1'); 

    });
    $routes->group('pages', function ($routes) { 
        $routes->get('', 'Admin\PageController::index');
        $routes->get('create', 'Admin\PageController::create');
        $routes->post('store', 'Admin\PageController::store');
        $routes->get('edit/(:num)', 'Admin\PageController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PageController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PageController::delete/$1');
    });
    $routes->group('withdraw-requests', function ($routes) { 
        $routes->get('', 'Admin\WithdrawController::index');
        $routes->get('approve/(:num)', 'Admin\WithdrawController::approve/$1');
        $routes->get('reject/(:num)', 'Admin\WithdrawController::reject/$1');
        $routes->get('details/(:num)', 'Admin\WithdrawController::details/$1');

    });
    $routes->group('products', function ($routes) { 
        $routes->get('', 'Admin\ProductController::index');
        $routes->get('view/(:num)', 'Admin\ProductController::view/$1');
        $routes->get('delete/(:num)', 'Admin\ProductController::delete/$1');
    });

    $routes->group('deposit-requests', function ($routes) { 
        $routes->get('', 'Admin\DepositController::index');
        $routes->get('approve/(:num)', 'Admin\DepositController::approve/$1');
        $routes->get('reject/(:num)', 'Admin\DepositController::reject/$1');
        $routes->get('details/(:num)', 'Admin\DepositController::details/$1');
    });

    $routes->group('deposit-requests', function ($routes) { 
        $routes->get('', 'Admin\DepositController::index');
        $routes->get('approve/(:num)', 'Admin\DepositController::approve/$1');
        $routes->get('reject/(:num)', 'Admin\DepositController::reject/$1');
        $routes->get('details/(:num)', 'Admin\DepositController::details/$1');
    });



    
    $routes->group('packages', function ($routes) { 
        $routes->get('', 'Admin\PackageController::index');
        $routes->get('create', 'Admin\PackageController::create');
        $routes->post('store', 'Admin\PackageController::store');
        $routes->get('edit/(:num)', 'Admin\PackageController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PackageController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PackageController::delete/$1');
    });
    
    

    $routes->group('groups', function ($routes) { 
        $routes->get('', 'Admin\GroupController::index');
        $routes->get('create', 'Admin\GroupController::create');
        $routes->post('store', 'Admin\GroupController::store');
        $routes->get('members/(:num)', 'Admin\GroupController::getGroupMembers/$1');
        $routes->get('edit/(:num)', 'Admin\GroupController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GroupController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GroupController::delete/$1');
    });

    $routes->group('posts', function ($routes) { 
        $routes->get('', 'Admin\PostsController::index');
        $routes->get('create', 'Admin\PostsController::create');
        $routes->post('store', 'Admin\PostsController::store');
        $routes->get('edit/(:num)', 'Admin\PostsController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PostsController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PostsController::delete/$1');
    });
    $routes->group('gifts', function ($routes) { 
        $routes->get('', 'Admin\GiftController::index');
        $routes->get('create', 'Admin\GiftController::create');
        $routes->post('store', 'Admin\GiftController::store');
        $routes->get('edit/(:num)', 'Admin\GiftController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GiftController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GiftController::delete/$1');
    });

    $routes->group('jobs', function ($routes) { 
        $routes->get('', 'Admin\JobController::index');
        $routes->get('create', 'Admin\JobController::create');
        $routes->post('store', 'Admin\JobController::store');
        $routes->get('applicants/(:num)', 'Admin\JobController::applicants/$1');
        $routes->get('edit/(:num)', 'Admin\JobController::edit/$1');
        $routes->post('update/(:num)', 'Admin\JobController::update/$1');
        $routes->get('delete/(:num)', 'Admin\JobController::delete/$1');
    });

    $routes->group('events', function ($routes) { 
        $routes->get('', 'Admin\EventController::index');
        $routes->get('details/(:num)', 'Admin\EventController::details/$1'); 
        $routes->get('edit/(:num)', 'Admin\EventController::edit/$1');
        $routes->post('update/(:num)', 'Admin\EventController::update/$1');
        $routes->get('delete/(:num)', 'Admin\EventController::delete/$1');
    });

    $routes->group('spaces', function ($routes) { 
        $routes->get('', 'Admin\SpaceController::index');
        $routes->get('details/(:num)', 'Admin\SpaceController::details/$1'); 
        $routes->get('delete/(:num)', 'Admin\SpaceController::delete/$1');
    });
    $routes->group('blood-requests', function ($routes) { 
        $routes->get('', 'Admin\BloodController::index');        
        
        $routes->get('delete/(:num)', 'Admin\BloodController::delete/$1');
    });
    $routes->get('blood/donors', 'Admin\BloodController::bloodDonors');

    $routes->group('post-advertisment', function ($routes) { 
        $routes->get('', 'Admin\AdvertisementController::getPostAdvertisement');        
        $routes->get('delete(:num)', 'Admin\AdvertisementController::delete/$1');        
    });

    $routes->group('gateways', function ($routes) { 
        
        $routes->get('', 'Admin\GatewaysController::index');
        $routes->get('create', 'Admin\GatewaysController::create');
        $routes->post('store', 'Admin\GatewaysController::store');
        $routes->get('edit/(:num)', 'Admin\GatewaysController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GatewaysController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GatewaysController::delete/$1');
    });
    $routes->group('filters', function ($routes) { 
        
        $routes->get('', 'Admin\FilterController::index');
        $routes->get('create', 'Admin\FilterController::create');
        $routes->post('store', 'Admin\FilterController::store');
        $routes->get('edit/(:num)', 'Admin\FilterController::edit/$1');
        $routes->post('update/(:num)', 'Admin\FilterController::update/$1');
        $routes->get('delete/(:num)', 'Admin\FilterController::delete/$1');
    });
    $routes->group('product-categories', function ($routes) { 
        $routes->get('', 'Admin\ProductCategoryController::index');
        $routes->get('create', 'Admin\ProductCategoryController::create');
        $routes->post('store', 'Admin\ProductCategoryController::store');
        $routes->get('edit/(:num)', 'Admin\ProductCategoryController::edit/$1');
        $routes->post('update/(:num)', 'Admin\ProductCategoryController::update/$1');
        $routes->get('delete/(:num)', 'Admin\ProductCategoryController::delete/$1');
    });
    $routes->group('group-categories', function ($routes) { 
        $routes->get('', 'Admin\GroupCategoryController::index');
        $routes->get('create', 'Admin\GroupCategoryController::create');
        $routes->post('store', 'Admin\GroupCategoryController::store');
        $routes->get('edit/(:num)', 'Admin\GroupCategoryController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GroupCategoryController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GroupCategoryController::delete/$1');
    });
    $routes->group('job-categories', function ($routes) { 
        $routes->get('', 'Admin\JobCategoryController::index');
        $routes->get('create', 'Admin\JobCategoryController::create');
        $routes->post('store', 'Admin\JobCategoryController::store');
        $routes->get('edit/(:num)', 'Admin\JobCategoryController::edit/$1');
        $routes->post('update/(:num)', 'Admin\JobCategoryController::update/$1');
        $routes->get('delete/(:num)', 'Admin\JobCategoryController::delete/$1');
    });

    $routes->group('games', function ($routes) { 
        
        $routes->get('', 'Admin\GameController::index');
        $routes->get('create', 'Admin\GameController::create');
        $routes->post('store', 'Admin\GameController::store');
        $routes->get('edit/(:num)', 'Admin\GameController::edit/$1');
        $routes->post('update/(:num)', 'Admin\GameController::update/$1');
        $routes->get('delete/(:num)', 'Admin\GameController::delete/$1');
    });

    $routes->group('movies', function ($routes) { 
        
        $routes->get('', 'Admin\MovieController::index');
        $routes->get('create', 'Admin\MovieController::create');
        $routes->post('store', 'Admin\MovieController::store');
        $routes->get('edit/(:num)', 'Admin\MovieController::edit/$1');
        $routes->post('update/(:num)', 'Admin\MovieController::update/$1');
        $routes->get('delete/(:num)', 'Admin\MovieController::delete/$1');
    });

    $routes->group('blogs', function ($routes) { 
        
        $routes->get('', 'Admin\BlogsController::index');
        $routes->get('create', 'Admin\BlogsController::create');
        $routes->post('store', 'Admin\BlogsController::store');
        $routes->get('edit/(:num)', 'Admin\BlogsController::edit/$1');
        $routes->post('update/(:num)', 'Admin\BlogsController::update/$1');
        $routes->get('delete/(:num)', 'Admin\BlogsController::delete/$1');
    });

    $routes->group('report', function ($routes) { 
        $routes->get('reported-post', 'Admin\ReportsController::index');
        $routes->get('reported-user', 'Admin\ReportsController::getUserReport');
        $routes->post('action', 'Admin\ReportsController::action');
        $routes->post('user-action', 'Admin\ReportsController::userAction');
        
        // $routes->get('create', 'Admin\ReportsController::create');
        // $routes->post('store', 'Admin\ReportsController::store');
        // $routes->get('edit/(:num)', 'Admin\ReportsController::edit/$1');
        // $routes->post('update/(:num)', 'Admin\ReportsController::update/$1');
        // $routes->get('delete/(:num)', 'Admin\ReportsController::delete/$1');
    });
    $routes->group('settings', function ($routes) { 
        $routes->get('', 'Admin\SettingController::general-setting');
        $routes->get('mail-configuration', 'Admin\SettingController::mailConfiguration');
        $routes->get('gateway-intigration', 'Admin\SettingController::gatewayIntigration');
        $routes->get('storage-configuration', 'Admin\SettingController::storageConfiguration');
        $routes->post('update-aws-storage', 'Admin\SettingController::updateAwsStorage');
        $routes->post('update-wasabi-storage', 'Admin\SettingController::updateWasabiStorage');
        $routes->post('update-ftp-storage', 'Admin\SettingController::updateFtpStorage');
        $routes->post('update-space-storage', 'Admin\SettingController::updateSpaceStorage');
        $routes->get('social-login-integration', 'Admin\SettingController::socialLoginIntegration');

        $routes->get('edit/(:num)', 'Admin\SettingController::');
        $routes->post('update/(:num)', 'Admin\SettingController::');
        $routes->get('delete/(:num)', 'Admin\SettingController::');
    });
    $routes->group('custom-page', function ($routes) { 
        $routes->get('', 'Admin\CustomPageController::index');
        $routes->get('create', 'Admin\CustomPageController::create');
        $routes->post('store', 'Admin\CustomPageController::store');
        $routes->get('edit/(:num)', 'Admin\CustomPageController::edit/$1');
        $routes->post('update/(:num)', 'Admin\CustomPageController::update/$1');
        $routes->get('delete/(:num)', 'Admin\CustomPageController::delete/$1');
    });
   
    $routes->group('api', ['filter' => 'auth:Role,2'], static function ($routes) {
	    $routes->post('update_settings', 'Admin\AdminApiController::updateSetting'); // Adjusted namespace
	    $routes->get('get_users', 'Admin\AdminApiController::get_users');
	});
    $routes->group('political-news', function ($routes) { 
        
        $routes->get('', 'Admin\PoliticalNewsController::index');
        $routes->get('create', 'Admin\PoliticalNewsController::create');
        $routes->post('store', 'Admin\PoliticalNewsController::store');
        $routes->get('edit/(:num)', 'Admin\PoliticalNewsController::edit/$1');
        $routes->post('update/(:num)', 'Admin\PoliticalNewsController::update/$1');
        $routes->get('delete/(:num)', 'Admin\PoliticalNewsController::delete/$1');
    });

    // $routes->group('admin', ['filter' => 'auth:Role,2'], static function ($routes) {

});

$routes->get('system-status', function () {
    return view('/admin/pages/system-status'); 
});