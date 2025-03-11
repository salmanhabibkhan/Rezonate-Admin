<?php

use CodeIgniter\HTTP\IncomingRequest;
use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) { //JWT is absent
        throw new Exception('Missing or invalid JWT in request');
    }
    //JWT is sent from client in the format Bearer XXXXXXXXX
    return explode(' ', $authenticationHeader)[1];
}


function get_app_sessions($encodedToken)
{
    $db = \config\Database::connect();
    return  $db->table('app_sessions')->where('token', $encodedToken)->get()->getFirstRow();
}


function validateJWTFromRequest(string $encodedToken)
{
    $key =  'MYNADSMEISTAHIRANOSDILOVEPASDKISSTAN';
    $leeway = 60; // Leeway in seconds (e.g., 60 seconds)
    JWT::$leeway = $leeway; // Applying leeway
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));

    // get user ip, user_toke, user_id

    if (isset($decodedToken->uid)) {

        $db = \config\Database::connect();
        $builder =   $db->table('app_sessions');
        $builder->where('token', $encodedToken);
        $userdata = $builder->get()->getFirstRow();

        if (empty($userdata)) {
            throw new Exception('Missing or invalid Session');
        }
        if (time() > $decodedToken->exp) {
            throw new Exception('Token Expired');
        }
    }


    if (empty($decodedToken)) {
        throw new Exception('Missing or invalid Token');
    }

    if (!isset($decodedToken->uid)) {
        throw new Exception('Missing or invalid Token');
    }
}


function getSignedJWTForUser(string $email, string $uid)
{
    $issuedAtTime = time();
    $tokenTimeToLive = 364584515;
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;    // expire time in seconds
    $notBeforeClaim = $issuedAtTime + 10;                   // not before in seconds
    $pvtKey = Services::getPrivateKey();                    // get RSA private key (NOT IN USE)
    $key =  'MYNADSMEISTAHIRANOSDILOVEPASDKISSTAN';
    $payload = [
        "iss" => "SocioOn",
        "nbf" => $notBeforeClaim,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
        'email' => $email,
        'uid' => $uid
    ];
    return JWT::encode($payload, $key, 'HS256');
}

function getCurrentUser()
{

    $request = request();
    $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
    if (empty($authenticationHeader)) {

        if (is_null($authenticationHeader) && empty(session()->get('isLoggedIn'))) {
            return [
                'id' => 0,
                'username' => '',
                'avatar' => '',
                'first_name' => '',
                'last_name' => '',
                'role' => 0
            ];
        } else {
            return session()->get();
        }
    }

    if (is_null($authenticationHeader)) {
        return [];
    }

    $encodedToken = explode(' ', $authenticationHeader)[1];
    $key =  'MYNADSMEISTAHIRANOSDILOVEPASDKISSTAN';
    $leeway = 60; // Leeway in seconds
    JWT::$leeway = $leeway; // Applying leeway
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));

    if (empty($decodedToken)) {
        return [];
    }

    if (!isset($decodedToken->uid)) {
        return [];
    }
    $userModel = new UserModel();
    $user = $userModel->find($decodedToken->uid);

    if (empty($user['avatar'])) {
        $user['avatar'] = getMedia('uploads/placeholder/avatar-1.jpg');
        if ($user['gender'] == "Female") {
            $user['avatar'] = getMedia('uploads/placeholder/avatar-f1.jpg');
        }
    }

    $user['avatar'] = getMedia($user['avatar'], 'avatar');
    $user['cover'] = getMedia($user['cover'], 'cover');

    return $user;
}
