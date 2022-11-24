<?php
    $had_comment_message = (!empty($had_comment_message)) ? $had_comment_message : 0;
  
?>

<?php
$ids = explode(',', $activity['Activity']['items']);
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
$photos_total = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids)));
$photos = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids),
    'limit' => 4
        ));
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

<?php if(empty($had_comment_message)): ?>
<div class="comment_message">
<?php //echo $this->viewMore(h($activity['Activity']['content']),null, null, null, true, array('no_replace_ssl' => 1)); ?>
    <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
</div>
<?php endif; ?>

<?php if (count($photos)):?>
	<?php $c = count($photos);?>
    <div class="activity_item_photo p_photos photo_addlist">
	    <?php if($c == 1): ?>
	        <?php foreach ( $photos as $key => $photo ): ?>
	            <div class="div_single">
                            
	                    <a  class=""  >
	                        <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>" alt="" />
	                    </a>	   
	               
	            </div>					
	        <?php endforeach; ?>
	    <?php elseif ($c==2): ?>
	        <?php foreach ( $photos as $key => $photo ): ?>
	            <div class="col-xs-6 photoAdd2File">
	                <div class="p_2">
	                    <a class="layer_square " style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '450'));?>);"  ></a>
	                </div>
	            </div>					
	        <?php endforeach; ?>
	    <?php elseif ($c==3): ?>
	          <?php foreach ( $photos as $key => $photo ): ?>
	            <?php if($key == 0): ?>   
	            <div class="PE">
	                <div class="ej">
	                    <a class="layer_square " style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>)" >
	                        
	                    </a>	   
	                </div>
	            </div>
	            <?php else: ?>
	                <?php if($key == 1): ?>
	                <div class="QE">
	                <?php endif; ?> 
	                    <div class="sp <?php if($key == 2): ?>eq<?php endif; ?>">
	                        <a class="layer_square "  >
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
	                    <a class=""  style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850'));?>)" >
	                        
	                    </a>	   
	                </div>
	            </div>
	            <?php else: ?>
	                <?php if($key == 1): ?>
	                <div class="QE">
	                <?php endif; ?> 
	                    <div class="sp1 <?php if($key == 2): ?>eq1<?php endif; ?>">
                                 
	                        <a class="layer_square "  >
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