<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class WebAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
     
        // jika user belum login
        if (!session()->get('logged_in')) {
            // maka redirct ke halaman login
            return view('auth/login');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
