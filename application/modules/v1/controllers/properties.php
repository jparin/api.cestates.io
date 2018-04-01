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
		$this->load->model("v1/Properties_images_model");


		$api_key = $this->post('api_key');
		$this->api_check = $this->Api_model->checkApiKey($api_key);
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;
	}

	public function index_get($id = null)
	{

		if($id == null){
			$property = $this->Properties_model->getProperties();
			foreach ($property as $key => $value) {
				$images = array('images' => $this->Properties_images_model->get_by(array('cet_pimages_property_id' => $property[$key]['id'])));
				$property[$key] = array_merge($property[$key], $images);
			}
			echo json_encode($property);

		}else{
			$property = $this->Properties_model->getProperty(array('cet_property_id' => $id));
			foreach ($property as $key => $value) {
				$images = array('images' => $this->Properties_images_model->get_by(array('cet_pimages_property_id' => $property[$key]['id'])));
				$property[$key] = array_merge($property[$key], $images);
			}
			echo json_encode($property);
		}
	}

	public function index_post(){
	}

	public function index_delete($property_id){
		$property_images = $this->Properties_images_model->get_by(array('cet_pimages_property_id' => $property_id));
		foreach ($property_images as $key => $value) {
			$exploded = explode('/', $property_images[$key]['cet_pimages_link']);
			$image_name = $exploded[2];
			unlink("images/properties/".$image_name);
		}
		$this->Properties_images_model->delete_images($property_id);
		$this->Properties_model->delete($property_id);
		$response = [
			'status' => 'success',
			'message' => 'Property Deleted',
		];
		$this->set_response($response, 'success');
	}
	public function save_property_post(){
		$validation = $this->Properties_model->properties_form_validation;
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('_name_is_unique', "Name is already been used!.");
		if($this->form_validation->run() == TRUE){
			$data = array(
				'cet_property_name' => strtolower($this->input->post('name')),
				'cet_property_description' =>strtolower($this->input->post('descriprion')),
				'cet_property_map' => strtolower($this->input->post('price')),
				'cet_property_price' => strtolower($this->input->post('map')),
				'cet_property_type' => strtolower($this->input->post('address')),
				'cet_property_address' => strtolower($this->input->post('type'))
			);

			if($property_id = $this->Properties_model->save($data)){
				if(isset($_FILES["images"])){
					$err = false;
					foreach ($_FILES["images"]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$fileName = hash('sha1', $this->input->post('name')).''.$key.''.date('YmdHis').'.jpg';
							$fileTmpLoc = $_FILES['images']["tmp_name"][$key];
							$pathAndName = $_SERVER['DOCUMENT_ROOT'] . "/images/properties/".$fileName;

							if(move_uploaded_file($fileTmpLoc , $pathAndName)){
								$data = array(
									'cet_pimages_property_id' => $property_id,
									'cet_pimages_link' => 'properties/'.$property_id.'/'.$fileName,
								);
								$this->Properties_images_model->save($data);
							}
						}
						else{$err = true;}
					}
					$response = [
						'status' => 'success',
						'message' => 'Successfully Save Property',
					];
					$this->set_response($response, 'success');
				}
				else{
					$response = [
						'status' => 'error',
						'message' => 'Form validation failed',
						'errors' => array('images' => 'There is no file selected!')
					];
					$this->set_response($response, 'error');
				}
			}
			else{
				$response = [
					'status' => 'error',
					'message' => 'Something is wrong! Please try again.',
					'errors' => array('query' => 'Something wrong with query')
				];
				$this->set_response($response, 'error');
			}

		}
		else {
			$errors = $this->form_validation->error_array();
			$response = [
				'status' => 'error',
				'message' => 'Form validation failed',
				'errors' => $errors
			];
			$this->set_response($response, 'error');
		}
	}

	public function update_property_post(){
		$validation = $this->Properties_model->properties_form_validation;
		$this->form_validation->set_rules($validation);
		$this->form_validation->set_message('_name_is_unique', "Name is already been used!.");
		if($this->form_validation->run() == TRUE){
			$id = $this->input->post('id');
			$data = array(
				'cet_property_name' => strtolower($this->input->post('name')),
				'cet_property_description' =>strtolower($this->input->post('descriprion')),
				'cet_property_map' => strtolower($this->input->post('price')),
				'cet_property_price' => strtolower($this->input->post('map')),
				'cet_property_type' => strtolower($this->input->post('address')),
				'cet_property_address' => strtolower($this->input->post('type'))
			);

			if($property_id = $this->Properties_model->save($data, $id)){

				if(isset($_FILES["images"])){
					$property_images = $this->Properties_images_model->get_by(array('cet_pimages_property_id' => $id));
					foreach ($property_images as $key => $value) {
						$exploded = explode('/', $property_images[$key]['cet_pimages_link']);
						$image_name = $exploded[2];
						unlink("images/properties/".$image_name);
					}
					$this->Properties_images_model->delete_images($id);
					$err = false;
					foreach ($_FILES["images"]["error"] as $key => $error) {
						if ($error == UPLOAD_ERR_OK) {
							$fileName = hash('sha1', $this->input->post('name')).''.$key.''.date('YmdHis').'.jpg';
							$fileTmpLoc = $_FILES['images']["tmp_name"][$key];
							$pathAndName = $_SERVER['DOCUMENT_ROOT'] . "/images/properties/".$fileName;

							if(move_uploaded_file($fileTmpLoc , $pathAndName)){
								$data = array(
									'cet_pimages_property_id' => $property_id,
									'cet_pimages_link' => 'properties/'.$property_id.'/'.$fileName,
								);
								$this->Properties_images_model->save($data);
							}
						}
						else{$err = true;}
					}
					$response = [
						'status' => 'success',
						'message' => 'Successfully Save Property',
					];
					$this->set_response($response, 'success');
				}
				$response = [
					'status' => 'success',
					'message' => 'Successfully Save Property',
				];
				$this->set_response($response, 'success');
			}
			else{
				$response = [
					'status' => 'error',
					'message' => 'Something is wrong! Please try again.',
					'errors' => array('query' => 'Something wrong with query')
				];
				$this->set_response($response, 'error');
			}

		}
		else {
			$errors = $this->form_validation->error_array();
			$response = [
				'status' => 'error',
				'message' => 'Form validation failed',
				'errors' => $errors
			];
			$this->set_response($response, 'error');
		}
	}

	public function _name_is_unique($name){
		$property = $this->Properties_model->get_by(array('cet_property_name' => trim($name)));
		return count($property)?false:true;
	}

	public function test_put(){
			parse_str(file_get_contents("php://input"),$putData);
		$t = json_encode($putData);

		print_r($putData);
			//echo $_SERVER['DOCUMENT_ROOT'];
	}

}
