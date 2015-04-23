<?php
class Logging_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function logSignin($uid){
    	if(isset($uid)){
    		$data = array(
               'timestamp' => now(),
               'uid' => $uid
            );

			$this->db->insert('logging_signin', $data); 

			return TRUE;

    	}else{
    		return FALSE;
    	}
    }
}