<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __('My Photos')?></h1>
            <div class="box_action">
                <?php $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array("controller" => "albums",
                        "action" => "create",
                        "plugin" => 'photo',
                    )),
                    'title' => __( 'Create New Album'),
                    'innerHtml'=> '<span class="btn-cs-main"><span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span><span class="btn-text hidden-xs">'.__( 'Create New Album').'</span></span>',
                    'class' => 'box-btn btn btn-header_title btn-cs'
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="box_content content_center_home">
        <div id="album-list-content" class="album-lists">
            <?php echo $this->element('lists/albums_list'); ?>
        </div>
    </div>
</div>