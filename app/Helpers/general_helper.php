<?php

include_once(APPPATH . 'ThirdParty/s3-lib/vendor/autoload.php');

use Aws\S3\S3Client;
use Config\PayPalConfig;
use FtpClient\FtpClient;
use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\Files\File;
use App\Libraries\SendEmail;
use Aws\Exception\AwsException;
use App\Models\TransactionModel;
use Google\Cloud\Storage\StorageClient;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;


function get_setting($key)
{
    $settingsModel = new \App\Models\Settings();
    $settings = $settingsModel->getSettings();
    return $settings[$key] ?? null;
}

function is_json_request()
{
    $request = request();
    $get_html = $request->getVar('get_html');
    if (!empty($get_html)) {
        return false;
    }
    $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
    if (empty($authenticationHeader)) {
        return false;
    }
    return true;
}


function is_profile_completed($user)
{
    if (!isset($user['is_profile_complete'])) {
        $userModel = new UserModel;
        $user = $userModel->getUserShortInfo($user['id'], 'date_of_birth');
    }
    $requirement_completed = 1;
    if (isset($user['is_profile_complete']) && $user['is_profile_complete'] == 1) {
        return true;
    }
    if (empty($user['date_of_birth'])) {
        $requirement_completed = 0;
    }
    if (empty($user['avatar'])  || strpos($user['avatar'], "uploads/placeholder/avatar")) {
        $requirement_completed = 0;
    }
    if (empty($user['cover']) || strpos($user['cover'], "uploads/placeholder/placeholder-cover")) {
        $requirement_completed = 0;
    }
    if (isset($user['is_profile_complete']) && $user['is_profile_complete'] == 0 && $requirement_completed == 0) {
        return false;
    } elseif (isset($user['is_profile_complete']) && $user['is_profile_complete'] == 0 && $requirement_completed == 1) {
        $userModel->update($user['id'], ['is_profile_complete' => 1]);
        return true;
    }
}



function getMedia($mediaPath, $type = "image", $storageType = 'local')
{
    // Setting placeholder
    if (empty($mediaPath)) {
        $mediaPath = "uploads/placeholder/placeholder-image.png";
        if ($type == "avatar") {
            $randNum = rand(1, 4);
            $mediaPath = "uploads/placeholder/avatar-" . $randNum . ".jpg";
        } elseif ($type == "cover") {
            $randNum = rand(1, 2);
            $mediaPath = "uploads/placeholder/placeholder-cover_" . $randNum . ".jpg";
        }
    }

    $storageType = get_setting('active_storage');

    if ($storageType === 'local') {
        return base_url($mediaPath);
    } elseif ($storageType === 'aws') {
        $amazone_s3_settings = json_decode(get_setting('amazone_s3_settings'));
        if (empty($amazone_s3_settings->amazone_s3_key) || empty($amazone_s3_settings->amazone_s3_s_key) || empty($amazone_s3_settings->region) || empty($amazone_s3_settings->bucket_name)) {
            return base_url($mediaPath); // Return local placeholder if AWS settings are incomplete
        }

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => $amazone_s3_settings->region,
            'credentials' => [
                'key' => $amazone_s3_settings->amazone_s3_key,
                'secret' => $amazone_s3_settings->amazone_s3_s_key,
            ],
        ]);

        try {
            $command = $s3->getCommand('GetObject', [
                'Bucket' => $amazone_s3_settings->bucket_name,
                'Key' => $mediaPath,
            ]);
            $request = $s3->createPresignedRequest($command, '+20 minutes');
            return (string)$request->getUri(); // Generate presigned URL for the object
        } catch (AwsException $e) {
            return base_url($mediaPath); // Fallback to local placeholder in case of error
        }
    } elseif ($storageType === 'wasabi') {
        $wasabi_settings = json_decode(get_setting('wasabi_settings'));
        if (empty($wasabi_settings->wasabi_bucket_name) || empty($wasabi_settings->wasabi_access_key) || empty($wasabi_settings->wasabi_secret_key) || empty($wasabi_settings->wasabi_bucket_region)) {
            return base_url($mediaPath); // Return local placeholder if Wasabi settings are incomplete
        }

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $wasabi_settings->wasabi_bucket_region,
            'endpoint' => 'https://s3.' . $wasabi_settings->wasabi_bucket_region . '.wasabisys.com',
            'credentials' => [
                'key' => $wasabi_settings->wasabi_access_key,
                'secret' => $wasabi_settings->wasabi_secret_key,
            ],
        ]);

        try {
            $command = $s3Client->getCommand('GetObject', [
                'Bucket' => $wasabi_settings->wasabi_bucket_name,
                'Key' => $mediaPath,
            ]);
            $request = $s3Client->createPresignedRequest($command, '+20 minutes');
            return (string)$request->getUri(); // Generate presigned URL for the object
        } catch (AwsException $e) {
            error_log('Wasabi S3 error: ' . $e->getMessage());
            return base_url($mediaPath); // Fallback to local placeholder in case of error
        }
    } elseif ($storageType === 'digital_ocean') {
        $digitalOceanSettings = json_decode(get_setting('space_settings'));
        if (empty($digitalOceanSettings->space_key) || empty($digitalOceanSettings->spaces_secret) || empty($digitalOceanSettings->space_name) || empty($digitalOceanSettings->space_region)) {
            return base_url($mediaPath); // Return local placeholder if DigitalOcean settings are incomplete
        }

        $key = $digitalOceanSettings->space_key;
        $secret = $digitalOceanSettings->spaces_secret;
        $spaceName = $digitalOceanSettings->space_name;
        $region = $digitalOceanSettings->space_region;
        $host = "digitaloceanspaces.com";
        $endpoint = "https://$spaceName.$region.$host";

        $s3 = new S3Client([
            'region' => $region,
            'version' => 'latest',
            'endpoint' => $endpoint,
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ],
            'bucket_endpoint' => true,
        ]);

        try {
            $command = $s3->getCommand('GetObject', [
                'Bucket' => $spaceName,
                'Key' => $mediaPath,
            ]);
            $request = $s3->createPresignedRequest($command, '+20 minutes');
            return (string)$request->getUri(); // Generate presigned URL for the object
        } catch (AwsException $e) {
            return base_url($mediaPath); // Fallback to local placeholder in case of error
        }
    } elseif ($storageType === 'ftp') {
        $ftp_settings = json_decode(get_setting('ftp_settings'));
        if (empty($ftp_settings->ftp_host) || empty($ftp_settings->ftp_username) || empty($ftp_settings->ftp_password)) {
            return base_url($mediaPath); // Return local placeholder if FTP settings are incomplete
        }

        return $ftp_settings->ftp_url_base . '/' . $mediaPath;
    } else {
        return base_url($mediaPath); // Default to local placeholder for unsupported storage types
    }
}


