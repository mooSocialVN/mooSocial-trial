<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGlobal"], function($,mooGlobal) {
        mooGlobal.initLeaveConversation();
        $('.remove_user').click(function(){
            var e = $(this);
        	$.post(mooConfig.url.base + '/conversations/do_remove_user', {message_id: <?php echo $conversation['Conversation']['id'];?>, user_id : $(this).data('id')}, function() {
                e.parent().parent().parent().remove();
            });
        });
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooGlobal'), 'object' => array('$', 'mooGlobal'))); ?>
mooGlobal.initLeaveConversation();
$('.remove_user').click(function(){
	var e = $(this);
	$.post(mooConfig.url.base + '/conversations/do_remove_user', {message_id: <?php echo $conversation['Conversation']['id'];?>, user_id : $(this).data('id')}, function() {
        e.parent().parent().parent().remove();
	});
});
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
<div class="bar-content">
	<div class="box2 bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __('Participants')?> (<?php echo count($convo_users)?>)</h3>
            </div>
        </div>
		<div class="box_content">
            <div class="participant-lists">
            <?php foreach ($convo_users as $convo_user): ?>
            <?php echo $this->element( 'misc/user_mini', array('remove'=>($conversation['User']['id'] == $uid && $convo_user['User']['id'] != $uid) || ($convo_user['User']['id'] != $uid && $uid && $cuser['Role']['is_admin']), 'user' => $convo_user['User'], 'areFriends' => in_array( $convo_user['User']['id'], $friends) ) ); ?>
            <?php endforeach; ?>
            </div>
		</div>
	</div>
	
	<div class="box2 bar-content-warp">
        <div class="box_content box_menu">
		    <ul class="menu-list">
                <?php if(!count($pair_blocker)): ?>
			    <li class="menu-list-item">
                    <?php
                    $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "conversations", "action" => "ajax_add", "plugin" => false, $conversation['Conversation']['id'])),
                        'title' =>  __('Add People To This Conversation'),
                        'innerHtml'=> '<span class="menu-list-icon material-icons moo-icon moo-icon-person_add_alt_1">person_add_alt_1</span><span class="menu-list-text">'.__('Add People').'</span>',
                        'class' => 'menu-list-link',
                        'data-dismiss' => 'sidebarModal'
                    ));
                    ?>
                </li>
                <?php endif; ?>
                <li class="menu-list-item">
                    <a href="javascript:void(0)" class="menu-list-link leaveConversation" data-msg="<?php echo addslashes(__('Are you sure you want to leave this conversation?'))?>" data-url="<?php echo $this->request->base?>/conversations/do_leave/<?php echo $conversation['Conversation']['id']?>" data-dismiss="sidebarModal">
                        <span class="menu-list-icon material-icons moo-icon moo-icon-person_remove">person_remove</span>
                        <span class="menu-list-text"><?php echo __('Leave Conversation')?></span>
                    </a>
                </li>
		    </ul>
        </div>
	</div>
</div>
<?php $this->end(); ?>

<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo h($conversation['Conversation']['subject'])?></h1>
                <div class="box_action">
                    <a class="btn btn-primary btn-cs" href="<?php echo $this->request->base?>/user_info/index/messages">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-backspace">backspace</span>
                            <span class="btn-text"><?php echo __('Back to Messages')?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="box_content">
            <div class="notification-view-content">
                <?php echo $this->Moo->getItemPhoto(array('User' => $conversation['User']),array( 'prefix' => '100_square'), array('class' => 'notification-avatar user_avatar'))?>
                <div class="notification_content">
                    <span class="notification-author"><?php echo $this->Moo->getName($conversation['User'])?></span>
                    <div class="notification-message">
                        <?php echo $this->Moo->formatText( $conversation['Conversation']['message'], false, true , array('no_replace_ssl' => 1))?>
                    </div>
                    <div class="notification-date">
                        <?php echo $this->Moo->getTime($conversation['Conversation']['created'], Configure::read('core.date_format'), $utz)?>
                    </div>
					<div class="notification-seen">
                        <div class="user-seen-list" data-conversation_id="<?php echo $conversation['Conversation']['id']; ?>">
                            <?php
                                $seenModel = MooCore::getInstance()->getModel("ConversationSeen");
                                $seen_cmt = $seenModel->find('all', array('conditions' => array('ConversationSeen.user_id !=' => $uid, 'ConversationSeen.conversation_id' => $conversation['Conversation']['id'])));

                                $count = count($seen_cmt);
                                $list_user_seen = [];
                                foreach ($seen_cmt as $key => $val):
                                    if ($key == 2)
                                    {
                                        break;
                                    }
                                    $list_user_seen[] = $val['User']['id'];
    
                                    ?>
                                    <div class="user-seen-item">
                                        <?php echo $this->Moo->getItemPhoto(array('User' => $val['User']),array( 'prefix' => '50_square'), array('class' => 'user_avatar')); ?>
                                    </div>
                                <?php
                                endforeach;
                            ?>
                            <?php if ($count > 2): ?>
                                <div class="user-seen-item">
                                    <a href="<?php echo $this->request->base?>/conversations/ajax_message_seen/<?php echo $conversation['Conversation']['id']; ?>" data-target="#themeModal" data-toggle="modal" data-dismiss="modal" data-backdrop="true">
                                        <span class="btn-see-more-icon material-icons moo-icon moo-icon-add">add</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="user-seen-ids lis_user_seen_conv_<?php echo $conversation['Conversation']['id']; ?>" data-list_user_id="<?php echo join(',', $list_user_seen); ?>"></div>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <div class="box2 bar-content-warp">
        <div class="box_content core_comments conversations-comment">
            <?php if($pair_blocker && count($pair_blocker)): ?>
                <?php echo __('%1$s blocked %2$s so that this conversation can\'t continue!',$pair_blocker['block_user']['name'],$pair_blocker['blocked_user']['name']) ?>
            <?php endif; ?>
            <?php if (!count($pair_blocker)): ?>
                <div class="comment_header_title"><?php echo __('Messages')?> (<span id="comment_count"><?php echo $conversation['Conversation']['message_count']?></span>)</div>
            <?php endif;?>
            <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                <?php
                if (!empty($uid) && !count($pair_blocker))
                    echo $this->element('comment_form', array('target_id' => $conversation['Conversation']['id'], 'type' => APP_CONVERSATION));
                ?>
                <div class="comment_lists comment_parent_lists" id="comments">
                    <?php echo $this->element('comments');?>
                </div>
            <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                <div class="comment_lists comment_parent_lists" id="comments">
                    <?php echo $this->element('comments_chrono');?>
                </div>
                <?php
                if (!empty($uid) && !count($pair_blocker))
                    echo $this->element('comment_form', array('target_id' => $conversation['Conversation']['id'], 'type' => APP_CONVERSATION));
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>