<?php if (!empty($photos)): ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>
    <?php foreach ($photos as $p): ?>
        <li id="photo_thumb_<?php echo $p['Photo']['id']?>">
            <a href="javascript:void(0)" data-id="<?php echo $p['Photo']['id']?>" class="showPhoto">
                <img width="50" src="<?php echo $photoHelper->getImage($p, array('prefix' => '75_square'));?>" />
            </a>
        </li>
    <?php endforeach; ?>

    <?php if ($photosAlbumCount > $page * Configure::read('Photo.photo_item_per_pages')):?>
        <li class="viewmore-photo">
            <a id="photo_load_btn" href="javascript:void(0)"><span class="viewmore-photo-icon material-icons moo-icon moo-icon-more_vert">more_vert</span></a>
        </li>
    <?php endif; ?>

<?php endif; ?>