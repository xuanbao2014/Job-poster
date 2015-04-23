<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="职点">
	<!--	fix this//-->
	<link rel="shortcut icon" href="../../docs-assets/ico/favicon.png">
	<title>
		<?php if(isset($title)):?>
			<?php echo $title.' | '.lang('zhidian_navbar_brand')?>
		<?php else:?>
			<?=lang('zhidian_navbar_brand')?>
		<?php endif;?>
	</title>
	<?php if(isset($meta_description)):?>
		<meta name="description" content="<?=$meta_description?>">	
	<?php else:?>
		<meta name="description" content="职点是一家致力于给北美华人提供就业资讯的网站，我们旨在推广各类与华人相关的求职信息，包括中国地区对海外高端人才/留学生的征聘需求">	
	<?php endif;?>
		
	<link rel="stylesheet" href="/tools/bootstrap3/css/bootstrap-yeti.min.css">
	<script src="/tools/jQuery/jquery-1.11.0.min.js"></script>
	<script src="/tools/bootstrap3/js/bootstrap.min.js"></script>
	<!--<script src="/tools/holder/holder.js"></script> -->
</head>

<?php
$memberinfo = $this->session->userdata('memberinfo');
$username = $memberinfo['username'];
?>

<body>
<style type="text/css">
	#logo{
		height: 40px;
	}
	
	.personal-center {
		width: 160px;
	}
	
	.small_msg{
		padding-top:5px;
		padding-bottom:5px;
	}

	/*for desktop/tablet*/
	@media (min-width: 768px) {
		.container{
			/*max-width: 960px;*/
		}
		#navbar-inner{
			padding-top: 10px;
			padding-bottom: 10px;
		}

		.navbar-default .navbar-nav>li>a:hover, 
		.navbar-default .navbar-nav>li>a:focus{
			background-color: transparent;
			opacity: 0.85;
		}

		.navbar-default .navbar-nav>.open>a, 
		.navbar-default .navbar-nav>.open>a:hover, 
		.navbar-default .navbar-nav>.open>a:focus{
			/*background-color: transparent;	*/
		}
		
		#logo{
			height: 60px;
		}

		#navigation-bar{
			background-image: url("/images/banner.png") ;
			background-position: center;
			background-repeat: no-repeat;
			background-color: #171a1d;
		}

		.navbar{
			font-size: 15px;
		}

		#circle {
			margin-top: 22.5px;
			right: 50px;
			position: absolute;
			
			width: 90px;
			height: 90px;
			background: white; 
			-moz-border-radius: 45.5px; 
			-webkit-border-radius: 45.5px; 
			border-radius: 45.5px;
			border: 5px solid #999;
			
			color: black;
			text-align: center;
			line-height: 52.5px;
			<?php if($this->session->userdata('site_lang')==='english'):?>
			font-size: 14px;
			<?php else:?>
			font-size: 20px;
			<?php endif;?>
		}

		#circle:hover{
			opacity: 1;
			background: #f4f4f4;
		}

		.navbar-right{
			padding-top: 0px;	
		}

		.navbar_link>li>a{
			font-size: 125%;
			margin-top: 15px;
		}
	}



</style>

<div class="navbar navbar-default navbar-static-top" role="navigation" id="navigation-bar">
	<div class="container" id="navbar-inner">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="/">
				<img src="/images/logo3.png" id="logo">
			</a>

		</div>

		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar_link">
				<li>
					<a href="/member/addpost"><?=lang('zhidian_member_addpost')?></a>	
				</li>
				<li>
					<a href="/member/account#upload_tab"><?=lang('zhidian_member_resume')?></a>	
				</li>
				<li>
					<a href="mailto:contact@zhidian.us"><?=lang('zhidian_customer_service')?></a>	
				</li>
				<li>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">报税 <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="/home/tax2015">2015 报税指南</a></li>
            <li><a href="/home/tax_guide">2014 报税指南</a></li>
          </ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right" style="margin-top:12px;">
				<li>
					<?php if($this->session->userdata('site_lang')==='english'):?>
						<a href='/langswitch/switchLanguage/chinese/<?=base64_encode(current_url())?>'>-&nbsp; 中 文 &nbsp;-</a>
					<?php else:?>
						<a href='/langswitch/switchLanguage/english/<?=base64_encode(current_url())?>'>-&nbsp;English&nbsp;-</a>
					<?php endif;?>
				</li>

				<?php if(isset($memberinfo['is_logged']) && $memberinfo['is_logged'] == true):?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle personal-center" data-toggle="dropdown">
							<span class="glyphicon glyphicon-user"></span> &nbsp;<?=lang('zhidian_personal_center')?>&nbsp;<b class="caret"></b>
						</a>
						<ul class="dropdown-menu">
							<li><a href="/member/welcome"><?=lang('zhidian_member_dashboard')?></a></li>
							<li><a href="/member/addpost"><?=lang('zhidian_member_addpost')?></a></li>
							<li><a href="/member/viewpost"><?=lang('zhidian_member_viewpost')?></a></li>
							<li><a href="/member/favorite"><?=lang('zhidian_member_favorite')?></a></li>
							<li><a href="/member/applyrecord"><?=lang('zhidian_member_applyrecord')?></a></li>
							<li><a href="/member/account"><?=lang('zhidian_member_account')?></a></li>
							<li class="divider"></li>
							<li><a href="/sign/signout"><?=lang('zhidian_signout')?></a></li>
						</ul>
					</li>
				<?php elseif(isset($memberinfo['is_admin']) && $memberinfo['is_admin'] === true):?>
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> &nbsp;<?=$username?></a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle personal-center" data-toggle="dropdown"><b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#">Dashboard</a></li>
							<li><a href="#">View Post</a></li>
							<li><a href="#">Add Post</a></li>
							<li><a href="#">Account</a></li>
							<li class="divider"></li>
							<li><a href="#">Sign out</a></li>
						</ul>
					</li>
				<?php else:?>
					<li>
						<a href="/sign/signin/<?=base64_encode(current_url())?>" role="button" class="signin" id="circle" style="margin-right:50px;">
							<strong><?=lang('zhidian_signin')?></strong> 							
						</a>
					</li>
				<?php endif;?>

				</ul>

			</div><!--/.nav-collapse -->
		</div>

	</div>
	<style>



		.container {
			/*max-width: 970px;*/
		}

		/*for desktop/tablet*/
		@media (min-width: 768px) {
			.navbar-static-top{
				min-height: 40px;
			}


		}



	</style>