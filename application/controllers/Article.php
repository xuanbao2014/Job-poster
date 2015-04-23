<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article extends CI_Controller {

	public function index(){
		$memberinfo = $this->session->userdata('memberinfo');
		$email = $memberinfo['username'];
//		if($email == "liuhuisheep@gmail.com" || $email == "wushizhang@gmail.com"){
			$xmlArray = array();
			$xmldoc = new DOMDocument();
			$xmldoc->load('resources/template/article.xml');
			$templates = $xmldoc->getElementsByTagName('template');
			foreach($templates as $template){
				$names = $template->getElementsByTagName('name');
				$name = $names->item(0)->nodeValue;
				$titles = $template->getElementsByTagName('title');
				$title = $titles->item(0)->nodeValue;
				$contents = $template->getElementsByTagName('content');
				$content = $contents->item(0)->nodeValue;

				array_push($xmlArray,[
					'name' => $name,
					'title' => $title,
					'content' => $content
				]);
			}

			$data['title'] = 'template';
			$data['templates'] = $xmlArray;
			$this->load->view('article/template.php',$data);
//		}
	}

}

?>