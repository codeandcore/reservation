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
|	https://codeigniter.com/userguide3/general/routing.html
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
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'user';
$route['admin'] = 'admin';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['(:any)'] = "user/$1";

// Admin-facing help center routes
$route['admin/help_center'] = 'HelpCenter/index';
$route['admin/help_center/update_positions'] = 'HelpCenter/update_positions';
$route['admin/help_center/create_page'] = 'HelpCenter/create_page';
$route['admin/help_center/edit_page/(:any)'] = 'HelpCenter/edit_page/$1';
$route['admin/help_center/delete_page/(:any)'] = 'HelpCenter/delete_page/$1';
$route['admin/help_center/view_page/(:any)'] = 'HelpCenter/view_page/$1';
$route['admin/help_center/create_topic/(:any)'] = 'HelpCenter/create_topic/$1';
$route['admin/help_center/edit_topic/(:any)'] = 'HelpCenter/edit_topic/$1';
$route['admin/help_center/delete_topic/(:any)'] = 'HelpCenter/delete_topic/$1';

// Public-facing help center routes
// $route['admin/simple'] = 'SimpleController/index';
// $route['admin/edit-new-features'] = 'NewFeaturesBackEnd/index';
$route['admin/help'] = 'Help/index';
$route['admin/help/view/(:any)'] = 'Help/view/$1';
$route['admin/help/search'] = 'Help/search';