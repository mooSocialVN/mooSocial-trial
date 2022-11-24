<div id="profile_videos">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title text-ellipsis"><?php echo __('Videos')?></h1>
                <div class="box_action">
                    <?php if ($user_id == $uid): ?>
                        <?php
                        $this->MooPopup->tag(array(
                            'href' => $this->Html->url(array("controller" => "videos",
                                "action" => "create",
                                "plugin" => 'video',
                            )),
                            'title' => __('Share New Video'),
                            'innerHtml' => '<span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>',
                            'class' => 'box-btn btn-header_icon box-add'
                        ));
                        ?>
                        <!-- Hook for video upload -->
                        <?php $this->getEventManager()->dispatch(new CakeEvent('Video.View.Elements.uploadVideo', $this)); ?>
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