<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// ADMIN
$route['admin'] = 'admin';
$route['admin/login'] = 'user/login';
$route['admin/lockscreen'] = 'user/lockscreen';
$route['admin/forgot-password'] = 'user/forgot_password';
$route['admin/reset'] = 'user/reset';
$route['admin/forgot-password'] = 'user/forgot_password';
$route['admin/redefine-password/(:any)'] = 'user/redefine_password/$1';
$route['admin/forgot-password/send']['post'] = 'user/forgot_password_send';
$route['admin/redefine-password-send']['post'] = 'user/redefine_password_send';
$route['admin/login/access']['post'] = 'user/access';
$route['admin/unlock']['post'] = 'user/unlock';
$route['admin/logout']['post'] = 'user/logout';

// ADMIN/USER
$route['admin/users'] = 'user';
$route['admin/users/new'] = 'user/page_create';
$route['admin/users/view/(:any)'] = 'user/page_update';
$route['admin/users/create']['post'] = 'user/create';
$route['admin/users/update']['post'] = 'user/update';
$route['admin/users/delete']['post'] = 'user/delete';

// PERMISSION/GROUP
$route['admin/nopermission'] = 'permission/nopermission';
$route['admin/permissions'] = 'permission';
$route['admin/permissions/group'] = 'permissiongroup/page_create';
$route['admin/permissions/group/(:any)'] = 'permissiongroup/page_update';
$route['admin/permissions/permission'] = 'permission/page_create';
$route['admin/permissions/permission/(:any)'] = 'permission/page_update';
$route['admin/permissions/create']['post'] = 'permission/create';
$route['admin/permissions/update']['post'] = 'permission/update';
$route['admin/permissionsgroup/create']['post'] = 'permissiongroup/create';
$route['admin/permissionsgroup/update']['post'] = 'permissiongroup/update';

// PAGES
$route['admin/page'] = 'page';
$route['admin/page/new'] = 'page/page_create';

// CONFIGURATIONS GERAL
$route['admin/configuration'] = 'configuration';
$route['admin/configuration/update']['post'] = 'configuration/update';

// PAGES SITE
$route['default_controller'] = 'website';
$route['([a-zA-Z0-9-]+)'] = 'website/page/$1';

// ERRO 404
$route['404_override'] = 'error404';


$route['translate_uri_dashes'] = FALSE;