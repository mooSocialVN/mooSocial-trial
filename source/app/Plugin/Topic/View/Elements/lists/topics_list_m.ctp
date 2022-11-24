<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <?php $title = __('My Topics'); ?>
            <h1 id="PageHeaderTitle" class="box_header_title text-ellipsis"><?php echo $title?></h1>
            <div class="box_action">
                <?php if (!empty($uid)): ?>
                    <?php echo $this->Html->link('<span class="box-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>', array(
                        'plugin' => 'Topic',
                        'controller' => 'topics',
                        'action' => 'create'
                    ), array(
                        'title' => __('Create New Topic'),
                        'class' => 'box-btn btn-header_icon box-add box-scrolling-hide',
                        'escape' => false
                    )); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div id="list-content" class="core-lists topic-lists list-view">
            <?php echo $this->element('lists/topics_list'); ?>
        </div>
    </div>
</div>