<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_Model extends BaseModel {

	public $has_many = [
		'member' => ['model' => 'Member_Model', 'primary_key' => 'project_id'],
		'thread' => ['model' => 'Thread_Model', 'primary_key' => 'project_id']
	];

	public $_table = "pj_projects";

	public function __construct() {
		parent::__construct();
	}
}
