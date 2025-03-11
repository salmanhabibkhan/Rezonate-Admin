<?php

define('ACTIVE_THEME', 'socio');


defined('APP_NAMESPACE') || define('APP_NAMESPACE', 'App');


defined('THEME_VIEWS')  || define('THEME_VIEWS',  'themes/' . ACTIVE_THEME . '/views/');
defined('THEME_ASSETS') || define('THEME_ASSETS',  'themes/' . ACTIVE_THEME . '/assets/');



// My Constant  
define('CURRECY_ARRAY', [
    'USD',
    'EUR',
    'JPY',
    'TRY',
    'GBP',
    'RUB',
    'PLN',
    'ILS',
    'BRL',
    'INR',
    'PKR'
]);

defined('PAGE_CATEGORIES') or define('PAGE_CATEGORIES', [
   
    1 => 'Arts & Entertainment',
    2 => 'Business & Finance',
    3 => 'Education & Learning',
    4 => 'Fashion & Beauty',
    5 => 'Food & Beverage',
    6 => 'Health & Wellness',
    7 => 'News & Media',
    8 => 'Science & Technology',
    9 => 'Sports & Recreation',
    10 => 'Travel & Tourism',
    11 => 'Community & Social Services',
    12 => 'Home & Garden',
    13 => 'Real Estate',
    14 => 'Automotive',
    15 => 'Pets & Animals',
    16 => 'Music & Performing Arts',
    17 => 'Photography & Visual Arts',
    18 => 'Legal & Government',
    19 => 'Environmental & Nature',
    20 => 'Hobbies & Crafts',
    21 => 'Books & Literature',
    22 => 'Religion & Spirituality'
]);


defined('GROUP_CATEGORIES') or define('GROUP_CATEGORIES', [

    1 => 'Arts & Entertainment',
    2 => 'Business & Finance',
    3 => 'Education & Learning',
    4 => 'Fashion & Beauty',
    5 => 'Food & Beverage',
    6 => 'Health & Wellness',
    7 => 'News & Media',
    8 => 'Science & Technology',
    9 => 'Sports & Recreation',
    10 => 'Travel & Tourism',
    11 => 'Community & Social Services',
    12 => 'Home & Garden',
    13 => 'Real Estate',
    14 => 'Automotive',
    15 => 'Pets & Animals',
    16 => 'Music & Performing Arts',
    17 => 'Photography & Visual Arts',
    18 => 'Legal & Government',
    19 => 'Environmental & Nature',
    20 => 'Hobbies & Crafts',
    21 => 'Books & Literature',
    22 => 'Religion & Spirituality'
]);

define('JOB_CATEGORIES', [
    1 => 'Healthcare',
    2 => 'Government',
    3 => 'Science and Research',
    4 => 'Information Technology',
    5 => 'Transportation',
    6 => 'Education',
    7 => 'Finance',
    8 => 'Sales',
    9 => 'Engineering',
    10 => 'Hospitality',
    11 => 'Retail',
    12 => 'Human Resources',
    13 => 'Construction',
    14 => 'Marketing',
    15 => 'Legal',
    16 => 'Customer Service',
    17 => 'Design',
    18 => 'Media and Entertainment',
    19 => 'Agriculture and Forestry',
    20 => 'Arts and Culture',
    21 => 'Real Estate',
    22 => 'Manufacturing',
    23 => 'Environmental',
    24 => 'Non-Profit and Social Services',
    25 => 'Telecommunications',
    26 => 'Sports and Recreation',
    27 => 'Travel and Tourism',
    28 => 'Food Services',
    29 => 'Beauty and Wellness',
    30 => 'Security and Law Enforcement'
]);

