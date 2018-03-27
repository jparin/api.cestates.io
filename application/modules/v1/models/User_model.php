<?php

class User_Model extends CI_Model
{
   public function __construct()
   {
      parent::__construct();
	  $this->load->model("api_model");
   }
   
	public function saveAccount($aData)
    {
		$aUserData['tu_fname'] = strtolower($aData['userFname']);
		$aUserData['tu_mname'] = strtolower($aData['userMname']);
		$aUserData['tu_lname'] = strtolower($aData['userLname']);
		$aUserData['tu_position'] = strtolower($aData['userPos']);
		$aUserData['tu_bu_id'] = $aData['userBu'];
		$aUserData['tu_user_email'] = $aData['userEmail'];
		
		if($aData['flag']=="add"){
			
			if(!$this->api_model->checkEmailExists($aData['userEmail'])){
			
				$aUserData['tu_status'] = 'pending';
				$password_key = $aData['userFname'].$aData['userMname'].$aData['userLname'].now();
				$aUserData['tu_password_key'] = hash('sha512',$password_key);
				$this->db->set('tu_password_key_created', 'NOW()', FALSE);
				
				if($this->db->insert('tbl_users',$aUserData)){
					
					$userId = $this->db->insert_id();
					$aUserApiInfo['tau_tal_id'] = $aData['api_id'];
					$aUserApiInfo['tau_tu_user_id'] = $userId;
					$aUserApiInfo['tau_user_key'] = hash('sha1',$userId.now());
					$aUserApiInfo['tau_tp_permissions'] = $aData['userPerm'];
					
					if($this->db->insert('tbl_api_users',$aUserApiInfo)){
						return array('user_id'=>$userId,'user_email'=>$aData['userEmail'],'password_key'=>$aUserData['tu_password_key'],'send_email'=>true);
					}else{
						$this->db->where('tu_user_id', $userId);
						$this->db->delete('tbl_users');
						return false;
					}
				}else{
					return false;
				}
			
			}else{
				return 'email_exist';
			}
		}else{
			
			// update permission
			$this->db->where('tau_tu_user_id', $aData['user_id']);
			$this->db->update('tbl_api_users',array('tau_tp_permissions'=>$aData['userPerm']));

			$emailReturned = $this->api_model->checkEmailExists($aData['userEmail']);
			if($emailReturned){
				if($emailReturned['tu_user_id']==$aData['user_id']){					
					// update userdata
					$this->db->where('tu_user_id', $aData['user_id']);
					$this->db->update('tbl_users',$aUserData);
					return array('send_email'=>false);
				}else{
					return 'email_exist';
				}
			}else{
				return $this->generate_pw_activation($aData['user_id']);
			}
			

		}
			
    }
	
	public function archive_user($userId)
	{
		$this->db->where('tu_user_id', $userId);
		return $this->db->update('tbl_users',array('tu_archived'=>1));
	}
	
	public function generate_pw_activation($userId)
	{
		$this->db->select('tu_fname AS userFname, tu_mname AS userMname, tu_fname AS userLname, tu_user_email AS email');
		$this->db->from('tbl_users');
		$this->db->where('tu_user_id',$userId);
		$query = $this->db->get();
		$aData = $query->row_array();

		$password_key = $aData['userFname'].$aData['userMname'].$aData['userLname'].now();
		$aUserData['tu_password_key'] = hash('sha512',$password_key);
		$this->db->set('tu_password_key_created', 'NOW()', FALSE);
		$this->db->where('tu_user_id', $userId);
		if($this->db->update('tbl_users',$aUserData)){
			return array('user_id'=>$userId,'user_email'=>$aData['email'],'password_key'=>$aUserData['tu_password_key'],'send_email'=>true);
		}
		
		return false;
	}
	
	
}