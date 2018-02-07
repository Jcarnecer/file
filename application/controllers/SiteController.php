<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SiteController extends BaseController
{

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		if (parent::current_user()) {
			parent::main_page("dashboard");
			if(ENVIRONMENT === 'development')
				redirect('http://localhost/task');
			else
				redirect('http://task.payakapps.com');
		} else {
			redirect(LOGIN_URL);
		}
	}
}
