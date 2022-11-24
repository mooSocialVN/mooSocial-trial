<?php
$blog = $object;
$blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
?>
<div class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_header">
                <div class="activity_feed_image">
                    <?php echo $this->Moo->getItemPhoto(array('User' => $blog['User']),array( 'prefix' => '50_square', 'tooltip' => true), array('class' => 'user_avatar'))?>
                </div>
                <div class="activity_feed_content">
                    <div class="activity_content_head">
                        <div class="activity_author">
                            <?php echo $this->Moo->getName($blog['User'], true, true) ?>
                            <?php echo __('created a new blog entry'); ?>
                        </div>
                    </div>
                    <div class="feed_time">
                        <span class="feed_time-txt"><?php echo $this->Moo->getTime($blog['Blog']['created'], Configure::read('core.date_format'), $utz) ?></span>
                    </div>
                </div>
            </div>
            <div class="activity_feed_content_text">
                <div class="activity_item activity_item_share_popup">
                    <div class="activity_left">
                        <a class="activity_img_thumb" target="_blank" href="<?php echo $blog['Blog']['moo_href'] ?>">
                            <img class="activity-img" src="<?php echo $blogHelper->getImage($blog, array('prefix' => '850')) ?>" />
                        </a>
                    </div>
                    <div class="activity_right">
                        <a class="activity_item_title" target="_blank" href="<?php echo $blog['Blog']['moo_href'] ?>"><?php echo $blog['Blog']['moo_title'] ?></a>
                        <div class="activity_item_text">
                            <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $blog['Blog']['body'])), 200, array('exact' => false)), Configure::read('Blog.blog_hashtag_enabled')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>