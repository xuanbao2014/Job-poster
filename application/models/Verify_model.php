<?php

class Verify_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function changeVerifyCode($email,$code){
		$criteria['email'] = $email;
		$affected['verify_code'] = $code;
//		$affected['status'] = 0;
		$this->db->where($criteria)->update('users',$affected);
//		$this->db->where('id',25)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function activateUser($email,$code){
		$criteria['email'] = $email;
		$criteria['verify_code'] = $code;
		$affected['status'] = 1;
		$this->db->where($criteria)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function check_member($email,$code){
		$criteria['email'] = $email;
		$criteria['status'] = 1;
		$affected['recovery_code'] = $code;
		$this->db->where($criteria)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function check_reset_code($email,$code){
		$criteria['email'] = $email;
		$criteria['status'] = 1;
		$criteria['recovery_code'] = $code;
		$query = $this->db->from('users')->where($criteria)->get();
		$num = $query->num_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function change_password($email,$password){
		$criteria['email'] = $email;
		$criteria['status'] = 1;
		$affected['password'] = md5($password);
		$this->db->where($criteria)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
}

?>