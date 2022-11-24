<div id="profile_topics">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title text-ellipsis"><?php echo __('Topics')?></h1>
                <div class="box_action">
                    <?php if ($user_id == $uid): ?>
                    <a class="box-btn btn-header_icon box-add" href="<?php echo  $this->request->base ?>/topics/create" title="<?php echo  __('Create New Topic') ?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'list-view') ); ?>
            <div id="list-content" class="core-lists topic-lists list-view">
                <?php echo $this->element('lists/topics_list'); ?>
            </div>
        </div>
    </div>
</div>