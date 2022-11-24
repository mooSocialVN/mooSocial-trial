<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($, mooGroup) {
        mooGroup.initTabPhoto1();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initTabPhoto1();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
	$group = MooCore::getInstance()->getItemByType('Group_Group',$target_id);
	$is_member = $this->Group->checkPostStatus($group,$uid);

?>
<div id="group_photos" class="bar-content">
    <div class="box2 box_browse bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Photos') ?></h1>
                <div class="box_action">
                    <?php if ( !empty( $is_member ) ){?>
                    <a class="box-btn btn-header_icon box-add groupUploadPhoto" href="javascript:void(0)" data-group-id="<?php echo $target_id; ?>" title="<?php echo __('Upload Photos');?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <!--<div class="<?php //if ( !empty( $is_member ) ): ?> p_top_15<?php //endif; ?>">-->
            <?php  echo $this->element( 'lists/photos_list', array('plugin'=>'Photo' ) );?>
            <!--</div>-->
        </div>
    </div>
</div>