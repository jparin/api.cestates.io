<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/modules/v1/libraries/REST_Controller.php';

 

    class Users extends REST_Controller {

        private $api_check;
        private $user_key;

        function __construct() {
            parent::__construct();
            $this->load->module("core/app");
            $this->load->model("api_model");
            $this->load->model("user_model");
           
            $api_key = $this->get('api_key');
            $user_key = $this->get('user_key');
            $this->api_check = $this->api_model->checkApiKey($api_key);
            $this->user_key = $this->api_model->checkUserKey($user_key);
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
    }