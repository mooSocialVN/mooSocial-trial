<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($,mooGroup) {
        mooGroup.initOnAjaxGroupVideo();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initOnAjaxGroupVideo();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div id="group_videos" class="bar-content">
    <div class="box2 box_browse bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Videos') ?></h1>
                <div class="box_action">
                    <?php if (!empty($is_member)): ?>
                        <a id="share-new" class="box-btn btn-header_icon box-add" data-target="#videoModal" data-toggle="modal" data-id="<?php echo $group_id?>" data-url="<?php echo $this->request->base ?>/videos/group_create" title="<?php echo __('Share New Video') ?>">
                            <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                        </a>

                        <!-- Hook for video upload -->
                        <?php $this->getEventManager()->dispatch(new CakeEvent('Video.View.Elements.groupUploadVideo', $this, array('group_id' => $group_id))); ?>
                        <!-- Hook for video upload -->
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
            <div id="list-content" class="core-lists video-lists grid-view">
                <?php echo $this->element('lists/videos_list'); ?>
            </div>
        </div>
    </div>
</div>

<section aria-hidden="true" aria-labelledby="myModalLabel" role="basic" id="videoModal" class="modal fade in" >
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</section>