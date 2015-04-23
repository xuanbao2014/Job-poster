<?php
	$this->load->view('admin/header');
?>
<?php
	if(!isset($username)){
		$username = base64_encode('attack');
	}
?>

		<style>
		fieldset.scheduler-border {
			border: 5px solid #ddd !important;
			padding: 0 1.4em 1.4em 1.4em !important;
			margin: 0 0 1.5em 0 !important;
			-webkit-box-shadow:  0px 0px 0px 0px #000;
					box-shadow:  0px 0px 0px 0px #000;
			font-weight: bolder;
			font-size: 24px;
		}

		legend.scheduler-border {
			font-size: 1.2em !important;
			font-weight: bold !important;
			text-align: center !important;
			width:auto;
			padding:0 10px;
			border-bottom:none;
		}
		</style>
		<div class="container">
			<div class="col-md-6 col-md-offset-3">
				<form method="post" accept-charset="utf-8" action="/admin/sign/sign_verify/<?=base64_encode($username)?>" role="form" novalidate>
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">Administrator</legend>
						<?php if(isset($msg_error)):?>
						<?=$msg_error;?>
						<?php endif;?>
						<div>
							<p class="alert alert-success" style="padding-top:5px;padding-bottom:5px">
								NOTE: An email should be sent to you, please use passcode inside to sign in.
							</p>
						</div>
						<div class="form-group">
							<label for="passcode">Passcode:</label>
							<input type="text" class="form-control" name="passcode" id="passcode" autofocus required>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-sm">Continue sign in</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
<?php
	$this->load->view('admin/footer');
?>