<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        $userRole = $session->get('role');

        // If no role is set, redirect to login
        if (!$userRole) {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        // Ensure $arguments is an array before using it
        if (is_array($arguments) && !in_array($userRole, $arguments)) {
            return redirect()->to('/login')->with('error', 'You are not authorized to access this page.');
        }

        // If allowed, do nothing (allow the request)
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Optional: Post-processing
    }
}
