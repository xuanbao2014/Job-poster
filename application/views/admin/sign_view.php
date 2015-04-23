<?php
	$this->load->view('admin/header');
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
				<form method="post" accept-charset="utf-8" action="/admin/sign/sign_check" role="form" novalidate>
					<fieldset class="scheduler-border">
						<legend class="scheduler-border">Administrator</legend>
						<?php if($this->session->flashdata('msg_error')):?>
						<?=$this->session->flashdata('msg_error')?>
						<?php endif;?>
						<div class="form-group">
							<label for="username">Username:</label>
							<input type="email" class="form-control" name="username" id="username" autofocus required>
						</div>
						<div class="form-group">
							<label for="password">Password:</label>
							<input type="password" class="form-control" name="password" id="password" required>
						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-sm">Sign in</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
<?php
	$this->load->view('admin/footer');
?>