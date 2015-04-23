<?php
	$this->load->view('home/header',$title);
?>
<div class="container" >
	<div class="center-block">
		<?php
			$this->load->view($right_page);
		?>
	</div>
</div>

<?php
	$this->load->view('home/footer');
?>