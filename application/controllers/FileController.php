<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FileController extends BaseController
{

	public function __construct() {

		parent::__construct();
	}


	public function project($id) {

		foreach ($this->thread->with('reply')->get_many_by(["project_id" => $id]) as $thread) {
			
			unset($thread['project_id']);
			unset($thread['deleted']);
			$data['threads'][]=$thread;
		}
		$project = $this->project->get($id);
		$this->session->set_userdata(['project' => $project]);

		return parent::main_page("file/index", $data ?? null);
	}
}
