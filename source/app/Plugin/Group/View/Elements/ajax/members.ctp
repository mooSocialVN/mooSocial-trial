<div id="group_members" class="bar-content">
    <div class="box2 box_browse bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Members') ?></h1>
                <div class="box_action"></div>
            </div>
        </div>
        <div class="box_content group-member">
            <?php echo $this->element( 'layout/grid_list_bar', array('id_div' => 'GridListBar','target_div' => '#list-content', 'active_type' => 'grid-view') ); ?>
            <div id="list-content" class="user-lists grid-view">
                <?php echo $this->element('lists/users_list'); ?>
            </div>
        </div>
    </div>
</div>