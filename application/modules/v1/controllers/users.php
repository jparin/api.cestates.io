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
        $this->load->model("v1/User_model"); 

        
        $api_key = $this->post('api_key');
        $this->api_check = $this->Api_model->checkApiKey($api_key);
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;
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

            // // check password validation
           


            $validation = $this->User_model->signup_form_validation;
            $this->form_validation->set_rules($validation);
            $this->form_validation->set_message('_password_allowed', "Password must contain atleast one Uppercase letter, one symbol and one number!.");
            $this->form_validation->set_message('_email_is_unique', "Email is already been used!.");
            if($this->form_validation->run() == TRUE){
                
                // CAPTCHA
                $client     = new GuzzleHttp\Client();
                $response = $client->request('POST','https://www.google.com/recaptcha/api/siteverify',[
                    'form_params' => ['secret'=>'6Ldy508UAAAAABpFbTRIIegvLQ-Rdr-4hvF7w_Gb','response' => 'test']
                ]);
               
                $result = json_decode($response->getBody()->getContents());
                if($result->success){
                    // send email verification


                }else{

                }
                $data = array(
                    'cet_user_fname' => strtolower($this->input->post('firstname')),
                    'cet_user_lname' =>strtolower($this->input->post('lastname')),
                    'cet_user_email' => strtolower($this->input->post('email')),
                    'cet_user_password' => hash('sha512', $this->input->post('password') . $this->config->item('encryption_key'))
                );
                $result = array();
                if($this->User_model->save($data)){
                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully Save Users',
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => 'Not saved users',
                    ];
                }

                
                $this->set_response($response, 'success');
            }else {
                $errors = $this->form_validation->error_array();
                $response = [
                    'status' => 'error',
                    'message' => 'Form validation failed',
                    'errors' => $errors
                ];
                $this->set_response($response, 'error');
            }
        }else {
            $response = [
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ];
            $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
        }
    
    }

    public function _password_allowed($password){
        $returnVal = true;
        if ( !preg_match("#[0-9]+#", $password) ) {
            $returnVal = False;
        }
        if ( !preg_match("#[a-z]+#", $password) ) {
            $returnVal = False;
        }
        if ( !preg_match("#[A-Z]+#", $password) ) {
            $returnVal = False;
        }
        if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|=_+!-]/", $password) ) {
            $returnVal = False;
        }
        return $returnVal;
    }

    public function _email_is_unique($email){
        $user = $this->User_model->get_by(array('cet_user_email' => trim($email)));
        return count($user)?false:true;
    }
}