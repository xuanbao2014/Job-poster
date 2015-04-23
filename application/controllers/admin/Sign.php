<?php

class Sign extends CI_Controller{

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('form_validation');
		$this->load->model('admin_model');
    }
	
	private function check_auth(){
		$admin_info = $this->session->userdata('admin_info');
		if(isset($admin_info) && $admin_info['signed'] == 'admin'){
			redirect('admin/panel');
		}else{
			$this->load->view('admin/sign_view');
		}
	}
	
	public function index(){
		$this->check_auth();
	}
	
	public function sign_check(){
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() == true){
			$username = $this->input->get_post('username');
			$password = $this->input->get_post('password');
			$result = $this->admin_model->get_admin_info_step1($username,$password);
			if(isset($result)){
				$result = current($result);
				$format = 'DATE_RFC822';
				$time = time();
				$curtime = standard_date($format, $time);
				$passcode = random_string('unique');

				if($this->admin_model->set_sign_passcode($username,$passcode,$time,3600)){
					$this->sign_send_passcode_email($username,$curtime,$passcode);
					$data['username'] = $username;
					$this->load->view('admin/sign_verify_view',$data);
				}
				else{
					$msg_error = '<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">Account action has been closed</p>';
					$this->session->set_flashdata('msg_error', $msg_error);
					redirect('admin/sign');
				}
			}else{
				$msg_error = '<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">Invalid username or password!</p>';
				$this->session->set_flashdata('msg_error', $msg_error);
				redirect('admin/sign');
			}
		}
		else{
			$form_error_msg = validation_errors('<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">');
			$this->session->set_flashdata('msg_error', $form_error_msg);
			redirect('admin/sign');
		}
	}
	
	private function sign_send_passcode_email($username,$curtime,$passcode){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.exmail.qq.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'no-reply@zhidian.us';
		$config['smtp_pass'] = 'Jobcopter1';
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from('no-reply@zhidian.us', 'zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->to($username);
		// ! NEED CHANGE LATER
		$this->email->subject('You are trying to sign in as an Administrator at '.base_url().'!');

		$this->email->message('You get this email because you have requested an <strong>ADMIN level</strong> sign in at '
			.base_url()
			.'.<br />If this is <strong>not your action</strong>, please change your password right now!<br /><br />'
			.'Here is your sign in info:<br />'
			.'Request Time: '.$curtime.'<br />'
			.'Request Acct: '.$username.'<br />'
			.'Passcode : '.$passcode.'<br />'
			.'Sign Link : '.base_url().'admin/sign/sign_verify/'.base64_encode($username).'<br />'
			.'This passcode will expire in an hour.<br /><br />'
			.'This is an automatically generated email from '.base_url().'. Support Email is contact@zhidian.us');

		$this->email->send();
	}
	
	public function sign_verify($username=''){
		$username = base64_decode($username);
		$this->form_validation->set_rules('passcode', 'Passcode', 'required');
		if($this->form_validation->run() == true){
			$passcode = $this->input->get_post('passcode');
			$result = $this->admin_model->get_admin_info_step2($username,$passcode);
			if(isset($result)){
				$result = current($result);
				$curtime = now();
				$expiretime = $result['passcode_expire_timestamp'];
				if($curtime<=$expiretime){
					//=====================sign successfully.set session.================================
					$admin_info['username'] = $username;
					$admin_info['priority'] = $result['priority'];
					$admin_info['signed'] = 'admin';
					$this->session->set_userdata('admin_info',$admin_info);
					redirect('admin/panel');
					//===================================================================================
				}else{
					$msg_expire = '<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px"> Your sign in request has been expired! Please sign in.</p>';
					$this->session->set_flashdata('msg_error', $msg_expire);
					redirect('admin/sign');
				}
			}else{
				$data['msg_error'] = '<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">Invalid passcode!</p>';
				$data['username'] = $username;
				$this->load->view('admin/sign_verify_view',$data);
			}
		}else{
			$data['msg_error'] = validation_errors('<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">');
			$data['username'] = $username;
			$this->load->view('admin/sign_verify_view',$data);
		}
	}
	
	public function sign_out(){
		$this->session->unset_userdata('admin_info');
		redirect('admin/sign');
	}
}