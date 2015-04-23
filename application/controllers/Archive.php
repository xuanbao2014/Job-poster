<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Archive extends CI_Controller {

	public function index(){
		//	Need set a cron job
		$curtime = now();
		$this->db->from('post');
		$query = $this->db->get();
		
		$total_post = $query->num_rows();
		$pending_post = 0;
		$approved_post = 0;
		$expired_post = 0;
		
		$new_pending_post = 0;
		$new_approved_post = 0;
		$new_expired_post = 0;

		foreach($query->result_array() as $row){
			$posttime = $row['timestamp'];
			$poststatus = $row['status'];
			
			if($poststatus==0){
				$pending_post++;
			}elseif($poststatus==1){
				$approved_post++;
			}elseif($poststatus==2){
				$expired_post++;
			}

			$timediff = $curtime - $posttime;
			if($timediff > 86400){
				$timeago = floor($timediff / 86400);
				
				if($timeago>=30){
					$criteria['id'] = $row['id'];
					$affected['status'] = 2;
					$this->db->where($criteria)->update('post',$affected);
					$num = $this->db->affected_rows();
					if($num==1){
						if($poststatus==0){
							$new_pending_post--;
							$new_expired_post++;
						}elseif($poststatus==1){
							$new_approved_post--;
							$new_expired_post++;
						}
					}
				}
			}
		}
		
		$format = 'DATE_ISO8601';
		echo "Date : ".standard_date($format, $curtime)."<br />";
		echo "Auto Archive Result:<br />";
		echo "Total   : ".$total_post."<br />";
		echo "Pending : ".$pending_post."(".($new_pending_post>0?"+".$new_pending_post:$new_pending_post).") -> ".($pending_post+$new_pending_post)."<br />";
		echo "Approved: ".$approved_post."(".($new_approved_post>0?"+".$new_approved_post:$new_approved_post).") -> ".($approved_post+$new_approved_post)."<br />";
		echo "Expired : ".$expired_post."(".($new_expired_post>0?"+".$new_expired_post:$new_expired_post).") -> ".($expired_post+$new_expired_post)."<br />";

	}

}

?>