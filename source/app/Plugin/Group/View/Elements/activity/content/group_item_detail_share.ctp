<?php 
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
$groupModel = MooCore::getInstance()->getModel('Group_Group');
$group = $groupModel->findById($activity['Activity']['parent_id']);
?>

<div class="activity_feed_message">
<?php echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1)); ?>
<?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<div class="activity_item">
    <div class="share-content">
        <div class="activity_feed_content_text">
            <div class="activity_item">
                <div class="activity_left">
                    <a class="activity_img_thumb" href="<?php echo $group['Group']['moo_href']?>">
                        <img class="activity-img" src="<?php echo $groupHelper->getImage($group, array('prefix' => '850'))?>">
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php echo $group['Group']['moo_href']?>"><?php echo $group['Group']['moo_title']?></a>
                    <div class="activity_item_text">
                        <?php echo  $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $group['Group']['description'])), 200, array('exact' => false)), Configure::read('Group.group_hashtag_enabled')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>