//uploading start
if (!function_exists('storeMedia')) {
    function storeMedia($media, $type, $photo_or_video = "photo", $config = [])
    {
        // Retrieve settings from .env file
        $maxSize = env('max_upload_size', 45); // Maximum file size in MB
        $allowedTypes = env('ALLOWED_FILE_TYPES', 'jpg,JPG,jpeg,JPEG,png,PNG,gif,GIF,mp4,MP4,avi,AVI,pdf,PDF,mp3,MP3,wav,WAV,mpeg,MPEG'); // Allowed file types

        // Base directory for photos and videos
        $baseDir = 'uploads/';

        // Validate the media type
        if (!in_array($photo_or_video, ['photo', 'video', 'doc', 'audio'])) {
            throw new InvalidArgumentException("Invalid media type. Expected 'photo', 'video', 'doc', or 'audio'.");
        }

        // Determine the subdirectory based on the type
        $validTypes = [
            'avatar',
            'cover',
            'post',
            'page_avatar',
            'page_cover',
            'products',
            'movie',
            'movie_cover',
            'group_avatar',
            'group_cover',
            'cv_file',
            'story_thumbnail',
            'advertisement',
            'media',
            'chat',
            'site_logo',
            'background_image',
            'gateway_logo',
            'screenshot',
            'thumbnail',
            'favicon',
            'game_image',
            'donation_image',
            'gift_image',
            'filter_image',
            'attachment',
            'chat_thumbnail'
        ];
        if (!in_array($type, $validTypes)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $subDir = $photo_or_video . 's/' . $type;

        // Construct the final directory with date
        $dir = $baseDir . $subDir . '/' . date('Y') . '/' . date('m');
        $file_path_dir = 'uploads/' . $subDir . '/' . date('Y') . '/' . date('m');

        // Check file size
        if ($media->getSizeByUnit('mb') > $maxSize) {
            throw new RuntimeException('File size is too large. Maximum size allowed is ' . $maxSize . 'MB');
        }

        // Check file type
        $allowedTypesArray = explode(',', strtolower($allowedTypes));
        if (!in_array($media->getExtension(), $allowedTypesArray)) {
            throw new RuntimeException('File type(' . $media->getExtension() . ') not allowed. Allowed types: ' . $allowedTypes);
        }

        // Check if the directory exists, if not create it
        if (!is_dir($dir) && !mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new RuntimeException('Failed to create directory: ' . $dir);
        }

        // Generate a new name for the media
        $newName = $media->getRandomName();
     
        // Move the file to the designated folder
        if (!$media->move($dir, $newName)) {
            throw new RuntimeException('Could not move file to ' . $dir);
        }

        // Resize logic based on the type of media
        // if ($photo_or_video == 'photo') {
        //     resizePhoto($dir, $newName, $type);
        // }

        // Upload to other platforms if configured
        $config['file_path'] = $file_path_dir . '/' . $newName;

        $activeStorage = get_setting('active_storage');
        if($activeStorage != 'local'){
            $uploadedToCloud = uploadFileToSelectedHost($dir . '/' . $newName, $config);
            if (!$uploadedToCloud) {
                throw new RuntimeException('Failed to upload the file to the cloud storage');
            }
            unlink($dir.'/'.$newName);
        }
        return $config['file_path'];
    }
}

if (!function_exists('resizePhoto')) {
    function resizePhoto($dir, $newName, $type)
    {
        $imageService = \Config\Services::image();
        if ($type == 'avatar' || $type == 'page_avatar' || $type == 'group_avatar') {
            $imageService->withFile($dir . '/' . $newName)
                ->fit(600, 600, 'center')
                ->save($dir . '/' . $newName);
        } elseif ($type == 'cover' || $type == 'group_cover' || $type == 'page_cover') {
            $imageService->withFile($dir . '/' . $newName)
                ->resize(800, 200, true, 'width')
                ->save($dir . '/' . $newName);
        } elseif ($type == 'post') {
            $imageService->withFile($dir . '/' . $newName)
                ->resize(1000, 1000, true, 'width')
                ->save($dir . '/' . $newName);
        } elseif ($type == 'advertisement') {
            $imageService->withFile($dir . '/' . $newName)
                ->resize(150, 150, true, 'width')
                ->save($dir . '/' . $newName);
        } elseif ($type == 'donation_image' || $type == 'thumbnail' || $type == 'game_image') {
            $imageService->withFile($dir . '/' . $newName)
                ->resize(854, 480, true, 'width')
                ->save($dir . '/' . $newName);
        }
    }
}

if (!function_exists('uploadFileToSelectedHost')) {
    function uploadFileToSelectedHost($filename, $config)
    {

        if (empty($filename) || !file_exists($filename)) {
            return false;
        }
        $activeStorage = get_setting('active_storage');

        // if ($activeStorage == 'ftp') {
        //     return uploadViaFTP($filename, $config);
        // } else
        if ($activeStorage == 'aws') {
            return uploadToS3($filename, $config);
        } elseif ($activeStorage == 'wasabi') {
            return uploadToWasabi($filename, $config);
        } elseif ($activeStorage == 'digital_ocean') {
            return uploadToDigitaloceanSpaces($filename, $config);
        } 

        return false;
    }
}

// if (!function_exists('uploadViaFTP')) {
//     function uploadViaFTP($filename, $config)
//     {
//         $ftp_settings = json_decode(get_setting('ftp_settings'));
//         $ftp = new FtpClient();
//         $ftp->connect($ftp_settings['ftp_host'], false, $ftp_settings['ftp_port']);
//         $login = $ftp->login($ftp_settings['ftp_username'], $ftp_settings['ftp_password']);

//         if ($login) {
//             if (!empty($ftp_settings['ftp_path']) && $ftp_settings['ftp_path'] != "./") {
//                 $ftp->chdir($ftp_settings['ftp_path']);
//             }

//             $file_path = substr($filename, 0, strrpos($filename, '/'));
//             $file_path_info = explode('/', $file_path);
//             $path = '';

//             foreach ($file_path_info as $key => $value) {
//                 $path .= (!empty($path) ? '/' : '') . $value;
//                 if (!$ftp->isDir($path)) {
//                     $ftp->mkdir($path);
//                 }
//             }

//             $ftp->chdir($file_path);
//             $ftp->pasv(true);

//             if ($ftp->putFromPath($filename)) {
//                 if (empty($config['delete'])) {
//                     @unlink($filename);
//                 }
//                 $ftp->close();
//                 return true;
//             }

//             $ftp->close();
//         }

//         return false;
//     }
// }

if (!function_exists('uploadToS3')) {
    function uploadToS3($filename, $config)
    {
       
        $amazone_s3_settings = json_decode(get_setting('amazone_s3_settings'));
       
        // Use object notation
        if (empty($amazone_s3_settings->amazone_s3_key) || empty($amazone_s3_settings->amazone_s3_s_key) || empty($amazone_s3_settings->region) || empty($amazone_s3_settings->bucket_name)) {
            return false;
        }
        try {
            $s3 = new S3Client([
                'version' => 'latest',
                'region' => $amazone_s3_settings->region,
                'credentials' => [
                    'key' => $amazone_s3_settings->amazone_s3_key,
                    'secret' => $amazone_s3_settings->amazone_s3_s_key
                ]
            ]);
            $s3->putObject([
                'Bucket' => $amazone_s3_settings->bucket_name,
                'Key' => $config['file_path'],
                'Body' => fopen($filename, 'r+'),
                'CacheControl' => 'max-age=3153600'
            ]);
            return true;
        } catch (AwsException $exception) {
            echo "Failed to upload " . basename($filename) . " with error: " . $exception->getMessage() . "\n";
            exit("Please fix the error with file upload before continuing.\n");
        }

        return false;
    }
}

if (!function_exists('uploadToWasabi')) {
    function uploadToWasabi($filename, $config)
    {

        
        $wasabi_settings = json_decode(get_setting('wasabi_settings'));

        if (empty($wasabi_settings->wasabi_bucket_name) || empty($wasabi_settings->wasabi_access_key) || empty($wasabi_settings->wasabi_secret_key) || empty($wasabi_settings->wasabi_bucket_region)) {
            return false;
        }
        $wasabi_settings = json_decode(get_setting('wasabi_settings'));
        if (empty($wasabi_settings->wasabi_bucket_name) || empty($wasabi_settings->wasabi_access_key) || empty($wasabi_settings->wasabi_secret_key) || empty($wasabi_settings->wasabi_bucket_region)) {
            return false;
        }
        $endpoint = 'https://s3.'.$wasabi_settings->wasabi_bucket_region.'.wasabisys.com';
        $bucketName = $wasabi_settings->wasabi_bucket_name;
        $region = $wasabi_settings->wasabi_bucket_region;
        $accessKey = $wasabi_settings->wasabi_access_key;
        $secretKey = $wasabi_settings->wasabi_secret_key;

        // Create the S3 client
        $s3Client = new S3Client([
            'region' => $region,
            'endpoint' => $endpoint,
            'version' => 'latest', // Explicitly specify the S3 API version
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);
        try {
            $s3Client->putObject([
                'Bucket' => $bucketName,
                'Key' => $config['file_path'],
                'SourceFile' => $filename,
            ]);
            return true;
        } catch (AwsException $exception) {
            echo "Failed to upload " . basename($filename) . " with error: " . $exception->getMessage() . "\n";
            exit("Please fix the error with file upload before continuing.\n");
        }
    }
}

if (!function_exists('uploadToDigitaloceanSpaces')) {
    function uploadToDigitaloceanSpaces($filename, $config)
    {
        $digitalOceanSettings = json_decode(get_setting('space_settings'));

        // Validate DigitalOcean settings
        if (empty($digitalOceanSettings->space_key) || 
            empty($digitalOceanSettings->spaces_secret) || 
            empty($digitalOceanSettings->space_name) || 
            empty($digitalOceanSettings->space_region)) {
            return false;
        }

        $key = $digitalOceanSettings->space_key;
        $secret = $digitalOceanSettings->spaces_secret;
        $spaceName = $digitalOceanSettings->space_name;
        $region = $digitalOceanSettings->space_region;
        $host = "digitaloceanspaces.com";
        $endpoint = "https://$spaceName.$region.$host";

        // Create the S3 client
        $s3 = new S3Client([
            'region' => $region,
            'version' => 'latest',
            'endpoint' => $endpoint,
            'credentials' => [
                'key' => $key,
                'secret' => $secret,
            ],
            'bucket_endpoint' => true,
        ]);

        try {
            $s3->putObject([
                'Bucket' => $spaceName,
                'Key' =>  $config['file_path'],
                'Body' => fopen($filename, 'r+'),
                'ACL' => 'public-read',
                'CacheControl' => 'max-age=3153600',
            ]);
             return true;
          
        } catch (AwsException $exception) {
            echo "Failed to upload " . basename($filename) . " with error: " . $exception->getMessage() . "\n";
            return false;
        }

        return false;
    }
}

// uploading ends

function HumanTime($timeInput)
{
    try {
        $time = new DateTime($timeInput);
        $now = new DateTime();

        // Difference between now and the input time
        $diff = $now->diff($time);

        if ($diff->y > 0) {
            return $diff->y . ' ' . ($diff->y > 1 ? 'years' : 'year') . ' ago';
        } elseif ($diff->m > 0) {
            return $diff->m . ' ' . ($diff->m > 1 ? 'months' : 'month') . ' ago';
        } elseif ($diff->d > 0) {
            return $diff->d . ' ' . ($diff->d > 1 ? 'days' : 'day') . ' ago';
        } elseif ($diff->h > 0) {
            return $diff->h . ' ' . ($diff->h > 1 ? 'hours' : 'hour') . ' ago';
        } elseif ($diff->i > 0) {
            return $diff->i . ' ' . ($diff->i > 1 ? 'minutes' : 'minute') . ' ago';
        } else {
            return $diff->s <= 5 ? 'a few seconds ago' : $diff->s . ' seconds ago';
        }
    } catch (Exception $e) {
        return "Invalid time format";
    }
}

function shortHumanTime($timeInput)
{
    try {
        $time = new DateTime($timeInput);
        $now = new DateTime();

        // Difference between now and the input time
        $diff = $now->diff($time);

        if ($diff->y > 0) {
            return $diff->y . '' . ($diff->y > 1 ? 'y' : 'y');
        } elseif ($diff->m > 0) {
            return $diff->m . '' . ($diff->m > 1 ? 'm' : 'm');
        } elseif ($diff->d > 0) {
            return $diff->d . '' . ($diff->d > 1 ? 'd' : 'd');
        } elseif ($diff->h > 0) {
            return $diff->h . '' . ($diff->h > 1 ? 'h' : 'h');
        } elseif ($diff->i > 0) {
            return $diff->i . '' . ($diff->i > 1 ? 'm' : 'm') . ' ago';
        } else {
            return $diff->s <= 5 ? 'just now' : 'just now';
        }
    } catch (Exception $e) {
        return "Invalid time format";
    }
}



function theme_asset_url($path)
{
    return base_url(THEME_ASSETS . $path);
}


function download_file($file_name)
{
    // make sure it's a file before doing anything!
    if (!is_file($file_name))
        exit();

    // required for IE
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    // get the file mime type using the file extension
    switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
        case 'pdf':
            $mime = 'application/pdf';
            break;
        case 'zip':
            $mime = 'application/zip';
            break;
        case 'jpeg':
        case 'jpg':
            $mime = 'image/jpg';
            break;
        default:
            exit();
    }

    header('Pragma: public');   // required
    header('Expires: 0');       // no cache
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file_name)) . ' GMT');
    header('Cache-Control: private', false);
    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file_name));    // provide file size
    header('Connection: close');
    readfile($file_name);       // push it out

    exit();
}




