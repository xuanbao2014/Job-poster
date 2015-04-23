<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$array = $this->uri->uri_to_assoc(2);
		$data = $this->_search($array);
		//TODO: add title
		$data['title'] = null;
		$data['meta_description'] = null;

		$this->load->view('home/index',$data);
	}


	public function _search($input){
		$temp = array();

		if(isset($input['industry'])){
			$temp['industry'] = urldecode($input['industry']);
		}
		if(isset($input['country'])){
			$temp['country'] = urldecode($input['country']);
		}
		if(isset($input['sponsor'])){
			$temp['sponsor'] = urldecode($input['sponsor']);
		}
		if(isset($input['employment_type'])){
			$temp['employment_type'] = urldecode($input['employment_type']);
		}

		$pn = isset($input['pn'])? $input['pn'] : 0;

		//	Show Only Approved Jobs
		$temp['status'] = 1;

		$this->load->model('jobpost_model');
		$slice = $this->jobpost_model->getFilterPost($temp,$pn);

		foreach($slice as $key => $val){
			$str = strip_tags($slice[$key]['description']);
			$allen = preg_match("/^[^\x80-\xff]+$/", $str);
        	$allcn = preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str);
			if($allen){
				$slice[$key]['description'] = mb_substr($str,0,400)." ...";
			}else{
				if($allcn){
					$slice[$key]['description'] = mb_substr($str,0,200)." ...";
				}else{
					$slice[$key]['description'] = mb_substr($str,0,250)." ...";
				}
			}
		}
		$data['content'] = $slice;


		$this->load->library('pagination');

		$config['base_url'] = '/filter/'.$this->uri->assoc_to_uri($temp).'/pn';
		$config['total_rows'] = $this->jobpost_model->getFilterPostCount($temp);
		$config['per_page'] = 20;
		$config['uri_segment'] = 3 + 2 * count($temp);
		
		//Just applying codeigniter's standard pagination config with twitter bootstrap stylings
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';

		//$config['first_link'] = '&laquo; First';
		$config['first_link'] = lang('zhidian_pagination_first');
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';

		//$config['last_link'] = 'Last &raquo;';
		$config['last_link'] = lang('zhidian_pagination_last');
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = '&gt;';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&lt;';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a>';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';

		$config['anchor_class'] = 'class="pagination_link"';


		$this->pagination->initialize($config);
		$data['page'] = $this->pagination->create_links();
		$data['filter'] = $temp;

		return $data;

	}
	
	public function feedback(){
		$fb = $this->input->get_post('fb');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('fb', 'Your feedback', 'trim|required|min_length[10]');

		if($this->form_validation->run()){
			$this->_send_feedback_email($fb);
			$form_feedback_errors = '<p class="alert alert-success" style="padding-top:5px;padding-bottom:5px"> Thanks for your feedback!</p>';
			echo $form_feedback_errors;
		}else{
			$form_feedback_errors = validation_errors('<p class="alert alert-warning" style="padding-top:5px;padding-bottom:5px">');
			echo $form_feedback_errors;
		}
	}

	public function _send_feedback_email($content){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from('no-reply', 'Custom feedback');
		// ! NEED CHANGE LATER
		$this->email->to('contact@zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->subject('[Feedback] '.date('Y-m-d g:i A', now()));
		$this->email->message($content);

		$this->email->send();
	}

	//marketing or blog
	public function employer(){
		$data['title'] = lang('zhidian_employer');
		$this->load->view('home/employer',$data);
	}

	public function tax_guide(){
		$data['title'] = "2014 Tax Return终极指南";
		$this->load->view('home/tax_guide',$data);
	}

	//disclaimer
	public function disclaimer(){
		$data['title'] = "免责声明(Disclaimer)";
		$this->load->view('home/disclaimer',$data);		
	}

	public function tax2015(){
		$data['title'] = "2015 Tax Return终极指南";
		$this->load->view('home/tax2015',$data);
	}

}

?>