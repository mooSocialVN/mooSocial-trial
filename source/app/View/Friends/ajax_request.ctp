<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initAjaxRequestPopup();
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooUser'),'object'=>array('$','mooUser'))); ?>
    mooUser.initAjaxRequestPopup();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setCurrentStyle(4);?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __('Friend Requests')?></div>
</div>

<div class="create_form">
    <div class="modal-body">
        <div class="friend-request-lists">
            <div id="request_<?php echo $request['FriendRequest']['id']?>" class="friend-request-item">
                <div class="friend-request-warp">
                    <div class="friend-request-main">
                        <div class="friend-request-avatar">
                            <?php echo $this->Moo->getItemPhoto(array('User' => $request['Sender']), array( 'prefix' => '100_square'), array('class' => 'user_avatar'))?>
                        </div>
                        <div class="friend-request-info">
                            <div class="friend-request-name">
                                <?php echo $this->Moo->getName($request['Sender'])?>
                            </div>
                            <div class="friend-request-message">
                                <?php echo nl2br(h($request['FriendRequest']['message']))?>
                            </div>
                            <span class="friend-request-date">
                                    <?php echo $this->Moo->getTime( $request['FriendRequest']['created'], Configure::read('core.date_format'), $utz )?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:void(0)" data-id="<?php echo $request['FriendRequest']['id']?>" data-status="1" class="btn btn-modal_save respondRequest"><?php echo __('Accept')?></a>
        <a href="javascript:void(0)" data-id="<?php echo $request['FriendRequest']['id']?>" data-status="0" class="btn btn-modal_close respondRequest"><?php echo __('Delete')?></a>
    </div>
</div>