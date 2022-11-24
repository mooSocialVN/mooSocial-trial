<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<?php if ( $page == 1 ): ?>
    <?php !empty($dislike)? $text = __n("%s People Dislike This","%s Peoples Dislike This", $count,$count) : $text = __n("%s People Like This","%s Peoples Like This", $count,$count); ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo $text;?>
    </div>
</div>
<div class="modal-body">
    <div class="user-lists list-view user-like" id="list-content2">
<?php endif; ?>

<?php echo $this->element('lists/users_list_bit'); ?>

<?php if (count($users) + ($page - 1) * RESULTS_LIMIT < $count):?>

    <?php $this->Html->viewMore($more_url,'list-content2') ?>
	<script>
		require(["mooBehavior"], function(mooBehavior) {
			mooBehavior.initMoreResultsPopup();
        });
	</script>
<?php endif; ?>

<?php if ( $page == 1 ): ?>
    </div>
</div>
<?php endif; ?>