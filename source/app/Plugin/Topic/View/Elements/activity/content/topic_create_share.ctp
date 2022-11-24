<?php
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if (!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <?php
        $activityModel = MooCore::getInstance()->getModel('Activity');
        $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
        $topic = MooCore::getInstance()->getItemByType($parentFeed['Activity']['item_type'], $parentFeed['Activity']['item_id']);
        ?>
        <div class="activity_feed_header">
            <div class="activity_feed_image">
                <?php echo $this->Moo->getItemPhoto(array('User' => $parentFeed['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
            </div>
            <div class="activity_feed_content">
                <div class="activity_content_head">
                    <div class="activity_author">
                        <?php echo $this->Moo->getName($parentFeed['User']) ?>
                        <?php
                        $subject = MooCore::getInstance()->getItemByType($parentFeed['Activity']['type'], $parentFeed['Activity']['target_id']);
                        $name = key($subject);
                        ?>
                        <?php if ($parentFeed['Activity']['target_id']): ?>

                            <?php $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject); ?>

                            <?php if ($show_subject): ?>
                                &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a>
                            <?php else: ?>
                                <?php echo __('created a new topic'); ?>
                            <?php endif; ?>

                        <?php else: ?>
                            <?php echo __('created a new topic'); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="feed_time">
                    <span class="feed_time-txt"><?php echo $this->Moo->getTime($parentFeed['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
                </div>
            </div>
        </div>
        <div class="activity_feed_content_text">
            <div class="activity_item">
                <div class="activity_left">
                    <a class="activity_img_thumb" href="<?php echo $topic['Topic']['moo_href'] ?>">
                        <img class="activity-img" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '850')) ?>"/>
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php if (!empty($topic['Topic']['group_id'])): ?><?php echo $this->request->base ?>/groups/view/<?php echo $topic['Topic']['group_id'] ?>/topic_id:<?php echo $topic['Topic']['id'] ?><?php else: ?><?php echo $this->request->base ?>/topics/view/<?php echo $topic['Topic']['id'] ?>/<?php echo seoUrl($topic['Topic']['title']) ?><?php endif; ?>"><b><?php echo $topic['Topic']['title'] ?></b></a>
                    <div class="activity_item_text">
                        <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $topic['Topic']['body'])), 200, array('exact' => false)), Configure::read('Topic.topic_hashtag_enabled')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
