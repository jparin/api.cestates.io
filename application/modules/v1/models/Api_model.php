<?php

class Api_Model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
   }
   
   public function checkApiKey($api_key)
	{
		if ($api_key)
		{
			$this->db->select('*');
			$this->db->from('cet_api_list');
			$this->db->where('cet_api_key',$api_key);
			$query = $this->db->get();
			$result = $query->row_array();
			if ($result)
			{
				return $result['cet_api_id'];
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

	public function checkUserByEmailPass($email,$password)
	{
		$username = $this->input->post('email', TRUE);
		$password = $password;
		$this->db->select('tau_tu_user_id AS user_id, tau_user_key AS user_key, tau_tp_permissions AS user_permission');
		$this->db->from('cet_api_users');
		$this->db->join('cet_users', 'tu_user_id = tau_tu_user_id','left');
		$this->db->join('cet_business_unit', 'tbu_id = tu_bu_id','left');
		$this->db->where('tu_user_email',$username);
		$this->db->where('tu_user_pass',$password);
		$this->db->where('tu_status','active');
		$this->db->where('tu_archived',0);
		$this->db->where('tbu_archived',0);
		
		$query = $this->db->get();
		return $query->row();
	}

	public function checkUserCredentials($account, $password){
		$this->db->select('tau_tu_user_id AS user_id, tau_user_key AS user_key, tau_tp_permissions AS user_permission');
		$this->db->join('cet_api_users', 'tau_tu_user_id = tu_user_id', 'left');
		$this->db->where('tu_username', $account);
		$this->db->where('tu_user_pass', $password);
		$this->db->where('tu_archived',0);
		$this->db->or_where('tu_user_email', $account);
		$this->db->where('tu_user_pass', $password);
		$this->db->where('tu_archived',0);
		return $this->db->get('cet_users')->row();
	}
	
	public function checkUserKey($user_key)
	{
		if ($user_key)
		{
			$this->db->select('*');
			$this->db->where('tau_user_key',$user_key);
			$this->db->from('cet_api_users');
			$query = $this->db->get();
			$result = $query->result_array();
			if ($result)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
	}

   
   public function checkEmailExists($email)
   {
		$this->db->select('tu_user_id, tu_user_email');
		$this->db->from('cet_users');
		$this->db->where('tu_user_email',$email);
		$this->db->where('tu_archived',0);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
   }
   
   public function getUserInfoById($userId)
   {
	   $this->db->select('*, "-protected-" as tu_password',false);
		$this->db->from('cet_users');
		$this->db->where('tu_userId',$userId);
		$query = $this->db->get();
		$result = $query->row();

		if($result){
			return $result;
		}else{
			return FALSE;
		}
   }
   
     

}