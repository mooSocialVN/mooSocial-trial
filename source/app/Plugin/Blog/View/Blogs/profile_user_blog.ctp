<div id="profile_blogs">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Blogs')?></h1>
                <div class="box_action">
                    <?php if ($user_id == $uid): ?>
                    <a class="box-btn btn-header_icon box-add" href="<?php echo $this->request->base ?>/blogs/create" title="<?php echo __('Write New Entry')?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'list-view') ); ?>
            <div id="list-content" class="core-lists blog-lists list-view">
                <?php echo $this->element('lists/blogs_list', array('user_blog' => true)); ?>
            </div>
        </div>
    </div>
</div>