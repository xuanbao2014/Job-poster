<?php
	$this->load->view('home/header',$title,$meta_description);
?>

<link href="/application/views/blog/css/index.css" rel="stylesheet">

<div class="container" >
	<div class="center-block">
		<?php
			$this->load->view('blog/'.$right_page);
		?>
	</div>
</div>

<?php
	$this->load->view('home/footer');
?>