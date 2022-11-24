<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <?php $title = __('My Videos'); ?>
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis" header-title="<?php echo $title?>"><?php echo $title?></h1>
            <div class="box_action">
                <?php
                $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "videos", "action" => "create", "plugin" => 'video')),
                    'title' => __( 'Share New Video'),
                    'innerHtml'=> '<span class="box-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>',
                    'data-backdrop' => 'static',
                    'class' => 'box-btn btn-header_icon box-add box-scrolling-hide'
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div id="list-content" class="core-lists video-lists grid-view">
            <?php echo $this->element('lists/videos_list'); ?>
        </div>
    </div>
</div>