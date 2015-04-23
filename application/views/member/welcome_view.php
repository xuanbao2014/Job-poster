<div><h4>&nbsp;&nbsp;<?=lang('zhidian_member_dashboard')?>
<a class="btn btn-info btn-sm pull-right" href="/" style="margin-right:10px;"><span class="glyphicon glyphicon-arrow-left"></span><?=lang('zhidian_back_to_homepage')?></a>
</h4></div><hr />


<div class="col-sm-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=lang('zhidian_addviewpost')?></h3>
		</div>
		<div class="panel-body">
			<h5><span class="glyphicon glyphicon-plus"></span> &nbsp;&nbsp;<a href="/member/addpost"><?=lang('zhidian_member_addpost')?></a></h5>
			<h5><span class="glyphicon glyphicon-list"></span> &nbsp;&nbsp;<a href="/member/viewpost"><?=lang('zhidian_member_viewpost')?></a></h5>
			<!--<h5><span class="glyphicon glyphicon-edit"></span> &nbsp;&nbsp;<a href="/member/viewpost"><?=lang('zhidian_member_editpost')?></a></h5>
			<h5><span class="glyphicon glyphicon-floppy-save"></span> &nbsp;&nbsp;<a href="/member/viewpost"><?=lang('zhidian_member_exportpost')?></a></h5>//-->
			<h5><span class="glyphicon glyphicon-star"></span> &nbsp;&nbsp;<a href="/member/favorite"><?=lang('zhidian_member_favorite')?></a></h5>
			<h5><span class="glyphicon glyphicon-pencil"></span> &nbsp;&nbsp;<a href="/member/applyrecord"><?=lang('zhidian_member_applyrecord')?></a></h5>
			<h5><span class="glyphicon glyphicon-tag"></span> &nbsp;&nbsp;<?php echo str_replace('%s',$num_of_post,lang('zhidian_youhavetotalpost'))?></h5>
			<h5><span class="glyphicon glyphicon-tag"></span> &nbsp;&nbsp;<?php echo str_replace('%s',$num_of_favorite,lang('zhidian_number_favorite'))?></h5>
			<h5><span class="glyphicon glyphicon-tag"></span> &nbsp;&nbsp;<?php echo str_replace('%s',$num_of_apply,lang('zhidian_number_applyrecord'))?></h5>
		</div>
	</div>
</div>
<div class="col-sm-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?=lang('zhidian_account')?></h3>
		</div>
		<div class="panel-body">
			<?php $memberinfo = $this->session->userdata('memberinfo'); ?>
			<h5><?=lang('zhidian_email')?> : <?=$memberinfo['username'];?></h5>
			<h5><span class="glyphicon glyphicon-lock"></span> &nbsp;&nbsp;<a href="/member/account#password_tab"><?=lang('zhidian_change_password')?></a></h5>
			<h5><span class="glyphicon glyphicon-envelope"></span> &nbsp;&nbsp;<a href="/member/account#email_tab"><?=lang('zhidian_change_email')?></a></h5>
			<h5><span class="glyphicon glyphicon-file"></span> &nbsp;&nbsp;<a href="/member/account#upload_tab"><?=lang('zhidian_upload_resume')?></a></h5>
		</div>
	</div>
</div>