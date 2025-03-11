<?php

/**
 * --------------------------------------------------------------------
 * CODEIGNITER 4 - SimpleAuth
 * --------------------------------------------------------------------
 *
 * This content is released under the MIT License (MIT)
 *
 * @package    SimpleAuth
 * @author     GeekLabs - Lee Skelding 
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://github.com/GeekLabsUK/SimpleAuth
 * @since      Version 1.0
 * 
 */

namespace App\Filters;


use App\Models\UserModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // IF THE USER IS NOT LOGGED IN REDIRECT TO LOGIN
        if (!session()->get('isLoggedIn')) {
            
            
            return redirect()->to('login');
        }
     
        // IF WE PASS A ROLE ARGUMENT IN THE ROUTE
        // CHECK IT MATCHES ROLE OF THE USER OR
        // REDIRECT TO A SAFE PAGE
    
        if (!empty($arguments)) {
            $role_one = $arguments[1] ?? null; // Corrected index from '1' to 1
            $role_two = $arguments[2] ?? null; // Corrected index from '2' to 2
    
            $userRole = session()->get('role');

            
            //completed profile



            if (!empty($role_one) && $role_one == $userRole) {
                // Role matches, do nothing
            } elseif (!empty($role_two) && $role_two == $userRole) {
                // Role matches, do nothing
            } else {
                
                // Redirect to a specific page, e.g., home or access denied
                return redirect()->to('/access-denied'); 
                
                
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}