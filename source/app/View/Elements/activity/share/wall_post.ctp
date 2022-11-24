<div class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_header">
                <div class="activity_feed_image">
                    <?php echo $this->Moo->getItemPhoto(array('User' => $activity['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
                </div>
                <div class="activity_feed_content">
                    <div class="activity_content_head">
                        <div class="activity_author">
                            <?php echo $this->Moo->getName($activity['User'], true, true) ?>

                            <?php if ($activity['Activity']['target_id']): ?>
                                <?php
                                $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);

                                list($plugin, $name) = mooPluginSplit($activity['Activity']['type']);
                                $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);

                                if ($show_subject):
                                    ?>
                                    &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="feed_time">
                        <span class="feed_time-txt"><?php echo $this->Moo->getTime($activity['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
                    </div>
                </div>
            </div>
            <div class="activity_feed_content_text">
                <div class="activity_feed_message">
                    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
                    <?php
                    if (!empty($activity['UserTagging']['users_taggings']))
                        $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']);
                    ?>
                    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
                </div>
                <div class="activity_feed_post">
                    <?php if ($activity['Activity']['item_type']): ?>
                        <?php
                        list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']);
                        ?>
                        <?php echo $this->element('activity/content/' . strtolower($name) . '_post_feed1', array('activity' => $activity, 'object' => $object, 'had_comment_message' => 1 ), array('plugin' => $plugin)); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>