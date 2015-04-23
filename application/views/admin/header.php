<html>
	<head>
		<link rel="stylesheet" href="/tools/bootstrap3/css/bootstrap-yeti.min.css">
		<script src="/tools/jQuery/jquery-1.11.0.min.js"></script>
		<script src="/tools/bootstrap3/js/bootstrap.min.js"></script>
	</head>
	
	<body>
		
		<?php
			$admin_info = $this->session->userdata('admin_info');
		?>

		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			  <img src="/images/logo3.png" width="80px">
			</div>

			  <?php if(isset($admin_info) && $admin_info['signed'] == 'admin'):?>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav">
					<li><a href="<?=base_url()?>admin/panel">Home</a></li>
					<li><a href="<?=base_url()?>admin/panel/users">Users</a></li>
					<li><a href="<?=base_url()?>admin/panel/posts">Posts</a></li>
					  <!--
					<li class="dropdown">
					  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Charts <b class="caret"></b></a>
					  <ul class="dropdown-menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
						<li class="divider"></li>
						<li><a href="#">One more separated link</a></li>
					  </ul>
					</li>-->
				  </ul>
				  <ul class="nav navbar-nav navbar-right">
					<li><a href="<?=base_url()?>admin/sign/sign_out">Sign out</a></li>
				  </ul>
				</div><!-- /.navbar-collapse -->
			  <?php else:?>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				  <ul class="nav navbar-nav navbar-right">
					<li><a href="<?=base_url()?>admin/sign">Sign in</a></li>
				  </ul>
				</div><!-- /.navbar-collapse -->
			  <?php endif;?>
		  </div><!-- /.container-fluid -->
		</nav>