<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initAddFriend();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initAddFriend();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal">
        <?php printf( __('Send %s a friend request'), $user['User']['name'] )?>
    </div>
</div>
<div class="create_form">
    <form id="addFriendForm" class="">
        <div class="modal-body">
            <div class="modal-form-content">
                <div class="form-content">
                <?php if ($warning_msg): ?>
                    <div class="form-group">
                        <?php echo $warning_msg?>
                    </div>
                <?php else: ?>
                    <input type="hidden" name="user_id" value="<?php echo $user['User']['id']?>">
                    <div class="form-group">
                        <?php printf( __('You can send <b>%s</b> an optional message below'), $user['User']['name'] ); ?>
                    </div>
                    <div class="form-group">
                        <div class="friend-request-message">
                            <div class="friend-request-message-l">
                                <?php echo $this->Moo->getImage(array('User' => $user['User']), array("class" => "user_avatar", 'prefix' => '50_square'))?>
                            </div>
                            <div class="friend-request-message-r">
                                <textarea name="message" class="form-control" maxlength="45"></textarea>
                                <div>
                                    <div class="core-item-date"><span id="message_count">45</span>/45</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php if (!$warning_msg): ?>
            <a class="btn btn-modal_save" href="javascript:void(0);" data-uid="<?php echo $user['User']['id']?>" id="sendReqAddFriendBtn"><?php echo __('Send Request')?></a>
            <?php endif; ?>
            <button type="button" class="btn btn-modal_close" data-dismiss="modal"><?php echo __('Close')?></button>
        </div>
    </form>
</div>