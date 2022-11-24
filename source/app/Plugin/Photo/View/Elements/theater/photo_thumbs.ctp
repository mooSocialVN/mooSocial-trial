<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery", "mooPhotoTheater"], function($, mooPhotoTheater) {
        mooPhotoTheater.initShowPhoto();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooPhotoTheater'), 'object' => array('$', 'mooPhotoTheater'))); ?>
mooPhotoTheater.initShowPhoto();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if (!empty($photos)): ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>
    <?php foreach ($photos as $key => $p): ?>
        <li photo-position="<?php echo $key + 1; ?>" id="photo_thumb_<?php echo $p['Photo']['id']?>">
            <a href="javascript:void(0)" data-thumb="0" data-id="<?php echo $p['Photo']['id']?>" class="showPhotoTheater">
                <img width="50" src="<?php echo $photoHelper->getImage($p, array('prefix' => '75_square'));?>" />
            </a>
        </li>
    <?php endforeach; ?>

<?php endif; ?>