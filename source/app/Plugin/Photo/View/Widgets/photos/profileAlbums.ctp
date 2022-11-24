<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
$friendModel = MooCore::getInstance()->getModel('Friend');
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');

if(empty($title)) $title = __("Album Photo");
if(isset($title_enable)&&($title_enable)=== "") $title_enable = false; else $title_enable = true;
?>


<?php if (Configure::read('Photo.photo_enabled') && isset($canView) && $canView): ?>
<?php if (!empty($albums)): ?>
<div class="bar-content full_content p_m_10 ">
    <div class="content_center">
    	<?php if ($title_enable):?>
        <h2><?php echo $title?></h2>
        <?php endif;?>
        <ul class="photo-list">
        <?php foreach ($albums as $album): ?>
        	<?php
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
                <li class="photoItem">
                    <div class="p_2">
                         <a class="layer_square" style="background-image:url(<?php echo $covert?>);" href="<?php echo $this->request->base?>/albums/view/<?php echo $album['Album']['id']?>"></a>
                    </div>
                </li>
        <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
        </div>
</div>
<?php endif; ?>
<?php endif; ?>