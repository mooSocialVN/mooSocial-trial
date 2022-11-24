<?php $this->getEventManager()->dispatch(new CakeEvent('View.Elements.activityWidget.renderActivityFeed', $this, array('class_feed' => $class_feed, 'check_post_status' => $check_post_status, 'target_id' => $target_id))); ?>
<div class="<?php echo $class_feed?>">
    <?php if ( $check_post_status): ?>
	    <div id="status_box" class="statusHome" style="display: none;">
			<?php  echo $this->element( 'activity_form',array('video_categories' => $video_categories, 'type'=>$subject_type,'text'=>$text,'target_id'=>$target_id)); ?>
			<div class="clear"></div>
	    </div>
    <?php endif; ?>

    <?php if(in_array($this->request->params['controller'], array('home', 'users'))):?>
        <div id="stories_widget">
            <?php $this->getEventManager()->dispatch(new CakeEvent('View.Element.afterRenderActivityForm', $this, array()));?>
        </div>
    <?php endif; ?>
    
    <div id="list-content" class="feed-entry-lists">
        <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
        <?php echo $this->element('activities', array('check_post_status' => $check_post_status, 'bIsACtivityloadMore' => $bIsACtivityloadMore, 'more_url' => $url_more,'activity_likes'=>$activity_likes,'activities'=>$activities, 'admins' => $admins)); ?>
        <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
        <?php echo $this->element('activities_chrono', array('check_post_status' => $check_post_status, 'bIsACtivityloadMore' => $bIsACtivityloadMore, 'more_url' => $url_more,'activity_likes'=>$activity_likes,'activities'=>$activities, 'admins' => $admins)); ?>
        <?php endif; ?>
    </div>
</div>