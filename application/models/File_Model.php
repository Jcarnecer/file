<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class File_Model extends BaseModel {

	public $belongs_to = [
		'folder' => ['model'=> 'Folder_Model', 'primary_key' => 'location'],
	];
	
	public $before_create = ['created_at', 'updated_at', 'set_author'];
	public $before_update =['updated_at', 'set_modifier'];


	protected $soft_delete = TRUE;

	public $_table = "file_data";

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
