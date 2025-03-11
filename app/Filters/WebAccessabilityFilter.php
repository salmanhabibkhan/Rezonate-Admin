<?php

namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class WebAccessabilityFilter implements FilterInterface
{
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
            if (!session()->get('isLoggedIn')) {
                return redirect()->to('login');
            }
            $user = getCurrentUser();
            if($user['is_profile_complete']==0)
            {
                return redirect()->to('start');
            }
        
            if($arguments['0'] == "page"){
                if(get_setting("chck-pages") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "group"){
                if(get_setting("chck-groups") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "game"){
                if(get_setting("chck-games") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "event"){
                if(get_setting("chck-events") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "job"){
                if(get_setting("chck-job_system") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "blog"){
                if(get_setting("chck-blogs") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "story"){
                if(get_setting("chck-user_status") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "withdraw"){
                if(get_setting("chck-point_allow_withdrawal") != "1"){
                    return $this->failUnauthorized( );
                }   
            }
            if($arguments['0'] == "movie"){
                if(get_setting("chck-movies") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "friend"){
                if(get_setting("is_friend_system") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "product"){
                if(get_setting("chck-product") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "package"){
                if(get_setting("chck-point_level_system") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "deleteaccount"){
                if(get_setting("chck-deleteAccount") != "1"){
                    return $this->failUnauthorized();
                }   
            }
            if($arguments['0'] == "blood"){
                if(get_setting("chck-blood") != "1"){
                    return $this->failUnauthorized();
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
        //
    }
    private function failUnauthorized()
    {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    }
}
