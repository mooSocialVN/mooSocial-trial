<div class="comment_message">
    <?php
    $activityModel = MooCore::getInstance()->getModel('Activity');
    $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
    $link = unserialize($parentFeed['Activity']['params']);
	$url = ((isset($link['url']) && $link['url'] != 'http://')  ? $link['url'] : $activity['Activity']['content']);
    ?>
    <?php
    echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1));
    ?>
    <?php
    if (!empty($activity['UserTagging']['users_taggings']))
        $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']);
    ?>
    <div class="share-content">
        <div class="feed-entry-item">
            <div class="feed-entry-warp">
                <div class="feed_main_info">
                    <div class="activity_feed_header">
                        <div class="activity_feed_image">
                            <?php echo $this->Moo->getItemPhoto(array('User' => $parentFeed['User']), array('prefix' => '50_square'), array('class' => 'user_avatar')) ?>
                        </div>
                        <div class="activity_feed_content">
                            <div class="activity_content_head">
                                <div class="activity_author">
                                    <?php echo $this->Moo->getName($parentFeed['User']) ?>
                                </div>
                            </div>
                            <div class="feed_time">
                                <span class="feed_time-txt"><?php echo $this->Moo->getTime($parentFeed['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="activity_feed_content_text">
                        <div class="activity_feed_message">
                            <?php echo $this->viewMore(h($parentFeed['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1));?>
                        </div>
                        <div class="activity_item activity_tb">
                            <?php if ( !empty( $link['type'] ) && $link['type'] == 'img'):?>
                                <?php if ( !empty( $link['image'] ) ): ?>
                                    <div class="activity_item">
                                        <div class="activity_parse_img">
                                            <img src="<?php echo $link['image'] ?>" class="activity-img">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if (!empty($link['image'])):
                                    if ( strpos( $link['image'], 'http' ) === false ):
                                        $link_image = $this->request->webroot . 'uploads/links/' .  $link['image'] ;
                                    else:
                                        $link_image = $link['image'];
                                    endif;
                                    ?>
                                    <div class="activity_left">
                                        <a class="activity_img_thumb" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                                            <img src="<?php echo $link_image ?>" class="activity-img">
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <div class="<?php if (!empty($link['image'])): ?>activity_right <?php endif; ?>">
                                    <a class="activity_item_title" href="<?php echo $url;?>" target="_blank" rel="nofollow">
                                        <?php if(!empty($link['title'])): ?>
                                            <strong><?php echo h($link['title']) ?></strong>
                                        <?php endif; ?>
                                    </a>

                                    <?php
                                    if (!empty($link['description']))
                                        echo '<div class="activity_item_text">' . ($this->Text->truncate($link['description'], 150, array('exact' => false))) . '</div>';
                                    ?>
                                </div>
                            <?php endif;?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $parentFeed))); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>