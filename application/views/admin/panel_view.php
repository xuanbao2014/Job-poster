<?php
	$this->load->view('admin/header');
?>
<script src="/tools/highcharts/highcharts.js"></script>

<style>
.bubble{
	color:#FFFFFF;background-color:#F04124;font-weight:bolder;
}
</style>

<?php
	$users_chart_data_line = "{";
	foreach($users_chart_data as $year => $monthlist){
		$users_chart_data_line .= "name:'".$year."',data:[".join(',',$monthlist)."]";
		$users_chart_data_line .= "},{";
	}
	$users_chart_data_line = substr_replace($users_chart_data_line, '', -2);

	$posts_chart_data_line = "{";
	foreach($posts_chart_data as $year => $monthlist){
		$posts_chart_data_line .= "name:'".$year."',data:[".join(',',$monthlist)."]";
		$posts_chart_data_line .= "},{";
	}
	$posts_chart_data_line = substr_replace($posts_chart_data_line, '', -2);
?>


<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="panel panel-default">
			  <div class="panel-heading">Users Overview</div>
			  <div class="panel-body">
				<ul class="list-group">
				  	<li class="list-group-item">
						<span class="badge bubble"><?=$registered_users_today;?></span>
						Registed Users Today
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$signed_users_today;?></span>
						Signed Users Today
				  	</li>
				</ul>
				<ul class="list-group">
				  	<li class="list-group-item">
						<span class="badge bubble"><?=$not_activated_users;?></span>
						Not Activated Users
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$activated_users;?></span>
						Activated Users
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$blocked_users;?></span>
						Blocked Users
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$total_users;?></span>
						Total Users
				  	</li>
				</ul>
			  </div>

				<div id="users_chart"></div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
			  <div class="panel-heading">Posts Overview</div>
			  <div class="panel-body">
				<ul class="list-group">
				  	<li class="list-group-item">
						<span class="badge bubble"><?=$new_posts_today;?></span>
						New Posts Today
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$approved_posts_today;?></span>
						Approved Posts Today
				  	</li>
				</ul>
				<ul class="list-group">
				  	<li class="list-group-item">
						<span class="badge bubble"><?=$pending_posts;?></span>
						Pending Posts
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$approved_posts;?></span>
						Approved Posts
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$expired_posts;?></span>
						Expired Posts
				  	</li>
					<li class="list-group-item">
						<span class="badge bubble"><?=$total_posts;?></span>
						Total Posts
				  	</li>
				</ul>
			  </div>

				<div id="posts_chart"></div>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {
        $('#users_chart').highcharts({
			chart: {
                type: 'column'
            },
			credits: {
				enabled: false
			},
            title: {
                text: 'Registered Users',
            },
            subtitle: {
                text: 'Source: job.users',
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Number Of Users'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
			legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0;font-size:12px">{series.name}: </td>' +
                    '<td style="padding:0;font-size:12px"><b>{point.y}&nbsp;users</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            series: [
				<?=$users_chart_data_line;?>
				, {
				type: 'pie',
				name: 'Total consumption',
				data: [{
					name: 'Not Activated Users',
					y: <?=$not_activated_users;?>,
					color: '#f0ad4e'
				}, {
					name: 'Activated Users',
					y: <?=$activated_users;?>,
					color: '#5cb85c'
				}, {
					name: 'Blocked Users',
					y: <?=$blocked_users;?>,
					color: '#d9534f'
				}],
				center: [30, 30],
				size: 60,
				showInLegend: false,
				dataLabels: {
					enabled: false
				}
			}]
        });
		
		$('#posts_chart').highcharts({
			chart: {
                type: 'column'
            },
			credits: {
				enabled: false
			},
            title: {
                text: 'Submitted Posts',
            },
            subtitle: {
                text: 'Source: job.post',
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
                title: {
                    text: 'Number Of Posts'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
			legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle',
                borderWidth: 0
            },
            tooltip: {
                headerFormat: '<span style="font-size:15px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0;font-size:12px">{series.name}: </td>' +
                    '<td style="padding:0;font-size:12px"><b>{point.y}&nbsp;posts</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            series: [
				<?=$posts_chart_data_line;?>
				, {
				type: 'pie',
				name: 'Total consumption',
				data: [{
					name: 'Pending Posts',
					y: <?=$pending_posts;?>,
					color: '#f0ad4e'
				}, {
					name: 'Approved Posts',
					y: <?=$approved_posts;?>,
					color: '#5cb85c'
				}, {
					name: 'Expired Posts',
					y: <?=$expired_posts;?>,
					color: '#d9534f'
				}],
				center: [30, 30],
				size: 60,
				showInLegend: false,
				dataLabels: {
					enabled: false
				}
			}]
        });
    });
</script>


<?php
	$this->load->view('admin/footer');
?>