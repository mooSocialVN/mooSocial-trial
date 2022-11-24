<?php
if ( !empty($conversations) )
{
    $no_image = $this->Moo->getImage(array('User' => array('moo_thumb' => 'avatar', 'id' => '', 'gender' => '', 'avatar' => '')),array( "width" => "45px", "class" => "notification-avatar user_avatar", 'prefix' => '50_square'));
    foreach ($conversations as $conversation): ?>
        <li class="notification-group-item">
            <div class="notification-group-main <?php echo $conversation['ConversationUser']['unread'] ? 'unread' : ''?>">
                <a href="<?php echo $this->request->base?>/conversations/view/<?php echo $conversation['Conversation']['id']?>">
                    <?php
                    if($conversation['Conversation']['lastposter_id'] != $uid){
                        echo !empty($conversation['Conversation']['LastPoster']) ? $this->Moo->getImage(array('User' => $conversation['Conversation']['LastPoster']), array('prefix' => '100_square', 'class' => 'notification-avatar user_avatar')) : $no_image;
                    }else if($conversation['Conversation']['other_last_poster']){
                        $last_poster = MooCore::getInstance()->getItemByType('User',$conversation['Conversation']['other_last_poster']);
                        echo !empty($last_poster) ? $this->Moo->getImage(array('User' => $last_poster['User']), array('prefix' => '100_square', 'class' => 'notification-avatar user_avatar')) : $no_image;
                    }else{
                        echo !empty($conversation['Conversation']['LastPoster']) ? $this->Moo->getImage(array('User' => $conversation['Conversation']['LastPoster']), array('prefix' => '100_square', 'class' => 'notification-avatar user_avatar')) : $no_image;
                    }
                    ?>
                    <div class="notification_content">
                        <span class="notification-subject"><?php echo h($conversation['Conversation']['subject'])?></span>
                        <div class="notification-message">
                            <?php
                            if(!empty($conversation['Conversation']['LastReply']['message'])){
                                echo $this->Text->truncate($this->Moo->parseSmilies(h($conversation['Conversation']['LastReply']['message'])), 85, array('exact' => strpos($conversation['Conversation']['LastReply']['message'],' ') ? false : true, 'html' => true));
                            }else {
                                echo $this->Text->truncate($this->Moo->parseSmilies(h($conversation['Conversation']['message'])), 85, array('exact' => strpos($conversation['Conversation']['message'],' ') ? false : true, 'html' => true));
                            }
                            ?>
                        </div>
                        <div class="notification-date">
                            <?php echo __n('%s message', '%s messages', $conversation['Conversation']['message_count'], $conversation['Conversation']['message_count'])?> .
                            <?php echo __('Participants')?>:
                            <?php
                            $i = 1;
                            $count = count( $conversation['Conversation']['ConversationUser'] );
                            foreach ( $conversation['Conversation']['ConversationUser'] as $user ):
                                echo $this->Moo->getName( $user['User'], false );
                                $remaining = $count - $i;

                                if ( $i == $count )
                                    break;
                                elseif ( $i >= 3 && ( $remaining > 0  ) )
                                {
                                    printf(__(' and %s others'), $remaining);
                                    break;
                                }
                                else
                                    echo ', ';

                                $i++;
                            endforeach; ?>
                        </div>
                    </div>
                </a>
            </div>
            <div class="noti_option">
                <a style="<?php if (!$conversation['ConversationUser']['unread']) echo 'display:none;' ?>" href="javascript:void(0)" data-id="<?php echo $conversation['Conversation']['id']?>" data-status="0" class="markMsgStaus mark_read tip mark_section" title="<?php echo __( 'Mark as Read')?>">
                    <span class="material-icons moo-icon moo-icon-check_circle">check_circle</span>
                </a>
                <a style="<?php if ($conversation['ConversationUser']['unread']) echo 'display:none;' ?>" href="javascript:void(0)" data-id="<?php echo $conversation['Conversation']['id']?>" data-status="1" class="markMsgStaus tip mark_section mark_unread" title="<?php echo __( 'Mark as unRead')?>">
                    <span class="material-icons moo-icon moo-icon-check_circle">check_circle</span>
                </a>
            </div>
        </li>
    <?php
    endforeach;
}
else
    echo '<div class="no-more-results">' . __('No more results found') . '</div>';
?>

<?php if (count($conversations) >= RESULTS_LIMIT): ?>

    <?php $this->Html->viewMore($more_url); ?>
<?php endif; ?>

<?php if($this->request->is('ajax')): ?>
    <script type="text/javascript">
        require(["jquery","mooBehavior", "mooGlobal"], function($, mooBehavior, mooGlobal) {
            mooBehavior.initMoreResults();
            mooGlobal.initMsgList();
        });
    </script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooBehavior', 'mooGlobal'), 'object' => array('$', 'mooBehavior', 'mooGlobal'))); ?>
    mooBehavior.initMoreResults();
    mooGlobal.initMsgList();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>