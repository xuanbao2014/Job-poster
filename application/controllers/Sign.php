<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sign extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('form_validation');
    }
	
	public function index(){
		redirect('/sign/signin');
	}

	public function signin($currentpage=NULL){
		$memberinfo = $this->session->userdata('memberinfo');

		if($memberinfo['is_logged'] == true){
			redirect(base64_decode($currentpage));
		}

		$data['title'] = lang('zhidian_signin_title');
		$data['currentpage'] = $currentpage;

		$this->load->view('sign/signin', $data);
	}

	//regular user sign in
	public function signin_check(){
		
		$this->form_validation->set_rules('username', lang('zhidian_email'), 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', lang('zhidian_password'), 'trim|required|xss_clean|callback__validate_signin');

		if($this->form_validation->run() === TRUE){
			$currentpage = $this->input->get_post("currentpage");

			$this->load->model('logging_model');
			$memberinfo = $this->session->userdata('memberinfo');
			$this->logging_model->logSignin($memberinfo['uid']);
				
			if(isset($currentpage)
				&&strlen($currentpage)!=0
				&&strpos(base64_decode($currentpage),'/verify')===FALSE
				&&strpos(base64_decode($currentpage),'/recovery_reset')===FALSE){
				redirect(base64_decode($currentpage));
			}else{
				redirect("/");
			}
			
		}else{
			$this->signin();
		}

	}
	
	public function _validate_signin($password)
	{
		$this->load->model('member_model');
		$email = $this->input->get_post('username');
		$query = $this->member_model->validate($email,$password);

		if($query){

			$result = $this->member_model->getMemberInfo($email,$password);
			if($result['status'] == 1){
				$this->session->unset_userdata('memberinfo');
				$data = array('username' => $email, 'is_logged' => TRUE, 'uid' => $result['id'], 'name' => $result['name'], 'status' => $result['status']);
				$this->session->set_userdata('memberinfo',$data);
				return true;
			}else if($result['status'] == 2){
				$this->form_validation->set_message('_validate_signin', lang('zhidian_account_suspended'));
				return false;
			}else{
				$this->form_validation->set_message('_validate_signin', 
					lang('zhidian_inactive_signin').'<br />'.
					lang('zhidian_no_email').
					'<a href="/sign/resend/email/'.base64_encode($email).'">'.
					lang('zhidian_resend'). $email .'</a>');
				return false;
			}
		}
		else{
			$this->form_validation->set_message('_validate_signin', lang('zhidian_invalid_signin'));
			return false;
		}
	}

	public function signup(){
		$memberinfo = $this->session->userdata('memberinfo');

		if($memberinfo['is_logged'] == true){
			redirect('/');
		}

		$data['title'] = lang('zhidian_signup_title');

		$this->load->view('sign/signup', $data);

	}

	public function signup_check(){
		
		// field name, error message, rules
		$this->form_validation->set_rules('sign_up_username', lang('zhidian_email'), 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('sign_up_password', lang('zhidian_password'), 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('sign_up_password2', lang('zhidian_password_confirm'), 'trim|required|matches[sign_up_password]');

		if($this->form_validation->run()){
			$this->load->model('member_model');
			$email = $this->input->get_post('sign_up_username');
			$password = $this->input->get_post('sign_up_password');
			$verify_code = random_string('unique');
			$query = $this->member_model->create_member($email,$password,$verify_code);

			if($query){
				$this->send_verify_email($email,$verify_code);
				$this->session->set_flashdata('msg_email', $email);
				redirect('/sign/signup_succ');
//				echo "You will be redirected to index in 5 seconds.";
//				header('Refresh: 5; URL=/');

			}else{
				$this->signup();
			}
		}else{
			$this->signup();
		}
	}
	
	public function signout(){
		$this->session->unset_userdata('memberinfo');
		redirect('/');
	}
	
	public function signup_succ(){
		$data = array();

		$data['title'] = lang('zhidian_signupsucc_title');

		$this->load->view('sign/signup_succ_view', $data);

	}
	
	public function send_verify_email($user_email,$verify_code){
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
		$this->email->to($user_email);
		// ! NEED CHANGE LATER
		$this->email->subject(lang('zhidian_confirmemail_subject'));
		$this->email->message(
			lang('zhidian_confirmemail_message')
			.'<a href="'.site_url('verify/email_verify')
			.'/email/'.base64_encode($user_email)
			.'/code/'
			.$verify_code
			.'">'
			.lang('zhidian_clickhere')
			.'</a>');

		$this->email->send();
	}

	//这个$string是干嘛的？
	public function resend($string){
		$email = $this->uri->segment(4,"NULL");
		if(strcmp($email, "NULL") != 0 && count($this->uri->segment_array()) == 4){
			$email = base64_decode($email);
			$new_verify_code = random_string('unique');
			$this->load->model('verify_model');
			$result = $this->verify_model->changeVerifyCode($email,$new_verify_code);
			if($result){
				$this->send_verify_email($email,$new_verify_code);
				redirect('/sign/signup_succ');
			}else{
				redirect('/');
			}
		}
	}
	
	public function recovery(){
		$data['title'] = lang('zhidian_recoveryemail_title');

		$this->load->view('sign/recovery_step1_view', $data);

	}

	public function recovery_step1(){
		
		// field name, error message, rules
		$this->form_validation->set_rules('email', lang('zhidian_email'), 'trim|required|valid_email');
		if($this->form_validation->run()){
			$this->load->model('verify_model');
			$email = $this->input->get_post('email');
			$verify_code = random_string('unique');
			$query = $this->verify_model->check_member($email,$verify_code);			

			if($query){
				$this->send_recovery_email($email,$verify_code);
				$this->session->set_flashdata('msg_succ', lang('zhidian_recoveryemail_sent'));
				redirect('/sign/recovery');

			}else{
				$this->session->set_flashdata('msg_error', lang('zhidian_invalid_email'));
				redirect('/sign/recovery');
			}
		}else{
			$this->recovery();
		}
	}
	
	public function recovery_reset($email){
		
		// field name, error message, rules
		$this->form_validation->set_rules('password', lang('zhidian_password'), 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('password2', lang('zhidian_password_confirm'), 'trim|required|matches[password]');

		if($this->form_validation->run()){
			$this->load->model('verify_model');
			$password = $this->input->get_post('password');
			$email = base64_decode($email);
			$query = $this->verify_model->change_password($email,$password);

			if($query){
				$data['msg_succ'] = lang('zhidian_changepassword_succ');
				$data['title'] = lang('zhidian_recoveryemail_title');
				
				$this->load->view('sign/recovery_step3_view', $data);			

			}else{
				$this->session->set_flashdata('msg_error',lang('zhidian_no_old_password'));
				redirect(current_url());
			}
		}else{
			$data['title'] = lang('zhidian_recoveryemail_title');
			$data['email'] = $email;
			
			$this->load->view('sign/recovery_step2_view', $data);
			
		}
	}
	
	public function send_recovery_email($user_email,$verify_code){
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
		$this->email->to($user_email);
		// ! NEED CHANGE LATER
		$this->email->subject(lang('zhidian_recoveryemail_subject'));
		$this->email->message(
			lang('zhidian_recoveryemail_message')
			.'<a href="'.site_url('verify/resetpwd_verify')
			.'/email/'
			.base64_encode($user_email)
			.'/code/'
			.$verify_code
			.'">'
			.lang('zhidian_clickhere')
			.'</a>');

		$this->email->send();
	}

}

?>