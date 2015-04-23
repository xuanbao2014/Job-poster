<!DOCTYPE html>
<html>
	<head>
		<title><?=$title?></title>
		<link rel="stylesheet" href="/tools/bootstrap3/css/bootstrap-yeti.min.css">
		<script src="/tools/jQuery/jQuery-1.10.2-dev.js"></script>
		<script src="/tools/bootstrap3/js/bootstrap.js"></script>
		<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<style>
#title{
	text-align:center;
}
</style>
	</head>
	<body>
<!--Config Content//-->
		<div class="container" style="margin-top:30px;">
			<div class="row">
				<div class="col-sm-4">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="HTML title...">
						<div class="input-group-btn">
							<button id="changeHtmlTitle" class="btn btn-default btn-sm">Change</button>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<select id="chooseTemplate" class="form-control">
						<option>Choose template...</option>
						<!--<option>1</option>
						<option>2</option>
						<option>3</option>//-->
						<?php foreach($templates as $row):?>
						<option><?=$row['name']?></option>
						<?php endforeach;?>
					</select>
				</div>
				<div class="col-sm-4">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="Save Name...">
						<div class="input-group-btn">
							<div class="btn-group">
							  <button type="button" class="btn btn-primary">Save</button>
							  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							  </button>
							  <ul class="dropdown-menu pull-right" role="menu">
								<li><a href="#">Save as template</a></li>
							  </ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr />
