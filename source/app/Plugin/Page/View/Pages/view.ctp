<div class="box2 box_view bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo $page['Page']['title']?></h1>
        </div>
    </div>
    <div class="box_content">
        <div class="post_body">
            <div class="post_content content">
                <?php echo $page['Page']['content']?>
            </div>
        </div>
    </div>
</div>

<?php if ( !empty($params['comments']) ): ?>
<div class="box2 bar-content-warp">
    <div class="box_content core_comments page-comment">
        <div class="comment_header_title"><?php echo __('Comments')?></div>
        <div class="comment_holder content_comment">
            <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                <?php echo $this->element( 'comment_form', array( 'target_id' => $page['Page']['id'], 'type' => APP_PAGE ) ); ?>
                <div id="comments" class="comment_lists">
                    <?php echo $this->element('comments');?>
                </div>
            <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                <div id="comments" class="comment_lists">
                    <?php echo $this->element('comments_chrono');?>
                </div>
                <?php echo $this->element( 'comment_form', array( 'target_id' => $page['Page']['id'], 'type' => APP_PAGE ) ); ?>
            <?php endif; ?>
        </div>
     </div>
</div>
<?php endif; ?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooComment'), 'object' => array('$', 'mooComment'))); ?>
mooComment.initReplyCommentItem();
<?php $this->Html->scriptEnd(); ?>
