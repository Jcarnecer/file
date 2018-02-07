<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RolePermission_Model extends BaseModel {

	public $_table = "roles_permissions";

	public function __construct() {
		parent::__construct();
	}
}
