<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initAjaxRequest();
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooUser'),'object'=>array('$','mooUser'))); ?>
    mooUser.initAjaxRequest();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setCurrentStyle(4);?>

<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Friend Requests')?></h3>
        </div>
    </div>
    <div class="box_content content_center_home">
        <?php if (empty($requests)): echo '<div class="text-center">' . __('You have no friend requests') . '</div>';
        else: ?>
        <div class="friend-request-lists">
            <?php foreach ($requests as $request): ?>
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
                        <div class="friend-request-action">
                            <a class="respondRequest btn btn-primary btn-sm" href="javascript:void(0)" data-id="<?php echo $request['FriendRequest']['id']?>" data-status="1">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-person_add">person_add</span>
                                    <span class="btn-text hidden-xs"><?php echo __('Accept')?></span>
                                </span>
                            </a>
                            <a class="respondRequest btn btn-danger btn-sm" href="javascript:void(0)" data-id="<?php echo $request['FriendRequest']['id']?>" data-status="0">
                                <span class="btn-cs-main">
                                    <span class="btn-icon material-icons moo-icon moo-icon-delete">delete</span>
                                    <span class="btn-text hidden-xs"><?php echo __('Delete')?></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>