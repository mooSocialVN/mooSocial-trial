<?php
$group = $object;
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
?>
<div class="feed-entry-item">
    <div class="feed-entry-warp">
        <div class="feed_main_info">
            <div class="activity_feed_content_text">
                <div class="activity_item activity_item_share_popup">
                    <div class="activity_left">
                        <a class="activity_img_thumb" target="_blank" href="<?php echo $group['Group']['moo_href'] ?>">
                            <img class="activity-img" src="<?php echo $groupHelper->getImage($group, array('prefix' => '850')) ?>">
                        </a>
                    </div>
                    <div class="activity_right">
                        <a class="activity_item_title" target="_blank" href="<?php echo $group['Group']['moo_href'] ?>"><?php echo $group['Group']['moo_title'] ?></a>
                        <div class="activity_item_text">
                            <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $group['Group']['description'])), 200, array('exact' => false)), Configure::read('Group.group_hashtag_enabled')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>