<?php

$db_file_path = "../app/Config/Database.php";
$db_file = file_get_contents($db_file_path);
$is_installed = strpos($db_file, "WRITE_hostname");

// Construct dashboard URL
$protocol = (!empty($_SERVER['HTTPS']) ? "https://" : "http://");
$dashboard_url = $protocol . $_SERVER['HTTP_HOST'] . preg_replace('/install.*/', '', $_SERVER['SCRIPT_NAME']);

if (!$is_installed) {
    include "view/already_installed.php";
    $index_file_path = "../index.php";

    $index_file = file_get_contents($index_file_path);
    $count = preg_match_all('/pre_installation/', $index_file, $matches);

    if ($count === 2) {
        $index_file = preg_replace('/pre_installation/', 'installed', $index_file, 1); // replace only the first occurrence of 'pre_installation'
        file_put_contents($index_file_path, $index_file);
    }
    exit();
}

$php_version_required = "8.0";
$current_php_version = PHP_VERSION;

// Redefine success flags based on direct checks or the consolidated $requirements array
$php_version_success = version_compare(PHP_VERSION, $php_version_required, ">=");
$mysql_success = function_exists("mysqli_connect");
$curl_success = function_exists("curl_version");
$mbstring_success = extension_loaded('mbstring');
$intl_success = extension_loaded('intl');
$json_success = extension_loaded('json');
$mysqlnd_success = extension_loaded('mysqlnd');
$xml_success = extension_loaded('xml');
$gd_success = extension_loaded('gd') && function_exists('gd_info');
$zlib_success = !ini_get("zlib.output_compression");

// Check if all requirements are met
$all_requirement_success = $php_version_success && $mysql_success && $curl_success && $mbstring_success && $intl_success && $json_success && $mysqlnd_success && $xml_success && $gd_success && $zlib_success;

// Array of writable directories
$writeable_directories = [
    '/writable',
    '/uploads',
    '/index.php',
    '/app/Config/Database.php',
];

// Verify writability of directories
foreach ($writeable_directories as $key => $value) {
    if (!is_writable(".." . $value)) {
        $all_requirement_success = false;
        break; // Exit loop if any directory is not writable
    }
}


// Include the view
include "view/index.php";
?>
