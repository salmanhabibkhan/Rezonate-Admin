<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;
use Exception;

class JWTFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
       
        $authenticationHeader = $request->getServer('HTTP_AUTHORIZATION');
        try {
            $encodedToken = getJWTFromRequest($authenticationHeader);
            validateJWTFromRequest($encodedToken);
            //$user_data = validateJWTFromRequest($encodedToken);
            //return $request;
        } catch (Exception $ex) {
            return $this->failUnauthorized('Access denied: ' . $ex->getMessage());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }
    
    private function failUnauthorized($message)
    {

        $response = service('response');
        $response->setStatusCode(401); // Unauthorized
        return $response->setJSON([
            "status" => 401,
            "error" => true,
            "messages" => $message
        ]);
    }
}
