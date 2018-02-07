<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Thread_Model extends BaseModel {

	public $belongs_to = ['user'];
	public $has_many = ['reply' => ['model'=> 'Reply_Model', 'primary_key' => 'thread_id']];
	public $before_create = ['created_at', 'updated_at'];
	public $before_update =['updated_at'];
	public $title;
	public $body;
	public $user_id;
	public $created_at;


	protected $soft_delete = TRUE;

	public $_table = "forum_threads";

	public function __construct() {
		parent::__construct();
	}
}
