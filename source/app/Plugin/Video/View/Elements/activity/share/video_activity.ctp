<?php $video = json_decode($activity['Activity']['params'], true); ?>
<div class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_content_text">
                <div class="activity_feed_message">
                    <?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1));?>
                    <?php $this->getEventManager()->dispatch(new CakeEvent('Element.activities.afterShowFeedContent', $this, array('activity' => $activity))); ?>
                </div>
                <div class="activity_item activity_item_share_popup">
                    <div class="video-feed-body">
                        <div class="video-feed-content">
                            <?php echo $this->element('Video./video_snippet', array('video' => array('Video' => $video))); ?>
                        </div>
                        <div class="video-feed-info video_feed_content">
                            <div class="video-title">
                                <a class="activity_item_title" target="_blank" href="
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
</div>