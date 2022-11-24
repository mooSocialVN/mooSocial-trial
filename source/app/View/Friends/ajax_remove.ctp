<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initRemoveFriend();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initRemoveFriend();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo  __('Please Confirm')?>
    </div>
</div>
<form id="removeFriendForm">
    <div class="modal-body">
        <div class><?php echo  __('Are you sure you want to remove this friend ?')?></div>
    </div>
    <div class="modal-footer">
        <input type="hidden" name="user_id" value="<?php echo $user['User']['id']?>">
        <a class="btn btn-modal_save ok" href="javascript:void(0)" data-uid="<?php echo $user['User']['id']?>" id="removeFriendButton"><?php echo __('Ok')?></a>
        <a class="btn btn-modal_close" href="javascript:void(0)" data-dismiss="modal"><?php echo __('Cancel')?></a>
    </div>
</form>