<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityLog_Model extends BaseModel {


	public $_table = "activity_logs";


	public function __construct() {
		parent::__construct();
	}
}
