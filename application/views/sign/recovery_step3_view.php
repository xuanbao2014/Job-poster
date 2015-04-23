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
		<div class="col-xs-4"><div class="progress"><div class="progress-bar" style="width:100%;"></div></div>
			<h5 class="text-success" style="text-align:center">
				<?=lang('zhidian_recovery_step3')?>
			</h5>
		</div>
	</div>
	<div class="col-xs-4 col-xs-offset-4" style="margin-top:100px;">
		<div>
			<?php
				if(isset($msg_error)){
					echo '<div class="alert alert-warning small_msg">'.$msg_error.'</div>';
				}
				if(isset($msg_succ)){
					echo '<div class="alert alert-success small_msg">'.$msg_succ.'</div>';
				}
			?>
		</div>
	</div>
</div>

<?php
	$this->load->view('home/footer');
?>1