<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooResponsive"], function($, mooResponsive) {
        mooResponsive.init();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooResponsive'), 'object' => array('$', 'mooResponsive'))); ?>
mooResponsive.init();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
$ids = explode(',', $activity['Activity']['items']);
$photoModel = MooCore::getInstance()->getModel('Photo_Photo');
$photos_total = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids)));
$photos = $photoModel->find('all', array('conditions' => array('Photo.id' => $ids),
    'limit' => 4
        ));
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

    <div class="activity_feed_content">
    
    <div class="activity_text">
        <?php echo $this->Moo->getName($activity['User'], true, true) ?>
        <?php if ($activity['Activity']['target_id']): ?>
            <?php
            $subject = MooCore::getInstance()->getItemByType($activity['Activity']['type'], $activity['Activity']['target_id']);
            $show_subject = MooCore::getInstance()->checkShowSubjectActivity($subject);
            $name = key($subject);
            ?>
            <?php if ($show_subject): ?>
                &rsaquo; <a target="_blank" href="<?php echo $subject[$name]['moo_href'] ?>"><?php echo ($subject[$name]['moo_title']) ?></a>
            <?php else: ?>

                <?php $number = count(explode(',', $activity['Activity']['items'])); ?>
                <?php
                if ($number > 1) {
                    echo __('added %s new photos', $number);
                } else {
                    echo __('added %s new photo', $number);
                }
                ?>
            <?php endif; ?>
        <?php else: ?>
            <?php list($plugin, $name) = mooPluginSplit($activity['Activity']['item_type']); ?>
            <?php if ($object): ?>		
                <?php $number = count(explode(',', $activity['Activity']['items'])); ?>
                <?php
                if ($number > 1) {
                    echo __('added %s new photos to album', $number);
                } else {
                    echo __('added %s new photo to album', $number);
                }
                ?> <a target="_blank" href="<?php echo $object[$name]['moo_href']; ?>"><?php echo ($object[$name]['moo_title']) ?></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="parent_feed_time">
        <span class="date"><?php echo $this->Moo->getTime($activity['Activity']['created'], Configure::read('core.date_format'), $utz) ?></span>
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

                    <a target="_blank" class="">
                        <img class="single_img" src="<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>" alt="" />
                    </a>	   

                </div>					
            <?php endforeach; ?>
        <?php elseif ($c == 2): ?>
            <?php foreach ($photos as $key => $photo): ?>
                <div class="col-xs-6 photoAdd2File">
                    <div class="p_2">
                        <a target="_blank" class="layer_square " style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '450')); ?>);" ></a>	   
                    </div>
                </div>					
            <?php endforeach; ?>
        <?php elseif ($c == 3): ?>
            <?php foreach ($photos as $key => $photo): ?>
                <?php if ($key == 0): ?>   
                    <div class="PE">
                        <div class="ej">
                            <a target="_blank" class="layer_square " style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>)">

                            </a>	   
                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($key == 1): ?>
                        <div class="QE">
                        <?php endif; ?> 
                        <div class="sp <?php if ($key == 2): ?>eq<?php endif; ?>">
                            <a target="_blank" class="layer_square " >
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
                            <a target="_blank" class=""  style="background-image:url(<?php echo $photoHelper->getImage($photo, array('prefix' => '850')); ?>)">

                            </a>	   
                        </div>
                    </div>
                <?php else: ?>
                    <?php if ($key == 1): ?>
                        <div class="QE">
                        <?php endif; ?> 
                        <div class="sp1 <?php if ($key == 2): ?>eq1<?php endif; ?>">

                            <a target="_blank" class="layer_square " >
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