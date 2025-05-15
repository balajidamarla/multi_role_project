<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->get('/unauthorized', function () {
    return view('errors/unauthorized');
});

$routes->get('/admin/dashboard', 'AdminController::dashboard');
$routes->get('/surveyor/dashboard', 'SurveyorController::dashboard');
$routes->get('/surveyorlite/dashboard', 'SurveyorLiteController::dashboard');

// $routes->get('/superadmin/dashboard', 'SuperAdminController::dashboard', ['filter' => 'role:superadmin']);
// $routes->get('/admin/dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']);
// $routes->get('/surveyor/dashboard', 'SurveyorController::dashboard', ['filter' => 'role:salessurveyor']);
// $routes->get('/surveyorlite/dashboard', 'SurveyorLiteController::dashboard', ['filter' => 'role:surveyorlite']);

$routes->get('/login', 'AuthController::login');
$routes->post('/auth/dologin', 'AuthController::doLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::registerForm');
$routes->post('/auth/register', 'AuthController::register');

//super admin register to admin
$routes->group('superadmin', ['filter' => 'superadminauth'], function ($routes) {
    $routes->get('dashboard', 'SuperAdminController::dashboard');
    $routes->get('add_admin', 'SuperAdminController::addAdminForm');
    $routes->post('create_admin', 'SuperAdminController::createAdmin');
    $routes->get('view_admins', 'SuperAdminController::viewAdmins');
    $routes->post('toggle_status/(:num)', 'SuperadminController::toggle_status/$1');
});

// Logout route (can be shared)
$routes->get('auth/logout', 'SuperadminController::logout');
$routes->post('auth/logout', 'SuperadminController::logout');


//admin panel
$routes->group('admin','salessurveyor', ['filter' => 'adminauth'], function ($routes) {
    // Customer management
    $routes->get('manage_customers', 'AdminController::manageCustomers');
    $routes->get('add_customer', 'AdminController::addCustomerForm');
    $routes->post('store_customer', 'AdminController::storeCustomer');
    $routes->get('delete_customer/(:num)', 'AdminController::deleteCustomer/$1');

    // Teams
    $routes->get('teams', 'Admin\TeamController::index');
    $routes->get('teams/create', 'Admin\TeamController::create');
    $routes->post('teams/store', 'Admin\TeamController::store');
    $routes->get('teams/delete/(:num)', 'Admin\TeamController::delete/$1');

    // Signs
    // $routes->get('signs/create', 'SignController::create');
    // $routes->post('signs/store', 'SignController::store');
    $routes->get('signs/delete/(:num)', 'SignController::delete/$1');

    // Customers detail
    $routes->get('customers', 'CustomerController::index');
    $routes->get('customers/(:num)', 'CustomerController::show/$1');
    $routes->get('delete_customer/(:num)', 'CustomerController::delete/$1');
    $routes->get('customers/report/(:num)', 'CustomerController::report/$1');
});


$routes->get('admin/projects', 'Admin\ProjectController::index');
$routes->get('admin/projects/create', 'Admin\ProjectController::create');
$routes->post('admin/projects/store', 'Admin\ProjectController::store');
$routes->post('admin/projects/store', 'Admin\ProjectController::store');
$routes->get('projects/delete/(:num)', 'Admin\ProjectController::delete/$1');

$routes->get('admin/projects/view/(:num)', 'admin\ProjectController::view/$1');


$routes->get('admin/projects', 'ProjectController::index');
$routes->get('admin/projects/view/(:num)', 'ProjectController::view/$1');
$routes->get('admin/projects/delete/(:num)', 'ProjectController::delete/$1');

$routes->get('admin/projects/edit/(:num)', 'Admin\ProjectController::edit/$1');
$routes->post('admin/projects/update/(:num)', 'Admin\ProjectController::update/$1');
$routes->get('admin/projects/deleteProject/(:num)', 'Admin\ProjectController::deleteProject/$1');
// $routes->get('admin/projects/creates', 'Admin\ProjectController::create');


$routes->post('admin/signs/updateProgress/(:num)', 'SignController::updateProgress/$1');


$routes->get('admin/signs/edit/(:num)', 'SignController::edit/$1');
$routes->post('admin/signs/update/(:num)', 'SignController::update/$1');

$routes->get('admin/signs/create/(:num)', 'SignController::create/$1');
$routes->post('admin/signs/store', 'SignController::store');
$routes->post('admin/signs/updateAssignment/(:num)', 'SignController::updateAssignment/$1');


$routes->get('admin/signs', 'SignController::index');              // View assigned tasks
$routes->get('admin/signs/create', 'SignController::create');      // Show the assign sign form
// $routes->post('signs/store', 'SignController::store');       // Submit new sign
$routes->get('signs/delete/(:num)', 'SignController::delete/$1'); // Delete a sign

//sales surveyor


