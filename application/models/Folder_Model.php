<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Folder_Model extends BaseModel {

	public $has_many = [
		'folder' => ['model'=> 'Folder_Model', 'primary_key' => 'location'],
		'file' => ['model' => 'File_Model', 'primary_key' => 'location']
	];
	public $before_create = ['created_at', 'updated_at', 'set_author'];
	public $before_update =['updated_at', 'set_modifier'];


	protected $soft_delete = TRUE;

	public $_table = "file_folders";

	public function __construct() {
		parent::__construct();
	}


	protected function set_author($folder) {

		$folder['created_by'] = $folder['updated_by'] = $this->session->user->id;

		return $folder;
	}


	public function set_modifier($folder) {

		$folder['updated_by'] = $this->session->user->id;

		return $folder;
	}
}
