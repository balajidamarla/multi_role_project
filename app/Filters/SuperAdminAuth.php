<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SuperAdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in and is a super admin
        if (session()->get('role') !== 'superadmin') {
            // Option 1: Show 404 if not allowed
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            // Option 2 (alternative): Redirect to unauthorized page
            // return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing
    }
}
