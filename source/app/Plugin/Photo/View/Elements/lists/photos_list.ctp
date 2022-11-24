<?php if (Configure::read('Photo.photo_enabled') == 1): ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
$is_tag = isset($is_tag) ? $is_tag : false;

if (!empty($photos) && count($photos) > 0)
{
	if ( empty($page) || $page == 1 )
		if ( !empty( $type ) && $type == 'Group_Group' || !empty( $param ) )
			echo '<div class="photo-lists p_photos2" id="list-content">';
		else
			echo '<div class="photo-lists" id="list-content">';
	
	foreach ($photos as $photo):
?>
        <?php $is_theater = Configure::read('core.photo_theater_mode'); ?>
        <?php if (empty($is_theater)): ?>
        <div class="photo-item" >
            <div class="photo-item-warp">
                <a class="layer_square" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '150_square'));?>);" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>#content" id="layer_square_<?php echo $photo['Photo']['id']?>"></a>

                <?php if (!empty($profileUserPhoto)): ?>
                    <?php if ($photo['PhotoTag']['user_id'] == $uid || !empty($cuser['Role']['is_admin'] )): ?>
                        <div class="list_option">
                            <div class="dropdown">
                                <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li><a onclick="$(this).parents('.photoItem:first').fadeOut(1000);mooAjax('<?php echo $this->request->base?>/photos/ajax_remove_tag', 'post', {'tag_id' : <?php echo $photo['PhotoTag']['id']?>}, function(data) {})" href="javascript:void(0)" ><?php echo __( 'Remove Tag')?></a></li>
                                    <li>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "reports",
                                                "action" => "ajax_create",
                                                "plugin" => false,
                                                'photo_photo',
                                                $photo['Photo']['id']
                                            )),
                                            'title' => __( 'Report Photo'),
                                            'innerHtml'=> __( 'Report Photo'),
                                            'data-backdrop' => 'static'
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
            <?php $this->Html->rating($photo['Photo']['id'],'photos','Photo'); ?>
        </div>
    <?php else: ?>
        <div class="photo-item" >
            <div class="photo-item-warp">
                <a class="layer_square photoModal" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '150_square'));?>);" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?><?php if ($is_tag) echo '?uid='.$tag_uid;?>" id="layer_square_modal_<?php echo $photo['Photo']['id']?>"></a>

                <?php if (!empty($profileUserPhoto)): ?>
                    <?php if ($photo['PhotoTag']['user_id'] == $uid || !empty($cuser['Role']['is_admin'] )): ?>
                        <div class="list_option">
                            <div class="dropdown">
                                <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                                    <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <li><a onclick="$(this).parents('.photoItem:first').fadeOut(1000);mooAjax('<?php echo $this->request->base?>/photos/ajax_remove_tag', 'post', {'tag_id' : <?php echo $photo['PhotoTag']['id']?>}, function(data) {})" href="javascript:void(0)" ><?php echo __( 'Remove Tag')?></a></li>
                                    <li>
                                        <?php
                                        $this->MooPopup->tag(array(
                                            'href'=>$this->Html->url(array("controller" => "reports",
                                                "action" => "ajax_create",
                                                "plugin" => false,
                                                'photo_photo',
                                                $photo['Photo']['id']
                                            )),
                                            'title' => __( 'Report Photo'),
                                            'innerHtml'=> __( 'Report Photo'),
                                            'data-backdrop' => 'static'
                                        ));
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
            <?php $this->Html->rating($photo['Photo']['id'],'photos','Photo'); ?>
        </div>
    <?php endif; ?>
<?php
	endforeach; ?>
<?php
	if ($photosAlbumCount > $page * Configure::read('Photo.photo_item_per_pages')):
?>
    <div class="clear"></div>
	<?php $this->Html->viewMore($more_url) ?>
<?php
	endif;

	if ( empty($page) || $page == 1 )
        echo '</div>';
}
else
	echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
?>

<?php endif; ?>