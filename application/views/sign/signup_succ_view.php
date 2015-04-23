<?php
	$this->load->view('home/header',$title);
?>

<style type="text/css">
	.center-block{
		max-width: 400px;
	}
</style>
<div class="container">
	<div class="center-block">
		<p>
			<h3><?=lang('zhidian_crateaccount_succ')?></h3>
			<?php if($this->session->flashdata('msg_email')){
					echo '<div class="alert alert-warning small_msg">'.$this->session->flashdata('msg_email').'</div>';
				}?>
		</p>
	</div>

</div>

<?php
	$this->load->view('home/footer');
?>