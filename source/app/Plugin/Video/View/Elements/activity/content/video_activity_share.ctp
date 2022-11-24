<?php $video = json_decode($activity['Activity']['params'], true); ?>
<?php $videoHelper = MooCore::getInstance()->getHelper('Video_Video'); ?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>

<div class="activity_item">
    <div class="share-content">
        <?php
        $activityModel = MooCore::getInstance()->getModel('Activity');
        $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
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
                        $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);
                        $name = key($subject);
                        ?>
                        <?php if ($activity['Activity']['target_id']): ?>

                            <?php $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject); ?>
                            <?php if ($show_subject): ?>
                                &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a>
                            <?php else: ?>

                            <?php endif; ?>

                        <?php else: ?>

                        <?php endif; ?>
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
                <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $parentFeed))); ?>
            </div>
            <div class="activity_item">
                <div class="video-feed-body">
                    <div class="video-feed-content">
                        <?php echo $this->element('Video./video_snippet', array('video' => array('Video' => $video))); ?>
                    </div>
                    <div class="video-feed-info">
                        <div class="video-title">
                            <a class="feed_title" target="_blank" href="
                    <?php if (!empty($video['group_id'])): ?>
                           <?php echo $this->request->base ?>/groups/view/<?php echo $video['group_id'] ?>/video_id:<?php echo $video['id'] ?>
                       <?php else: ?>
                           <?php if (!empty($video['id'])): ?>
                               <?php echo $this->request->base ?>/videos/view/<?php echo $video['id'] ?>/<?php echo seoUrl($video['title']) ?>
                           <?php else: ?>
                               <?php if ($video['source'] == VIDEO_TYPE_YOUTUBE): ?>
                                   <?php echo 'https://' . $video['source'] . '.com/watch?v=' . $video['source_id']; ?>
                               <?php else: ?>
                                   <?php echo 'https://' . $video['source'] . '.com/' . $video['source_id']; ?>
                               <?php endif; ?>
                           <?php endif; ?>
                       <?php endif; ?>">
                                <?php echo $video['title'] ?>
                            </a>
                        </div>
                        <div class="video-description">
                            <?php echo $this->Text->truncate(nl2br($this->Text->convert_clickable_links_for_hashtags($video['description'], Configure::read('Video.video_hashtag_enabled') )), 400, array('exact' => false))?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

