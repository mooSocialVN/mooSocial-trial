<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooComment"], function($,mooComment) {
        mooComment.initReplyCommentItem();
        mooComment.initCloseComment();
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooComment'), 'object' => array('$', 'mooComment'))); ?>
    mooComment.initReplyCommentItem();
    mooComment.initCloseComment();
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php
	$uid = $this->Auth->user('id');
?>

<?php if ($check_see_status):?>

    <div class="comment_header_title">
        <?php if (isset($title)) echo $title; else echo __('Comments');?> (<span id="comment_count"><?php if (isset($comment_count)) echo $comment_count; else echo $subject[key($subject)]['comment_count']?></span>)
    </div>

    <div class="comment_holder content_comment">
    <?php
    if(!empty($item_close_comment)){
        $title =  __('Open Comment');
        $is_close_comment = 1;
    }else{
        $title =   __('Close Comment');
        $is_close_comment = 0;
    }

    if ((!empty($subject['User']['id']) && $subject['User']['id'] == $uid) || (!empty($cuser) && $cuser['Role']['is_admin']) ){
        $is_owner = 1;
    }else{
        $is_owner = 0;
    }

    ?>

    <?php if ($is_owner ): ?>
        <a class="closeComment" data-id="<?php echo $subject[key($subject)]['id']?>" data-type="<?php echo $subject[key($subject)]['moo_type']?>" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
            <?php echo $title; ?>
        </a>
    <?php endif; ?>

    <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                <?php if ($check_post_status || !$uid):?>
                    <?php if($is_close_comment && !$is_owner) :?>
                        <div class="closed-comment"><?php echo __('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User']));?></div>
                    <?php else:?>
                        <?php echo $this->element( 'comment_form', array_merge($params,array( 'target_id' => $subject[key($subject)]['id'], 'type' => $subject[key($subject)]['moo_type']) )); ?>
                    <?php endif;?>
                <?php else:?>
                    <div><?php if(isset($text_post_error)) echo $text_post_error;?></div>
                <?php endif;?>
                <div class="comment_lists comment_parent_lists" id="comments">
                    <?php echo $this->element('comments',array('data'=>$data, 'is_close_comment' => $is_close_comment));?>
                </div>
            <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                <div class="comment_lists comment_parent_lists" id="comments">
                    <?php echo $this->element('comments_chrono',array('data'=>$data, 'is_close_comment' => $is_close_comment));?>
                </div>
                <?php if ($check_post_status || !$uid):?>
                    <?php if($is_close_comment && !$is_owner) :?>
                        <div class="closed-comment"><?php echo __('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User']));?></div>
                    <?php else:?>
                        <?php echo $this->element( 'comment_form', array_merge($params,array( 'target_id' => $subject[key($subject)]['id'], 'type' => $subject[key($subject)]['moo_type']) )); ?>
                    <?php endif;?>
                <?php else:?>
                    <div><?php if(isset($text_post_error)) echo $text_post_error;?></div>
                <?php endif;?>
            <?php endif; ?>
    </div>
<?php else:?>
    <div class="comment_holder content_comment">
    <?php if(isset($text_private_error)) echo $text_private_error; else echo __('This is private item');?>
    </div>
<?php endif;?>