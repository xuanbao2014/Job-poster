<?php
class Member_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	//validate regular user
	function validate($email,$password){
		$info = array('email' => $email, 'password' => md5($password));
		$this->db->from('users')->where($info)->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			
			$criteria['email'] = $email;
			$affected['last_sign_timestamp'] = now();
			$this->db->where($criteria)->update('users',$affected);

			return true;
		}else{
			return false;
		}
	}

	//get regular user information
	function getMemberInfo($email,$password){
		$info = array('email' => $email, 'password' => md5($password));
		$this->db->from('users')->where($info)->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}


	//validate admin
	function validate_admin($email,$password){
		$info = array('email' => $email, 'password' => md5($password));
		$this->db->from('admin_users')->where($info)->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	//get admin information
	function getAdminInfo($email,$password){
		$info = array('email' => $email, 'password' => md5($password));
		$this->db->from('admin_users')->where($info)->limit(1);
		$query = $this->db->get();
		return $query->row_array();
	}

	function create_member($email,$password,$verify_code){
		list($name,$mailserver) = split('@',$email);
		$info = array('email' => $email, 'password' => md5($password), 'name' => $name, 'verify_code' => $verify_code, 'reg_timestamp' => now());
		$insert = $this->db->insert('users',$info);
		return $insert;
	}

	function getAllPosts(){
//		$this->db->from('post')->select('id,timestamp,jobtitle,company,industry,country,area,sponsor,employment_type,owner');
		$this->db->from('post');
		$query = $this->db->get();
		return $query->result_array();
	}

	function getPostsByUser($userid){
//		$this->db->from('post')->select('id,timestamp,jobtitle,company,industry,country,area,sponsor,employment_type')->where("owner", $userid);
		$this->db->from('post')->where("owner", $userid);
		$query = $this->db->get();
		return $query->result_array();
	}

	function getTimestamp(){
		$this->db->from('post')->select('timestamp')->order_by("timestamp", "asc");
		$query = $this->db->get();
		return $query->result_array();
	}
	
	function validateOldPassword($old,$uid){
		$criteria['id'] = $uid;
		$criteria['password'] = md5($old);
		$this->db->from('users')->where($criteria);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	function changeUserPassword($new,$uid){
		$criteria['id'] = $uid;
		$affected['password'] = md5($new);
		$this->db->where($criteria)->update('users',$affected);
//		$this->db->where('id',25)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function validateOldEmail($old,$uid){
		$criteria['id'] = $uid;
		$criteria['email'] = $old;
		$this->db->from('users')->where($criteria);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}

	function changeUserEmail($new,$uid){
		$criteria['id'] = $uid;
		$affected['email'] = $new;
		$this->db->where($criteria)->update('users',$affected);
//		$this->db->where('id',25)->update('users',$affected);
		$num = $this->db->affected_rows();
		if($num == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function setFavorite($uid,$pid){
		$criteria['uid'] = $uid;
		$criteria['pid'] = $pid;
		$this->db->from('favorite')->where($criteria);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$this->db->delete('favorite',$criteria);
		}else{
			$this->db->insert('favorite',$criteria);
		}
	}

	function checkFavorite($uid,$pid){
		$criteria['uid'] = $uid;
		$criteria['pid'] = $pid;
		$this->db->from('favorite')->where($criteria);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			return 1;
		}else{
			return 0;
		}
	}
	
	function getFavoritePostsByUser($uid){

		$this->db->from('favorite')->where("uid", $uid);
		$query = $this->db->get();
		$this->db->from('post');
		if($query->num_rows()==0){
			$result = $this->db->get();
			return array();
		}else if($query->num_rows()>=1){
			$cnt = 1;
			foreach($query->result_array() as $row){
				if($cnt==1){
					$this->db->where('id',$row['pid']);
				}else{
					$this->db->or_where('id',$row['pid']);
				}
				$cnt++;
			}
			$result = $this->db->get();
			return $result->result_array();
		}
	}
	
	function setApplyRecord($uid,$pid,$file){
		$criteria['uid'] = $uid;
		$criteria['pid'] = $pid;
		$criteria['timestamp'] = now();
		$criteria['file'] = $file;
		$criteria['status'] = 1;
		$this->db->insert('apply',$criteria);
	}
	
	function getApplyRecordByUser($uid){
		
		$output = array();

		$this->db->from('apply')->where("uid", $uid);
		$query = $this->db->get();
		$output['apply'] = $query->result_array();

		$this->db->from('post');
		if($query->num_rows()==0){
			$output['post'] = array();
		}else if($query->num_rows()>=1){
			$cnt = 1;
			foreach($query->result_array() as $row){
				if($cnt==1){
					$this->db->where('id',$row['pid']);
				}else{
					$this->db->or_where('id',$row['pid']);
				}
				$cnt++;
			}
			$result = $this->db->get();

			foreach($result->result_array() as $row){
				$data[$row['id']] = $row;
			}

			if(isset($data)){
				$output['post'] = $data;	
			}else{
				$output['post'] = NULL;	
			}
			
		}
		return $output;
	}
	
	function setFileBinding($uid,$fullpath,$name){
		$criteria['timestamp'] = now();
		$criteria['uid'] = $uid;
		$criteria['fullpath'] = $fullpath;
		$criteria['name'] = $name;
		$this->db->insert('upload_file',$criteria);
	}
	
	function getFileBinding($uid){
		$criteria['uid'] = $uid;
		$this->db->from('upload_file')->where($criteria);
		$query = $this->db->get();
		return $query;
	}
	
	function getFileBindingNumber($uid){
		$criteria['uid'] = $uid;
		$this->db->from('upload_file')->where($criteria);
		$query = $this->db->get();
		return $query->num_rows()+1;
	}
	
	function getFileInfo($uid,$id){
		$criteria['uid'] = $uid;
		$criteria['id'] = $id;
		$this->db->from('upload_file')->where($criteria)->limit(1);
		$query = $this->db->get();
		return $query;
	}
	
	function deleteUpload($uid, $id){
		$criteria['uid'] = $uid;
		$criteria['id'] = $id;
		$this->db->delete('upload_file',$criteria);
		return true;
	}
	
	function getLastApplyRecord($uid,$pid){
		$criteria['uid'] = $uid;
		$criteria['pid'] = $pid;
		$this->db->from('apply')->where($criteria)->order_by('timestamp','desc');
		$query = $this->db->get();
		return $query;
	}

	function getCurrentPostMemberInfo($pid){
		$this->db->from('post')->where('id',$pid)->limit(1);
		$query = $this->db->get();
		$post = current($query->result_array());
		$poster = $post['owner'];
		$this->db->from('users')->where('id',$poster)->limit(1);
		$query = $this->db->get();
		return $query->result_array();
	}
}
