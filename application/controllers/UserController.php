<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    
    public function __construct() {

		parent::__construct();
    }
    

    public function get($user_id) {
        
        $user = $this->user->get($user_id);
        foreach ($user as $key => $value) {
            if($key == 'first_name' || $key == 'last_name' || $key == 'email_address' || $key == 'avatar_url')
                continue;
            unset($user[$key]);
        }
        echo json_encode([
            'first_name'    => $user['first_name'],
            'last_name'     => $user['last_name'],
            'email_address' => $user['email_address'],
            'avatar_url'    => $user['avatar_url']
        ]);
    }
}