<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
		$this->is_logged_in();
		$this->load->library('form_validation');
    }
	
	function test(){
		
	}

	function index(){
		redirect('/member/welcome');
	}

	function is_logged_in(){
		$memberinfo = $this->session->userdata('memberinfo');

		if(!isset($memberinfo['is_logged']) || $memberinfo['is_logged'] != true){
			$this->session->set_flashdata('msg_error','zhidian_have_not_signin');
			redirect('/sign/signin');
		}
	}

	function welcome(){
		$this->load->model('member_model');
		$memberinfo = $this->session->userdata('memberinfo');
		$query = $this->member_model->getPostsByUser($memberinfo['uid']);
		$data['num_of_post'] = count($query);
		$query = $this->member_model->getFavoritePostsByUser($memberinfo['uid']);
		$data['num_of_favorite'] = count($query);
		$query = $this->member_model->getApplyRecordByUser($memberinfo['uid']);
		$data['num_of_apply'] = count($query['apply']);

		$data['right_page'] = "member/welcome_view";

		$data['title'] = lang('zhidian_member_dashboard');
		$this->load->view('member/index',$data);
	}

	function viewpost(){
		$this->load->model('member_model');
		$memberinfo = $this->session->userdata('memberinfo');
		if($memberinfo['uid']==5){
			$query = $this->member_model->getAllPosts($memberinfo['uid']);
		}else{
			$query = $this->member_model->getPostsByUser($memberinfo['uid']);
		}
		$data['content'] = $query;
		$data['title'] = lang('zhidian_member_viewpost');
		$data['right_page'] = "member/viewpost_view";
		$this->load->view('member/index',$data);
	}

	function addpost(){
		$data['status'] = false;
		$data['function'] = 'add';

		$data['right_page'] = "member/job_composer_view";
		$data['title'] = lang('zhidian_member_addpost');

		$this->load->view('member/index',$data);
	}

	function updatepost($pid){
		$this->db->from('post')->where('id',$pid)->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() > 0){
			$data=$query->row_array();
			$data['right_page'] = "member/job_composer_view";
			$data['updatepid']=$pid;
			$data['function']='update';
 			$data['title'] = lang('zhidian_member_editpost');

			$this->load->view('member/index',$data);
		}else{
			redirect('/member/viewpost');
		}
	}

	
	public function updatePostFromDataBase(){

		$updatepid = $this->input->get_post('updatepid');
		$jobtitle = $this->input->get_post('jobtitle');
		$company = $this->input->get_post('company');
		$industry = $this->input->get_post('industry');
		$country =  $this->input->get_post('country');
		$state = $this->input->get_post('state');
		$city =  $this->input->get_post('city');	
		$latitude =  $this->input->get_post('latitude');
		$longitude =  $this->input->get_post('longitude');
		$sponsor = $this->input->get_post('sponsor');
		$employment_type = $this->input->get_post('employment_type');
		$description = $this->input->get_post('description');
		$link = $this->input->get_post('link');
		$email = $this->input->get_post('email');
		$user_entered_location = $this->input->get_post('user_entered_location');

		
		
		// field name, error message, rules
		//ben: do we only need either link or email? or need both of them?
		$this->form_validation->set_rules('jobtitle', lang('zhidian_jobtitle'), 'trim|required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('company', lang('zhidian_jobcompany'), 'trim|required|max_length[100]');
		$this->form_validation->set_rules('industry', lang('zhidian_jobindustry'), 'trim|required');

		$this->form_validation->set_rules('country', lang('zhidian_jobcountry'), 'trim|required');
		$this->form_validation->set_rules('state', lang('zhidian_jobstate'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', lang('zhidian_jobcity'), 'trim|required|max_length[50]');
		
		$this->form_validation->set_rules('sponsor', lang('zhidian_jobsponsor'), 'trim|required');
		$this->form_validation->set_rules('employment_type', lang('zhidian_jobmploymenttype'), 'trim|required');
		$this->form_validation->set_rules('description', lang('zhidian_jobdescription'), 'trim|required');
		$this->form_validation->set_rules('link', lang('zhidian_joblink'), 'trim|callback_valid_url');
		$this->form_validation->set_rules('email', lang('zhidian_jobemail'), 'trim|valid_email');


		$memberinfo = $this->session->userdata('memberinfo');
		$actor = $memberinfo['uid'];
		$this->db->select('owner')->from('post')->where('id',$updatepid)->limit(1);
		$query = $this->db->get();

		if($this->form_validation->run()
			&& $query->num_rows()>0
			&& ($query->row()->owner==$actor || $actor==5)){
			
			$data = array(
				'jobtitle' => $jobtitle,
				'company' => $company,
				'industry' => $industry,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'sponsor' => $sponsor,
				'employment_type' => $employment_type,
				'description' => $description,
				'link' => $link,
				'email' => $email,
				'user_entered_location' => $user_entered_location,
			);

			//The following code is to find a place's chinese name by Google reverse geocoding
			//if the reponse is not OK, then the chinese name will be the same as English
			$pre_url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=zh_CN&latlng=';
			$url = $pre_url.$latitude.",".$longitude;

			header('Content-type: application/json; charset=UTF-8');

			$response = json_decode(file_get_contents($url),true);
			
			$componentForm = array(
				'locality' => 'long_name',
				'administrative_area_level_1' => 'long_name',
				'country' => 'long_name',
			);
		
			$lookup_cn = array(
				'locality' => 'city_cn',
				'administrative_area_level_1' => 'state_cn',
				'country' => 'country_cn',
			);
			
			$lookup_en = array(
				'locality' => 'city',
				'administrative_area_level_1' => 'state',
				'country' => 'country',
			);

			$data['city'] = $city;
			$data['state'] = $state;
			$data['country'] = $country;

			if($response['status'] === "OK" and isset($response['results'][0]['address_components'])){								
				foreach($response['results'][0]['address_components'] as $item){					
					if(isset($componentForm[$item['types'][0]])){
						$data[$lookup_cn[$item['types'][0]]] =	$item[$componentForm[$item['types'][0]]];
					}
				}
			}else{
				$data['city_cn'] = $city;
				$data['state_cn'] = $state;
				$data['country_cn'] = $country;
			}		


			$this->db->where('id', $updatepid);
			$this->db->update('post', $data);
			redirect('/postdetail/'.$updatepid);
		}else{
			$data['right_page'] = "member/job_composer_view";
 			$data['title'] = lang('zhidian_member_editpost');		
			$this->load->view('member/index',$data);
		}
	}	


	function deletepost($pid){
		$data['delpid'] = $pid;

		$this->load->view('/member/deletepost_dialog',$data);
	}
	
	function editpoststatus($pid,$url){
		$data['pid'] = $pid;
		$data['url'] = $url;

		$this->load->view('/member/job_edit_status',$data);
	}
	
	//	Post Status Control -----------------------------------------------------
	function editPostStatusFromDataBase($pid,$status,$url){
		$memberinfo = $this->session->userdata('memberinfo');
		$actor = $memberinfo['uid'];
		$criteria['id'] = $pid;
		$affected['status'] = $status;
		
		$this->load->model('member_model');
		$posterinfo = current($this->member_model->getCurrentPostMemberInfo($pid));
		$poster_email = $posterinfo['email'];

		if($status==0){
			//	Must be admin
			if($actor==5){
				$this->db->where($criteria)->update('post',$affected);
				//	Send Pending Email
				$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
				$this->send_email_new_pending_post('contact@zhidian.us',$jobpost_url);
			}else{
			}
		}else if($status==1){
			if($actor==5){
				$this->db->where($criteria)->update('post',$affected);
				
				//	Send Approve Email
				$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
				$this->send_email_new_approved_post($poster_email,$jobpost_url);
			}else{
			}
		}else if($status == 2){
			$this->db->where($criteria)->update('post',$affected);
			
			//	Send Expired Email
			$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
			$this->send_email_new_expired_post($poster_email,$jobpost_url);

		}else if($status == 3){
			$affected['timestamp'] = now();
			$affected['status'] = 0;
			$this->db->where($criteria)->update('post',$affected);

			//	Send Pending Email
			$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
			$this->send_email_new_pending_post('contact@zhidian.us',$jobpost_url);
		}
		
		redirect(base64_decode($url));
	}

	function deletePostFromDataBase($delpid){

		$memberinfo = $this->session->userdata('memberinfo');
		$actor = $memberinfo['uid'];
		$this->db->select('owner')->from('post')->where('id',$delpid)->limit(1);
		$query = $this->db->get();
		if($query->num_rows()>0){
			if($owner=$query->row()->owner==$actor || $actor==5){
				$this->db->delete('post', array('id' => $delpid)); 
			}
		}
		redirect('/member/viewpost');
	}

	public function addPostToDataBase(){

		$timestamp = now();
		$jobtitle = $this->input->get_post('jobtitle');
		$company = $this->input->get_post('company');
		$industry = $this->input->get_post('industry');
		$country =  $this->input->get_post('country');
		$state = $this->input->get_post('state');
		$city =  $this->input->get_post('city');
		$latitude =  $this->input->get_post('latitude');
		$longitude =  $this->input->get_post('longitude');
		$sponsor = $this->input->get_post('sponsor');
		$employment_type = $this->input->get_post('employment_type');
		$description = $this->input->get_post('description');
		$link = $this->input->get_post('link');
		$email = $this->input->get_post('email');
		$user_entered_location = $this->input->get_post('user_entered_location');

		
		// field name, error message, rules
		//ben: do we only need either link or email? or need both of them?
		$this->form_validation->set_rules('jobtitle', lang('zhidian_jobtitle'), 'trim|required|min_length[2]|max_length[100]');
		$this->form_validation->set_rules('company', lang('zhidian_jobcompany'), 'trim|required|max_length[100]');
		$this->form_validation->set_rules('industry', lang('zhidian_jobindustry'), 'trim|required');

		$this->form_validation->set_rules('country', lang('zhidian_jobcountry'), 'trim|required');
		$this->form_validation->set_rules('state', lang('zhidian_jobstate'), 'trim|required|max_length[50]');
		$this->form_validation->set_rules('city', lang('zhidian_jobcity'), 'trim|required|max_length[50]');
		
		$this->form_validation->set_rules('sponsor', lang('zhidian_jobsponsor'), 'trim|required');
		$this->form_validation->set_rules('employment_type', lang('zhidian_jobmploymenttype'), 'trim|required');
		$this->form_validation->set_rules('description', lang('zhidian_jobdescription'), 'trim|required');
		$this->form_validation->set_rules('link', lang('zhidian_joblink'), 'trim|callback_valid_url');
		$this->form_validation->set_rules('email', lang('zhidian_jobemail'), 'trim|valid_email');

		//suspebd form validation for testing!
		if($this->form_validation->run()){
			$memberinfo = $this->session->userdata('memberinfo');
			$owner = $memberinfo['uid'];

			$data = array(
				'timestamp' => $timestamp,
				'jobtitle' => $jobtitle,
				'company' => $company,
				'industry' => $industry,
				'latitude' => $latitude,
				'longitude' => $longitude,
				'sponsor' => $sponsor,
				'employment_type' => $employment_type,
				'description' => $description,
				'link' => $link,
				'email' => $email,
				'owner' => $owner,
				'user_entered_location' => $user_entered_location,
			);

			//if admin, set the post status to 1 (approved)
			if($owner == 5 || $owner == 980){
				$data['status'] = 1;
			}else{
				$data['status'] = 0;
			}

			//The following code is to find a place's chinese name by Google reverse geocoding
			//if the reponse is not OK, then the chinese name will be the same as English
			$pre_url = 'http://maps.googleapis.com/maps/api/geocode/json?sensor=false&language=zh_CN&latlng=';
			$url = $pre_url.$latitude.",".$longitude;

			header('Content-type: application/json; charset=UTF-8');

			$response = json_decode(file_get_contents($url),true);
			
			$componentForm = array(
				'locality' => 'long_name',
				'administrative_area_level_1' => 'long_name',
				'country' => 'long_name',
			);
		
			$lookup_cn = array(
				'locality' => 'city_cn',
				'administrative_area_level_1' => 'state_cn',
				'country' => 'country_cn',
			);
			
			$lookup_en = array(
				'locality' => 'city',
				'administrative_area_level_1' => 'state',
				'country' => 'country',
			);

			$data['city'] = $city;
			$data['state'] = $state;
			$data['country'] = $country;

			if($response['status'] === "OK" and isset($response['results'][0]['address_components'])){								
				foreach($response['results'][0]['address_components'] as $item){					
					if(isset($componentForm[$item['types'][0]])){
						$data[$lookup_cn[$item['types'][0]]] =	$item[$componentForm[$item['types'][0]]];
					}
				}
			}else{
				$data['city_cn'] = $city;
				$data['state_cn'] = $state;
				$data['country_cn'] = $country;
			}

				


			$this->db->insert('post',$data);
			$this->db->from('post')->where('timestamp',$timestamp);
			$newpost = $this->db->get()->row_array();
			$pid = $newpost['id'];

			if($data['status']==0){
				$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
				$this->send_email_new_pending_post('contact@zhidian.us',$jobpost_url);
				
				$this->load->model('member_model');
				$posterinfo = current($this->member_model->getCurrentPostMemberInfo($pid));
				$poster_email = $posterinfo['email'];
				$this->send_email_new_pending_post($poster_email,$jobpost_url);
			}else if($data['status']==1){
				$this->load->model('member_model');
				$posterinfo = current($this->member_model->getCurrentPostMemberInfo($pid));
				$poster_email = $posterinfo['email'];
				//	Send Approve Email
				$jobpost_url = base64_encode(site_url('postdetail').'/'.$pid);
				$this->send_email_new_approved_post($poster_email,$jobpost_url);
			}

			$this->session->set_flashdata('pid', $pid);
			redirect('/member/addpost');

		}else{
			$data['function'] = 'add';
			$data['right_page'] = "member/job_composer_view";
			$data['title'] = lang('zhidian_member_addpost');
			$this->load->view('member/index',$data);
		}
	}

	public function valid_url($str){
        $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        if(empty($str)){
        	return TRUE;
        }elseif (!preg_match($pattern, $str)){
            return FALSE;
        }else{
    		return TRUE;
		}
	}
	
	public function profile(){
		$data['right_page'] = "member/profile_view";
		$data['title'] = 'Profile';
		$this->load->view('member/index',$data);
	}
	
	public function account($data=array()){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$data['right_page'] = "member/account_view";
		$data['title'] = lang('zhidian_member_account');
		$this->load->model('member_model');
		$query = $this->member_model->getFileBinding($uid);
		if($query->num_rows() > 0){
			$data['content'] = $query->result_array();
		}
		$this->load->view('member/index',$data);
	}

	public function changePassword(){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$old_password = $this->input->get_post('old_password');
		$new_password = $this->input->get_post('new_password');
		$new_password2 = $this->input->get_post('new_password2');

		
		// field name, error message, rules
		$this->form_validation->set_rules('old_password', lang('zhidian_current_password'), 'trim|required|min_length[6]|max_length[32]|callback__check_old_password');
		$this->form_validation->set_rules('new_password', lang('zhidian_new_password'), 'trim|required|min_length[6]|max_length[32]');
		$this->form_validation->set_rules('new_password2', lang('zhidian_password_confirm'), 'trim|required|matches[new_password]');

		$data['tab'] = '#password_tab';
		if($this->form_validation->run()){

			$this->load->model('member_model');
			$result = $this->member_model->changeUserPassword($new_password,$uid);

			if($result){
				$this->session->set_flashdata('pwd_changed', 1);
				$data['title'] = lang('zhidian_member_account');
				redirect('/member/account');
			}else{
				$data['form1_errors'] = validation_errors('<p class="alert alert-warning small_msg" >');
				$data['title'] = lang('zhidian_member_account');
				$this->account($data);
			}
		}else{
			$data['form1_errors'] = validation_errors('<p class="alert alert-warning small_msg" >');
			$data['title'] = lang('zhidian_member_account');
			$this->account($data);
		}
	}

	public function _check_old_password($old)
	{
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$result = $this->member_model->validateOldPassword($old,$uid);

		if($result){
			return true;
		}
		else{
			$this->form_validation->set_message('_check_old_password', lang('zhidian_invalid_current_password'));
			return false;
		}
	}
	
	public function changeEmail(){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$old_email = $this->input->get_post('old_email');
		$new_email = $this->input->get_post('new_email');
		$new_email2 = $this->input->get_post('new_email2');

		
		// field name, error message, rules
		$this->form_validation->set_rules('old_email', lang('zhidian_current_email'), 'trim|required|valid_email|callback__check_old_email');
		$this->form_validation->set_rules('new_email', lang('zhidian_new_email'), 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('new_email2', lang('zhidian_email_confirm'), 'trim|required|valid_email|matches[new_email]');

		$data['tab'] = '#email_tab';
		if($this->form_validation->run()){

			$this->load->model('member_model');
			$result = $this->member_model->changeUserEmail($new_email,$uid);

			if($result){
				$this->session->set_flashdata('email_changed', 1);
				redirect('/member/account');
			}else{
				$data['form2_errors'] = validation_errors('<p class="alert alert-warning small_msg" >');
				$this->account($data);
			}
		}else{
			$data['form2_errors'] = validation_errors('<p class="alert alert-warning small_msg" >');
			$this->account($data);
		}
	}

	public function _check_old_email($old)
	{
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$result = $this->member_model->validateOldEmail($old,$uid);

		if($result){
			return true;
		}
		else{
			$this->form_validation->set_message('_check_old_email', lang('zhidian_invalid_current_email'));
			return false;
		}
	}
	
	public function favorite(){
		$data['right_page'] = "member/favorite_post_view";
		$data['title'] = lang('zhidian_member_favorite');
		$this->load->model('member_model');
		$memberinfo = $this->session->userdata('memberinfo');
		$query = $this->member_model->getFavoritePostsByUser($memberinfo['uid']);
		$data['content'] = $query;

		$this->load->view('member/index',$data);
	}
	
	public function addToFavorite($pid){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$query = $this->member_model->setFavorite($uid,$pid);
	}
	
	public function checkFavorite($pid){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$query = $this->member_model->checkFavorite($uid,$pid);
		echo $query;
	}
	
	function deleteFavorite($pid){
		$data['delpid'] = $pid;

		$this->load->view('member/deletefavorite_dialog',$data);
	}

	function deleteFavoriteFromDataBase($delpid){

		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$criteria['uid'] = $uid;
		$criteria['pid'] = $delpid;
		$this->db->delete('favorite',$criteria);
		redirect('/member/favorite');
	}
	
	function applyjob($pid){
		$memberinfo = $this->session->userdata('memberinfo');
		$email = $memberinfo['username'];
		$uid = $memberinfo['uid'];

		$this->load->model('jobpost_model');
		$query = $this->jobpost_model->getPostContent($pid);
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$post_email = $row['email'];
				$data['subject'] = lang('zhidian_email_subject_default_text').$row['jobtitle'];
			}
			$this->load->model('member_model');
			$query = $this->member_model->getFileBinding($uid);
			$data['usermail'] = $email;
			$data['postmail'] = $post_email;
			$data['pid'] = $pid;
			$data['right_page'] = "member/applyjob_view";
			$data['title'] = lang('zhidian_apply');
			if($query->num_rows() > 0){
				$data['filelist'] = $query->result_array();
			}
			$this->load->view('member/index',$data);
		}else{
			redirect('/');
		}
	}
	
	function applyjob_send($pid){
		$memberinfo = $this->session->userdata('memberinfo');
		$name = $memberinfo['name'];
		$email = $memberinfo['username'];
		$uid = $memberinfo['uid'];
		$this->load->model('jobpost_model');
		$query = $this->jobpost_model->getPostContent($pid);
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$post_email = $row['email'];
			}
			$from = 'no-reply@zhidian.us';
			$to = $post_email;
			$cc = $email;
			$userfile = $this->input->get_post('userfile');
			$description = $this->input->get_post('description');
			$myfileid = $this->input->get_post('myfile');
			$subject = $this->input->get_post('subject');

			$this->load->model('member_model');
			
			// field name, error message, rules
			//ben: do we only need either link or email? or need both of them?
			$this->form_validation->set_rules('description', lang('zhidian_email_body'), 'trim|required');
			
			if($myfileid == NULL){
				$result = $this->_do_upload();
			}else{
				$result = array();
				$fileinfo = $this->member_model->getFileInfo($uid,$myfileid);
				if($fileinfo->num_rows() > 0){
					$result['flag'] = true;
					foreach($fileinfo->result_array() as $row){
						$result['file']['orig_name'] = $row['name'];
						$result['file']['full_path'] = $row['fullpath'];
					}
				}else{
					$result['flag'] = false;
				}
			}

			/*echo "from: ".$from."<br />";
			echo " to : ".$to."<br />";
			echo " cc : ".$cc."<br />";
			if($result['flag']){
				echo "atth:".$result['file']['full_path']."<br />";
			}else{
				echo "atth:".$result['error']."<br />";
			}*/

			if($this->form_validation->run() && $result['flag']){

				$this->_send_applyjob_email($from,$to,$cc,$result['file']['full_path'],$subject,$pid,$description,$result['file']['orig_name']);

				$this->member_model->setApplyRecord($uid,$pid,$result['file']['full_path']);

				$this->session->set_flashdata('success', 'You have successfully applied this job!');
				redirect('/postdetail/'.$pid);
			}else{
				$this->session->set_flashdata('error', $result['error']);
				$this->applyjob($pid);
			}
		}else{
			redirect('/');
		}
	}

	function _do_upload(){
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '10000000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$result = array('error' => $this->upload->display_errors());
			$result['flag'] = false;
			return $result;
		}
		else
		{
			$result = array('file' => $this->upload->data());
			$result['flag'] = true;
			return $result;
		}
	}

	public function _send_applyjob_email($from,$to,$cc,$file,$subject,$pid,$desc,$orig_filename){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.exmail.qq.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'no-reply@zhidian.us';
		$config['smtp_pass'] = 'Jobcopter1';
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from($from,'zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->to($to);
		// ! NEED CHANGE LATER
		$this->email->cc($cc);
		$this->email->reply_to($cc);
		$this->email->subject($subject);
		$this->email->message(
					'<p>'.$desc.'</p><hr />'
					.'<p>'.lang('zhidian_email_message_addon').'</p>'
					.'<p><a href="'.site_url('postdetail/'.$pid).'">'.site_url('postdetail/'.$pid).'</a></p>'
					.'<p> 简历在附件中 Resume has been attached.</p>');
		$this->email->attach($file, 'attachment', $orig_filename);

		$this->email->send();
	}
	
	public function applyrecord(){
		$data['right_page'] = "member/applyrecord_view";
		$data['title'] = lang('zhidian_member_applyrecord');
		$this->load->model('member_model');
		$memberinfo = $this->session->userdata('memberinfo');
		$query = $this->member_model->getApplyRecordByUser($memberinfo['uid']);
		
		$data['apply'] = $query['apply'];	
		$data['post'] = $query['post'];	
		
		
		
//		print_r ($query);

		$this->load->view('member/index',$data);
	}
	
	public function applyjob_preview($pid){
		if($this->input->is_ajax_request()){
			$memberinfo = $this->session->userdata('memberinfo');
			$name = $memberinfo['name'];
			$email = $memberinfo['username'];
			$uid = $memberinfo['uid'];
			$this->load->model('jobpost_model');
			$query = $this->jobpost_model->getPostContent($pid);
			if($query->num_rows() == 1){
				foreach($query->result_array() as $row){
					$post_email = $row['email'];
				}
				$from = 'no-reply@zhidian.us';
				$to = $post_email;
				$cc = $email;
				$userfile = $this->input->get_post('userfile');
				$desc = $this->input->get_post('description');
				$subject = $this->input->get_post('subject');

				$data['right_page'] = "member/applyjob_preview_view";
				$data['title'] = 'Preview';
				$data['from'] = $from;
				$data['to'] = $to;
				$data['cc'] = $cc;
				$data['subject'] = $subject;
				$data['userfile'] = $userfile;
				$data['description'] = 
					'<p>'.$desc.'</p><hr />'
					.'<p>'.lang('zhidian_email_message_addon').'</p>'
					.'<p><a href="'.site_url('postdetail/'.$pid).'">'.site_url('postdetail/'.$pid).'</a></p>'
					.'<p> 简历在附件中 Resume has been attached.</p>';

				$this->load->view('member/index',$data);
			}
		}else{
			redirect('/');
		}
	}

	public function upload_file(){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$filenum = $this->member_model->getFileBindingNumber($uid);
		
		if($filenum<=5){
			$result = $this->_do_account_upload();
			if($result['flag']){
				$this->member_model->setFileBinding($uid,$result['file']['full_path'],$result['file']['orig_name']);

				$this->session->set_flashdata('success', $result['file']['orig_name'].lang('zhidian_files_uploaded'));
				redirect('/member/account#upload_tab');
			}else{
				$this->session->set_flashdata('error', $result['error']);
				redirect('/member/account#upload_tab');
			}
		}else{
			$this->session->set_flashdata('error', lang('zhidian_upload_file_limit'));
			redirect('/member/account#upload_tab');
		}
	}

	function _do_account_upload(){
		$config['upload_path'] = './uploads';
		$config['allowed_types'] = 'pdf';
		$config['max_size']	= '10000000';
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		if ( ! $this->upload->do_upload())
		{
			$result = array('error' => $this->upload->display_errors());
			$result['flag'] = false;
			return $result;
		}
		else
		{
			$result = array('file' => $this->upload->data());
			$result['flag'] = true;
			return $result;
		}
	}
	
	function delete_upload($id){
		$memberinfo = $this->session->userdata('memberinfo');
		$uid = $memberinfo['uid'];
		$this->load->model('member_model');
		$filenum = $this->member_model->deleteUpload($uid,$id);
		$this->session->set_flashdata('success', 'File deleted!');
		redirect('/member/account#upload_tab');
	}
	
	public function send_email_new_pending_post($user_email,$base64_url){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.exmail.qq.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'no-reply@zhidian.us';
		$config['smtp_pass'] = 'Jobcopter1';
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from('no-reply@zhidian.us', 'zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->to($user_email);
		// ! NEED CHANGE LATER
		$this->email->subject('A pending job need approve.');
		$this->email->message(
			'A pending job need approve!<br />This is the link:'
			.'<a href="'.base64_decode($base64_url).'">'.base64_decode($base64_url).'</a>');
		//$this->email->message(file_get_contents('http://www.zhidian.us/'));


		$this->email->send();
	}

	public function send_email_new_approved_post($user_email,$base64_url){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.exmail.qq.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'no-reply@zhidian.us';
		$config['smtp_pass'] = 'Jobcopter1';
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from('no-reply@zhidian.us', 'zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->to($user_email);
		// ! NEED CHANGE LATER
		$this->email->subject('Your post has been approved.');
		$this->email->message(
			'Your post has been approved!<br />This is the link:'
			.'<a href="'.base64_decode($base64_url).'">'.base64_decode($base64_url).'</a>');

		$this->email->send();
	}
	
	public function send_email_new_expired_post($user_email,$base64_url){
		$this->load->library('email');
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.exmail.qq.com';
		$config['smtp_port'] = 465;
		$config['smtp_user'] = 'no-reply@zhidian.us';
		$config['smtp_pass'] = 'Jobcopter1';
		$config['newline'] = "\r\n";
		$this->email->initialize($config);
		// ! NEED CHANGE LATER
		$this->email->from('no-reply@zhidian.us', 'zhidian.us');
		// ! NEED CHANGE LATER
		$this->email->to($user_email);
		// ! NEED CHANGE LATER
		$this->email->subject('Your post has expired.');
		$this->email->message(
			'Your post has expired! If you still want it, you can log in and renew it!<br />This is the link:'
			.'<a href="'.base64_decode($base64_url).'">'.base64_decode($base64_url).'</a>');

		$this->email->send();
	}
}

?>