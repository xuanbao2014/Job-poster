<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Blog extends CI_Controller {

	public function index($id=0){
		$data['title'] = '职点杂谈';
		$data['meta_description'] = null;
		$data['right_page'] = $id;

		$this->load->view('blog/index',$data);
	}


}

?>