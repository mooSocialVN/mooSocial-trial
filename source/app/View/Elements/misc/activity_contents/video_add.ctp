<div class="activity_item">
    <div class="video-feed-content">
        <?php echo $this->element('Video./video_snippet', array('video' => $activity['Content'])); ?>
    </div>
    <div class="video-feed-info">
        <div class="video-title">
            <a class="activity_item_title" href="<?php if ( !empty( $activity['Content']['Video']['group_id'] ) ): ?><?php echo $this->request->base?>/groups/view/<?php echo $activity['Content']['Video']['group_id']?>/video_id:<?php echo $activity['Content']['Video']['id']?><?php else: ?><?php echo $this->request->base?>/videos/view/<?php echo $activity['Content']['Video']['id']?>/<?php echo seoUrl($activity['Content']['Video']['title'])?><?php endif; ?>">
                <?php echo h($activity['Content']['Video']['title'])?>
            </a>
        </div>

        <div class="video-description comment_message feed_detail_text">
            <?php echo h($this->Text->truncate($activity['Content']['Video']['description'], 200, array('exact' => false)))?>
        </div>
    </div>

</div>