<!--Main Content//-->
		<div id="main" class="container">
			<div id="title" class="row"><h2></h2></div>
		</div>
	</body>
	
	<script>
	$(document).ready(function(){
		$('#changeHtmlTitle').click(function(e){
			e.preventDefault();
			var temp = $(this).parent().parent().children('input');
			$('title').html(temp.val());
		});
		$('#chooseTemplate').change(function(){
			var template = $(this).val();
			$('#main').empty();
			if(template == 1){
				$('#main').append('<div id="title" class="row"><h2>谷歌投资基金Google Capital正式上线 面向成长期企业</h2></div>');
				tinymce.init({
					selector: "#title",
					inline: true,
					toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify",
					menubar: false
				});
				$('#main').append('<div style="height:20px;"></div>');
				$('#main').append('<div id="content" class="row"><p><img style="float: left;" src="http://zhidian.us/images/template/template.png" alt="" width="180" height="105" /></p><p>对谷歌投资有所了解的同学应该也知道现有的Google Ventures基金，不过Ventures主要针对的是刚刚起步的企业。而Google Capital则由谷歌提供支持，由David Lawee、Scott Tierney和Gene Frantz领衔。这项基金主要的投资目标是已经有一定基础，并期望往大方向上扩展业务的企业。</p><p>Google Ventures自2009年起已经帮助投资了超过200家创业公司，比较有名的Nest即是其中之一。目前Google Capital已经投资的企业包括有SurveyMonkey、Lending Club和Renaissance Learning。未来还将有更多的企业会得到Google Captial投资基金的支援。</p></div>');
				tinymce.init({
					selector: "#content",
					inline: true,
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen",
						"insertdatetime media table contextmenu paste"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			}
			if(template == 2){
				$('#main').append('<div id="title" class="row"><h2>谷歌投资基金Google Capital正式上线 面向成长期企业</h2></div>');
				tinymce.init({
					selector: "#title",
					inline: true,
					toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify",
					menubar: false
				});
				$('#main').append('<div style="height:20px;"></div>');
				$('#main').append('<div id="content" class="row"><p style="text-align: center;"><span class="date">2014-02-19 21:53:21 &nbsp; &nbsp; &nbsp; &nbsp;</span><span class="where">稿源：<a href="http://www.zhidian.us/">zhidian.us</a></span></p><p class="col-sm-8 col-sm-offset-2" style="background-color: #eeeeee; border-top: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; padding-top: 10px;"><img style="float: right;" title="TinyMCE Logo" src="http://zhidian.us/images/template/google.gif" alt="" width="113" height="41" />大约在一年前，谷歌宣布了将要成立Google Capital投资基金的消息。就在今天，谷歌正式发布了这个新的投资基金项目，旨在帮助一些成长期的企业更快地向前发展。</p><p style="clear: both;">&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; 对谷歌投资有所了解的同学应该也知道现有的Google Ventures基金，不过Ventures主要针对的是刚刚起步的企业。而Google Capital则由谷歌提供支持，由David Lawee、Scott Tierney和Gene Frantz领衔。这项基金主要的投资目标是已经有一定基础，并期望往大方向上扩展业务的企业。</p><p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://zhidian.us/images/template/template-lg.png" alt="" width="600" height="350" /></p><p>&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; Google Ventures自2009年起已经帮助投资了超过200家创业公司，比较有名的Nest即是其中之一。目前Google Capital已经投资的企业包括有SurveyMonkey、Lending Club和Renaissance Learning。未来还将有更多的企业会得到Google Captial投资基金的支援。</p>ssance Learning。未来还将有更多的企业会得到Google Captial投资基金的支援。</p></div>');
				tinymce.init({
					selector: "#content",
					inline: true,
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen",
						"insertdatetime media table contextmenu paste"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			}
			if(template == 3){
				$('#main').append('<div id="title" class="row"><h2>[图]百度筹建新总部大楼：建筑面积25.2万平米 2015年竣工</h2></div>');
				tinymce.init({
					selector: "#title",
					inline: true,
					toolbar: "undo redo | bold italic | alignleft aligncenter alignright alignjustify",
					menubar: false
				});
				$('#main').append('<div style="height:20px;"></div>');
				$('#main').append('<div id="content" class="row"><p style="text-align: center;"><span class="date">2014-02-19 21:53:21 &nbsp; &nbsp; &nbsp; &nbsp;</span><span class="where">稿源：<a href="http://www.zhidian.us/">zhidian.us</a></span></p><p class="col-sm-8 col-sm-offset-2" style="background-color: #eeeeee; border-top: 1px solid #AAAAAA; border-bottom: 1px solid #AAAAAA; padding-top: 10px;"><img style="float: right;" title="TinyMCE Logo" src="http://zhidian.us/images/template/baidulogo.gif" alt="" width="113" height="41" />2月19日消息，<strong>由于人员扩充迅速，百度已将办公大楼扩建计划提上日程。据悉，百度已拿下北京中关村软件园二期（西扩）C-1、N-2、N3、N4、N5地块，用于建设新总部大楼，工程计划于2015年8月竣工启用。</strong>据悉，百度新总部大楼为五栋地上7层，地下2层的办公楼；另有一栋地上1层，地下2层的报告厅；占地面积65000平方米，建筑面积达252000平方米，相当于现有百度大厦建筑面积的2.75倍。</p><p style="clear: both;">&nbsp;</p><p><img style="display: block; margin-left: auto; margin-right: auto;" src="http://zhidian.us/images/template/template_3_1.jpg" alt="" width="600" height="350" /></p><p style="text-align: center;">&nbsp;百度新总部大楼鸟瞰图</p><p style="text-align: center;"><img style="undefined" src="http://zhidian.us/images/template/template_3_2.jpg" alt="" width="602" height="350" /></p><p style="text-align: center;">百度新总部大楼内部设计</p><p style="text-align: center;">&nbsp;</p><p>&nbsp; &nbsp; &nbsp; &nbsp; 新的百度总部计划于2015年8月竣工启用，届时租用写字楼办公的百度员工将全部迁入，总人数近万人。</p><p>&nbsp; &nbsp; &nbsp; &nbsp; 与此同时，2012年1月初开工建设，位于深圳市南山区高新技术产业园的百度国际大厦，预计也将于2015年竣工启用，建筑面积超过22万平方米，可容纳万名员工。</p><p>&nbsp; &nbsp; &nbsp; &nbsp; 有消息称，2012年后，百度位于深圳、北京所新建的办公楼，总耗资超过60亿人民币。</p><p>&nbsp; &nbsp; &nbsp; &nbsp; 目前正在使用的百度大厦位于北京海淀区上地信息产业基地北区7号地块，总建筑面积为91500平方米，但随着业务扩充，百度大厦工位严重不足，百度云等业务团队随后搬迁至鹏寰大厦、奎科大厦、首创空间大厦办公。</p></div>');
				tinymce.init({
					selector: "#content",
					inline: true,
					plugins: [
						"advlist autolink lists link image charmap print preview anchor",
						"searchreplace visualblocks code fullscreen",
						"insertdatetime media table contextmenu paste"
					],
					toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
				});
			}
		});
	});
	</script>
</html>