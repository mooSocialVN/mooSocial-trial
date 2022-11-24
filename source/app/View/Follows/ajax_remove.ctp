<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initRemoveFollow();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initRemoveFollow();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo  __('Please Confirm')?>
    </div>
</div>
<form id="removeFollowForm">
    <input type="hidden" name="user_id" value="<?php echo $user['User']['id']?>">
    <div class="modal-body">
        <div class="post_content">
            <p><?php echo  __('Are you sure you want to remove this follow ?')?></p>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-modal_delete" href="javascript:void(0)" data-uid="<?php echo $user['User']['id']?>" id="removeFollowButton"><?php echo __('Ok')?></a>
        <a class="btn btn-modal_close" href="javascript:void(0)" data-dismiss="modal"><?php echo __('Cancel')?></a>
    </div>
</form>