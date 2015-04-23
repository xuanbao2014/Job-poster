      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
        <h3 class="modal-title" style="color:#a94442;"><span class="glyphicon glyphicon-list"></span> &nbsp;<?=lang('zhidian_jobstatus')?></h3>
      </div>
      <div class="modal-body">
        <h3>By default, this job will be expired after 30 days from its post date. If you want to keep it, just renew it! No need to post it again :)</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal"><?=lang('zhidian_cancel')?></button>
		<?php
			$memberinfo = $this->session->userdata('memberinfo');
			$actor = $memberinfo['uid'];
		?>
		<?php if($actor==5): ?>
        <button type="button" class="btn-sm btn-warning" onclick="location.href='/member/editPostStatusFromDataBase/<?=$pid?>/0/<?=$url?>'">Pending</button>
		<button type="button" class="btn-sm btn-success" onclick="location.href='/member/editPostStatusFromDataBase/<?=$pid?>/1/<?=$url?>'">Approved</button>
		<?php endif; ?>
		<button type="button" class="btn-sm btn-info" onclick="location.href='/member/editPostStatusFromDataBase/<?=$pid?>/2/<?=$url?>'">Expired</button>
		<button type="button" class="btn-sm btn-info" onclick="location.href='/member/editPostStatusFromDataBase/<?=$pid?>/3/<?=$url?>'">Renew</button>
      </div>
