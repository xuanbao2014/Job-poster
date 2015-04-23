<?php
	$this->load->view('home/header',$title, $meta_description);
?>

<script type="text/javascript" src="/application/views/home/script/index.js"></script>
<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<link href="/application/views/home/css/index.css" rel="stylesheet">

<?php
    $memberinfo = $this->session->userdata('memberinfo');
    $username = $memberinfo['username'];
?>

<div class="container">
	<div class="row">
		<div class="col-md-3 col-xs-12 left-sidebar">	

			<div id="filter_div" class="panel panel-dafault">
				<div class="filter-label">
					<?=lang('zhidian_filter_title') ?>
				</div>
				<div id="collapse">
					<div class="panel-body">
						<div class="filter-panel">
							<div class="dropdown filter-item <?php echo (isset($filter['country']) ? 'filter-selected':''); ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href>
                                    <?php 
                                    	if (isset($filter['country'])) { 
                                    		echo lang('zhidian_filter_'.strtolower(str_replace(' ','_',$filter['country'])));
                                    	} else {
                                   			echo lang('zhidian_filter_country');
                                    	}
                                    ?>
                                    <span class="submenu-pointer"> &gt;&gt; </span>
								</a>
								<ul class="dropdown-menu">
									<?php $filter_temp = $filter?>
									<li class="first-dropdown"><a href="<?php unset($filter_temp['country']);echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_all')?></a></li>
									<li><a href="<?php $filter_temp['country']='United States';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_united_states')?></a></li>
									<li><a href="<?php $filter_temp['country']='China';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_china')?></a></li>
								</ul>
							</div>
							<div class="dropdown filter-item <?php echo (isset($filter['employment_type']) ? 'filter-selected':''); ?>">
								<a class="dropdown-toggle" data-toggle="dropdown" href>
									<?php 
                                    	if (isset($filter['employment_type'])) { 
                                    		echo lang('zhidian_filter_'.strtolower(str_replace(' ','_',$filter['employment_type'])));
                                    	} else {
                                   			echo lang('zhidian_filter_employment_type');
                                    	}
                                   	?>   
                                    <span class="submenu-pointer"> &gt;&gt; </span>
								</a>
								<ul class="dropdown-menu">
									<?php $filter_temp = $filter?>
									<li class="first-dropdown"><a href="<?php unset($filter_temp['employment_type']);echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_all')?></a></li>
									<li><a href="<?php $filter_temp['employment_type']='Full Time';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_full_time')?></a></li>
									<li><a href="<?php $filter_temp['employment_type']='Part Time';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_part_time')?></a></li>
									<li><a href="<?php $filter_temp['employment_type']='Internship';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_internship')?></a></li>
								</ul>
							</div>
							<div class="dropdown filter-item <?php echo (isset($filter['sponsor']) ? 'filter-selected':''); ?>">
								<a class="dropdown-toggle" data-toggle="dropdown" href>
									<?php 
                                    	if (isset($filter['sponsor'])) { 
                                    		echo lang('zhidian_filter_'.strtolower(str_replace(' ','_',$filter['sponsor'])));
                                    	} else {
                                   			echo lang('zhidian_filter_sponsor');
                                    	}
                                   	?>   
                                    <span class="submenu-pointer"> &gt;&gt; </span>
								</a>
								<ul class="dropdown-menu">
									<?php $filter_temp = $filter?>
									<li class="first-dropdown"><a href="<?php unset($filter_temp['sponsor']);echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_all')?></a></li>
									<li><a href="<?php $filter_temp['sponsor']='H1B';echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_h1b')?></a></li>
								</ul>
							</div>
							<div class="dropdown filter-item <?php echo (isset($filter['industry']) ? 'filter-selected':''); ?>">
								<a class="dropdown-toggle" data-toggle="dropdown" href>
									<?php 
                                    	if (isset($filter['industry'])) { 
                                    		echo lang('zhidian_filter_'.strtolower(str_replace(' ','_',$filter['industry'])));
                                    	} else {
                                   			echo lang('zhidian_filter_industry');
                                    	}
                                   	?>   
                                    <span class="submenu-pointer"> &gt;&gt; </span>
								</a>
								<ul class="dropdown-menu" style="list-style:none;width:295px;text-align:center">
									<?php $filter_temp = $filter?>
									<li class="first-dropdown"><a href="<?php unset($filter_temp['industry']);echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);?>"><?=lang('zhidian_filter_all')?></a></li>
									<?php 
											$filter_industry_array = array(
														"Finance",
														"Technology",
														"Marketing",
														"Language",
														"Media",
														"Resturant",
														"Management",
														"Design",
														"Entertainment",
														"Service",
														"Sports",
														"Consulting",
														"International Commerce",
														"Engineering",
														"Law",
														"Art"
													);
									?>
									<?php foreach($filter_industry_array as $fitler_industry_item):?>
									<li style="float:left; width:50%;">
										<a href="<?php
										 			$filter_temp['industry']=$fitler_industry_item;
										 			echo '/filter/'.$this->uri->assoc_to_uri($filter_temp);
										 		?>">
										<?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$fitler_industry_item))) ?>
										</a>
									</li>											
									<?php endforeach;?>
									<li style="clear:both;"></li>
								</ul>
							</div>
						</div>					
					</div>
				</div>
			</div>				

			<a href="/blog" class="tax_guide hidden-xs hidden-sm">
				<img class="img-responsive" src="/images/blogs/zhidian zatan.png">
			</a>

