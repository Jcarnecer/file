<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member_Model extends BaseModel {

	public $belongs_to = ['project' => ['model' => 'Project_Model', 'primary_key' => 'project_id']];

	public $_table = "pj_members";


	public function __construct() {
		parent::__construct();
	}
}
