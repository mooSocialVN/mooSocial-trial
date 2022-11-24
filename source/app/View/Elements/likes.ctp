<?php
$likeModel =  MooCore::getInstance()->getModel('Like');
$item['like_count'] = $likeModel->getBlockLikeCount($item['id'],$item['moo_type']);
$item['dislike_count'] = $likeModel->getBlockLikeCount($item['id'],$item['moo_type'],0);
if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooLike"], function($,mooLike) {
        mooLike.initLikeItem();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true,'requires'=>array('jquery', 'mooLike'), 'object' => array('$', 'mooLike'))); ?>
mooLike.initLikeItem();
<?php $this->Html->scriptEnd();  ?>
<?php endif; ?>

<?php if ( empty( $hide_container ) ): ?>
<div class="like-section content-like">
    <div class="like-action">
        <?php if(empty($hide_like)): ?>
            <div class="act-item act-item-like">
                <a id="<?php echo $type?>_l_<?php echo $item['id'] ?>" class="act-item-symbol likeItem <?php if ( !empty($uid) && !empty( $like['Like']['thumb_up'] ) ): ?>active<?php endif; ?>" href="javascript:void(0)" data-type="<?php echo $type?>" data-id="<?php echo $item['id']?>" data-status="1">
                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                </a>
                <?php $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array(
                        "controller" => "likes",
                        "action" => "ajax_show",
                        "plugin" => false,
                        $type,
                        $item['id']
                    )),
                    'title' => __('People Who Like This'),
                    'innerHtml'=> '<span class="act-item-txt" id="like_count"> ' . $item['like_count'] . '</span>',
                    'data-dismiss'=> 'modal',
                    'class' => 'act-item-text'
                ));
                ?>
            </div>
        <?php endif; ?>
        <?php if(empty($hide_dislike)): ?>
            <div class="act-item act-item-dislike">
                <a id="<?php echo $type?>_d_<?php echo $item['id'] ?>" class="act-item-symbol likeItem <?php if ( !empty($uid) && isset( $like['Like']['thumb_up'] ) && $like['Like']['thumb_up'] == 0 ): ?>active<?php endif; ?>" href="javascript:void(0)" data-type="<?php echo $type?>" data-id="<?php echo $item['id']?>" data-status="0">
                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                </a>
                <?php $this->MooPopup->tag(array(
                    'href'=>$this->Html->url(array(
                        "controller" => "likes",
                        "action" => "ajax_show",
                        "plugin" => false,
                        $type,
                        $item['id'],1
                    )),
                    'title' => __('People Who DisLike This'),
                    'innerHtml'=> '<span class="act-item-txt" id="dislike_count">' . $item['dislike_count'] . '</span>',
                    'data-dismiss' => 'modal',
                    'class' => 'act-item-text'
                ));
                ?>
            </div>
        <?php endif; ?>
        <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeButton', $this,array('uid' => $uid,'item' => array('id' => $item['id'], 'like_count' => $item['like_count']), 'item_type' => $type ))); ?>
        <?php if (isset($shareUrl) && !isset($doNotShare)): ?>
            <div class="act-item act-item-share">
                <a href="javascript:void(0);" share-url="<?php echo $shareUrl ?>" class="shareFeedBtn">
                <span class="act-item-symbol">
                    <span class="act-item-icon material-icons moo-icon moo-icon-share">share</span>
                </span>
                    <span class="act-item-text">
                    <span class="act-item-txt"><?php echo __('Share') ?></span>
                </span>
                </a>
            </div>
        <?php endif; ?>
        <?php $this->getEventManager()->dispatch(new CakeEvent('element.likes.afterRenderShareButton', $this,array('item'=> $item, 'type' => $type))); ?>
    </div>
    <div class="likes">
        <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeReview', $this,array('uid' => $uid,'item' => array('id' => $item['id'], 'like_count' => $item['like_count']), 'item_type' => $type ))); ?>
        <?php if(empty($hide_like)): ?>
            <?php
            $total_users = count($likes);
            $new_likes = array();
            if($total_users > 6):
                for($i = 0; $i <6; $i++):
                    $new_likes[] = $likes[$i];
                endfor;
            else:
                $new_likes = $likes;
            endif;
            ?>
            <div class="like-desc">
                <span id="like_count2"><?php echo $total_users ?></span> <?php echo __('people liked this') ?>
            </div>
            <div class="box_liked_user">
                <?php echo $this->element( 'blocks/users_block', array( 'users' => $new_likes ) ); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>