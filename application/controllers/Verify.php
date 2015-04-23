<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	public function email_verify($string){

		$email = $this->uri->segment(4,"NULL");
		$code = $this->uri->segment(6,"NULL");

		if(strcmp($email, "NULL") != 0 && strcmp($code, "NULL") != 0 && count($this->uri->segment_array()) == 6){

			$this->load->model('verify_model');
			$result = $this->verify_model->activateUser(base64_decode($email),$code);
			if($result){

				$data['title'] = lang('zhidian_signin_title');
				$data['msg'] = lang('zhidian_confirmation_succ');
				
				$this->load->view('sign/signin', $data);
				

			}else{

				$data['title'] = lang('zhidian_signin_title');
				$data['msg'] = lang('zhidian_confirmation_fail');
				$this->load->view('sign/signin', $data);

			}
		}
	}
	
	public function resetpwd_verify($string){
		$email = $this->uri->segment(4,"NULL");
		$code = $this->uri->segment(6,"NULL");

		if(strcmp($email, "NULL") != 0 && strcmp($code, "NULL") != 0 && count($this->uri->segment_array()) == 6){

			$this->load->model('verify_model');
			$result = $this->verify_model->check_reset_code(base64_decode($email),$code);
			if($result){

				$data['email'] = $email;
				
				$data['title'] = lang('zhidian_recoveryemail_title');

				$this->load->view('sign/recovery_step2_view', $data);

			}else{
				$this->session->set_flashdata('msg_error', lang('zhidian_confirmation_fail'));
				redirect('/sign/recovery');
			}
		}
	}
}
	
?>