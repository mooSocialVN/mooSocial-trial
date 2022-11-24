<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
    <script>
function respondRequest(id, status)
{
	jQuery.post('<?php echo $this->request->base?>/groups/ajax_respond', {id: id, status: status}, function(data){
		jQuery('#request_'+id).find('.user-item-action').remove();
		jQuery('#request_'+id).find('.user-message').html(data);
	});
    var request_count = parseInt(jQuery("#join-request").attr("data-request"));
    request_count = request_count - 1;
    if(request_count == 0){
        jQuery("#join-request").remove();
    }
    else if(request_count == 1){
        jQuery("#join-request").find('.btn-count').html(request_count);
        jQuery("#join-request").find('.btn-text').html('<?php echo addslashes(__('join request'));?>');
    }
    else{
        jQuery("#join-request").find('.btn-count').html(request_count);
        jQuery("#join-request").find('.btn-text').html('<?php echo addslashes(__('join requests'));?>');
    }
    jQuery("#join-request").attr("data-request",request_count);
}

</script>

<?php if (empty($requests)): ?>
<div class="modal-body">
    <div align="center"><?php echo __( 'No join requests') ?></div>
</div>
<?php else: ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only"><?php echo __('Close');?></span></button>
    <div class="title-modal" id="myModalLabel"><?php echo __('Join Requests');?></div>
</div>
<div class="modal-body">
    <div class="user-lists user_join_request list-view" id="list-request">
        <?php echo $this->element( 'lists/requests_list');?>
    </div>
</div>
<?php endif; ?>