<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script>
tinymce.init({
//	mode : "textareas"
    selector: '#description',
	menubar:    false,
	statusbar:  false,
	height:     250,
	plugins: "paste"
});
</script>

<div><h4>&nbsp;&nbsp;<?=lang('zhidian_apply')?>
<a class="btn btn-info btn-sm pull-right" href="/postdetail/<?=$pid?>" style="margin-right:10px;"><span class="glyphicon glyphicon-arrow-left"></span><?=lang('zhidian_return_to_jobdetail')?></a>
</h4></div><hr />
<div class="col-sm-8 col-sm-offset-2">
	<form id="applyjob_form" role="form" method="post" action="/member/applyjob_send/<?=$pid?>" enctype="multipart/form-data">

		<?php
		if($this->session->flashdata('error')){
			echo '<div class="alert alert-warning small_msg">'.$this->session->flashdata('error').'</div>';
		}
		?>
		<?php echo validation_errors('<p class="alert alert-warning small_msg" >');?>

	  <div class="form-group">
		<label><?=lang('zhidian_email_subject')?></label>
		<input id="subject" type="text" class="form-control" name="subject" value="<?=$subject?>">
	  </div>

	  <div class="form-group">
		<label><?=lang('zhidian_resume')?> ( <a href="/member/account#upload_tab" target="_blank"><?=lang('zhidian_upload_resume_msg')?></a> )</label>
		<input id="lefile" name="userfile" type="file" style="display:none">
		<input id="ulfile" name="myfile" type="text" style="display:none">
		<div class="input-group">
			<input id="file" class="form-control" type="text" readonly>
		  	<div class="input-group-btn">
              <a data-toggle="dropdown" href="#" class="btn btn-default dropdown-toggle"><span class="caret"></span></a>
			  <a class="btn btn-default" onclick="$('input[id=lefile]').click();"><?=lang('zhidian_browse')?></a>
			  <ul class="dropdown-menu pull-right" role="menu">
				<?php if(isset($filelist)):?>
					<?php foreach($filelist as $row):?>
					<li><a class="choosefile" href='#' filename='<?=$row['name']?>' fileid='<?=$row['id']?>'><span class="text-success" style="font-size:18px"><strong><?=$row['name']?></strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="pull-right"><?=date('Y-m-d g:i A', $row['timestamp'])?></span></a></li>
					<?php endforeach;?>
				<?php else:?>
					<li><a href='#'><?=lang('zhidian_no_upload_resume')?></a></li>
				<?php endif;?>
			  </ul>
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

	  <div class="form-group">
		<label><?=lang('zhidian_email_body')?></label>
		<textarea id="description" class="form-control" rows="8" name="description"><?php echo isset($description)?set_value('description',$description):set_value('description'); ?></textarea>
	  </div>


	  <div style="height:50px;"></div>
	  <button type="reset" class="btn btn-default btn-sm"><?=lang('zhidian_clear')?></button>
	  <button type="submit" class="btn btn-primary btn-sm pull-right" data-loading-text="Processing..."><?=lang('zhidian_submit')?></button>
	  <a type="button" target="_new" class="btn btn-info btn-sm pull-right" style="margin-right:20px" id="preview"><?=lang('zhidian_preview')?></a>
	  <script>
		$(document).ready(function(){
			  $("#preview" ).click(function( event ) {
				event.preventDefault();
				  var p = window.open();
	//			$('#description').val(tinyMCE.get('description').getContent());
	//			  alert(tinyMCE.get('description').getContent());
				var form = $(this);
				$.ajax({
					type: form.attr('method'),
					url: '/member/applyjob_preview/<?=$pid?>',
					data: {
						userfile: $('#file').val(),
						description: tinyMCE.get('description').getContent(),
						subject: $('#subject').val()
					}
				}).done(function(data) {
					p.document.write(data);
				}).fail(function() {
					alert("fail");
					$('body').scrollTop(0);
				});
			  });
			$('.choosefile').click(function(e) {
				e.preventDefault();
//				alert(111);
				$('#ulfile').val($(this).attr('fileid'));
				$('#file').val($(this).attr('filename'));
			});
		});
	  </script>
	</form>
</div>