<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LangSwitch extends CI_Controller{
	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	function switchLanguage($language = "",$currentpage="/") {
		$language = ($language != "") ? $language : "chinese";
		$current_page = base64_decode($currentpage);
		$this->session->set_userdata('site_lang', $language);
		redirect($current_page);
	}
}