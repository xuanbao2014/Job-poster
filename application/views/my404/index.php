<?php
	$this->load->view('home/header',$title, $meta_description);	
?>	

	<br/>
    <div class="jumbotron">
      <div class="container">
        <h1>恭喜您</h1>
        <p>找到了一个神秘的宝藏，我们也不知道里面是什么？</p>
        <p><a class="btn btn-primary btn-lg" role="button" href="<?=site_url()?>">马上打开看看 &raquo;</a></p>
        <img src="/images/404.jpg">
      </div>
    </div>



<?php
	$this->load->view('home/footer');	
?>	