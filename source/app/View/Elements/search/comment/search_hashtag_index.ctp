<div class="box2 bar-content-warp">
    <div class="box_header">
        <div class="box_header_main">
            <h3 class="box_header_title"><?php echo __('Comments') ?></h3>
            <div class="box_action"></div>
        </div>
    </div>
    <div class="box_content">
        <div id="comments" class="comment_lists comment_parent_lists">
            <?php echo $this->element('lists/comments_list');?>
        </div>
    </div>
</div>