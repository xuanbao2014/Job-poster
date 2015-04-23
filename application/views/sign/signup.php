<?php
	$this->load->view('home/header',$title);
?>

<style type="text/css">
.center-block{
	max-width: 400px;
}	
</style>


<div class="container">
	<div class="center-block">
		<?php echo validation_errors('<p class="alert alert-danger small_msg" >');?>
		<h1><?=lang('zhidian_signup_title')?></h1>
		<form method="post" accept-charset="utf-8" action="/sign/signup_check" role="form" novalidate>
			<div class="form-group">
				<label for="signUpUsername"><?=lang('zhidian_email')?></label>
				<input type="email" class="form-control" name="sign_up_username" id="signUpUsername" autofocus autocomplete="off" required>
			</div>
			<div class="form-group">
				<label for="signUpPassword"><?=lang('zhidian_password')?></label>
				<input type="password" class="form-control" name="sign_up_password" id="signUpPassword" autocomplete="off" required>
			</div>
			<div class="form-group">
				<label for="signUpPassword2"><?=lang('zhidian_password_confirm')?></label>
				<input type="password" class="form-control" name="sign_up_password2" id="signUpPassword2" autocomplete="off" required>
			</div>
			<button type="submit" class="btn btn-primary btn-sm"><?=lang('zhidian_signup')?></button>
		</form>

		<h3><?=lang('zhidian_alreadyhaveaccount')?></h3>
		<a href="/sign/signin"><?=lang('zhidian_signinhere')?></a>

	</div>

</div>

<?php
	$this->load->view('home/footer');
?>