<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initBlockUser();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initBlockUser();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo  __('Confirm Block')?>
    </div>
</div>
<form id="blockUserForm">
    <input type="hidden" name="user_id" value="<?php echo $user['User']['id']?>">
    <div class="modal-body">
        <div class="post_content">
            <p><?php echo  __('Are you sure you want to block %s?',$user['User']['name'])?></p>
            <p><?php echo  __('%s will no longer be able to:', $user['User']['name']) ?></p>
            <ul>
                <li><?php echo  __('See things you post on your timeline') ?></li>
                <li><?php echo  __("If you're friends, blocking %s will also unfriend this user", $user['User']['name']) ?></li>
            </ul>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-modal_save" href="javascript:void(0)" data-uid="<?php echo $user['User']['id']?>" id="blockUserButton"><?php echo __('Ok')?></a>
        <a class="btn btn-modal_close" href="javascript:void(0)" data-dismiss="modal"><?php echo __('Cancel')?></a>
    </div>
</form>