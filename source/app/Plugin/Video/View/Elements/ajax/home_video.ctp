<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __('My Videos')?></h1>
            <div class="box_action">
                <?php
                $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "videos",
                        "action" => "create",
                        "plugin" => 'video'
                    )),
                    'title' => __( 'Share New Video'),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span><span class="btn-text hidden-xs">'.__( 'Share New Video').'</span></span>',
                    'class' => 'box-btn btn btn-header_title btn-cs'
                ));
                ?>
                <!-- Hook for video upload -->
                <?php $this->getEventManager()->dispatch(new CakeEvent('Video.View.Elements.uploadVideo', $this)); ?>
                <!-- Hook for video upload -->
            </div>
        </div>
    </div>
    <div class="box_content content_center_home">
        <div id="list-content" class="video-lists">
            <?php echo $this->element( 'lists/videos_list' ); ?>
        </div>
    </div>
</div>