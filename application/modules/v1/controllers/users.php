<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/modules/v1/libraries/REST_Controller.php';
require APPPATH.'/modules/v1/libraries/Format.php';

 

class Users extends REST_Controller {

    private $api_check;
    private $user_key;

    function __construct() {
        parent::__construct();
        $this->load->model("v1/Api_model");

        
        $api_key = $this->post('api_key');
        $this->api_check = $this->Api_model->checkApiKey($api_key);
    
    }

    public function index_get($user_id = null)
    {
        $users = array();
        if($user_id == null){
            // FETCH ALL USERS

            return $users;
        }else{
            // FETCH SPECIFIC


        }
    }

    public function index_post()
    {
        // CREATE USERS
        








    }

    public function index_put()
    {
        // UPDATE USERS
    }

    public function login_post(){
        
    }

    public function signup_post(){
        if ($this->api_check != FALSE ){
            echo "AUTHORIZED";
        }else {
            echo "NOT AUTHORIZED";
        }
    
    }
}