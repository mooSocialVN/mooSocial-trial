<?php
$blogHelper = MooCore::getInstance()->getHelper('Blog_Blog');
if (!empty($blogs) && count($blogs) > 0)
{
	$i = 1;
	foreach ($blogs as $blog):
?>
<div class="core-list-item <?php if( !empty($uid) && (($blog['Blog']['user_id'] == $uid ) || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ) ): ?>core-is-owner<?php endif; ?>">
    <div class="core-item-warp">
        <div class="core-item-figure">
            <a href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                <img class="core-item-img" src="<?php echo $blogHelper->getImage($blog, array('prefix' => '300_square'))?>">
            </a>
        </div>
        <div class="core-item-info">
            <div class="core-item-head">
                <a class="core-item-title" href="<?php echo $this->request->base?>/blogs/view/<?php echo $blog['Blog']['id']?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                    <?php echo $blog['Blog']['title'] ?>
                </a>
                <?php if( !empty($uid) && (($blog['Blog']['user_id'] == $uid ) || ( !empty($cuser) && $cuser['Role']['is_admin'] ) ) ): ?>
                    <div class="list_option">
                        <div class="dropdown">
                            <button id="dropdown-edit" data-target="#" data-toggle="dropdown" >
                                <span class="material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </button>
                            <ul role="menu" class="dropdown-menu" aria-labelledby="dropdown-edit" style="float: right;">

                                <?php if ($blog['User']['id'] == $uid || ( !empty($cuser) && $cuser['Role']['is_admin'] )): ?>
                                    <li><a href="<?php echo $this->request->base?>/blogs/create/<?php echo $blog['Blog']['id']?>"> <?php echo __( 'Edit Blog')?></a></li>
                                <?php endif; ?>
                                <?php if ( ($blog['Blog']['user_id'] == $uid ) || ( !empty( $blog['Blog']['id'] ) && !empty($cuser) && $cuser['Role']['is_admin'] ) ): ?>
                                    <li><a href="javascript:void(0)" data-id="<?php echo $blog['Blog']['id']?>" class="deleteBlog" > <?php echo __( 'Delete Blog')?></a></li>
                                    <li class="seperate"></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="core-item-date">
                <?php echo __( 'Posted by')?> <?php echo $this->Moo->getName($blog['User'], false)?>
                <?php echo $this->Moo->getTime( $blog['Blog']['created'], Configure::read('core.date_format'), $utz )?> &nbsp;
                <?php
                switch($blog['Blog']['privacy']){
                    case 1:
                        $icon_class = 'public';
                        $tooltip = __('Shared with: Everyone');
                        break;
                    case 2:
                        $icon_class = 'people';
                        $tooltip = __('Shared with: Friends Only');
                        break;
                    case 3:
                        $icon_class = 'lock';
                        $tooltip = __('Shared with: Only Me');
                        break;
                }
                ?>
                <a class="tip core-item-privacy" href="javascript:void(0);" original-title="<?php echo  $tooltip ?>"> <span class="item-privacy-icon material-icons moo-icon moo-icon-<?php echo  $icon_class ?>"><?php echo  $icon_class ?></span></a>
            </div>

            <div class="core-item-description">
                <?php echo $this->Text->convert_clickable_links_for_hashtags($this->Text->truncate(strip_tags(str_replace(array('<br>','&nbsp;'), array(' ',''), $blog['Blog']['body'])), 200, array('eclipse' => '')), Configure::read('Blog.blog_hashtag_enabled')); ?>
            </div>

            <div class="core-item-action">
                <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeReview', $this,array('uid' => $uid,'item' => array('id' => $blog['Blog']['id'], 'like_count' => $blog['Blog']['like_count']), 'item_type' => 'Blog_Blog' ))); ?>
                <div class="like-section">
                    <div class="like-action">
                        <?php if(empty($hide_like)): ?>
                        <div class="act-item act-item-like">
                            <a class="act-item-symbol likeItem <?php if (!empty($uid) && !empty($like[$blog['Blog']['id']])): ?>active<?php endif; ?>" data-type="Blog_Blog" data-id="<?php echo $blog['Blog']['id']?>" data-status="1" href="javascript:void(0)">
                                <span class="act-item-icon material-icons moo-icon moo-icon-thumb_up">thumb_up</span>
                            </a>
                            <?php
                            $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array(
                                    "controller" => "likes",
                                    "action" => "ajax_show",
                                    "plugin" => false,
                                    'Blog_Blog',
                                    $blog['Blog']['id'],
                                )),
                                'title' => __('People Who Like This'),
                                'innerHtml'=>'<span class="act-item-txt likeCount">'.$blog['Blog']['like_count'].'</span>',
                                'class' => 'act-item-text'
                            ));
                            ?>
                        </div>
                        <?php endif; ?>
                        <?php if(empty($hide_dislike)): ?>
                        <div class="act-item act-item-dislike">
                            <a class="act-item-symbol likeItem <?php if (!empty($uid) && isset($like[$blog['Blog']['id']]) && $like[$blog['Blog']['id']] == 0): ?>active<?php endif; ?>" data-type="Blog_Blog" data-id="<?php echo $blog['Blog']['id']?>" data-status="0" href="javascript:void(0)">
                                <span class="act-item-icon material-icons moo-icon moo-icon-thumb_down">thumb_down</span>
                            </a>
                            <?php
                            $this->MooPopup->tag(array(
                                'href'=>$this->Html->url(array(
                                    "controller" => "likes",
                                    "action" => "ajax_show",
                                    "plugin" => false,
                                    'Blog_Blog',
                                    $blog['Blog']['id'],
                                    '1',
                                )),
                                'title' => __('People Who DisLike This'),
                                'innerHtml'=>'<span class="act-item-txt dislikeCount">'.$blog['Blog']['dislike_count'].'</span>',
                                'class' => 'act-item-text'
                            ));
                            ?>
                        </div>
                        <?php endif; ?>
                        <?php $this->getEventManager()->dispatch(new CakeEvent('element.items.renderLikeButton', $this,array('uid' => $uid,'item' => array('id' => $blog['Blog']['id'], 'like_count' => $blog['Blog']['like_count']), 'item_type' => 'Blog_Blog' ))); ?>
                        <div class="act-item act-item-comment">
                            <a class="act-item-symbol" href="<?php echo  $this->request->base ?>/blogs/view/<?php echo  $blog['Blog']['id'] ?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                                <span class="act-item-icon material-icons moo-icon moo-icon-comment">comment</span>
                            </a>
                            <a class="act-item-text" href="<?php echo  $this->request->base ?>/blogs/view/<?php echo  $blog['Blog']['id'] ?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                                <span id="comment_count" class="act-item-txt"><?php echo $blog['Blog']['comment_count']?></span>
                            </a>
                        </div>
                        <div class="act-item act-item-share">
                            <a href="<?php echo  $this->request->base ?>/blogs/view/<?php echo  $blog['Blog']['id'] ?>/<?php echo seoUrl($blog['Blog']['title'])?>">
                                <span class="act-item-symbol">
                                    <span class="act-item-icon material-icons moo-icon moo-icon-share">share</span>
                                </span>
                                <span class="act-item-text">
                                    <span class="act-item-txt"><?php echo  $blog['Blog']['share_count'] ?></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="core-extra-info">
                <?php $this->Html->rating($blog['Blog']['id'],'blogs', 'Blog'); ?>
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

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooBlog"], function($,mooBlog) {
        mooBlog.initOnListing();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooBlog'), 'object' => array('$', 'mooBlog'))); ?>
mooBlog.initOnListing();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>
