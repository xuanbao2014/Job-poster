<link rel="stylesheet" href="/tools/fontawesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/tools/summernote/summernote.css">
<script src="/tools/summernote/summernote.min.js"></script>

<div class="right_container">

<form method="post" accept-charset="utf-8" id="profileForm" role="form" action="">
	<div class="form-group">
		<label>First Name</label>
		<input type="text" class="form-control" name="jobtitle" placeholder="Enter First Name">
	</div>
	<div class="form-group">
		<label>Last Name</label>
		<input type="text" class="form-control" name="company" placeholder="Enter Company Name">
	</div>
	<div class="form-group">
		<label>Description</label>
		<textarea id="editor" class="form-control" rows="10" name="description" placeholder="Enter Description"></textarea>
	</div>
	<!--<div class="summernote">

	</div>//-->
	<div class="form-group">
		<label>My Website</label>
		<input type="url" class="form-control" name="link" placeholder="Link for candidates to apply for this job">
		<label>My Email</label>
		<input type="email" class="form-control" name="email" placeholder="Email for candidates to apply for this job">
	</div>

	<button type="submit" class="btn btn-primary">Update</button>
</form>

<script type="text/javascript">
	$('input:checked').parent().addClass('active');
	$(document).ready(function() {
		$('textarea').summernote({
			height: 300,
			toolbar: [
			  ['style', ['style']],
			  ['font', ['bold', 'italic', 'underline', 'clear']],
			  ['fontsize', ['fontsize']],
			  ['color', ['color']],
			  ['para', ['ul', 'ol', 'paragraph']],
			  ['height', ['height']],
			  ['table', ['table']],
			  ['insert', ['link'/*, 'picture', 'video'*/]],
			  ['view', ['fullscreen', 'codeview']],
			  ['help', ['help']]
			]
		});
	});
</script>

</div>