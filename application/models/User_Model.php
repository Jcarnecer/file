<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends BaseModel {

	public $id;
	public $first_name;
	public $last_name;
	public $username;
	public $password;
	public $role;
	public $created_at;
	public $last_login_at;
	public $avatar_url;
	public $uuid;
	
	protected $_table = "users";

	public function __construct() {
		parent::__construct();
	}

	public function authenticate_user($email_address, $password) {
		$user = $this->db->get_where('users', ['email_address' => $email_address])->row();

		if ($user && $this->encryption->decrypt($user->password) === $password) {
			unset($user->password);
			$this->session->set_userdata("user", $user);
			return TRUE;
		}
		return FALSE;
	}
}