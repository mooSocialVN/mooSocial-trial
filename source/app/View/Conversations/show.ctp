<span class="arr-notify"></span>
<ul class="initSlimScroll notification-group-list">
    <?php if (empty($conversations)): ?>
        <li class="notify_no_content"><?php echo __('No more results found')?></li>
    <?php else: ?>
        <?php $no_image = $this->Moo->getImage(array('User' => array('moo_thumb' => 'avatar', 'id' => '', 'gender' => '', 'avatar' => '')),array("class" => "notification-avatar user_avatar", 'prefix' => '50_square'));?>
        <?php foreach ($conversations as $conversation): ?>
            <li class="notification-group-item">
                <div class="notification-group-main <?php echo $conversation['ConversationUser']['unread'] ? 'unread' : ''?>">
                    <a class="" href="<?php echo $this->request->base?>/conversations/view/<?php echo $conversation['Conversation']['id']?>">
                        <?php
                        if($conversation['Conversation']['lastposter_id'] != $uid){
                            echo !empty($conversation['Conversation']['LastPoster']) ? $this->Moo->getImage(array('User' => $conversation['Conversation']['LastPoster']),array( "class" => "notification-avatar user_avatar", 'prefix' => '50_square')) : $no_image;
                        }else if($conversation['Conversation']['other_last_poster']){
                            $last_poster = MooCore::getInstance()->getItemByType('User',$conversation['Conversation']['other_last_poster']);
                            echo !empty($last_poster) ? $this->Moo->getImage(array('User' => $last_poster['User']), array("class" => "notification-avatar user_avatar", 'prefix' => '50_square')) : $no_image;
                        }else{
                            echo !empty($conversation['Conversation']['LastPoster']) ? $this->Moo->getImage(array('User' => $conversation['Conversation']['LastPoster']),array( "class" => "notification-avatar user_avatar", 'prefix' => '50_square')) : $no_image;
                        }
                        ?>
                        <div class="notification_content">
                            <span class="notification-subject"><?php echo h($conversation['Conversation']['subject'])?></span>
                            <div class="notification-message"><?php
                                if(!empty($conversation['Conversation']['LastReply']['message'])){
                                    echo $this->Text->truncate($this->Moo->parseSmilies(h($conversation['Conversation']['LastReply']['message'])), 85, array('exact' => strpos($conversation['Conversation']['LastReply']['message'],' ') ? false : true, 'html' => true));
                                }else{
                                    echo $this->Text->truncate($this->Moo->parseSmilies(h($conversation['Conversation']['message'])), 85, array('exact' => strpos($conversation['Conversation']['message'],' ') ? false : true, 'html' => true));
                                }
                                ?>
                            </div>
                            <div class="notification-date">
                        <?php echo __n("%s message", "%s messages", $conversation['Conversation']['message_count'],$conversation['Conversation']['message_count'])?>&nbsp;
                                <?php echo  __('Participants') . ':' ?>
                                <?php
                                $i = 1;
                                $count = count($conversation['Conversation']['ConversationUser']);
                                foreach ($conversation['Conversation']['ConversationUser'] as $user):
                                    echo $this->Moo->getNameWithoutUrl($user['User'], true);
                                    $remaining = $count - $i;

                                    if ($i == $count)
                                        break;
                                    elseif ($i >= 3 && ( $remaining > 0 )) {
                                        echo ' and ' .$remaining .' others';
                                        break;
                                    } else
                                        echo ', ';
                                    $i++;
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
</ul>
<div class="more-notify">
    <a id="messages" href="<?php echo $this->request->base?>/user_info/index/messages"><?php echo __('View All Messages')?></a>
</div>