<div class="content_center_home">
    <div class="box_header">
        <div class="box_header_main">
            <?php $title = __('My Blog'); ?>
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis" header-title="<?php echo $title?>"><?php echo $title?></h1>
            <div class="box_action">
                <?php if (!empty($uid)): ?>
                    <a class="box-btn btn-header_icon box-add box-scrolling-hide" href="<?php echo $this->request->base?>/blogs/create" title="<?php echo __('Write New Entry')?>">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div id="list-content" class="core-lists blog-lists list-view">
            <?php echo $this->element('lists/blogs_list', array('user_blog' => true)); ?>
        </div>
    </div>
</div>