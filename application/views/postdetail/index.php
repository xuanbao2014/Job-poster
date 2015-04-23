<?php
	$this->load->view('home/header',$title,$meta_description);
?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/postdetail/script/index.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>application/views/postdetail/css/index.css" rel="stylesheet">


<div class="container">
	<div class="col-sm-8 col-sm-offset-2">
		<?php
			$timediff = now()- $content['timestamp'];
			if($timediff > 86400){
				$timeago = floor($timediff / 86400).lang('zhidian_timeago_day');
			}else if($timediff > 3600){
				$timeago = floor($timediff / 3600).lang('zhidian_timeago_hour');
			}else if($timediff > 60){
				$timeago = floor($timediff / 60).lang('zhidian_timeago_minute');
			}else{
				$timeago = floor($timediff).lang('zhidian_timeago_second');
			}

//			if(isset($this->session->userdata('memberinfo'))){
				$memberinfo = $this->session->userdata('memberinfo');
//			}
		?>
		
		<?php if(!($memberinfo['uid'] == $content['owner'] || $memberinfo['uid'] == 5)){
		if($content['status'] == 0){
			redirect('/');
					}
				}
		?>

		<?php
		if($this->session->flashdata('success')){
			echo '<div class="alert alert-success" style="padding-top:5px;padding-bottom:5px">'.$this->session->flashdata('success').'</div>';
		}
		if(isset($last_apply_timestamp)){
			$last_apply_timediff = now()- $last_apply_timestamp;
			if($last_apply_timediff > 86400){
				$last_apply_timeago = floor($last_apply_timediff / 86400).lang('zhidian_timeago_day');
			}else if($last_apply_timediff > 3600){
				$last_apply_timeago = floor($last_apply_timediff / 3600).lang('zhidian_timeago_hour');
			}else if($last_apply_timediff > 60){
				$last_apply_timeago = floor($last_apply_timediff / 60).lang('zhidian_timeago_minute');
			}else{
				$last_apply_timeago = floor($last_apply_timediff).lang('zhidian_timeago_second');
			}
			echo '<div class="alert alert-success" style="padding-top:5px;padding-bottom:5px">'.str_replace('%s',$last_apply_timeago,lang('zhidian_already_applied')).'</div>';
		}
		?>

		<?php if($memberinfo['uid'] == 5):?>
		<div style="background-color:#C4E3F3">
			Poster Email: <?=(isset($poster_email)?$poster_email:'not set');?><br />
			Job Email: <?=(isset($content['email'])?$content['email']:'not set');?><br />
			Job Link: <a href="<?=(isset($content['link'])?$content['link']:'#');?>" target="_blank"><?=(isset($content['link'])?$content['link']:'not set');?></a>
		</div>
		<hr />
		<?php endif; ?>

		<div style="clear:both;"></div>
		<div class="job-title"><?php echo $content['jobtitle'];?>
			<div class="pull-right">

			<?php if(isset($memberinfo['is_logged']) && $memberinfo['is_logged'] == true):?>
			<a href="/member/addToFavorite/<?=$content['id']?>" class="favoritePopover" data-container="body" data-toggle="popover" style="cursor:pointer;" value="/member/checkFavorite/<?=$content['id']?>"><i class="fa fa-star-o text-warning"></i></a>

				<?php if($memberinfo['uid'] == $content['owner']):?>			
				<small style="margin-left: 10px;">
				  <a class="" data-toggle="modal" href="/member/deletepost/<?=$content['id']?>" data-target="#deleteModal"><span class="glyphicon glyphicon-trash"></span></a>
				</small>

				<small style="margin-left: 10px;">				  
				  <a class="" href="/member/updatepost/<?=$content['id']?>"><span class="glyphicon glyphicon-edit"></span></a>
				</small>
				<small style="margin-left: 10px;">
				  <a class="" data-toggle="modal" href="/member/editpoststatus/<?=$content['id']?>/<?=base64_encode(current_url());?>" data-target="#deleteModal">
					  <?php if($content['status'] == 0): ?>
							<span class="label label-warning">Pending</span>
						<?php elseif($content['status'] == 1): ?>
							<span class="label label-success">Approved</span>
						<?php elseif($content['status'] == 2): ?>
							<span class="label label-info">Expired</span>
						<?php endif; ?>
				</a>
				</small>
				<?php elseif($memberinfo['uid'] == 5):?>
				<small style="margin-left: 10px;">
				  <a class="" data-toggle="modal" href="/member/deletepost/<?=$content['id']?>" data-target="#deleteModal"><span class="glyphicon glyphicon-trash"></span></a>
				</small>

				<small style="margin-left: 10px;">				  
				  <a class="" href="/member/updatepost/<?=$content['id']?>"><span class="glyphicon glyphicon-edit"></span></a>
				</small>
				<small style="margin-left: 10px;">
				  <a class="" data-toggle="modal" href="/member/editpoststatus/<?=$content['id']?>/<?=base64_encode(current_url());?>" data-target="#deleteModal">
					  <?php if($content['status'] == 0): ?>
							<span class="label label-warning">Pending</span>
						<?php elseif($content['status'] == 1): ?>
							<span class="label label-success">Approved</span>
						<?php elseif($content['status'] == 2): ?>
							<span class="label label-info">Expired</span>
						<?php endif; ?>
				</a>
				</small>
				<?php endif?>

			<?php else:?>
			<a class="favoritePopover2" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_likethispost')?>" data-content="<?=lang('zhidian_popover_saveit')?>" style="cursor:pointer;"><i class="fa fa-star-o text-warning"></i></a>
				<small style="margin-left: 10px;">

						<?php if($content['status'] == 2): ?>
							<span class="label label-info">Expired</span>
						<?php endif; ?>
			</small>
			<?php endif;?>


			</div>
						
									
		</div>

		<div class="job-company">
			<?php echo lang('zhidian_jobcompany').': '.$content['company']?>
		</div>
		<div class="job-city">
			<?php if($content['country'] === 'China' && $this->session->userdata('site_lang') != "english"):?>											
				<?php echo lang('zhidian_jobcity').': '.$content['city_cn'].", ".$content['state_cn']." ".$content['country_cn']?>
			<?php else:?>
				<?php echo lang('zhidian_jobcity').': '.$content['city'].", ".$content['state']." ".$content['country']?>
			<?php endif;?>
		</div>
		<div class="meta-tag-apply">
		<?php if(isset($memberinfo['is_logged']) && $memberinfo['is_logged'] == true):?>
				<?php if(strlen($content['email'])):?>
					<a href="/member/applyjob/<?=$content['id']?>" class="pull-right btn btn-success btn-sm"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?=lang('zhidian_apply')?></a>
				<?php endif;?>
				<?php if(strlen($content['link'])):?>
					<a href="<?=$content['link']?>" class="pull-right btn btn-info btn-sm"><span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;<?=lang('zhidian_source')?></a>
				<?php endif;?>
			<?php else:?>
				<?php if(strlen($content['email'])):?>
					<a class="favoritePopoverApply pull-right btn btn-success btn-sm" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_wanttoapply')?>" data-content="<?php echo str_replace('%s',base64_encode('/member/applyjob/'.$content['id']),lang('zhidian_popover_apply'))?>" style="cursor:pointer;">
					<span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?=lang('zhidian_apply')?>
					</a>
				<?php endif;?>
				<?php if(strlen($content['link'])):?>
					<a class="favoritePopoverApply pull-right btn btn-info btn-sm" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_wanttoapply')?>" data-content="<?php echo str_replace('%s',base64_encode($content['link']),lang('zhidian_popover_apply'))?>" style="cursor:pointer;">
					<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;<?=lang('zhidian_source')?>
					</a>
				<?php endif;?>
		<?php endif;?>

			<span class='job-tag label label-primary'><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$content['employment_type'])))?></span>
			<span class='job-tag label label-primary'><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$content['industry'])))?></span>
			<?php if($content['sponsor'] === "H1B"):?>
				<span class='job-tag label label-primary'><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$content['sponsor'])))?></span>
			<?php endif;?>
		</div>
		<hr />

		<div class="post-content"><?php echo $content['description']?></div>
		<h5><small><?php echo $timeago?></small></h5>

		<?php if(isset($memberinfo['is_logged']) && $memberinfo['is_logged'] == true):?>
				<?php if(strlen($content['email'])):?>
					<a href="/member/applyjob/<?=$content['id']?>" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?=lang('zhidian_apply')?></a>
				<?php endif;?>
				<?php if(strlen($content['link'])):?>
					<a href="<?=$content['link']?>" class="btn btn-info btn-sm"><span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;<?=lang('zhidian_source')?></a>
				<?php endif;?>
			<?php else:?>
				<?php if(strlen($content['email'])):?>
					<a class="favoritePopoverApply btn btn-success btn-sm" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_wanttoapply')?>" data-content="<?php echo str_replace('%s',base64_encode('/member/applyjob/'.$content['id']),lang('zhidian_popover_apply'))?>" style="cursor:pointer;">
					<span class="glyphicon glyphicon-briefcase"></span>&nbsp;&nbsp;<?=lang('zhidian_apply')?>
					</a>
				<?php endif;?>
				<?php if(strlen($content['link'])):?>
					<a class="favoritePopoverApply btn btn-info btn-sm" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_wanttoapply')?>" data-content="<?php echo str_replace('%s',base64_encode($content['link']),lang('zhidian_popover_apply'))?>" style="cursor:pointer;">
					<span class="glyphicon glyphicon-link"></span>&nbsp;&nbsp;<?=lang('zhidian_source')?>
					</a>
				<?php endif;?>
		<?php endif;?>
		
		<hr />
		
		<div class="alert alert-warning" role="alert">
			
			北美职点温馨提醒广大用户：近期QQ安全中心收到大量用户举报，出现多起利用QQ或微信诈骗事件，若是通过QQ或微信与雇主联系，请谨防上当受骗！详情请见：<a href="http://aq.qq.com/v2/safe_school/teach_44.shtml" class="alert-link">都是“跳转”惹的祸，谨防坏人利用知名网站的跳转链接制造钓鱼陷阱</a>				
			
		</div>


	</div>

</div>

<div class="modal fade" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
	$this->load->view('home/footer');
?>
