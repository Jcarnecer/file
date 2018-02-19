<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileController extends BaseController
{

	public function __construct() {

		parent::__construct();
		$this->load->model('Files_Model');
		$this->load->library('upload');
	}

	public function project($id) {

		$project = $this->project->get($id);
		$this->session->set_userdata(['project' => $project]);
		
		//var_dump($data['dirs']); die;

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

<<<<<<< HEAD
	public function make_new_folder() {
		$this->load->library('Utilities');

		//var_dump($this->session->project['id']); die;

		$new_folder_data = array(
			'id' => $this->utilities->create_random_string(11),
			'name' => $this->input->post('new_folder_name'),
			'type' => 'folder',
			'parent' => $this->session->project['id'],
			'company_id' => $this->session->project['company_id'],
			'project_id' => $this->session->project['id'],
			'owner_id' => $this->session->user->id
		);

		if ($this->Files_Model->create_folder($new_folder_data)) {
			echo "ERROR IN INSERTING"; die;
		}

		$project_id = $this->session->project['id'];
		redirect("project/$project_id");
	}

	public function show_all_contents() {
		$result = $this->Files_model->get_contents();

		$data['dirs'] = $result;
		//var_dump($data['dirs']); die;
		return parent::main_page("file/index", $data ?? null);
		
		//echo json_encode($result);
	}

	public function add_file(){
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'txt|doc|docx|xls|xlsx|ppt|pptx|zip|rar|jpg|gif|png';
		$config['max_size'] = 120000;
		$config['max_filename'] = 255;
		$config['max_filename_increment'] = 999;
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;

		//var_dump($config); die;

		$this->upload->initialize($config);		
		
		if (!$this->upload->do_upload('new_file'))
		{
			//$data = array('upload_data' => $this->upload->data());
			$error = array('error' => $this->upload->display_errors());
			//$this->load->view('error', $error);
			var_dump($error); die;
		}
		else
		{	
			$new_file_data = array(
				'id' => $this->upload->data('raw_name'),
				'name' => $this->upload->data('orig_name'),
				'type' => $this->upload->data('file_ext'),
				'parent' => $this->session->project['id'],
				'company_id' => $this->session->project['company_id'],
				'project_id' => $this->session->project['id'],
				'owner_id' => $this->session->user->id,
				'path' => $this->upload->data('file_name')
			);

			//var_dump($new_file_data); die;
			
			if ($this->Files_Model->create_folder($new_file_data)) {
				echo "ERROR IN INSERTING"; die;
			}

			$project_id = $this->session->project['id'];
			redirect("project/$project_id");
		}
	}
=======
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
>>>>>>> master
}
