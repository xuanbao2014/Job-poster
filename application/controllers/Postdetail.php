<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postdetail extends CI_Controller {

	public function index($pid){
		$this->load->model('jobpost_model');
		$query = $this->jobpost_model->getPostDetail($pid);
		$data['content'] = current($query);
		
		$this->load->model('member_model');
		$memberinfo = $this->session->userdata('memberinfo');
		if(isset($memberinfo)){
			$uid = $memberinfo['uid'];

			$query = $this->member_model->getLastApplyRecord($uid,$pid);
			if($query->num_rows() > 0){
				$first = current($query->result_array());
				$data['last_apply_timestamp'] = $first['timestamp'];
			}
		}

		$data['title'] = $data['content']['jobtitle'];

		$str = str_replace(array("\r", "\r\n", "\n"), ' ', strip_tags($data['content']['description']));
		$data['meta_description'] = mb_substr($str,0,100);

		$posterinfo = current($this->member_model->getCurrentPostMemberInfo($pid));
		
		$data['poster_email'] = $posterinfo['email'];

		$this->load->view('postdetail/index', $data);
		
	}

}

?>