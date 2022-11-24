<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __('My Groups')?></h1>
            <div class="box_action">
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->request->base?>/groups/create">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                        <span class="btn-text hidden-xs"><?php echo __('Create New Group')?></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="box_content content_center_home">
        <div id="list-content" class="group-lists">
            <?php echo $this->element( 'lists/groups_list' ); ?>
        </div>
    </div>
</div>