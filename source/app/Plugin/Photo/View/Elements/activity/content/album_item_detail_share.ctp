<?php
$albumModel = MooCore::getInstance()->getModel('Photo_Album');
$friendModel = MooCore::getInstance()->getModel('Friend');
$album = $albumModel->findById($activity['Activity']['parent_id']);
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
$photos_total = $photoModel->find('all', array('conditions' => array('Photo.type' => 'Photo_Album', 'Photo.target_id' => $album['Album']['id'])));
$photos = $photoModel->find('all', array('conditions' => array('Photo.type' => 'Photo_Album', 'Photo.target_id' => $album['Album']['id']),
    'limit' => 4
        ));
$cover = '';
if ($album['Album']['type'] == 'newsfeed' && $role_id != ROLE_ADMIN && $uid != $album['Album']['user_id'] && (!$uid || $friendModel->areFriends($uid, $album['Album']['user_id']))) {
    $photo = $photoModel->getPhotoCoverOfFeedAlbum($album['Album']['id']);
    if ($photo) {
        $cover = $photoHelper->getImage($photo, array('prefix' => '850'));
    } else {
        $cover = $photoHelper->getAlbumCover('', array('prefix' => '850'));
    }
} else {
    $cover = $photoHelper->getAlbumCover($album['Album']['cover'], array('prefix' => '850'));
}
?>


    <div class="activity_feed_message">
        <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
        <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
    </div>

<div class="share-content">
    <div class="album-info">
        <div class="album-title">
            <a href="<?php echo $album['Album']['moo_href']; ?>"><?php echo $album['Album']['moo_title']; ?></a>
        </div>
        <div class="album-desc">
            <?php echo $album['Album']['description']; ?>
        </div>
        <div class="album-cover">
            <?php if (count($photos)):?>
	<?php $c = count($photos);?>            
    <div class="activity_item_photo p_photos photo_addlist">
	    <?php if($c == 1): ?>
	        <?php foreach ( $photos as $key => $photo ): ?>
	            <div class="div_single">
                            
	                    <a target="_blank" href="<?php echo $photo['Photo']['moo_href']?>" class="photoModal">
	                        <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>" alt="" />
	                    </a>	   
	               
	            </div>					
	        <?php endforeach; ?>
	    <?php elseif ($c==2): ?>
	        <?php foreach ( $photos as $key => $photo ): ?>
	            <div class="col-xs-6 photoAdd2File">
	                <div class="p_2">
	                    <a target="_blank" class="layer_square photoModal" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '450'));?>);" href="<?php echo $photo['Photo']['moo_href']?>"></a>	   
	                </div>
	            </div>					
	        <?php endforeach; ?>
	    <?php elseif ($c==3): ?>
	          <?php foreach ( $photos as $key => $photo ): ?>
	            <?php if($key == 0): ?>   
	            <div class="PE">
	                <div class="ej">
	                    <a target="_blank" class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href']?>" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>)">
	                        
	                    </a>	   
	                </div>
	            </div>
	            <?php else: ?>
	                <?php if($key == 1): ?>
	                <div class="QE">
	                <?php endif; ?> 
	                    <div class="sp <?php if($key == 2): ?>eq<?php endif; ?>">
	                        <a target="_blank" class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href']?>">
	                            <img src="<?php echo $photoHelper->getImage($photo, array('prefix' => '300_square'));?>" alt="" />
	                        </a>	   
	                    </div>
	                <?php if($key == 1): ?>
	                
	                <?php endif; ?>   
	            <?php endif; ?>
	        <?php endforeach; ?>  
	        </div>
	    <?php elseif ($c==4): ?>   
	        <?php foreach ( $photos as $key => $photo ): ?>
	           <?php if($key == 0): ?>   
	            <div class="PE">
	                <div class="ej1">
	                    <a target="_blank" class="photoModal" href="<?php echo $photo['Photo']['moo_href']?>" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>)">
	                        
	                    </a>	   
	                </div>
	            </div>
	            <?php else: ?>
	                <?php if($key == 1): ?>
	                <div class="QE">
	                <?php endif; ?> 
	                    <div class="sp1 <?php if($key == 2): ?>eq1<?php endif; ?>">
                                 
	                        <a target="_blank" class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href']?>">
	                            <?php if ($key == 3 && count($photos_total) > 4): ?>
                                    <div class="photo-add-more">
                                        <div>
                                            +<?php echo count($photos_total) - 4; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <img src="<?php echo $photoHelper->getImage($photo, array('prefix' => '300_square'));?>" alt="" />
	                        </a>	   
	                    </div>
	            <?php endif; ?>
	            
	        <?php endforeach; ?> 
	        </div>
	    <?php endif; ?>
	</div>
<?php endif;?>
        </div>
        
    </div>
</div>

