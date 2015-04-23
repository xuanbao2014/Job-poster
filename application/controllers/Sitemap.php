<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends CI_Controller {

	public function index(){
//		echo OK;
		$params = array('domain' => 'http://zhidian.us');
		$this->load->library('sitemap',$params);
//		$this->sitemap->setPath('/');
		$this->sitemap->setFilename('mysite');
		$this->sitemap->addItem('/', '1.0', 'daily', 'Today');
//		$this->sitemap->addItem('/about', '0.8', 'monthly', 'Jun 25');
//		$this->sitemap->addItem('/contact', '0.6', 'yearly', '14-12-2009');
//		$this->sitemap->addItem('/otherpage');
		$this->db->select('id,timestamp')->from('post')->order_by("id", "desc");
		$query = $this->db->get();
		foreach ($query->result_array() as $row) {
			$this->sitemap->addItem('/postdetail/'.$row["id"], '0.6', 'weekly', date('Y-m-d g:i A', $row['timestamp']));
		}
		$this->sitemap->createSitemapIndex('http://zhidian.us/', 'Today');
		redirect('/mysite-index.xml');
	}

}

?>