function load_view(string $name, array $data = [], array $options = []): string
{
    $themePath = FCPATH . 'themes/' . ACTIVE_THEME . '/views/';
    $renderer = Config\Services::renderer($themePath);


    $config   = config(Config\View::class);
    $saveData = $config->saveData;

    if (array_key_exists('saveData', $options)) {
        $saveData = (bool) $options['saveData'];
        unset($options['saveData']);
    }
    $options['custom_view'] = 1;

    return $renderer->setData($data, 'raw')->render($name, $options, $saveData);
}

function load_asset($path = "")
{
    $assets_path = base_url('themes/' . ACTIVE_THEME . '/assets/');
    if (empty($path)) {
        return $assets_path;
    }
    return $assets_path . $path;
}


function array_flatten($array)
{
    $return = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $return = array_merge($return, array_flatten($value));
        } else {
            $return[$key] = $value;
        }
    }

    return $return;
}


// Function to check if the current page matches the link
function isActive($pageUri)
{
    $currentUri = $_SERVER['REQUEST_URI'];
    if (strpos($currentUri, $pageUri) !== false) {
        return 'active';
    }
    return '';
}

// Create a helper function in app/Helpers/MY_url_helper.php
if (!function_exists('is_active_admin_link')) {
    function is_active_admin_link($url)
    {
        $currentURL = current_url(true)->setHost(''); // Remove the hostname to compare relative URLs
        $targetURL = site_url($url);

        if ($currentURL == $targetURL) {
            return 'active'; // Return 'active' class if URLs match
        }

        return ''; // Return an empty string if not active
    }
}

