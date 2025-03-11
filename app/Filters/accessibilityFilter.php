<?php

namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\API\ResponseTrait;
use Exception;

class accessibilityFilter implements FilterInterface
{
    use ResponseTrait;
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        
        if (!empty($arguments)) {
            if($arguments['0'] == "page"){
                if(get_setting("chck-pages") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "group"){
                if(get_setting("chck-groups") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "game"){
                if(get_setting("chck-games") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "event"){
                if(get_setting("chck-events") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "job"){
                if(get_setting("chck-job_system") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "blog"){
                if(get_setting("chck-blogs") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "story"){
                if(get_setting("chck-user_status") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "space"){
                if(get_setting("chck-space") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
            if($arguments['0'] == "withdraw"){
                if(get_setting("chck-point_allow_withdrawal") != "1"){
                    return $this->failUnauthorized('Access denied: ' );
                }   
            }
           

        
        
        }


        
       
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */

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
