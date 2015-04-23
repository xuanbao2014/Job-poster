<?php
class LanguageLoader{
	function initialize(){
		$ci =& get_instance();

		$site_lang = $ci->session->userdata('site_lang');
		if ($site_lang) {
			$ci->lang->load('zhidian',$ci->session->userdata('site_lang'));
			$ci->lang->load('form_validation',$ci->session->userdata('site_lang'));
		} else {
			$ci->lang->load('zhidian','chinese');
			$ci->lang->load('form_validation','chinese');
		}
	}
}