<?php if(Configure::read('Topic.topic_enabled') == 1): ?>

<?php
$topicHelper = MooCore::getInstance()->getHelper('Topic_Topic');
if (!empty($topics) && count($topics) > 0)
{
    $i = 1;
	foreach ($topics as $topic):
?>
	<div class="core-list-item <?php if(!empty($uid) && (($topic['Topic']['user_id'] == $uid ) ||  (!empty($cuser) && $cuser['Role']['is_admin']) ) ): ?>core-is-owner<?php endif; ?>">
        <div class="core-item-warp">
            <div class="core-item-figure">
                <?php if(!empty( $ajax_view )): ?>
                    <a class="ajaxLoadTopicDetail" href="javascript:void(0)" data-url="<?php echo  $this->request->base ?>/topics/ajax_view/<?php echo  $topic['Topic']['id'] ?>">
                        <img class="core-item-img" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '300_square'))?>">
                    </a>
                <?php else: ?>
                    <a href="<?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo  seoUrl($topic['Topic']['title']) ?>">
                        <img class="core-item-img" src="<?php echo $topicHelper->getImage($topic, array('prefix' => '300_square'))?>">
                    </a>
                <?php endif; ?>
            </div>
            <div class="core-item-info">
                <div class="core-item-head">
                    <?php if(!empty( $ajax_view )): ?>
                        <a class="core-item-title ajaxLoadTopicDetail" href="javascript:void(0)" data-url="<?php echo  $this->request->base ?>/topics/ajax_view/<?php echo  $topic['Topic']['id'] ?>"><?php echo  $topic['Topic']['title'] ?></a>
                    <?php else: ?>
                        <a class="core-item-title" href="<?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo  seoUrl($topic['Topic']['title']) ?>"><?php echo $topic['Topic']['title'] ?></a>
                    <?php endif; ?>
                    <?php if(!empty($uid) && (($topic['Topic']['user_id'] == $uid ) ||  (!empty($cuser) && $cuser['Role']['is_admin']) ) ): ?>
                        <div class="list_option">
                            <div class="dropdown">
                                <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                                </button>

                                <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                                    <?php if ( ( !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                        <?php if ( !$topic['Topic']['pinned'] ): ?>
                                            <li><a href='<?php echo $this->request->base?>/topics/do_pin/<?php echo $topic['Topic']['id']?>'><?php echo __( 'Pin Topic')?></a></li>
                                        <?php else: ?>
                                            <li><a href='<?php echo $this->request->base?>/topics/do_unpin/<?php echo $topic['Topic']['id']?>'><?php echo __( 'Unpin Topic')?></a></li>
                                        <?php endif; ?>

                                        <?php if ( !$topic['Topic']['locked'] ): ?>
                                            <li><a href='<?php echo $this->request->base?>/topics/do_lock/<?php echo $topic['Topic']['id']?>'><?php echo __( 'Lock Topic')?></a></li>
                                        <?php else: ?>
                                            <li><a href='<?php echo $this->request->base?>/topics/do_unlock/<?php echo $topic['Topic']['id']?>'><?php echo __( 'Unlock Topic')?></a></li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ( ($topic['Topic']['user_id'] == $uid ) || ( !empty($cuser['Role']['is_admin']) ) ): ?>
                                        <li><?php echo $this->Html->link(__( 'Edit Topic'), array(
                                                'plugin' => 'Topic',
                                                'controller' => 'topics',
                                                'action' => 'create',
                                                $topic['Topic']['id']
                                            )); ?></li>
                                        <li><a href="javascript:void(0);" class="deleteTopic" data-id="<?php echo $topic['Topic']['id']?>"><?php echo __( 'Delete')?></a></li>
                                        <li class="seperate"></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="core-item-pin">
                    <?php if ( $topic['Topic']['pinned'] ): ?>
                        <span class="core-pin-icon material-icons moo-icon moo-icon-offline_pin tip" title="<?php echo __( 'Pinned')?>">offline_pin</span>
                    <?php endif; ?>

                    <?php if ( $topic['Topic']['attachment'] ): ?>
                        <span class="core-pin-icon material-icons moo-icon moo-icon-attach_file tip" title="<?php echo __( 'Attached files')?>">attach_file</span>
                    <?php endif; ?>
                    <?php if ( $topic['Topic']['locked'] ): ?>
                        <span class="core-pin-icon material-icons moo-icon moo-icon-lock tip" title="<?php echo __( 'Locked')?>">lock</span>
                    <?php endif; ?>
                </div>
                <div class="core-item-date">
                    <?php echo __( 'Last posted by %s', $this->Moo->getName($topic['LastPoster'], false))?> <?php echo $this->Moo->getTime( $topic['Topic']['last_post'], Configure::read('core.date_format'), $utz )?>
                </div>
                <div class="core-item-description">
                    <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>','&nbsp;'), array(' ',''), $topic['Topic']['body'])), 200, array('exact' => false)), Configure::read('Topic.topic_hashtag_enabled')) ?>
                </div>
                <div class="core-item-action">
                    <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeReview', $this,array('uid' => $uid,'item' => array('id' => $topic['Topic']['id'], 'like_count' => $topic['Topic']['like_count']), 'item_type' => 'Topic_Topic' ))); ?>
                    <div class="like-section">
                        <div class="like-action">
                            <?php if(empty($hide_like)): ?>
                            <div class="act-item act-item-like">
                                <a class="act-item-symbol likeItem <?php if (!empty($uid) && !empty($like[$topic['Topic']['id']])): ?>active<?php endif; ?>" data-type="Topic_Topic" data-id="<?php echo $topic['Topic']['id']?>" data-status="1" href="javascript:void(0)">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                                </a>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "likes",
                                        "action" => "ajax_show",
                                        "plugin" => false,
                                        'Topic_Topic',
                                        $topic['Topic']['id'],
                                    )),
                                    'title' => __('People Who Like This'),
                                    'innerHtml'=> '<span class="act-item-txt likeCount">' . $topic['Topic']['like_count'] . '</span>',
                                    'class' => 'act-item-text'
                                ));
                                ?>
                            </div>
                            <?php endif; ?>
                            <?php if(empty($hide_dislike)): ?>
                            <div class="act-item act-item-dislike">
                                <a class="act-item-symbol likeItem <?php if (!empty($uid) && isset($like[$topic['Topic']['id']]) && $like[$topic['Topic']['id']] == 0): ?>active<?php endif; ?>" data-type="Topic_Topic" data-id="<?php echo $topic['Topic']['id']?>" data-status="0" href="javascript:void(0)">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                                </a>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "likes",
                                        "action" => "ajax_show",
                                        "plugin" => false,
                                        'Topic_Topic',
                                        $topic['Topic']['id'], 1
                                    )),
                                    'title' => __('People Who DisLike This'),
                                    'innerHtml'=>  '<span class="act-item-txt dislikeCount">' . $topic['Topic']['dislike_count'] . '</span>',
                                    'class' => 'act-item-text'
                                ));
                                ?>
                            </div>
                            <?php endif; ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeButton', $this,array('uid' => $uid,'item' => array('id' => $topic['Topic']['id'], 'like_count' => $topic['Topic']['like_count']), 'item_type' => 'Topic_Topic' ))); ?>
                            <div class="act-item act-item-comment">
                                <a class="act-item-symbol" href="<?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo seoUrl($topic['Topic']['title'])?>">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-comment">comment</span>
                                </a>
                                <a class="act-item-text" href="<?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo seoUrl($topic['Topic']['title'])?>">
                                    <span class="act-item-txt"><?php echo $topic['Topic']['comment_count']?></span>
                                </a>
                            </div>
                            <div class="act-item act-item-share">
                                <a href="<?php echo  $this->request->base ?>/topics/view/<?php echo  $topic['Topic']['id'] ?>/<?php echo seoUrl($topic['Topic']['title'])?>">
                                    <span class="act-item-symbol">
                                        <span class="act-item-icon material-icons moo-icon moo-icon-share">share</span>
                                    </span>
                                        <span class="act-item-text">
                                        <span class="act-item-txt"><?php echo  $topic['Topic']['share_count'] ?></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="core-extra-info">
                    <?php $this->Html->rating($topic['Topic']['id'],'topics', 'Topic'); ?>
                </div>
            </div>
        </div>
	</div>
<?php
    $i++;
	endforeach;
}
else
	echo '<div class="no-more-results">' . __( 'No more results found') . '</div>';
?>
<?php if (isset($more_url)&& !empty($more_result)): ?>
    <?php $this->Html->viewMore($more_url) ?>
<?php endif; ?>

<?php endif; ?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooTopic","mooGroup"], function($,mooTopic,mooGroup) {
        <?php if(!empty( $ajax_view )): ?>
            mooTopic.initOnGroupListing();
            mooGroup.initOnTopicList();
        <?php else: ?>
            mooTopic.initOnListing();
        <?php endif;?>
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooTopic'), 'object' => array('$', 'mooTopic'))); ?>
mooTopic.initOnListing();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>