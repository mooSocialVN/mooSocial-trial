<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initUnBlockUser();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initUnBlockUser();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php echo  __('Unblock %s', $user['User']['name'])?>
    </div>
</div>
<form id="unBlockUserForm">
    <input type="hidden" name="user_id" value="<?php echo $user['User']['id']?>">
    <div class="modal-body">
        <div class="post_content">
            <p class><?php echo  __('Are you sure you want to unblock %s?',$user['User']['name'])?></p>
            <ul>
                <li><?php echo  __('%s may be able to see your timeline or contact you', $user['User']['name']) ?></li>
                <li><?php echo  __('%s may be able add you as a friend and contact with you', $user['User']['name']) ?></li>
            </ul>
        </div>
    </div>
    <div class="modal-footer">
        <a class="btn btn-modal_save" href="javascript:void(0)" data-uid="<?php echo $user['User']['id']?>" id="unBlockUserButton"><?php echo __('Confirm')?></a>
        <a class="btn btn-modal_close" href="javascript:void(0)" data-dismiss="modal"><?php echo __('Cancel')?></a>
    </div>
</form>