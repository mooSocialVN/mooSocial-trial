<div class="">
    <!-- blog thumbnail -->
   <div class="activity_left">
    <?php if($activity['Content']['Blog']['thumbnail']): ?>
    <img width="150" class="thum_activity" src="<?php echo  $this->request->base . '/' . $activity['Content']['Blog']['thumbnail']; ?>" />
    <?php else: ?>
    <img width="150" class="thum_activity" src="<?php echo $this->request->base?>/img/noimage/noimage-blog.png" />
    <?php endif; ?>
   </div>
    <!-- end blog thumbnail -->
    <div class="activity_right ">
        <div class="activity_header">
            <a class="feed_title" href="<?php echo $this->request->base?>/blogs/view/<?php echo $activity['Content']['Blog']['id']?>/<?php echo seoUrl($activity['Content']['Blog']['title'])?>"><b><?php echo h($activity['Content']['Blog']['title'])?></b></a>
        </div>
        <div class="feed_detail_text">
            <?php echo $this->Text->truncate( strip_tags( str_replace( array('<br>','&nbsp;'), array(' ',''), $activity['Content']['Blog']['body'] ) ), 160 , array('exact' => false))?>
        </div>
    </div>
    <div class="clear"></div>
</div>