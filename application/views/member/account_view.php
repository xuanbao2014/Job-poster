<script type="text/javascript">
	$(document).ready(function(){
		<?php if(!isset($tab)){$tab="#upload_tab";}?>
		$("<?=$tab?>").addClass('active');
		$("a[href='<?=$tab?>']").parent("li").addClass('active');
	})
</script>
<div><h4>&nbsp;&nbsp;<?=lang('zhidian_member_account')?>
<a class="btn btn-info btn-sm pull-right" href="/member" style="margin-right:10px;"><span class="glyphicon glyphicon-arrow-left"></span> <?=lang('zhidian_back_to_dashboard')?> </a>
</h4></div><hr />
<div class="right_container">

	<div class="row">
		<!-- Nav tabs -->
		<ul class="nav nav-tabs">
			<li><a href="#upload_tab" data-toggle="tab">
				<div class="text-danger"><strong><span class="glyphicon glyphicon-floppy-open"></span> &nbsp;<?=lang('zhidian_upload_resume')?></strong></div>
			</a></li>
			<li><a href="#password_tab" data-toggle="tab">
				<div class="text-danger"><strong><span class="glyphicon glyphicon-lock"></span> &nbsp;<?=lang('zhidian_change_password')?></strong></div>
			</a></li>
			<li><a href="#email_tab" data-toggle="tab">
				<div class="text-danger"><strong><span class="glyphicon glyphicon-envelope"></span> &nbsp;<?=lang('zhidian_change_email')?></strong></div>
			</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane col-sm-6 col-sm-offset-3" id="password_tab" style="margin-top:30px;">
				<?php
				if($this->session->flashdata('pwd_changed')){
					echo '<div class="alert alert-success small_msg"> Successfully change your password.<br />Please remember use your new password for next sign in.</div>';
				}
				?>
				<?php
				if(isset($form1_errors)){
					echo $form1_errors;
				}
				?>
				<form method="post" accept-charset="utf-8" id="accountChangePasswordForm" role="form" action="/member/changePassword" novalidate>
					<div class="form-group">
						<label><?=lang('zhidian_current_password')?></label>
						<input type="password" class="form-control" name="old_password">
					</div>
					<div class="form-group">
						<label><?=lang('zhidian_new_password')?></label>
						<input type="password" class="form-control" name="new_password">
					</div>
					<div class="form-group">
						<label><?=lang('zhidian_password_confirm')?></label>
						<input type="password" class="form-control" name="new_password2">
					</div>

					<button type="submit" class="btn btn-primary btn-sm" value="password"><?=lang('zhidian_update')?></button>
				</form>
			</div>
			<div class="tab-pane col-sm-6 col-sm-offset-3" id="email_tab" style="margin-top:30px;">
				<?php
				if($this->session->flashdata('email_changed')){
					echo '<div class="alert alert-success small_msg"> Successfully change your sign in email address.<br />Please remember your new sign in email address</div>';
				}
				?>
				<?php
				if(isset($form2_errors)){
					echo $form2_errors;
				}
				?>
				<form method="post" accept-charset="utf-8" id="accountChangeEmailForm" role="form" action="/member/changeEmail" novalidate>
					<div class="form-group">
						<label><?=lang('zhidian_current_email')?></label>
						<input type="text" class="form-control" name="old_email">
					</div>
					<div class="form-group">
						<label><?=lang('zhidian_new_email')?></label>
						<input type="text" class="form-control" name="new_email">
					</div>
					<div class="form-group">
						<label><?=lang('zhidian_email_confirm')?></label>
						<input type="text" class="form-control" name="new_email2">
					</div>

					<button type="submit" class="btn btn-primary btn-sm" value="email"><?=lang('zhidian_update')?></button>
				</form>

			</div>
			
			<div class="tab-pane col-sm-6 col-sm-offset-3" id="upload_tab" style="margin-top:30px;">
				<?php
				if($this->session->flashdata('error')){
					echo '<div class="alert alert-warning small_msg">'.$this->session->flashdata('error').'</div>';
				}
				?>
				<?php
				if($this->session->flashdata('success')){
					echo '<div class="alert alert-success small_msg">'.$this->session->flashdata('success').'</div>';
				}
				?>
				<table id="post_table" class="table table-striped">
					<thead>
						<tr>
							<th width="30%"><?=lang('zhidian_upload_time')?></th>
							<th width="60%"><?=lang('zhidian_upload_resume_name')?></th>
							<th style="text-align:center;width:30px;"><?=lang('zhidian_jobdelete')?></th>
						</tr>
					</thead>
					<?php if(isset($content)):?>
					<tbody>
						<?php foreach($content as $row):?>
						<tr>
							<td><?=date('Y-m-d g:i A', $row['timestamp'])?></td>
							<td><?=$row['name']?></td>
							<td style="text-align:center;"><a href="/member/delete_upload/<?=$row['id']?>"><span class="glyphicon glyphicon-trash"></span></a></td>
						</tr>
						<?php endforeach;?>
					</tbody>
					<?php endif;?>
				</table>
				<?php if(!isset($content)):?>
				<div> <?=lang('zhidian_no_upload_resume')?> </div>
				<?php endif;?>
				<div style="height:50px;"></div>
				<form method="post" accept-charset="utf-8" role="form" action="/member/upload_file" enctype="multipart/form-data" novalidate>
					<div class="form-group">
					<label><?=lang('zhidian_upload_resume_msg')?></label>
					<input id="lefile" name="userfile" type="file" style="display:none">
					<div class="form-search">
					  <div class="input-group">
						  <input id="file" class="form-control" type="text" disabled>
						  <span class="input-group-btn">
							<a class="btn btn-default" onclick="$('input[id=lefile]').click();"><?=lang('zhidian_browse')?> </a>
						  </span>
						  <span class="input-group-btn">
							<button type="submit" class="btn btn-primary btn-sm" value="upload" style="margin-left:20px;"><?=lang('zhidian_submit')?></button>
						  </span>
					  </div>
					</div>

					<script type="text/javascript">
						$('input[id=lefile]').change(function() {
							if(this.files[0].size <= 10000000){
								$('#file').val(this.files[0].name);
			//					$('#file').val($(this).val());
							}else{
								alert('Your file is too large. Please use file less than 10 MB.');
							}
						});
					</script>
				  </div>

				</form>

			</div>

		</div>


	</div>

</div>
<script>
	$(document).ready(function(){
		$(function(){
		  var hash = window.location.hash;
		  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

		  $('.nav-tabs a').click(function (e) {
			$(this).tab('show');
			var scrollmem = $('body').scrollTop();
			window.location.hash = this.hash;
			$('html,body').scrollTop(scrollmem);
		  });
		});
	});
</script>