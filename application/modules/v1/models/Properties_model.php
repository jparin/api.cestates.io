<?php
class Properties_model extends MY_Model{
	protected $_table_name = 'cet_properties';
	protected $_primary_key = 'cet_property_id';
	protected $_table_prefix = 'cet';
	protected $_order_by = '';
	protected $_timestamps = false;

	public $properties_form_validation = array(
		'name' => array('field' => 'name', 'label' => 'Property Name', 'rules' => 'required'),
		'description' => array('field' => 'description', 'label' => 'Property Description', 'rules' => 'required'),
		'price' => array('field' => 'email', 'label' => 'Property Price', 'rules' => 'required|numeric'),
		'map' => array('field' => 'map', 'label' => 'Map', 'rules' => 'required'),
		'address' => array('field' => 'address', 'label' => 'address', 'rules' => 'required')
	);

	public function __construct()
	{
		parent::__construct();
		$this->load->model("api_model");
	}

	public function getProperty($property_id){
		$this->db->select( 'cp.cet_property_id as id,
							cp.cet_property_name as name,
							cp.cet_property_description as description,
							cp.cet_property_map as map,
							cp.cet_property_price as price,
							cp.cet_property_address as address,
							cp.cet_property_type as type,
							cpi.cet_pimages_link as image');

		$this->db->from('cet_properties as cp');
		$this->db->join('cet_properties_images as cpi', 'cp.cet_property_id = cpi.cet_pimages_id');
		$this->db->where($property_id);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function getProperties(){
		$this->db->select( 'cp.cet_property_id as id,
							cp.cet_property_name as name,
							cp.cet_property_description as description,
							cp.cet_property_map as map,
							cp.cet_property_price as price,
							cp.cet_property_address as address,
							cp.cet_property_type as type,
							cpi.cet_pimages_link as image');

		$this->db->from('cet_properties as cp');
		$this->db->join('cet_properties_images as cpi', 'cp.cet_property_id = cpi.cet_pimages_property_id');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}

	public function saveProperty($aPropertyData){

	}
}
?>
