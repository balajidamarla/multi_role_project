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

// Logout 
$routes->get('auth/logout', 'SuperadminController::logout');
$routes->post('auth/logout', 'SuperadminController::logout');


//admin panel
$routes->group('admin', 'salessurveyor', ['filter' => 'adminauth'], function ($routes) {
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
$routes->get('admin/projects/delete/(:num)', 'Admin\ProjectController::delete/$1');


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
$routes->post('signs/setDueDate', 'SignController::setDueDate');



$routes->get('admin/signs/create/(:num)', 'SignController::create/$1');
$routes->post('admin/signs/store', 'SignController::store');
$routes->post('admin/signs/updateAssignment/(:num)', 'SignController::updateAssignment/$1');


$routes->get('admin/signs', 'SignController::index');              // View assigned tasks
$routes->get('admin/signs/create', 'SignController::create');      // Show the assign sign form
// $routes->post('signs/store', 'SignController::store');       // Submit new sign
$routes->get('signs/delete/(:num)', 'SignController::delete/$1'); // Delete a sign

//surveyorlite
$routes->get('admin/signs/view/(:num)', 'SignController::view/$1');

//------------------------------------------------------------------------------------------------------------------
$routes->get('team/create', 'TeamController::showCreateForm');


$routes->get('admin/roles/edit/(:num)', 'RoleController::edit/$1');
$routes->post('admin/roles/update/(:num)', 'RoleController::update/$1');
$routes->get('admin/roles', 'RoleController::index');
$routes->get('admin/roles/delete/(:num)', 'RoleController::delete/$1');

$routes->get('admin/team', 'TeamController::index', ['filter' => 'permission:view_team']);
$routes->get('admin/teams/create', 'TeamController::create', ['filter' => 'permission:create_team,admin_access']);

$routes->get('admin/roles/edit/(:num)', 'RoleController::edit/$1', ['filter' => 'permission:edit_role']);
$routes->post('admin/roles/update/(:num)', 'RoleController::update/$1', ['filter' => 'permission:edit_role']);
//add roles
$routes->get('admin/roles/create', 'RoleController::create');
$routes->post('admin/roles/store', 'RoleController::store');
//permissions
$routes->get('admin/permissions', 'PermissionController::index');
$routes->get('admin/permissions/create', 'PermissionController::create');
$routes->post('admin/permissions/store', 'PermissionController::store');
$routes->get('admin/permissions/edit/(:num)', 'PermissionController::edit/$1');
$routes->post('admin/permissions/update/(:num)', 'PermissionController::update/$1');
$routes->get('admin/permissions/delete/(:num)', 'PermissionController::delete/$1');

// $routes->get('admin/roles/edit/(:num)', 'RoleController::edit/$1');
// $routes->post('admin/roles/update/(:num)', 'RoleController::update/$1');
$routes->get('no-access', function () {
    return view('errors/no_access');
});

//profiles
$routes->get('admin/roles/(:segment)', 'UserController::showRole/$1');
$routes->post('admin/user/update/(:num)', 'UserController::update/$1');


//search input for customers
$routes->get('admin/search_customers', 'CustomerController::searchCustomers');
// $routes->get('signs/filter', 'SignController::filter');
$routes->get('signs/search', 'SignsController::searchSigns');

// $routes->get('signs/filterByName', 'SignsController::filterByName');




//-------------------------------------------------------------------------------------------

//jwt API's
$routes->post('api/login', 'api\ApiLoginController::login');
$routes->get('api/login', 'api\ApiLoginController::login');

$routes->group('api', ['filter' => 'jwt'], function ($routes) {
    $routes->get('protected-data', 'api\ApiLoginController::protectedData');
    $routes->get('customers', 'api\CustomerApiController::index');
    $routes->get('projects', 'api\ProjectApiController::index');
    $routes->get('signs', 'api\SignsApiController::index');
    $routes->get('users', 'api\UsersApiController::index');
    $routes->get('roles', 'api\RoleApiController::index');
    $routes->get('permissions', 'api\PermissionsApiController::index');
    

});

