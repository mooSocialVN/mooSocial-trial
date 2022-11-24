<script type="text/javascript">
    require(["jquery","mooGroup","mooComment"], function($, mooGroup, mooComment) {
        mooGroup.initOnAjaxViewTopic('<?php echo $topic['Topic']['moo_href']?>');
        mooComment.initReplyCommentItem();
        mooComment.initCloseComment();
    });
</script>
<?php
    if(!empty($item_close_comment)){
        $title =  __('Open Comment');
        $is_close_comment = 1;
    }else{
        $title =   __('Close Comment');
        $is_close_comment = 0;
    }
    if ((!empty($admins) && !empty($cuser) && in_array($cuser['id'], $admins)) || (!empty($cuser) && $cuser['Role']['is_admin']) ){
        $is_owner = 1;
    }else{
        $is_owner = 0;
    }

?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo $topic['Topic']['title']; ?></h1>
                <div class="box_action">
                    <?php if (!empty($uid)): ?>
                    <div class="box-dropdown">
                        <div class="dropdown">
                            <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                                <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($uid == $topic['Topic']['user_id'] || ( !empty($cuser) && $cuser['Role']['is_admin'] ) || in_array($uid, $admins) ): ?>
                                    <li><a href='javascript:void(0)' class="ajaxLoadTopicEdit" data-url="<?php echo $this->request->base?>/topics/group_create/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Edit Topic')?></a></li>
                                    <li><a href="javascript:void(0);" class="deleteTopic" data-id="<?php echo $topic['Topic']['id']?>" data-group="<?php echo $topic['Topic']['group_id']?>"><?php echo  __( 'Delete') ?></a></li>
                                <?php endif; ?>
                                <?php if (!empty($cuser['Role']['is_admin']) || in_array($uid, $admins) ): ?>
                                    <?php if ( !$topic['Topic']['pinned'] ): ?>
                                        <li><a href="<?php echo $this->request->base?>/topics/do_pin/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Pin Topic')?></a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo $this->request->base?>/topics/do_unpin/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Unpin Topic')?></a></li>
                                    <?php endif; ?>

                                    <?php if ( !$topic['Topic']['locked'] ): ?>
                                        <li><a href="<?php echo $this->request->base?>/topics/do_lock/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Lock Topic')?></a></li>
                                    <?php else: ?>
                                        <li><a href="<?php echo $this->request->base?>/topics/do_unlock/<?php echo $topic['Topic']['id']?>"><?php echo __( 'Unlock Topic')?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "reports",
                                            "action" => "ajax_create",
                                            "plugin" => false,
                                            'Topic_Topic',
                                            $topic['Topic']['id']
                                        )),
                                        'title' => __( 'Report Topic'),
                                        'innerHtml'=> __( 'Report Topic'),
                                    ));
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <div class="post_body topic_view_body">
                <div class="post_content">
                    <?php echo $this->Moo->cleanHtml($this->Text->convert_clickable_links_for_hashtags( $topic['Topic']['body'] , Configure::read('Topic.topic_hashtag_enabled')))?>
                </div>
                <?php if ( !empty( $pictures ) ): ?>
                <div class="post_attached_file">
                    <div class="post_attached_head"><?php echo __( 'Attached Images')?></div>
                    <div class="post_attached_list row">
                        <?php foreach ($pictures as $p): ?>
                        <div class="col-xs-3 col-sm-2 col-md-3 col-lg-2">
                            <div class="post_attached_warp">
                                <a style="background-image:url(<?php echo $this->request->webroot?>uploads/attachments/t_<?php echo $p['Attachment']['filename']?>)" href="<?php echo $this->request->webroot?>uploads/attachments/<?php echo $p['Attachment']['filename']?>" class="post-attached-image"></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if ( !empty( $files ) ): ?>
                    <div class="post_attached_file">
                    <div class="post_attached_head"><?php echo __( 'Attached Files')?></div>
                    <ul class="post_attached_download_list">
                        <?php foreach ($files as $attachment): ?>
                        <li>
                            <span class="attached-download-icon material-icons moo-icon moo-icon-attach_file">attach_file</span>
                            <a class="attached-download-link" href="<?php echo $this->request->base?>/attachments/download/<?php echo $attachment['Attachment']['id']?>"><?php echo $attachment['Attachment']['original_filename']?></a>
                            <span class="attached-download-date">(<?php echo __n('%s download', '%s downloads', $attachment['Attachment']['downloads'], $attachment['Attachment']['downloads'] )?>)</span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
                <div class="extra_info">
                    <?php echo __( 'Posted by %s', $this->Moo->getName($topic['User']))?> <?php echo $this->Moo->getTime($topic['Topic']['created'], Configure::read('core.date_format'), $utz)?>
                </div>
            </div>
        </div>
    </div>

    <div class="box2 bar-content-warp">
        <div class="box_content">
            <?php if ($topic['Group']['moo_privacy'] == PRIVACY_PUBLIC): ?>
                <?php echo $this->element('likes', array('shareUrl' => $this->Html->url(array(
                    'plugin' => false,
                    'controller' => 'share',
                    'action' => 'ajax_share',
                    'Topic_Topic',
                    'id' => $topic['Topic']['id'],
                    'type' => 'topic_item_detail'
                ), true), 'item' => $topic['Topic'], 'type' => 'Topic_Topic', 'hide_container' => false)); ?>
            <?php else: ?>
                <?php echo $this->element('likes', array('doNotShare' => true, 'shareUrl' => $this->Html->url(array(
                    'plugin' => false,
                    'controller' => 'share',
                    'action' => 'ajax_share',
                    'Topic_Topic',
                    'id' => $topic['Topic']['id'],
                    'type' => 'topic_item_detail'
                ), true), 'item' => $topic['Topic'], 'type' => 'Topic_Topic', 'hide_container' => false)); ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="box2 bar-content-warp">
        <div class="box_content core_comments topic-comment">
            <div class="comment_header_title">
                <?php echo __( 'Replies (%s)', $topic['Topic']['comment_count'])?>
            </div>
            <div class="comment_holder content_comment">
                <?php if ($is_owner ): ?>
                <a class="closeComment" data-id="<?php echo $topic['Topic']['id']?>" data-type="<?php echo $topic['Topic']['moo_type']?>" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
                    <?php echo $title; ?>
                </a>
                <?php endif; ?>
                <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                    <?php
                    if ( !isset( $is_member ) || $is_member  )
                        if ( $topic['Topic']['locked'] ) {
                            echo '<span class="material-icons moo-icon moo-icon-lock icon-small">lock</span> ' . __('This topic has been locked');
                        }else if($is_close_comment && !$is_owner){
                            echo '<div class="closed-comment">'.__('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User'])). '</div>';
                        }
                        else {
                            echo $this->element('comment_form', array('target_id' => $topic['Topic']['id'], 'type' => 'Topic_Topic'));
                        }
                    else
                        echo __( 'This a group topic. Only group members can leave comment');
                    ?>
                    <div id="comments" class="comment_lists comment_parent_lists">
                        <?php echo $this->element('comments');?>
                    </div>
                <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                    <div id="comments" class="comment_lists comment_parent_lists">
                        <?php echo $this->element('comments_chrono');?>
                    </div>
                    <?php
                    if ( !isset( $is_member ) || $is_member  )
                        if ( $topic['Topic']['locked'] ){
                            echo '<span class="material-icons moo-icon moo-icon-lock icon-small">lock</span> ' . __( 'This topic has been locked');
                        }else if($is_close_comment && !$is_owner){
                            echo '<div class="closed-comment">'.__('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User'])). '</div>';
                        }else {
                            echo $this->element('comment_form', array('target_id' => $topic['Topic']['id'], 'type' => 'Topic_Topic'));
                        }
                    else
                        echo __( 'This a group topic. Only group members can leave comment');
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>