defined('LANGUAGE_') or define('LANGUAGES', [
    1 => 'English',
    2 => 'Spanish',
    3 => 'French',
    4 => 'German',
    5 => 'Italian',
    // Add more languages as needed
]);
define('MOVIE_GENRES', [
        'Action',
        'Adventure',
        'Comedy',
        'Drama',
        'Thriller',
        'Horror',
        'Science Fiction (Sci-Fi)',
        'Fantasy',
        'Mystery',
        'Romance',
        'Animation',
        'Family',
        'Superhero',
        'Documentary',
        'Biography'
]);
defined('BLOG_CATEGORIES') or define('BLOG_CATEGORIES', [
    1 => "Cars and Vehicles",
    2 => "Comedy",
    3 => "Economics and Trade",
    4 => "Education",
    5 => "Entertainment",
    6 => "Movies & Animation",
    7 => "Gaming",
    8 => "History and Facts",
    9 => "Live Style",
    10 => "Natural",
    11 => "News and Politics",
    12 => "People and Nations",
    13 => "Pets and Animals",
    14 => "Places and Regions",
    15 => "Science and Technology",
    16 => "Sport",
    17 => "Travel and Events",
    18 => "Other"
]);
define('PRODUCT_CATEGORIES', [
   
    1 => "Clothing",
    2 => "Home and Furniture",
    3 => "Books and Media",
    4 => "Beauty and Personal Care",
    5 => "Sports and Outdoors",
    6 => "Toys and Games",
    7 => "Automotive",
    8 => "Health and Wellness",
    9 => "Grocery and Food",
    10 => "Electronics",
]);

define('IS_DEMO', false);
/*
 | --------------------------------------------------------------------------
 | Composer Path
 | --------------------------------------------------------------------------
 |
 | The path that Composer's autoload file is expected to live. By default,
 | the vendor folder is in the Root directory, but you can customize that here.
 */
defined('COMPOSER_PATH') || define('COMPOSER_PATH', ROOTPATH . 'vendor/autoload.php');

/*
 |--------------------------------------------------------------------------
 | Timing Constants
 |--------------------------------------------------------------------------
 |
 | Provide simple ways to work with the myriad of PHP functions that
 | require information to be in seconds.
 */
defined('SECOND') || define('SECOND', 1);
defined('MINUTE') || define('MINUTE', 60);
defined('HOUR')   || define('HOUR', 3600);
defined('DAY')    || define('DAY', 86400);
defined('WEEK')   || define('WEEK', 604800);
defined('MONTH')  || define('MONTH', 2_592_000);
defined('YEAR')   || define('YEAR', 31_536_000);
defined('DECADE') || define('DECADE', 315_360_000);

/*
 | --------------------------------------------------------------------------
 | Exit Status Codes
 | --------------------------------------------------------------------------
 |
 | Used to indicate the conditions under which the script is exit()ing.
 | While there is no universal standard for error codes, there are some
 | broad conventions.  Three such conventions are mentioned below, for
 | those who wish to make use of them.  The CodeIgniter defaults were
 | chosen for the least overlap with these conventions, while still
 | leaving room for others to be defined in future versions and user
 | applications.
 |
 | The three main conventions used for determining exit status codes
 | are as follows:
 |
 |    Standard C/C++ Library (stdlibc):
 |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
 |       (This link also contains other GNU-specific conventions)
 |    BSD sysexits.h:
 |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
 |    Bash scripting:
 |       http://tldp.org/LDP/abs/html/exitcodes.html
 |
 */
defined('EXIT_SUCCESS')        || define('EXIT_SUCCESS', 0);        // no errors
defined('EXIT_ERROR')          || define('EXIT_ERROR', 1);          // generic error
defined('EXIT_CONFIG')         || define('EXIT_CONFIG', 3);         // configuration error
defined('EXIT_UNKNOWN_FILE')   || define('EXIT_UNKNOWN_FILE', 4);   // file not found
defined('EXIT_UNKNOWN_CLASS')  || define('EXIT_UNKNOWN_CLASS', 5);  // unknown class
defined('EXIT_UNKNOWN_METHOD') || define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     || define('EXIT_USER_INPUT', 7);     // invalid user input
defined('EXIT_DATABASE')       || define('EXIT_DATABASE', 8);       // database error
defined('EXIT__AUTO_MIN')      || define('EXIT__AUTO_MIN', 9);      // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      || define('EXIT__AUTO_MAX', 125);    // highest automatically-assigned error code

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_LOW instead.
 */
define('EVENT_PRIORITY_LOW', 200);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_NORMAL instead.
 */
define('EVENT_PRIORITY_NORMAL', 100);

/**
 * @deprecated Use \CodeIgniter\Events\Events::PRIORITY_HIGH instead.
 */
define('EVENT_PRIORITY_HIGH', 10);


