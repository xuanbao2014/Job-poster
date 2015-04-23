<?php
	$this->load->view('admin/header');
?>

<link rel="stylesheet" type="text/css" href="/tools/dataTable_bootstrap3/dataTables.bootstrap.css">
<script type="text/javascript" language="javascript" src="/tools/dataTable_bootstrap3/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="/tools/dataTableTools/js/ZeroClipboard.js"></script>
<script type="text/javascript" language="javascript" src="/tools/dataTableTools/js/TableTools.js"></script>
<script type="text/javascript" language="javascript" src="/tools/dataTable_bootstrap3/dataTables.bootstrap.js"></script>

<script type="text/javascript">
TableTools.BUTTONS.newpost = $.extend( true, TableTools.buttonBase, {
	"sNewLine": "<br>",
	"sButtonText": "New Post",
	"sDiv": "",
	"fnClick": function( nButton, oConfig ) {
//		document.getElementById(oConfig.sDiv).innerHTML =
//			this.fnGetTableData(oConfig);
		window.location.href = "/member/addpost";
	}
} );
$(document).ready(function(){
	$('#users_table').dataTable({
		"sDom": '<"top"fT>tr<"bottom"p>',
		"oTableTools": {
			"sSwfPath": "/tools/dataTableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends":    "newpost",
					"sButtonText": "<span class='glyphicon glyphicon-plus'></span> &nbsp;Create User",
					"sDiv":        "new"
				},
				{
					"sExtends":    "csv",
					"sButtonText": "<span class='glyphicon glyphicon-floppy-save'></span> &nbsp;Export",
					"sDiv":        "csv",
					"sButtonClass":"hidden-xs"
				}
			]
		},
        "aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": [
		  { "bSortable": false, "aTargets": [ -1,-2 ] }
		],
		"iDisplayLength": 25,
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ Rows",
					"sSearch": "<span class='glyphicon glyphicon-search' style='font-size:16px;'></span>"
		}
    });
	$(function(){
		$('#users_table').each(function(){
			var datatable = $(this);
			// SEARCH - Add the placeholder for Search and Turn this into in-line formcontrol
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search');
			search_input.addClass('form-control input-small');
			search_input.css('width', '250px');
			search_input.css('height', '30px');

			// SEARCH CLEAR - Use an Icon
			var clear_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] a');
			clear_input.html('<i class="icon-remove-circle icon-large"></i>');
			clear_input.css('margin-left', '5px');

			// LENGTH - Inline-Form control
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-small');
			length_sel.css('width', '75px');

			// LENGTH - Info adjust location
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_info]');
			length_sel.css('margin-top', '18px');
		});
	});

/*	$("#updateModal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});
*/	$("#deleteModal").on('hidden.bs.modal', function () {
		$(this).data('bs.modal', null);
	});
//	$("div.toolbar").html('<a href="/member/addpost"><button class="btn btn-dafualt"><span class="glyphicon glyphicon-star"></span> New Post</button></a>');
});
</script>

<div class="container">
	<div class="table-responsive">
		<table id="users_table" class="table table-striped">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Reg Date</th>
				<th>Last Date</th>
				<th style="text-align:center;width:30px;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($userlist)):?>
				<?php foreach($userlist as $row):?>
				<tr>
					<td><?=$row['id'];?></td>
					<td><?=$row['name'];?></td>
					<td><?=$row['email'];?></td>
					<?php if(date('Y', strtotime(unix_to_human($row['reg_timestamp'])))>=2013):?>
						<td><?=date('Y-m-d g:i A', $row['reg_timestamp']);?></td>
					<?php else:?>
						<td>N/A</td>
					<?php endif;?>
					<?php if(date('Y', strtotime(unix_to_human($row['last_sign_timestamp'])))>=2013):?>
						<td><?=date('Y-m-d g:i A', $row['last_sign_timestamp']);?></td>
					<?php else:?>
						<td>N/A</td>
					<?php endif;?>
					<td style="text-align:center;">
						<?php if($row['status'] == 0): ?>
							<span class="label label-warning">not activated</span>
						<?php elseif($row['status'] == 1): ?>
							<span class="label label-success">activated</span>
						<?php elseif($row['status'] == 2): ?>
							<span class="label label-danger">blocked</span>
						<?php endif; ?>
					</td>
				</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
	</div>
</div>

<?php
	$this->load->view('admin/footer');
?>