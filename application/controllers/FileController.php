<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileController extends BaseController
{

	public function __construct() {

		parent::__construct();
	}


	public function project($id) {

		$project = $this->project->get($id);
		$this->session->set_userdata(['project' => $project]);

		// creates new root folder of project if there is none
		$folder = $this->folder->get($id);
		if(!isset($folder)){
			$data = [
				'id' => $id,
				'name' => $project['name'],
				'root' => TRUE
			];
			$this->folder->insert($data);
		}

		return parent::main_page("file/index", $data ?? null);
	}

	/* ************** These are functions to be used when creating new folders.. to be updated ***************** @author JM
	public function create_folder($id) {

		$data = [
			'id' => //generate id,
			'name'=> $this->input->post('name'),
			'location' => $id,
			'root' => FALSE

		];

		return $this->folder->insert($data);
	}

	public function update_folder($id) {

		$data = [
			'name' => $this->input->post('name'),
			'location' => $id
		];

		return $this->folder->update($data)
	}
	*/
}
