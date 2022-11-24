<?php if (Configure::read('Photo.photo_enabled') == 1): ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
if(empty($title)) $title = "Popular Albums";
if(empty($num_item_show)) $num_item_show = 10;
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;

?>
<?php if (!empty($popular_albums)):?>
<div class="box2 bar-content-warp">
    <?php if($title_enable): ?>
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title">
                <?php echo $title; ?>
            </h3>
        </div>
    </div>
    <?php endif; ?>
    <div class="box_content box_popular-album box-region-<?php echo $region ?>">
        <div class="album-box-lists">
            <?php foreach ($popular_albums as $album): ?>
                <div class="album-box-item">
                    <div class="album-box-item-warp">
                        <a class="album-box-item-cover" href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>/<?php echo seoUrl($album['Album']['moo_title'])?>">
                            <div class="album-box-item-figure">
                                <img class="album-box-item-img" src="<?php echo $photoHelper->getAlbumCover($album['Album']['cover'], array('prefix' => '150_square')); ?>" alt="<?php echo ($album['Album']['moo_title'])?>" />
                            </div>
                            <div class="album-box-item-title">
                                <?php echo ($album['Album']['moo_title'])?>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>