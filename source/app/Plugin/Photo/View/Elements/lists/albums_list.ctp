<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooPhoto"], function($,mooPhoto) {
        mooPhoto.initOnListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooPhoto'), 'object' => array('$', 'mooPhoto'))); ?>
mooPhoto.initOnListing();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>


<?php if (Configure::read('Photo.photo_enabled') == 1): ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
$friendModel = MooCore::getInstance()->getModel('Friend');
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
?>

<?php
if (!empty($albums) && count($albums) > 0) {
    foreach ($albums as $album):
    	$covert = '';
    	if ($album['Album']['type'] == 'newsfeed' &&  $role_id != ROLE_ADMIN && $uid != $album['Album']['user_id'] && (!$uid || $friendModel->areFriends($uid,$album['Album']['user_id'])))  
    	{    		
	    	$photo = $photoModel->getPhotoCoverOfFeedAlbum($album['Album']['id']);
	    	if ($photo)
	    	{
	    		$covert = $photoHelper->getImage($photo, array('prefix' => '150_square'));
	    	}
	    	else
	    	{
	    		$covert = $photoHelper->getAlbumCover('', array('prefix' => '150_square'));
	    	}
    	}
    	else
    	{
    		$covert = $photoHelper->getAlbumCover($album['Album']['cover'], array('prefix' => '150_square'));
    	}
        ?>
        <div class="album-list-item">
            <div class="album-item-warp">
                <a href="<?php echo  $this->request->base ?>/albums/view/<?php echo  $album['Album']['id'] ?>/<?php echo  seoUrl($album['Album']['moo_title']) ?>" class="album_cover layer_square" style="background-image:url(<?php echo  $covert ?>)">
                    <div class="infoLayer hidden-xs hidden-sm">
                        <span class="albumlist_title"><?php echo ($this->Moo->getAlbumTitle($album['Album']['moo_title'])); ?></span>
                        <div class="albumlist_count"><span class="album_count_icon material-icons moo-icon moo-icon-perm_media">perm_media</span> <?php echo  __n('%s', '%s ', $album['Album']['photo_count'], $album['Album']['photo_count']) ?></div>
                    </div>
                </a> 
                <?php if (($album['Album']['user_id'] == $uid || !empty($cuser['Role']['is_admin'] )) && $album['Album']['type'] !='profile' && $album['Album']['type'] !='newsfeed' && $album['Album']['type'] !='cover'): ?>
                <div class="list_option">
                    <div class="dropdown">
                        <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false">
                            <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                        </button>
                        
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li>
                            <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "albums", "action" => "create", "plugin" => 'photo', $album['Album']['id'])),
                                    'title' => __( 'Edit Album'),
                                    'innerHtml'=> __( 'Edit Album'),
                                    'data-backdrop' => 'static'
                                ));
                            ?>
                           </li>
                            <?php if($album['Album']['type'] != 'cover'): ?>
                            <li><a href="javascript:void(0);" class="deleteAlbum" data-id="<?php echo $album['Album']['id']?>"><?php echo __( 'Delete Album')?></a></li>
                            <?php endif; ?>
                            <li><a href="<?php echo $this->request->base?>/albums/edit/<?php echo $album['Album']['id']?>"><?php echo __( 'Edit Photos')?></a></li>
                        </ul>
                        
                    </div>
                </div>
                <?php endif; ?>
                <div class="album_info">
                    <a class="album_title" href="<?php echo $this->request->base ?>/albums/view/<?php echo  $album['Album']['id'] ?>/<?php echo  seoUrl($album['Album']['moo_title']) ?>"><?php echo ($this->Text->truncate($album['Album']['moo_title'], 25, array('exact' => false))) ?></a>
                    <div class="album_count"><?php echo __n('%s photo', '%s photos', $album['Album']['photo_count'], $album['Album']['photo_count']) ?></div>
                </div>

            </div>
            <?php $this->Html->rating($album['Album']['id'], 'albums', 'Photo'); ?>
        </div>
        <?php
    endforeach;
} else
    echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
?>

<?php if (!empty($album_more_result)): ?>
    <?php $this->Html->viewMore($album_more_url,'album-list-content') ?>
<?php endif; ?>

<?php endif; ?>
