<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/modules/v1/libraries/REST_Controller.php';
require APPPATH.'/modules/v1/libraries/Format.php';


class Auth extends REST_Controller
{

    public function __construct(){
        parent::__construct();
        $api_key = $this->get('api_key');
		$this->api_check = $this->api_model->checkApiKey($api_key);
    } 
    
    public function token_post()
    {
        $dataPost = $this->input->post();
        $user = $this->user_model->login($dataPost['username'], $dataPost['password']);
        if ($user != null) {
            $tokenData = array();
            $tokenData['id'] = $user->id;
            $response['token'] = Authorization::generateToken($tokenData);
            $this->set_response($response, REST_Controller::HTTP_OK);
            return;
        }
        $response = [
            'status' => REST_Controller::HTTP_UNAUTHORIZED,
            'message' => 'Unauthorized',
        ];
        $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
    }

    /****************** EXAMPLE TOKEN VALIDATION ********
      public function index_get($id = null)
    {
        $headers = $this->input->request_headers();

        if (Authorization::tokenIsExist($headers)) {
            $token = Authorization::validateToken($headers['Authorization']);
            if ($token != false) {
                $todo = ($id != null)
                    ? $this->todo_model->get($id)
                    : $this->todo_model->all($token->id);
                $this->set_response($todo, REST_Controller::HTTP_OK);
                return;
            }
        }
        $response = [
            'status' => REST_Controller::HTTP_FORBIDDEN,
            'message' => 'Forbidden',
        ];
        $this->set_response($response, REST_Controller::HTTP_FORBIDDEN);
    }

    public function index_post()
    {
        $headers = $this->input->request_headers();

        if (Authorization::tokenIsExist($headers)) {
            $token = Authorization::validateToken($headers['Authorization']);
            if ($token != false) {
                $dataPost = $this->input->post();
                $id = $this->todo_model->create($dataPost, $token);
                if ($id != false) {
                    $todo = $this->todo_model->get($id);
                    $this->set_response($todo, REST_Controller::HTTP_OK);
                    return;
                }
            }
            $response = [
                'status' => REST_Controller::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized',
            ];
            $this->set_response($response, REST_Controller::HTTP_UNAUTHORIZED);
            return;
        }
        $response = [
            'status' => REST_Controller::HTTP_FORBIDDEN,
            'message' => 'Forbidden',
        ];
        $this->set_response($response, REST_Controller::HTTP_FORBIDDEN);
    }

    ******************/
}