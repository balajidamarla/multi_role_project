<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PermissionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // First argument should be the required permission name, e.g. 'edit_role'
        $requiredPermission = $arguments[0] ?? null;

        if (!$requiredPermission) {
            // No permission specified, allow access
            return;
        }

        if (!has_permission($requiredPermission)) {
            // Permission denied: redirect or throw error
            return redirect()->to('/no-access')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Not needed here
    }
}
