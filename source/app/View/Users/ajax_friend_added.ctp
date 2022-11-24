<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo __( 'Friends Added')?>
    </div>
</div>
<div class="modal-body">
    <div class="activity_content activity_friend_add">
    <?php if (!count($users)):?>
	    <?php echo __('No more results found');?>
    <?php else:?>
        <div class="user-lists grid-view">
	    <?php foreach ( $users as $user ): ?>
	        <?php echo $this->element('user/item', array('user' => $user)); ?>
	    <?php endforeach; ?>
        </div>
    <?php endif;?>
    </div>
</div>