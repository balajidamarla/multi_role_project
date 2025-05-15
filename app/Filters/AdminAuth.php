<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!in_array(session()->get('role'), ['admin', 'salessurveyor'])) {
            // Show 404 if unauthorized
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

            // OR redirect instead (optional):
            // return redirect()->to('/unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing to do after
    }
}
