<?php
if ( (count( $comments )+ count($activity_comments)) > 0):
    //Item comments
    foreach ($comments as $comment):
        ?>
        <div id="itemcomment_<?php echo $comment['Comment']['id']?>" class="comment-item">
            <?php
            // delete link available for commenter, site admin and item author (except convesation)
            if ( ( $this->request->controller != Inflector::pluralize(APP_CONVERSATION) ) && ( $comment['Comment']['user_id'] == $uid || ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $data['admins'] ) && in_array( $uid, $data['admins'] ) ) ) ):
                ?>
            <div class="comment-option">
                <div class="dropdown">
                    <a href="javascript:void(0)" data-toggle="dropdown" class="cross-icon">
                        <span class="comment-option-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php if ($comment['Comment']['user_id'] == $uid || $cuser['Role']['is_admin'] ):?>
                            <li>
                                <a href="javascript:void(0)" data-id="<?php echo $comment['Comment']['id']?>" data-photo-comment="0" class="editItemComment">
                                    <?php echo __('Edit Comment'); ?>
                                </a>
                            </li>
                        <?php endif;?>
                        <li>
                            <a class="admin-or-owner-confirm-delete-item-comment removeItemComment" href="javascript:void(0)" data-photo-comment="0" data-id="<?php echo $comment['Comment']['id']?>"  >
                                <?php echo __('Delete Comment'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
            <div class="comment-outer">
                <div class="comment-avatar">
                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $comment))); ?>
                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                        <?php echo $comment_reply_creator->result['image'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']), array('prefix' => '100_square'), array('class' => 'user_avatar'))?>
                    <?php endif;?>
                </div>
                <div class="comment-inner">
                    <div class="comment-user-name">
                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                            <?php echo $comment_reply_creator->result['name'];?>
                        <?php else:?>
                            <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                        <?php endif;?>
                    </div>
                    <div  class="comment-content-text" id="item_feed_comment_text_<?php echo $comment['Comment']['id']?>">
                        <?php echo $this->viewMore( h($comment['Comment']['message']))?>
                        <?php if ($comment['Comment']['thumbnail']):?>
                            <div class="comment_thumb">
                                <a data-dismiss="modal" href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
                                    <?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
                                        <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                    <?php else: ?>
                                        <?php echo $this->Moo->getImage($comment,array('class' => 'comment-img', 'prefix'=>'200'));?>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="comment-action-list">
                        <div class="comment-action">
                            <div class="like-action">
                                <div class="act-item comment-time">
                                    <?php echo $this->Moo->getTime( $comment['Comment']['created'], Configure::read('core.date_format'), $utz )?>
                                </div>
                                <div id="history_activity_comment_<?php echo $comment['Comment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['Comment']['edited']) ? 'display:none' : ''; ?>">
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'core_activity_comment', $comment['Comment']['id'])),
                                    'title' => __('Show edit history'),
                                    'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_item_comment-text">'.__('Edited').'</span></span>',
                                    'class'=>'edit-btn',
                                    'data-dismiss'=>'modal'
                                ));
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="comment-search-more">
                            <a class="btn btn-primary btn-xs" href="<?php echo $comment['Comment']['view_link']?>"><?php echo __('Go to comment')?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endforeach;
    //Activity comments
    foreach ($activity_comments as $comment):
        ?>
        <div id="comment_<?php echo $comment['ActivityComment']['id']?>" class="comment-item">
            <div class="comment-outer">
                <div class="comment-avatar">
                    <?php $comment_reply_creator = $this->getEventManager()->dispatch(new CakeEvent('View.renderCommentReplyCreator', $this, array('comment' => $comment))); ?>
                    <?php if(!empty($comment_reply_creator->result['image'])):?>
                        <?php echo $comment_reply_creator->result['image'];?>
                    <?php else:?>
                        <?php echo $this->Moo->getItemPhoto(array('User' => $comment['User']), array('prefix' => '100_square'), array('class' => 'user_avatar'))?>
                    <?php endif;?>
                </div>
                <div class="comment-inner">
                    <div class="comment-user-name">
                        <?php if(!empty($comment_reply_creator->result['name'])):?>
                            <?php echo $comment_reply_creator->result['name'];?>
                        <?php else:?>
                            <?php echo $this->Moo->getName($comment['User'])?><?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterRenderUserNameComment', $this,array('user'=>$comment['User']))); ?>
                        <?php endif;?>
                    </div>
                    <div class="comment-content-text" id="activity_feed_comment_text_<?php echo $comment['ActivityComment']['id']?>">
                        <?php echo $this->viewMore( h($comment['ActivityComment']['comment']))?>
                        <?php if ($comment['ActivityComment']['thumbnail']):?>
                            <div class="comment_thumb">
                                <a data-dismiss="modal" href="<?php echo $this->Moo->getImageUrl($comment,array());?>">
                                    <?php if($this->Moo->isGifImage($this->Moo->getImageUrl($comment,array()))) :  ?>
                                        <?php echo $this->Moo->getImage($comment,array('class'=>'comment-img gif_image'));?>
                                    <?php else: ?>
                                        <?php echo $this->Moo->getImage($comment,array('class' => 'comment-img', 'prefix'=>'200'));?>
                                    <?php endif; ?>
                                </a>
                            </div>
                        <?php endif;?>
                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.comments.afterShowCommentMessage', $this, array('comment' => $comment))); ?>
                    </div>
                    <div class="comment-action-list">
                        <div class="comment-action">
                            <div class="like-action">
                                <div class="act-item comment-time">
                                    <?php echo $this->Moo->getTime( $comment['ActivityComment']['created'], Configure::read('core.date_format'), $utz )?>
                                </div>
                                <div id="history_activity_comment_<?php echo $comment['ActivityComment']['id'] ?>" class="act-item act-item-edited" style="<?php echo empty($comment['ActivityComment']['edited']) ? 'display:none;' : ''; ?>">
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "histories", "action" => "ajax_show", "plugin" => false, 'core_activity_comment', $comment['ActivityComment']['id'])),
                                        'title' => __('Show edit history'),
                                        'innerHtml'=> '<span class="act-item-symbol"><span class="act-item-icon material-icons moo-icon moo-icon-history">history</span></span><span class="act-item-text"><span class="act-item-txt history_activity_comment-text">'.__('Edited').'</span></span>',
                                        'class' => 'edit-btn',
                                        'data-dismiss'=>'modal'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-search-more">
                        <a class="btn btn-primary btn-xs" href="<?php echo $this->request->base?>/users/view/<?php echo $comment['ActivityComment']['user_id']?>/activity_id:<?php echo $comment['ActivityComment']['activity_id']?>"><?php echo __('Go to comment')?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endforeach;

else:
    echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
endif;
?>
<?php if (isset($more_url) && (count($comments)+count($activity_comments)) >= RESULTS_LIMIT): ?>
    <?php $this->Html->viewMore($more_url) ?>
<?php endif; ?>