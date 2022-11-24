<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __('My Blogs')?></h1>
            <div class="box_action">
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->Html->url(array('plugin' => 'blog', 'controller' => 'blogs', 'action' => 'create')); ?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                        <span class="btn-text hidden-xs"><?php echo __('Write New Entry')?></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="box_content content_center_home">
        <div id="list-content" class="blog-lists">
            <?php echo $this->element( 'lists/blogs_list', array('user_blog' => true) ); ?>
        </div>
    </div>
</div>