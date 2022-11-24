<div class="modal-header">
    <button onclick="return $(this).parents('.notify_content').find('#notificationDropdown').dropdown('toggle')" type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php if ($title):?>
			<?php echo $title?>
		<?php else:?>
			<?php echo __('Error')?>
		<?php endif;?>
    </div>
</div>
<div class="modal-body">
    <div class="bar-content full_content p_m_10">
        <div class="content_center">
            <?php echo $msg; ?>
        </div>
    </div>
</div>