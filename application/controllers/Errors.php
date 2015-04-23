<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {
		public function index(){
		$data['title'] = '页面不存在';
		$data['meta_description'] = null;

		$this->load->view('my404/index',$data);
	}
}

?>