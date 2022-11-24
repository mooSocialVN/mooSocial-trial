<?php //echo $this->element('browse_tabs')?>
<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis" header-title="<?php echo __('My Photos') ?>"><?php echo __('My Photos') ?></h1>
            <div class="box_action">
                <?php
                $this->MooPopup->tag(array(
                    'href' => $this->Html->url(array("controller" => "albums", "action" => "create", "plugin" => 'photo')),
                    'title' => __('Create New Album'),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span> <span class="btn-text">'.__( 'Create New Album').'</span></span>',
                    'class' => 'box-btn btn btn-header_title btn-cs',
                ));
                ?>
            </div>
        </div>
    </div>

    <div class="box_content">
        <div id="album-list-content" class="album-lists">
            <?php echo $this->element('lists/albums_list'); ?>
        </div>
    </div>
</div>