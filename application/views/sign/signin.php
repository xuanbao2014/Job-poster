<?php
	$this->load->view('home/header',$title);
?>

<style type="text/css">
.center-block{
	max-width: 400px;
}	
</style>


<div class="container ">
	<div class="center-block" >
		<?php echo validation_errors('<p class="alert alert-warning small_msg" >');?>
		<?php if(isset($msg)){echo '<p class="alert alert-warning small_msg">'.$msg.'</p>';}?>
		<?php if($this->session->flashdata('msg_error')):?>
			<p class="alert alert-warning small_msg">
				<?=lang($this->session->flashdata('msg_error'))?></a>
			</p>
		<?php endif;?>

		<h1><?=lang('zhidian_signin_title')?></h1>
		<form method="post" accept-charset="utf-8" action="/sign/signin_check" role="form" novalidate>
			<div class="form-group">
				<label for="$signInUsername"><?=lang('zhidian_email')?></label>
				<input type="email" class="form-control" name="username" id="signInUsername" autofocus required>
		 	</div>
			<div class="form-group">
				<label for="signInPassword"><?=lang('zhidian_password')?></label>
				<input type="password" class="form-control" name="password" id="signInPassword" required>
		 	</div>

		 	<input name="currentpage" value="<?php echo isset($currentpage)?$currentpage:null; ?>" hidden>

		 	<button type="submit" class="btn btn-primary btn-sm"><?=lang('zhidian_signin')?></button>
  			<a href="/sign/recovery">
				<?=lang('zhidian_forget_password')?>
			</a>

		</form>
		<h3><?=lang('zhidian_donothaveaccount')?></h3>
		<a href="/sign/signup"><?=lang('zhidian_signuphere')?></a>
	</div>
</div>

<?php
	$this->load->view('home/footer');
?>