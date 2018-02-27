<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route["default_controller"] = "SiteController/index";

# project
$route['project/(:any)'] = "FileController/project/$1";
$route['delete/(:any)'] = "FileController/delete_file/$1";
$route['get_dir_contents'] = "FileController/get_dir_contents";


# api
# $route['api/get_contents'] = 'FileController/show_all_contents';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;