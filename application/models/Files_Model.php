<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Files_Model extends BaseModel {
	
	protected $_table = "files";

	public function __construct() {
		parent::__construct();
	}

	public function create_folder($data) {
		return $this->insert($data);
	}

	public function get_contents($folder) {
		$data = $this->get_many_by('parent',$folder);
		//var_dump($data); die;
		return $data;
	}

	public function get_folders($project_id) {
		$params = array(
			'project_id' => $project_id,
			'type' => 'folder'
		);
		$data = $this->get_many_by($params);
		//var_dump($data); die;
		return $data;
	}
}