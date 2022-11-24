<?php

$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __( 'Joined Groups')?></div>
</div>

<div class="modal-body">
    <div class="activity_feed_content_text">
    <?php foreach ( $groups as $group ): ?>
        <div class="activity_list_items">
            <div class="activity_item">
                <div class="activity_left">
                    <a class="activity_img_thumb" href="<?php echo $group['Group']['moo_href']?>">
                        <img class="activity-img" src="<?php echo $groupHelper->getImage($group, array('prefix' => '850'))?>"/>
                    </a>
                </div>
                <div class="activity_right">
                    <a class="activity_item_title" href="<?php echo $group['Group']['moo_href']?>"><?php echo $group['Group']['moo_title']?></a>
                    <div class="activity_item_text">
                        <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>', '&nbsp;'), array(' ', ''), $group['Group']['description'])), 125, array('exact' => false)), Configure::read('Group.group_hashtag_enabled')) ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>
