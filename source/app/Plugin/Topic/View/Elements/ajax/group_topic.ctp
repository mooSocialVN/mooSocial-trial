<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooGroup"], function($, mooGroup) {
        mooGroup.initOnTopicList();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooGroup'), 'object' => array('$', 'mooGroup'))); ?>
mooGroup.initOnTopicList();
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<div id="group_topics" class="bar-content">
    <div class="box2 box_browse bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Topics') ?></h1>
                <div class="box_action">
                    <?php if ( !empty( $is_member ) ): ?>
                        <div class="groupId" data-id="<?php echo $group_id; ?>"></div>
                        <a href="javascript:void(0)" class="box-btn btn-header_icon box-add createGroupTopic" title="<?php echo __( 'Create New Topic')?>">
                            <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'list-view') ); ?>
            <div id="list-content" class="core-lists topic-lists list-view">
                <?php echo $this->element( 'group/topics_list' ); ?>
            </div>
        </div>
    </div>
</div>