<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <?php $title = __('My Groups'); ?>
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis"><?php echo $title?></h1>
            <div class="box_action">
                <?php if (!empty($uid)): ?>
                    <a class="box-btn btn-header_icon box-add box-scrolling-hide" href="<?php echo $this->request->base?>/groups/create" title="<?php echo __( 'Create New Group')?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div id="list-content" class="core-lists group-lists list-view">
            <?php echo $this->element('lists/groups_list'); ?>
        </div>
    </div>
</div>