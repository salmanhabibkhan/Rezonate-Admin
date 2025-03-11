<?php

try {

    ini_set('max_execution_time', 300); //300 seconds 

    if (isset($_POST)) {
        $host = $_POST["host"];
        $dbuser = $_POST["dbuser"];
        $dbpassword = $_POST["dbpassword"];
        $dbname = $_POST["dbname"];
        $dbprefix = $_POST["dbprefix"];
        $purchasecode = $_POST['purchasecode'];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $email = $_POST["email"];
        

        //$purchase_code = $_POST["purchase_code"];

        //check required fields
        if (!($host && $dbuser && $dbname && $first_name && $last_name && $email && $dbprefix && $purchasecode)) {
            echo json_encode(array("success" => false, "message" => "Please input all fields."));
            exit();
        }

        //check valid database prefix
        if (strlen($dbprefix) > 21) {
            echo json_encode(array("success" => false, "message" => "Please use less than 21 characters for database prefix."));
            exit();
        }

        //check for valid email
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo json_encode(array("success" => false, "message" => "Please input a valid email."));
            exit();
        }


        //validate purchase code
        // $verification = verify_purchase_code($purchase_code);
        // if (!$verification || $verification != "verified") {
        //     echo json_encode(array("success" => false, "message" => "Please enter a valid purchase code."));
        //     exit();
        // }

        //check for valid database connection
        $mysqli = @new mysqli($host, $dbuser, $dbpassword, $dbname);

        if (mysqli_connect_errno()) {
            echo json_encode(array("success" => false, "message" => $mysqli->connect_error));
            exit();
        }


        //all input seems to be ok. check required fiels
        if (!is_file('database.sql')) {
            echo json_encode(array("success" => false, "message" => "The database.sql file could not found in install folder!"));
            exit();
        }


        /*
         * check the db config file
         * if db already configured, we'll assume that the installation has completed
         */


        $db_file_path = "../app/Config/Database.php";
        $db_file = file_get_contents($db_file_path);
        $is_installed = strpos($db_file, "WRITE_hostname");

        if (!$is_installed) {
            echo json_encode(array("success" => false, "message" => "Seems this app is already installed! You can't reinstall it again."));
            exit();
        }


        //start installation

        $sql = file_get_contents("database.sql");

        //set admin information to database
        $now = date("Y-m-d H:i:s");



        
        //set database prefix
        $sql = str_ireplace('DROP TABLE IF EXISTS `', 'DROP TABLE IF EXISTS `' . $dbprefix, $sql);
        $sql = str_ireplace('CREATE TABLE `', 'CREATE TABLE `' . $dbprefix, $sql);
        // Since your sample SQL does not include an INSERT statement, this line will not modify anything, but it's correct as per your requirement
        $sql = str_ireplace('insert  into `', 'INSERT INTO `' . $dbprefix, $sql);
        $sql = str_ireplace('ALTER TABLE `', 'ALTER TABLE `' . $dbprefix, $sql);
       
       
       
        //create tables in datbase 

        $mysqli->multi_query($sql);
        do {
            
        } while (mysqli_more_results($mysqli) && mysqli_next_result($mysqli));

        $mysqli->close();
        // database created
        // set the database config file
    
        $db_file = str_replace('WRITE_hostname', $host, $db_file);
        $db_file = str_replace('WRITE_db_username', $dbuser, $db_file);
        $db_file = str_replace('WRITE_db_password', $dbpassword, $db_file);
        $db_file = str_replace('WRITE_database_name', $dbname, $db_file);
        $db_file = str_replace('WRITE_dbprefix', $dbprefix, $db_file);

        file_put_contents($db_file_path, $db_file);

        $purchasecodefilePath = "../purchase_code.txt";

// Check if the file exists
        if (!file_exists($purchasecodefilePath)) {
            // Create the file if it doesn't exist
            file_put_contents($purchasecodefilePath, 'WRITE_PURCHASECODE');
        }

        // Get the contents of the file
        $purchasecodefile = file_get_contents($purchasecodefilePath);

        // Replace the placeholder 'WRITE_PURCHASECODE' with the actual purchase code
        $changeabletext = str_replace('WRITE_PURCHASECODE', $purchasecode, $purchasecodefile);

        // Write the modified content back into the file
        file_put_contents($purchasecodefilePath, $changeabletext);
        $index_file_path = "../index.php";
         $index_file = file_get_contents($index_file_path);
        $count = preg_match_all('/pre_installation/', $index_file, $matches);

        if ($count === 2) {
            $index_file = preg_replace('/pre_installation/', 'installed', $index_file, 1); // replace only the first occurrence of 'pre_installation'
            file_put_contents($index_file_path, $index_file);
        }

        echo json_encode(array("success" => true, "message" => "Installation successfull."));
        
        exit();
    }
} catch (\Exception $ex) {
   error_log(date('[Y-m-d H:i:s e] ') . $ex->getMessage() . PHP_EOL, 3, "../writable/logs/install.log");
   echo json_encode(array("success" => false, "message" => "Something went wrong. Please check the error log for more details.".$ex->getMessage()));
}

// function verify_purchase_code($code) {
// 	return 'verified';
//     $code = urlencode($code);
//     $url = "https://verify.socioon.com/?type=install&code=" . $code . "&domain=" . $_SERVER['HTTP_HOST'];

//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
//     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
//     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
//     curl_setopt($ch, CURLOPT_HTTPHEADER, Array('Content-type: text/plain'));

//     $data = curl_exec($ch);
//     curl_close($ch);

//     if (!$data) {
//         $data = file_get_contents($url);
//     }

//     return $data;
// }
