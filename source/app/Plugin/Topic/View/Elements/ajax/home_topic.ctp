<div class="box2 bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo __('My Topics')?></h1>
            <div class="box_action">
                <a class="box-btn btn btn-header_title btn-cs" href="<?php echo $this->Html->url(array('plugin' => 'topic', 'controller' => 'topics', 'action' => 'create')); ?>">
                    <span class="btn-cs-main">
                        <span class="btn-icon material-icons moo-icon moo-icon-add_circle">add_circle</span>
                        <span class="btn-text hidden-xs"><?php echo __('Create New Topic')?></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="box_content content_center_home">
        <ul class="topic-lists" id="list-content">
            <?php echo $this->element('lists/topics_list'); ?>
        </ul>
    </div>
</div>