function check_active_url($link)
{

    trim($link);

    if (current_url() == site_url($link)) {
        return 'active';
    } else {
        return '';
    }
}



function load_css(array $cssFiles)
{
    $html = '';
    foreach ($cssFiles as $file) {
        $html .= '<link href="' . base_url('public') . $file . '" rel="stylesheet" type="text/css">';
    }
    return $html;
}

function load_js(array $jsFiles)
{
    $html = '';
    foreach ($jsFiles as $file) {
        $html .= '<script src="' .  base_url('public') . $file . '"></script>';
    }
    return $html;
}
function updateLastSeen()
{
    $user_id = getCurrentUser()['id'];
    $currentDateTime = new DateTime();
    $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s');

    $db = \Config\Database::connect();
    $db->table('users')->where('id', $user_id)->update(['last_seen' => $formattedDateTime]);
}
function createtransactions($loggendInUserID, $postUserId, $post_id, $action, $action_type = '', $comment_id = 0, $share_id = 0)
{

    if (get_setting('earning_system') == '0') {
        return 0;
    }

    if ($loggendInUserID == $postUserId) {
        return 0;
    }

    $userModel = new UserModel();
    $loggedInUserdata = $userModel->getLeveldata($loggendInUserID);

    $postUserdata = $userModel->getLeveldata($postUserId);
    $transactionModel = new TransactionModel();
    $checkloginUserTransaction = $transactionModel->where(['user_id' => $loggendInUserID, 'flag' => 'C', 'post_id' => $post_id])->orderBy('id', 'desc')->first();
    $checkpostUserTransaction = $transactionModel->where(['user_id' => $postUserId, 'flag' => 'C', 'post_id' => $post_id])->orderBy('id', 'desc')->first();

    if ($action_type == 'C') {

        if ($action == 'like') {
            $loggedInUserLiketrasaction = [
                'user_id' => $loggendInUserID,
                'flag' => 'C',
                'post_id' => $post_id,
                'action_type' => 1,
                'comment_id' => 0,
                'amount' => $loggedInUserdata['like_amount'],
            ];
            $transactionModel->save($loggedInUserLiketrasaction);

            $adminDebittransaction = [
                'user_id' => 1,
                'flag' => 'D',
                'action_type' => 1,
                'post_id' => $post_id,
                'comment_id' => 0,
                'amount' => $loggedInUserdata['like_amount'],
            ];
            $transactionModel->save($adminDebittransaction);


            $postOwnerlikeTransaction = [
                'user_id' => $postUserId,
                'flag' => 'C',
                'action_type' => 1,
                'post_id' => $post_id,
                'comment_id' => 0,
                'amount' => $postUserdata['po_like_amount'],
            ];
            $transactionModel->save($postOwnerlikeTransaction);
            $adminDebittransaction = [
                'user_id' => 1,
                'flag' => 'D',
                'action_type' => 1,
                'post_id' => $post_id,
                'comment_id' => 0,
                'amount' => $postUserdata['po_like_amount'],
            ];
            $transactionModel->save($adminDebittransaction);
        } elseif ($action == 'comment') {
            if (empty($checkloginUserTransaction) || $checkloginUserTransaction['action_type'] != 2) {
                $loggedInUserCommentTrasaction = [
                    'user_id' => $loggendInUserID,
                    'flag' => 'C',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $loggedInUserdata['comment_amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);
                $adminDebitcommentTransaction = [
                    'user_id' => 1,
                    'flag' => 'D',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $loggedInUserdata['comment_amount'],
                ];
                $transactionModel->save($adminDebitcommentTransaction);
                $postOwnerUserCommentTrasaction = [
                    'user_id' => $postUserId,
                    'flag' => 'C',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $postUserdata['po_comment_amount'],
                ];
                $transactionModel->save($postOwnerUserCommentTrasaction);
                $adminOwnerDebitcommentTransaction = [
                    'user_id' => 1,
                    'flag' => 'D',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $postUserdata['po_comment_amount'],
                ];
                $transactionModel->save($adminOwnerDebitcommentTransaction);
            }
        } elseif ($action == 'share') {
            if (empty($checkloginUserTransaction) || $checkloginUserTransaction['action_type'] != 3) {

                $loggedInUserCommentTrasaction = [
                    'user_id' => $loggendInUserID,
                    'flag' => 'C',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $loggedInUserdata['share_amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);
                $loggedInUserCommentTrasaction = [
                    'user_id' => 1,
                    'flag' => 'D',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $loggedInUserdata['share_amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);
                $postOwnerUsershareTrasaction = [
                    'user_id' => $postUserId,
                    'flag' => 'C',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $postUserdata['po_share_amount'],
                ];
                $transactionModel->save($postOwnerUsershareTrasaction);
                $adminpostOwnerUsershareTrasaction = [
                    'user_id' => 1,
                    'flag' => 'D',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $postUserdata['po_share_amount'],
                ];
                $transactionModel->save($adminpostOwnerUsershareTrasaction);
            }
        }
    } else {
        if (!empty($checkloginUserTransaction)) {
            if ($action == 'like') {
                $loggedInUserLiketrasaction = [
                    'user_id' => $loggendInUserID,
                    'flag' => 'D',
                    'action_type' => 1,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($loggedInUserLiketrasaction);
                $adminDebittransaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 1,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($adminDebittransaction);
                $postOwnerlikeTransaction = [
                    'user_id' => $postUserId,
                    'flag' => 'D',
                    'action_type' => 1,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'amount' => $checkpostUserTransaction['amount']
                ];
                $transactionModel->save($postOwnerlikeTransaction);
                $adminDebittransaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 1,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'amount' => $checkpostUserTransaction['amount']
                ];
                $transactionModel->save($adminDebittransaction);
            } elseif ($action == 'comment' && $checkloginUserTransaction['comment_id'] == $comment_id) {
                $loggedInUserCommentTrasaction = [
                    'user_id' => $loggendInUserID,
                    'flag' => 'D',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);
                $adminDebitcommentTransaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($adminDebitcommentTransaction);
                $postOwnerUserCommentTrasaction = [
                    'user_id' => $postUserId,
                    'flag' => 'D',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $checkpostUserTransaction['amount']
                ];
                $transactionModel->save($postOwnerUserCommentTrasaction);
                $adminOwnerDebitcommentTransaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 2,
                    'post_id' => $post_id,
                    'comment_id' => $comment_id,
                    'amount' => $checkpostUserTransaction['amount']
                ];
                $transactionModel->save($adminOwnerDebitcommentTransaction);
            } elseif ($action == 'share' && $checkloginUserTransaction['share_id'] == $share_id) {
                $loggedInUserCommentTrasaction = [
                    'user_id' => $loggendInUserID,
                    'flag' => 'D',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);
                $loggedInUserCommentTrasaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $checkloginUserTransaction['amount'],
                ];
                $transactionModel->save($loggedInUserCommentTrasaction);

                $postOwnerUsershareTrasaction = [
                    'user_id' => $postUserId,
                    'flag' => 'D',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $checkpostUserTransaction['amount'],
                ];
                $transactionModel->save($postOwnerUsershareTrasaction);
                $adminpostOwnerUsershareTrasaction = [
                    'user_id' => 1,
                    'flag' => 'C',
                    'action_type' => 3,
                    'post_id' => $post_id,
                    'comment_id' => 0,
                    'share_id' => $share_id,
                    'amount' => $checkpostUserTransaction['amount']
                ];
                $transactionModel->save($adminpostOwnerUsershareTrasaction);
            }
        }
    }
}



if (!function_exists('curl_request')) {
    function curl_request($url, $method = 'GET', $data = array(), $headers = array(), $username = null, $password = null)
    {
        $ch = curl_init();

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } elseif ($method == 'GET') {
            $url .= '?' . http_build_query($data);
        }

        // Set common cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Set basic authentication if username and password are provided
        if ($username && $password) {
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception("Error processing cURL request: " . curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }
}

function sendPushNotification($device, $notification_text, $type = 'other')
{

    $app_id = get_setting('one_signal_app_id');
    $app_key = get_setting('one_signal_app_key');
    $user = getCurrentUser();
    $headers = [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $app_key
    ];

    if (gettype($device) != 'array') {
        $device  = [$device];
    }
    $data = [
        'app_id' => $app_id,
        'include_player_ids' => $device,
        'send_after' => date('c', strtotime('+1 second')), // Format date correctly
        'isChrome' => false,
        'contents' => ['en' => $notification_text],
        'headings' => ['en' => $user['first_name'] . " " . $user['last_name']], // Use a function to get full name
        'android_led_color' => 'FF0000FF',
        'priority' => 10,
        'data' => [
            'user_id' => $user['id'], // Use a function to get user ID
            'user_profile' => $user['avatar'], // Use a function to get avatar
            'type' => $type,

            'username' => $user['first_name'] . " " . $user['last_name'],


        ],
        'large_icon' => $user['avatar'] // Use a function to get avatar
    ];
    $fields = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $responseData = json_decode($response, true);

    if ($responseData === null) {
        // Handle invalid JSON response
        echo '<div style="color: red;">' . 'Invalid JSON response from OneSignal API' . '</div>';
        exit();
    }
}

function getuserwallet($user_id)
{
    $transactionModel = new TransactionModel();
    $creditAmount = $transactionModel->selectSum('amount', 'total')
        ->where('user_id', $user_id)
        ->where('flag', 'C')
        ->get()
        ->getRow()
        ->total;

    $debitAmount = $transactionModel->selectSum('amount', 'total')
        ->where('user_id', $user_id)
        ->where('flag', 'D')
        ->get()
        ->getRow()
        ->total;

    return  $creditAmount - $debitAmount;
}
/**
 * Initializes and configures email settings.
 * 
 * Retrieves settings from application configuration to initialize the email library.
 * 
 * @return \CodeIgniter\Email\Email Prepared Email instance with configured settings.
 */
if (!function_exists('getMailConfiguration')) {
    function getMailConfiguration()
    {
        $email = \Config\Services::email();
        $config = [
            'protocol'   => get_setting('mail_mailer'),
            'SMTPHost'   => get_setting('mail_host'),
            'SMTPPort'   => get_setting('mail_port'),
            'SMTPUser'   => get_setting('mail_username'),
            'SMTPPass'   => get_setting('mail_password'),
            'SMTPCrypto' => get_setting('mail_encryption'),
            'mailType'   => get_setting('mail_type'),
        ];
        $email->initialize($config);
        $email->setFrom(get_setting('mail_username'), get_setting('mail_from_name'));
        return $email;
    }
}


/**
 * Send an email.
 * 
 * @param mixed $to Recipient(s).
 * @param string $subject Subject line.
 * @param string $message Email body.
 * @param array $options (Optional) Extra options like attachments.
 * @param bool $convert_message_to_html (Optional) Convert message to HTML.
 * @return bool True on success, false on failure.
 */
if (!function_exists('send_app_mail')) {
    function send_app_mail($to, $subject, $message, $options = [], $convert_message_to_html = true)
    {
        // Logging recipient(s)
        $emails_for_log = is_array($to) ? implode(',', $to) : $to;
        log_message('notice', "Sending email to: $emails_for_log with Subject: $subject");

        // Initializing email configuration
        $email = \CodeIgniter\Config\Services::email();
        $config = [
            'protocol' => get_setting('mail_mailer'),
            'mailType' => $convert_message_to_html ? 'html' : get_setting('mail_type'),
            'charset'  => 'utf-8',
        ];

        // Adding SMTP settings if protocol is SMTP
        if ($config['protocol'] === 'smtp') {
            $config += [
                'SMTPHost'   => get_setting('mail_host'),
                'SMTPPort'   => get_setting('mail_port'),
                'SMTPUser'   => get_setting('mail_username'),
                'SMTPPass'   => get_setting('mail_password'),
                'SMTPCrypto' => get_setting('mail_encryption') !== 'none' ? get_setting('mail_encryption') : '',
            ];
        }

        $email->initialize($config);
        $email_from_address = get_setting('email_from_address'); // Default "from" address
        $email_from_name = get_setting('mail_from_name'); // "From" name/ "From" name
        $email->setFrom($email_from_address, $email_from_name);
        $email->setTo($to);
        $email->setSubject($subject);

        // HTML message conversion
        if ($convert_message_to_html && $config['mailType'] === 'html') {
            $message = htmlspecialchars_decode($message);
        }
        $email->setMessage($message);

        // Handling attachments
        if (isset($options['attachments']) && is_array($options['attachments'])) {
            foreach ($options['attachments'] as $attachment) {
                $email->attach($attachment['file_path'], 'attachment', $attachment['file_name']);
            }
        }

        // Setting reply-to, cc, and bcc if provided
        if (!empty($options['reply_to'])) {
            $email->setReplyTo($options['reply_to']);
        }
        if (!empty($options['cc'])) {
            $email->setCC($options['cc']);
        }
        if (!empty($options['bcc'])) {
            $email->setBCC($options['bcc']);
        }

        // Attempting to send the email
        if ($email->send()) {
            return true;
        } else {
            // Optional: Log email error details in non-production environments
            if (ENVIRONMENT !== 'production') {
                log_message('error', $email->printDebugger(['headers']));
            }
            return false;
        }
    }
}


/**
 * Retrieves the user's relationship status based on the provided ID.
 *
 * @param int $id The index representing the user's relationship status.
 * @return string The description of the user's relationship status.
 */
if (!function_exists('getuserrelation')) {
    function getuserrelation($id)
    {
        $relationArray = [
            0 => 'None',
            1 => 'Single',
            2 => 'In a Relationship',
            3 => 'Married',
            4 => 'Engaged',
        ];

        // Return the relationship status if the ID exists in the array; otherwise, return 'None'
        return isset($relationArray[$id]) ? $relationArray[$id] : 'None';
    }
}

if (!function_exists('sendmailnotificaiton')) {

    function sendmailnotificaiton($email, $subject, $notification_text)

    {

        $SendEmail = new SendEmail;
        // SET DATA TO SEND TO EMAIL CONTENT
        $data = [

            'first_name' => getCurrentUser()['first_name'],
            'last_name' => getCurrentUser()['last_name'],
            'profile_image' => getCurrentUser()['avatar'],
            'notification_text' => $notification_text,
        ];

        // SET DATA FOR EMAIL HEADERS
        $emaildata = [

            'to' => $email,


            'subject' => $subject,
            'fromEmail' => get_setting('mail_from_name'),
            'fromName' => get_setting('email_from_address'),
            'message_view' => 'emailnotification.php',
            'messagedata' => $data,
        ];

        // SEND DATA TO SEND EMAIL LIBRARY
        echo  $SendEmail->build($emaildata);
    }
}





function getPayPalApiContext()
{
    
    // Load PayPal config
    $config = new PayPalConfig();
    $paypalConfig = $config->getPayPalConfig();

    // Create the PayPal API context with credentials
    $apiContext = new ApiContext(
        new OAuthTokenCredential($paypalConfig['clientId'], $paypalConfig['clientSecret'])
    );

    // Set API mode and log configuration
    $apiContext->setConfig([
        'mode' => $paypalConfig['mode'],  // sandbox or live
        'log.LogEnabled' => true,
        'log.FileName' => WRITEPATH . 'logs/PayPal.log',
        'log.LogLevel' => 'DEBUG', // DEBUG for development
        'cache.enabled' => true,
    ]);

    return $apiContext;
}

function createPayPalPayment($amount, $currency = 'USD', $description = 'Deposit')
{
    require_once APPPATH . 'ThirdParty/PayPal/Api/Payer.php';
    require_once APPPATH . 'ThirdParty/PayPal/Api/Amount.php';
    require_once APPPATH . 'ThirdParty/PayPal/Api/Transaction.php';
    require_once APPPATH . 'ThirdParty/PayPal/Api/Payment.php';
    require_once APPPATH . 'ThirdParty/PayPal/Api/RedirectUrls.php';
    require_once APPPATH . 'ThirdParty/PayPal/Auth/OAuthTokenCredential.php';
    require_once APPPATH . 'ThirdParty/PayPal/Rest/ApiContext.php';
    require_once APPPATH . 'ThirdParty/PayPal/Api/PaymentExecution.php';
    // Set payment method as PayPal
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    // Set payment amount and currency
    $amountObj = new Amount();
    $amountObj->setTotal($amount);
    $amountObj->setCurrency($currency);
    
    // Set transaction details
    $transaction = new Transaction();
    $transaction->setAmount($amountObj);
    $transaction->setDescription($description);

    // Set return and cancel URLs
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(base_url('paypal/success'))
                 ->setCancelUrl(base_url('paypal/cancel'));

    // Create a new payment object
    $payment = new Payment();
    $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions([$transaction])
            ->setRedirectUrls($redirectUrls);

    
    try {
        // Create payment and get approval URL
        $payment->create(getPayPalApiContext());
        return $payment->getApprovalLink();
    } catch (Exception $ex) {
        // Handle errors here
        echo "<pre>";
        return $ex;
    }
}



if (!function_exists('get_available_languages')) {
    /**
     * Get a list of available languages from the language directory with their full names.
     *
     * @return array
     */
    function get_available_languages()
    {
        // Define an associative array mapping language codes to full names
        $popularLanguages = [
            'ar' => 'Arabic',
            'de' => 'German',
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'nl' => 'Dutch',
            'ur' => 'Urdu',
            'zh' => 'Chinese',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'it' => 'Italian',
            'ja' => 'Japanese',
            'ko' => 'Korean',
            'hi' => 'Hindi',
            'bn' => 'Bengali',
            'tr' => 'Turkish',
            'vi' => 'Vietnamese',
            'th' => 'Thai',
            'sv' => 'Swedish',
            'pl' => 'Polish',
            'id' => 'Indonesian',
            'ms' => 'Malay',
            'fa' => 'Persian',
            'he' => 'Hebrew',
            'uk' => 'Ukrainian',
            'el' => 'Greek',
            'cs' => 'Czech',
            'hu' => 'Hungarian',
            'ro' => 'Romanian',
            'da' => 'Danish',
            'fi' => 'Finnish',
            'no' => 'Norwegian',
            'sk' => 'Slovak',
            'sr' => 'Serbian',
            'bg' => 'Bulgarian',
            'hr' => 'Croatian',
            'sl' => 'Slovenian',
            'lt' => 'Lithuanian',
            'lv' => 'Latvian',
            'et' => 'Estonian'
        ];
        

        $languages = [];
        $langDirectory = APPPATH . 'Language'; // Path to the Language directory

        // Check if the directory exists
        if (is_dir($langDirectory)) {
            // Open the directory and read its contents
            if ($handle = opendir($langDirectory)) {
                while (false !== ($entry = readdir($handle))) {
                    // Exclude current and parent directory entries
                    if ($entry != "." && $entry != ".." && is_dir($langDirectory . DIRECTORY_SEPARATOR . $entry)) {
                        // If the language code exists in the popular languages array, get the full name
                        $languages[$entry] = $popularLanguages[$entry] ?? ucfirst($entry); // Use the language code itself if not found in popularLanguages
                    }
                }
                closedir($handle);
            }
        }

        return $languages; // Return array where key is code, value is full language name
    }
    function check_purchase_code() {
        $filePath = 'purchase_code.txt';
       
        if (!file_exists($filePath)) {
            header("Location:".base_url('verify-purchase-code'));
            exit();  
        }
        $purchaseCode = trim(file_get_contents($filePath));
        if (empty($purchaseCode)) {
            header("Location:".base_url('verify-purchase-code'));
            exit();  
        }
        return 0;
    }
}

