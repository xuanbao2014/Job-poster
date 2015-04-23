
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></button>
        <h3 class="modal-title" style="color:#a94442;"><span class="glyphicon glyphicon-trash"></span> &nbsp;<?=lang('zhidian_jobdelete')?></h3>
      </div>
      <div class="modal-body">
        <h3><?=lang('zhidian_jobdelete_message')?></h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?=lang('zhidian_cancel')?></button>
        <button type="button" class="btn btn-primary" onclick="location.href='/member/deletePostFromDataBase/<?=$delpid?>'"><?=lang('zhidian_jobdelete')?></button>
      </div>
