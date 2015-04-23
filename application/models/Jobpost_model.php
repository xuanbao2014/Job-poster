<?php
class Jobpost_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

/*    function getLatestPost()
    {
		$this->db->from('post')->order_by("timestamp", "desc")->limit(100);
		$query = $this->db->get();
        return $query->result_array();
    }*/

	function getFilterPost($criteria = array(),$offset)
    {
		$this->db->from('post')->where($criteria)->order_by("timestamp", "desc")->limit(20,$offset);
		$query = $this->db->get();
        return $query->result_array();
    }

    function getFilterPostCount($criteria = array()){
        $this->db->where($criteria);
        $this->db->from('post');
        return $this->db->count_all_results();
    }

	
	function getPostDetail($docid){
		$this->db->where('id', $docid);
		$this->db->set('clicks', 'clicks+1', FALSE);
		$this->db->update('post');

		$this->db->from('post')->where('id',$docid)->limit(1);
		$query = $this->db->get();

        return $query->result_array();
	}
	
	function getPostContent($docid){
		$this->db->from('post')->where('id',$docid)->limit(1);
		$query = $this->db->get();
        return $query;
	}
}
