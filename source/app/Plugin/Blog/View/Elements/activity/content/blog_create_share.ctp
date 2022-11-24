<?php
    $blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
?>
<div class="activity_feed_message">
    <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <?php
        $activityModel = MooCore::getInstance()->getModel('Activity');
        $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
        $blog = MooCore::getInstance()->getItemByType($parentFeed['Activity']['item_type'], $parentFeed['Activity']['item_id']);
        ?>
        <div class="activity_feed_header">
            <div class="activity_feed_image">
                <?php echo $this->Moo->getItemPhoto(array('User' => $parentFeed['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
            </div>
            <div class="activity_feed_content">
                <div class="activity_content_head">
                    <div class="activity_author">
                        <?php echo $this->Moo->getName($parentFeed['User']) ?>
                        <?php echo __('created a new blog entry'); ?>
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
                    <a class="activity_img_thumb" href="<?php echo $blog['Blog']['moo_href']?>">
                        <img class="activity-img" src="<?php echo $blogHelper->getImage($blog, array('prefix' => '850')) ?>" />
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php echo $blog['Blog']['moo_href'] ?>"><?php echo $blog['Blog']['moo_title'] ?></a>
                    <div class="activity_item_text">
                        <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $blog['Blog']['body'])), 200, array('exact' => false)), Configure::read('Blog.blog_hashtag_enabled')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>