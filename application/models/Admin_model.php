<?php
class Admin_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

	function get_admin_info_step1($email,$password){
		$info = array('email' => $email, 'password' => md5($password));
		$this->db->from('admin_users')->where($info)->limit(1);
		$query = $this->db->get();
		if($query->num_rows()==1){
			return $query->result_array();
		}else{
			return null;
		}
	}
	
	function get_admin_info_step2($email,$passcode){
		$info = array('email' => $email, 'passcode' => $passcode);
		$this->db->from('admin_users')->where($info)->limit(1);
		$query = $this->db->get();
		if($query->num_rows()==1){
			return $query->result_array();
		}else{
			return null;
		}
	}
	
	function set_sign_passcode($email,$passcode,$curtime,$duration){
		$criteria['email'] = $email;
		$affected['passcode'] = $passcode;
		$affected['passcode_expire_timestamp'] = $curtime+$duration;
		
		$this->db->where($criteria)->update('admin_users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function get_all_users_info(){
		$this->db->from('users');
		$query = $this->db->get();
		if($query->num_rows()>=0){
			return $query->result_array();
		}else{
			return null;
		}
	}
	
	function get_all_posts_info(){
		$this->db->from('post');
		$query = $this->db->get();
		if($query->num_rows()>=0){
			return $query->result_array();
		}else{
			return null;
		}
	}
}

?>