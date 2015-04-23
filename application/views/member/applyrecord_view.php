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
	$('#post_table').dataTable({
//		"sDom": 'T<"clear">lfrtip',
//		"sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
		"sDom": '<"top"fT>tr<"bottom"p>',
		"oTableTools": {
			"sSwfPath": "/tools/dataTableTools/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends":    "newpost",
					"sButtonText": "<span class='glyphicon glyphicon-plus'></span> &nbsp;<?=lang('zhidian_member_addpost')?>",
					"sDiv":        "new"
				},
				// {
				// 	"sExtends":    "copy",
				// 	"sButtonText": "<span class='glyphicon glyphicon-file'></span> &nbsp;Copy",
				// 	"sDiv":        "copy"
				// },
//				"copy",
//				"print",
				// {
				// 	"sExtends":    "print",
				// 	"sButtonText": "<span class='glyphicon glyphicon-print'></span> &nbsp;<?=lang('zhidian_print')?>",
				// 	"sDiv":        "print"
				// },
				/*{
					"sExtends":    "collection",
					"sButtonText": 'Save <span class="caret" />',
					"aButtons":    [ "csv", "xls", "pdf" ]
				}*/
				{
					"sExtends":    "csv",
					"sButtonText": "<span class='glyphicon glyphicon-floppy-save'></span> &nbsp;<?=lang('zhidian_csv')?>",
					"sDiv":        "csv",
					"sButtonClass":"hidden-xs"
				}/*,
				{
					"sExtends":    "xls",
					"sButtonText": "<span class='glyphicon glyphicon-floppy-save'></span> &nbsp;XLS",
					"sDiv":        "xls"
				},
				{
					"sExtends":    "pdf",
					"sButtonText": "<span class='glyphicon glyphicon-floppy-save'></span> &nbsp;PDF",
					"sDiv":        "pdf"
				}*/
			]
		},
        "aaSorting": [[ 0, "desc" ]],
		"aoColumnDefs": [
		  { "bSortable": false, "aTargets": [ -1,-2 ] }
		],
		"iDisplayLength": 25,
		"oLanguage": {
			"sLengthMenu": "Show _MENU_ Rows",
					"sSearch": ""
		}
    });
	$(function(){
		$('#post_table').each(function(){
			var datatable = $(this);
			// SEARCH - Add the placeholder for Search and Turn this into in-line formcontrol
			var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
			search_input.attr('placeholder', 'Search')
			search_input.addClass('form-control input-small')
			search_input.css('width', '250px')

			// SEARCH CLEAR - Use an Icon
			var clear_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] a');
			clear_input.html('<i class="icon-remove-circle icon-large"></i>')
			clear_input.css('margin-left', '5px')

			// LENGTH - Inline-Form control
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
			length_sel.addClass('form-control input-small')
			length_sel.css('width', '75px')

			// LENGTH - Info adjust location
			var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_info]');
			length_sel.css('margin-top', '18px')
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
<div><h4>&nbsp;&nbsp;<?=lang('zhidian_member_applyrecord')?>
<a class="btn btn-info btn-sm pull-right" href="/member" style="margin-right:10px;"><span class="glyphicon glyphicon-arrow-left"></span> <?=lang('zhidian_back_to_dashboard')?> </a>
</h4></div><hr />
<div class="table-responsive">
<!--	<a href="/member/addpost"><button class="btn btn-dafualt"><span class="glyphicon glyphicon-star"></span> New Post</button></a>//-->

	<table id="post_table" class="table table-striped">
		<thead>
			<tr>
				<th><?=lang('zhidian_apply_time')?></th>
				<th><?=lang('zhidian_jobtitle')?></th>
				<th><?=lang('zhidian_jobcompany')?></th>
				<th><?=lang('zhidian_jobcountry')?></th>
				<th><?=lang('zhidian_jobcity')?></th>
				<th style="text-align:center;width:30px;">Status</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($apply)):?>
				<?php foreach($apply as $row):?>
				<tr>
					<?php if(isset($post[$row['pid']])):?>
						<?php $cur_post = $post[$row['pid']];?>
						<td><?=date('Y-m-d g:i A', $row['timestamp'])?></td>
						<td><a target="_blank" href="/postdetail/<?=$row['pid']?>"><?=$cur_post['jobtitle']?></a></td>
						<td><?=$cur_post['company']?></td>

						<?php if($cur_post['country'] === 'China' && $this->session->userdata('site_lang') != "english"):?>											
							<td><?=$cur_post['country_cn']?></td>
							<td><?=$cur_post['city_cn']?></td>
						<?php else:?>
							<td><?=$cur_post['country']?></td>
							<td><?=$cur_post['city']?></td>
						<?php endif;?>
						<?php if($row['status']==1):?>
							<td style="text-align:center;width:30px;"><span class="text-success glyphicon glyphicon-ok"></span></td>
						<?php else:?>
							<td style="text-align:center;width:30px;"><span class="text-danger glyphicon glyphicon-remove"></span></td>
						<?php endif;?>
					<?php else:?>
						<td><?=lang('zhidian_applyrecord_null')?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="text-align:center;width:30px;"><span class="text-danger glyphicon glyphicon-remove"></span></td>
					<?php endif;?>	
				</tr>
				<?php endforeach;?>
			<?php endif;?>
		</tbody>
	</table>
</div>

<!--<div class="modal fade" id="updateModal"></div>//--><!-- /.modal -->

<div class="modal fade" id="deleteModal">
  <div class="modal-dialog">
    <div class="modal-content">
	</div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->