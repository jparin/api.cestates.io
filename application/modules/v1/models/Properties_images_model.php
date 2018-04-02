<?php
class Properties_images_model extends MY_Model{
	protected $_table_name = 'cet_properties_images';
	protected $_primary_key = 'cet_pimages_id';
	protected $_table_prefix = 'cet';
	protected $_order_by = '';
	protected $_timestamps = false;


	public function __construct()
	{
		parent::__construct();
		$this->load->model("api_model");
	}
	public function delete_images($property_id){
		$this->db->where(array('cet_pimages_property_id' => $property_id));
		return $this->db->delete($this->_table_name);
	}
}
?>
