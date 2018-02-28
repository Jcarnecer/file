<?php
if (!defined('BASEPATH')) exit('No direct access allowed');

class Utilities 
{

	private $CI;


	public function __construct()
	{
		$this->CI =& get_instance();
	}


	public function create_random_string($length = 11)
	{
		$string = "";
	    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

	    for ($i = 0; $i < $length; $i++) {
	        $string .= $characters[rand(0, strlen($characters) - 1)];
	    }

    	return $string;
	}
}