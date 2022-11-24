<div>
    <!-- topic thumbnail -->
    <div class="activity_left">
        <?php if ($activity['Content']['Topic']['thumbnail']): ?>
            <img width="150" class="thum_activity" src="<?php echo  $this->request->base . '/' .$activity['Content']['Topic']['thumbnail']; ?>"/>
        <?php else: ?>
            <img width="150" class="thum_activity" src="<?php echo  $this->request->base ?>/img/noimage/noimage-topic.png"/>
        <?php endif; ?>
    </div>
    <!-- end topic thumbnail -->
    <div class="activity_right ">
        <div class="activity_header">
            <a class="feed_title" href="<?php if (!empty($activity['Content']['Topic']['group_id'])): ?><?php echo  $this->request->base ?>/groups/view/<?php echo  $activity['Content']['Topic']['group_id'] ?>/topic_id:<?php echo  $activity['Content']['Topic']['id'] ?><?php else: ?><?php echo  $this->request->base ?>/topics/view/<?php echo  $activity['Content']['Topic']['id'] ?>/<?php echo  seoUrl($activity['Content']['Topic']['title']) ?><?php endif; ?>"><b><?php echo  h($activity['Content']['Topic']['title']) ?></b></a>
        </div>
        <div class="feed_detail_text">
            <?php echo  $this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $activity['Content']['Topic']['body'])), 160, array('exact' => false)) ?>
        </div>
    </div>
    <div class="clear"></div>
</div>