<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/modules/v1/libraries/REST_Controller.php';
require APPPATH.'/modules/v1/libraries/Format.php';

class Properties extends REST_Controller {

    private $api_check;
    private $user_key;

    function __construct() {
        parent::__construct();
        $this->load->model("v1/Api_model");
        $this->load->model("v1/User_model");
		$this->load->model("v1/Properties_model");


        $api_key = $this->post('api_key');
        $this->api_check = $this->Api_model->checkApiKey($api_key);
        $this->load->library('form_validation');
        $this->form_validation->CI =& $this;
    }

    public function index_get()
    {
        $id = $this->input->get('id');
        if($id == null){
			$property = $this->Properties_model->getProperties();
			echo json_encode($property);

        }else{
			$property = $this->Properties_model->getProperty(array('cet_property_id' => $id));
			echo json_encode($property);
        }
    }


}
