<?php
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
$photo = $photoModel->findById($activity['Activity']['parent_id']);
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>


    <div class="activity_feed_message">
        <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
        <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
    </div>

<div class="share-content">
    <div class="activity_item_photo p_photos photo_addlist">
        <div class="div_single">
            <a href="<?php echo $photo['Photo']['moo_href'] ?>" class="photoModal"  >
                <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>" alt="" />
            </a>	   
        </div>
    </div>
</div>

