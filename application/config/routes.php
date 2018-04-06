<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route["default_controller"] = "SiteController/index";

# project
$route['project/(:any)'] = "FileController/project/$1";
$route['get_dir_contents'] = "FileController/get_dir_contents";
$route['get_bin_contents'] = "FileController/get_bin_contents";
$route['add_file'] = "FileController/add_file";
$route['delete_file/(:any)'] = "FileController/delete_file/$1";
$route['restore_file/(:any)'] = "FileController/restore_file/$1";

# api
$route['api/user/(:any)'] = "UserController/get/$1";
$route['api/icon/(:any)'] = "FileController/getIconClass/$1";

$route['404_override'] = '';
$route['translate_uri_dashes'] = false;
