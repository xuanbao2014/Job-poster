<?php
	$this->load->view('home/header',$title);
?>

<div class="container">
	<div><h4><span class="glyphicon glyphicon-lock"></span> &nbsp;&nbsp;<?=lang('zhidian_recovery_password')?></h4></div><hr />
	<div class="row">
		<div class="col-xs-4"><div class="progress"><div class="progress-bar" style="width:100%;"></div></div>
			<h5 class="text-success" style="text-align:center">
				<?=lang('zhidian_recovery_step1')?>
			</h5>
		</div>
		<div class="col-xs-4"><div class="progress"><div class="progress-bar" style="width:100%;"></div></div>
			<h5 class="text-success" style="text-align:center">
				<?=lang('zhidian_recovery_step2')?>
			</h5>
		</div>
		<div class="col-xs-4"><div class="progress"><div class="progress-bar"></div></div>
			<h5 class="text-success" style="text-align:center">
				<?=lang('zhidian_recovery_step3')?>
			</h5>
		</div>
	</div>
	<div class="col-xs-4 col-xs-offset-4" style="margin-top:100px;">
		<div>
			<?php
				if($this->session->flashdata('msg_error')){
					echo '<div class="alert alert-warning small_msg">'.$this->session->flashdata('msg_error').'</div>';
				}
				if($this->session->flashdata('msg_succ')){
					echo '<div class="alert alert-success small_msg">'.$this->session->flashdata('msg_succ').'</div>';
				}
			?>
			<?php echo validation_errors('<p class="alert alert-warning small_msg" >');?>
			<form class="<?php if($this->session->flashdata('msg_succ')){echo 'hidden';}?>" method="post" accept-charset="utf-8" action="/sign/recovery_reset/<?=$email;?>" role="form" novalidate>
			  <div class="form-group">
				<label><?=lang('zhidian_password')?></label>
				<input type="password" class="form-control" name="password" autofocus>
				  <label><?=lang('zhidian_password_confirm')?></label>
				<input type="password" class="form-control" name="password2">
			  </div>
			  <button type="submit" class="btn btn-primary btn-sm"><?=lang('zhidian_recovery_submit')?></button>
			</form>
		</div>
	</div>
</div>

<?php
	$this->load->view('home/footer');
?>