<?php
$photo = $object;

$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

<div class="activity_feed_message">
    <?php echo $this->viewMore(h($photo['Photo']['caption']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>

<div class="activity_item_photo p_photos photo_addlist">
    <div class="div_single">
        <a target="_blank" class=""  >
            <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>" alt="" />
        </a>	   
    </div>
</div>