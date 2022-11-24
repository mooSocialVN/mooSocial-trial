<?php
$ids = explode(',', $activity['Activity']['items']);
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
$photos_total = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids)));
$photos = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids),
    'limit' => 4
        ));
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

    <div class="activity_feed_message">
        <?php echo $this->viewMore(h($activity['Activity']['content']), null, null, null, true, array('no_replace_ssl' => 1)); ?>
        <?php if(!empty($activity['UserTagging']['users_taggings'])) $this->MooPeople->with($activity['UserTagging']['id'], $activity['UserTagging']['users_taggings']); ?>
    </div>


<div class="share-content">
    <?php
    $activityModel = MooCore::getInstance()->getModel('Activity');
    $parentFeed = $activityModel->findById($activity['Activity']['parent_id']);
    ?>
    <div class="activity_feed_content">
     
    <div class="activity_text">
        <?php echo $this->Moo->getName($parentFeed['User']) ?>
        <?php if ($parentFeed['Activity']['target_id']): ?>
            <?php
            $subject = MooCore::getInstance()->getItemByType($parentFeed['Activity']['type'], $parentFeed['Activity']['target_id']);
            $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);
            $name = key($subject);
            ?>
            <?php if ($show_subject): ?>
                &rsaquo; <a href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo $subject[$name]['moo_title'] ?></a>
            <?php else: ?>

                <?php $number = count(explode(',', $parentFeed['Activity']['items'])); ?>
                <?php
                if ($number > 1) {
                    echo __('added %s new photos', $number);
                } else {
                    echo __('added %s new photo', $number);
                }
                ?>
            <?php endif; ?>
        <?php else: ?>
            <?php list($plugin, $name) = mooPluginSplit($parentFeed['Activity']['item_type']); ?>
            <?php if ($object): ?>		
                <?php $number = count(explode(',', $parentFeed['Activity']['items'])); ?>
                <?php
                if ($number > 1) {
                    echo __('added %s new photos to album', $number);
                } else {
                    echo __('added %s new photo to album', $number);
                }
                ?> <a href="<?php echo $object[$name]['moo_href']; ?>"><?php echo $object[$name]['moo_title'] ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="parent_feed_time">
        <span class="date"><?php echo $this->Moo->getTime($parentFeed['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
    </div>
    
    </div>
     <div class="clear"></div>
    <?php if (count($photos)): ?>
        <?php $c = count($photos); ?> 
        <div class="activity_feed_content_text">           
        <div class="activity_item_photo p_photos photo_addlist">
            <?php if ($c == 1): ?>
                <?php foreach ($photos as $key => $photo): ?>
                    <div class="div_single">

                        <a href="<?php echo $photo['Photo']['moo_href'] ?>" class="photoModal">
                            <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>" alt="" />
                        </a>	   

                    </div>					
                <?php endforeach; ?>
            <?php elseif ($c == 2): ?>
                <?php foreach ($photos as $key => $photo): ?>
                    <div class="col-xs-6 photoAdd2File">
                        <div class="p_2">
                            <a class="layer_square photoModal" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '450')); ?>);" href="<?php echo $photo['Photo']['moo_href'] ?>"></a>	   
                        </div>
                    </div>					
                <?php endforeach; ?>
            <?php elseif ($c == 3): ?>
                <?php foreach ($photos as $key => $photo): ?>
                    <?php if ($key == 0): ?>   
                        <div class="PE">
                            <div class="ej">
                                <a class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href'] ?>" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>)">

                                </a>	   
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($key == 1): ?>
                            <div class="QE">
                            <?php endif; ?> 
                            <div class="sp <?php if ($key == 2): ?>eq<?php endif; ?>">
                                <a class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href'] ?>">
                                    <img src="<?php echo $photoHelper->getImage($photo, array('prefix' => '300_square')); ?>" alt="" />
                                </a>	   
                            </div>
                            <?php if ($key == 1): ?>

                            <?php endif; ?>   
                        <?php endif; ?>
                    <?php endforeach; ?>  
                </div>
            <?php elseif ($c == 4): ?>   
                <?php foreach ($photos as $key => $photo): ?>
                    <?php if ($key == 0): ?>   
                        <div class="PE">
                            <div class="ej1">
                                <a class="photoModal" href="<?php echo $photo['Photo']['moo_href'] ?>" style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>)">

                                </a>	   
                            </div>
                        </div>
                    <?php else: ?>
                        <?php if ($key == 1): ?>
                            <div class="QE">
                            <?php endif; ?> 
                            <div class="sp1 <?php if ($key == 2): ?>eq1<?php endif; ?>">

                                <a class="layer_square photoModal" href="<?php echo $photo['Photo']['moo_href'] ?>">
                                    <?php if ($key == 3 && count($photos_total) > 4): ?>
                                        <div class="photo-add-more">
                                            <div>
                                                +<?php echo count($photos_total) - 4; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <img src="<?php echo $photoHelper->getImage($photo, array('prefix' => '300_square')); ?>" alt="" />
                                </a>	   
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?> 
                </div>
            <?php endif; ?>
        </div>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>