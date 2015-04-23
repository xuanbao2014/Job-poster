<?php

class Panel extends CI_Controller{

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->load->model('admin_model');
    }
	
	private function check_auth(){
		$admin_info = $this->session->userdata('admin_info');
		if(isset($admin_info) && $admin_info['signed'] == 'admin'){

		}else{
			redirect('/admin/sign');
		}
	}
	
	public function index(){
		
		$this->check_auth();

		//----- Users Overview --------------------------------------------------
		$registered_users_today = 0;
		$signed_users_today = 0;
		$not_activated_users = 0;
		$activated_users = 0;
		$blocked_users = 0;
		$total_users = 0;

		$users_chart_data;

		$userlist = $this->admin_model->get_all_users_info();
		foreach($userlist as $user){
			$user_id = $user['id'];
			$user_name = $user['name'];
			$user_email = $user['email'];
			$user_reg_time = $user['reg_timestamp'];
			$user_last_time = $user['last_sign_timestamp'];
			$user_status = $user['status'];

			if(date('Ymd') == date('Ymd', strtotime(unix_to_human($user_reg_time)))){
				$registered_users_today++;
			}

			if(date('Ymd') == date('Ymd', strtotime(unix_to_human($user_last_time)))){
				$signed_users_today++;
			}
			
			if($user_status == 0){
				$not_activated_users++;
			}else if($user_status == 1){
				$activated_users++;
			}else if($user_status == 2){
				$blocked_users++;
			}
			$total_users++;

			$year = date('Y', strtotime(unix_to_human($user_reg_time)));
			$month = date('M', strtotime(unix_to_human($user_reg_time)));
			if($year >= 2013){
				if(!isset($users_chart_data[$year])){
					$users_chart_data[$year]['Jan'] = 0;
					$users_chart_data[$year]['Feb'] = 0;
					$users_chart_data[$year]['Mar'] = 0;
					$users_chart_data[$year]['Apr'] = 0;
					$users_chart_data[$year]['May'] = 0;
					$users_chart_data[$year]['Jun'] = 0;
					$users_chart_data[$year]['Jul'] = 0;
					$users_chart_data[$year]['Aug'] = 0;
					$users_chart_data[$year]['Sep'] = 0;
					$users_chart_data[$year]['Oct'] = 0;
					$users_chart_data[$year]['Nov'] = 0;
					$users_chart_data[$year]['Dec'] = 0;
				}
				$users_chart_data[$year][$month]++;
			}
		}
		
		$data['registered_users_today'] = $registered_users_today;
		$data['signed_users_today'] = $signed_users_today;
		$data['not_activated_users'] = $not_activated_users;
		$data['activated_users'] = $activated_users;
		$data['blocked_users'] = $blocked_users;
		$data['total_users'] = $total_users;
		$data['users_chart_data'] = $users_chart_data;
		
		//----- Posts Overview: 0 - pending, 1 - approved, 2 - expired
		$new_posts_today = 0;
		$approved_posts_today = 0;
		$pending_posts = 0;
		$approved_posts = 0;
		$expired_posts = 0;
		$total_posts = 0;
		
		$posts_chart_data;

		$postlist = $this->admin_model->get_all_posts_info();
		foreach($postlist as $post){
			$post_id = $post['id'];
			$post_timestamp = $post['timestamp'];
			$post_status = $post['status'];

			if(date('Ymd') == date('Ymd', strtotime(unix_to_human($post_timestamp)))){
				$new_posts_today++;
				if($post_status == 1){
					$approved_posts_today++;
				}
			}


			if($post_status == 0){
				$pending_posts++;
			}else if($post_status == 1){
				$approved_posts++;
			}else if($post_status == 2){
				$expired_posts++;
			}
			$total_posts++;

			$year = date('Y', strtotime(unix_to_human($post_timestamp)));
			$month = date('M', strtotime(unix_to_human($post_timestamp)));
			if($year >= 2013){
				if(!isset($posts_chart_data[$year])){
					$posts_chart_data[$year]['Jan'] = 0;
					$posts_chart_data[$year]['Feb'] = 0;
					$posts_chart_data[$year]['Mar'] = 0;
					$posts_chart_data[$year]['Apr'] = 0;
					$posts_chart_data[$year]['May'] = 0;
					$posts_chart_data[$year]['Jun'] = 0;
					$posts_chart_data[$year]['Jul'] = 0;
					$posts_chart_data[$year]['Aug'] = 0;
					$posts_chart_data[$year]['Sep'] = 0;
					$posts_chart_data[$year]['Oct'] = 0;
					$posts_chart_data[$year]['Nov'] = 0;
					$posts_chart_data[$year]['Dec'] = 0;
				}
				$posts_chart_data[$year][$month]++;
			}
		}

		$data['new_posts_today'] = $new_posts_today;
		$data['approved_posts_today'] = $approved_posts_today;
		$data['pending_posts'] = $pending_posts;
		$data['approved_posts'] = $approved_posts;
		$data['expired_posts'] = $expired_posts;
		$data['total_posts'] = $total_posts;
		$data['posts_chart_data'] = $posts_chart_data;

		//	Send Overview Data to page

		$this->load->view('/admin/panel_view',$data);
	}

	public function users(){
		$this->check_auth();

		$userlist = $this->admin_model->get_all_users_info();
		$data['userlist'] = $userlist;
		$this->load->view('/admin/panel_users',$data);
	}
	
	public function posts(){
		$this->check_auth();

		$postlist = $this->admin_model->get_all_posts_info();
		$data['postlist'] = $postlist;
		$this->load->view('/admin/panel_posts',$data);
	}
}

?>