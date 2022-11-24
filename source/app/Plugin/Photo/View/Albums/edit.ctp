<?php $this->setCurrentStyle(4) ?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooPhoto'), 'object' => array('$', 'mooPhoto'))); ?>
mooPhoto.initOnEditAlbum();
<?php $this->Html->scriptEnd(); ?> 

<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo ($album['Album']['moo_title'])?></h1>
                <div class="box_action">
                    <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>">
                        <span class="btn-cs-main">
                            <span class="btn-icon material-icons moo-icon moo-icon-list_alt">list_alt</span>
                            <span class="btn-text hidden-xs"><?php echo __( 'View Album')?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="box_content">
            <div class="create_form">
                <form action="<?php echo $this->request->base?>/albums/edit/<?php echo $album['Album']['id']?>" method="post">
                    <?php echo $this->Form->hidden('id', array('value' => $album['Album']['id'])); ?>
                        <?php
                        if (count($photos) == 0):
                            echo __( 'No photos found');
                        else:
                            ?>
                            <div class="row photos_edit">
                                <?php foreach ($photos as $photo): ?>
                                    <div class="col-md-3">
                                        <div class="albums_edit_item">
                                            <input type="checkbox" id="select_<?php echo $photo['Photo']['id']?>" name="select_<?php echo $photo['Photo']['id'] ?>" value="1" class="photo_edit_checkbox" >
                                            <div class="albums_edit_item-warp">
                                                <label class="albums_photo_edit" for="select_<?php echo $photo['Photo']['id'] ?>" style="background-image: url(<?php echo $photoHelper->getImage($photo, array('prefix' => '250'));?>)"></label>
                                                <div class="album_info_edit">
                                                    <div class="album_edit_caption">
                                                        <?php echo $this->Form->textarea('caption_' . $photo['Photo']['id'], array('value' => $photo['Photo']['caption'], 'placeholder' => __( 'Caption'), 'class' => 'form-control no-grow')) ?>
                                                    </div>
                                                    <label class="radio-control">
                                                        <?php echo __( 'Album cover')?>
                                                        <input type="radio" name="cover" value="<?php echo $photo['Photo']['thumbnail']?>" <?php if ($photo['Photo']['thumbnail'] == $album['Album']['cover']) echo 'checked'; ?>>
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    <div class="photos_edit_select">
                        <div class="form-inline">
                            <div class="form-group">
                                <?php echo $this->Form->select('select_photos', array('move' => __( 'Move to'), 'delete' => __( 'Delete') ), array( 'empty' => __( 'With selected...'), 'class' => 'form-control' ) ); ?>
                            </div>
                            <div id="album_id_select" class="form-group hidden">
                            	<?php 
                            		foreach ($albums as &$album1)
                            			$album1 = html_entity_decode($album1);
                            	?>
                                <?php echo $this->Form->select('album_id', $albums, array( 'class' => 'form-control' ) ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="photos_edit_action">
                        <input class="btn btn-primary" type="submit" value="<?php echo __( 'Save Changes')?>">
                        <?php if ( empty( $album['Album']['type'] ) ): ?>
                            <input class="btn btn-danger deleteAlbum" type="button" value="<?php echo __( 'Delete Album')?>" data-id="<?php echo $album['Album']['id']?>">
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>