<!-- 			<a href="/home/tax_guide" class="tax_guide hidden-xs hidden-sm">
				<img class="img-responsive" src="/images/2014_tax_guide.png">
			</a> -->						

			<div id="weibo" class="hidden-xs hidden-sm">
				<iframe width="100%" height="400" class="share_self"  frameborder="0" scrolling="no" src="http://widget.weibo.com/weiboshow/index.php?language=&width=0&height=550&fansRow=0&ptype=1&speed=0&skin=1&isTitle=1&noborder=1&isWeibo=1&isFans=1&uid=5024264485&verifier=b18ab61a&dpc=1"></iframe>
			</div>
		</div>

		<div class="col-md-9 col-xs-12 content-block-wrapper">
			<div class="content-block">
				<div class="row">
					<?php 
					foreach($content as $index => $row):
						$timediff = now()- $row['timestamp'];
						if($timediff > 86400){
							$timeago = floor($timediff / 86400).lang('zhidian_timeago_day');
						}else if($timediff > 3600){
							$timeago = floor($timediff / 3600).lang('zhidian_timeago_hour');
						}else if($timediff > 60){
							$timeago = floor($timediff / 60).lang('zhidian_timeago_minute');
						}else{
							$timeago = floor($timediff).lang('zhidian_timeago_second');
						}
					?>
					<div class="col-xs-12 col-md-6 job-summary">							
						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-10 col-lg-11">
									<div class="job-title">
										<a href="/postdetail/<?=$row['id']?>" target="_blank"><?=$row['jobtitle']?></a>
									</div>
									<div class="job-information">
										<div class="job-company">
											<?php echo lang('zhidian_jobcompany').': '.$row['company']?>
										</div>
										<div class="job-city">
											<?php if($row['country'] === 'China' && $this->session->userdata('site_lang') != "english"):?>											
												<?php echo lang('zhidian_jobcity').': '.$row['city_cn'].", ".$row['state_cn']." ".$row['country_cn']?>
											<?php else:?>
												<?php echo lang('zhidian_jobcity').': '.$row['city'].", ".$row['state']." ".$row['country']?>
											<?php endif;?>
										</div>
										<!--
										<p class="job-post-summary">
											<a href="/postdetail/<?=$row['id']?>" target="_blank">
												<?php echo $row['description'] ?>
											</a>
										</p>
									-->
									</div>
								</div>
								<div class="col-xs-2 col-lg-1 fav-icon-div">
									<h3 class="pull-right">
										<?php if(isset($memberinfo['is_logged']) && $memberinfo['is_logged'] == true):?>
										<a href="/member/addToFavorite/<?=$row['id']?>" class="favoritePopover" data-container="body" data-toggle="popover" style="cursor:pointer;" value="/member/checkFavorite/<?=$row['id']?>">
											<i class="fa fa-star-o text-warning"></i>
										</a>
										<?php else:?>
										<a class="favoritePopover2" data-container="body" data-toggle="popover" data-title="<?=lang('zhidian_popover_likethispost')?>" data-content="<?=lang('zhidian_popover_saveit')?>">
											<i class="fa fa-star-o text-warning"></i>
										</a>
										<?php endif;?>
									</h3>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<h5>
								<span class="job-post-time"><?=$timeago?></span>
								<?php if(isset($row['clicks'])):?>
									<span class="badge click_group" data-toggle="tooltip" title="<?=$row['clicks']?><?=lang('zhidian_click_tooltip')?>">
										<?=$row['clicks']?>
										<span class="glyphicon glyphicon-hand-up"></span>
									</span>
								<?php endif;?>
								<span class="labels-span">
									<span class="label label-primary" style=""><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$row['employment_type'])))?></span>
									<span class="label label-primary" style=""><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$row['industry'])))?></span>							
									<?php if($row['sponsor'] === "H1B"):?>
										<span class="label label-primary" style=""><?=lang('zhidian_filter_'.strtolower(str_replace(' ','_',$row['sponsor'])))?></span>
									<?php endif;?>
								</span>
							</h5>
						</div>
					</div>
					<?php if ($index % 2): ?>
					<div class="clearfix"></div>
					<?php endif; ?>
					<?php endforeach;?>
				</div>
			<!-- pagination -->			
			</div>
			<div style="text-align:center">
					<?php echo $page?>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('home/footer');
?>
