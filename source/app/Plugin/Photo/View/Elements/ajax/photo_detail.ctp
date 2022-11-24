<?php $ref = "";?>
<?php if (!isset($_SERVER['HTTP_REFERER'])):?>
	<?php if ( ( $photo['Photo']['type'] == 'Group_Group' ) ):?>
		<?php $ref = $this->request->base.'/groups/view/'.$photo['Photo']['target_id'];?>		
	<?php elseif ( ( $photo['Photo']['type'] == 'Photo_Album' ) ): ?>
		<?php $ref = $this->request->base.'/albums/view/'.$photo['Photo']['target_id'];?>	    
	<?php endif; ?>
<?php else:?>
	<?php $ref = $_SERVER['HTTP_REFERER'];?>
<?php endif;?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooPhoto"], function($, mooPhoto) {
        mooPhoto.initOnPhotoView({
            photo_id : <?php echo $photo['Photo']['id']?>,
            photo_thumb : '<?php echo $photo['Photo']['thumbnail']?>',
            tag_uid : <?php echo isset($this->request->named['uid']) ? $this->request->named['uid'] : 0?>,
            taguserid : <?php echo isset($this->request->query['uid']) ? $this->request->query['uid'] : 0?>,
            type : '<?php echo $type; ?>',
            target_id : <?php echo $target_id?>,
            album_type : '<?php echo $photo['Photo']['album_type']; ?>',
            album_type_id : <?php echo $photo['Photo']['album_type_id']; ?>,
			ref : '<?php echo $ref;?>',
        });
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooPhoto'), 'object' => array('$', 'mooPhoto'))); ?>
mooPhoto.initOnPhotoView({
    photo_id : <?php echo $photo['Photo']['id']?>,
    photo_thumb : '<?php echo $photo['Photo']['thumbnail']?>',
    tag_uid : <?php echo isset($this->request->named['uid']) ? $this->request->named['uid'] : 0?>,
    taguserid : <?php echo isset($this->request->query['uid']) ? $this->request->query['uid'] : 0?>,
    type : '<?php echo $type?>',
    target_id : <?php echo $target_id?>,
    album_type : '<?php echo $photo['Photo']['album_type']; ?>',
    album_type_id : <?php echo $photo['Photo']['album_type_id']; ?>,
	ref : '<?php echo $ref;?>',
});
<?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php if($this->request->is('ajax')) $this->setCurrentStyle(4) ?>
<?php
$photoHelper = MooCore::getInstance()->getHelper('Photo_Photo');
?>

<!--<div class="bar-content">-->
    <div id="photo_wrapper" >
        <div id="tag-wrapper">
            <img src="<?php if ($is_redirect) echo $this->Storage->getImage('/photo/img/noimage/privacy.png'); else echo $photoHelper->getImage($photo, array('prefix' => '1500'))?>" id="photo_src">
            <div id="tag-target"></div>
            <div id="tag-input">
                <?php echo __( "Enter person's name")?>
                <input type="text" id="tag-name">
                <?php echo __( 'Or select a friend')?>
                <div id="friends_list" class="tag_friends_list"></div>
                <a href="#" id="tag-submit" class="btn btn-primary btn-xs"><?php echo __( 'Submit')?></a>
                <a href="#" id="tag-cancel" class="btn btn-default btn-xs"><?php echo __( 'Cancel')?></a>
            </div>
            <?php
            if (!$isMobile):
                foreach ( $photo_tags as $tag ):
                    ?>
                    <div style="<?php echo $tag['PhotoTag']['style']?>" class="hotspot" id="hotspot-0-<?php echo $tag['PhotoTag']['id']?>"><span>
            <?php
            if ( $tag['PhotoTag']['user_id'] ){
                $tag['User']['no_tooltip'] = true;
                echo $this->Moo->getName( $tag['User'], false );
            }else{
                echo h($tag['PhotoTag']['value']);
            }
            ?>
        </span></div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
        <?php if ($is_show_full_photo):?>
            <div id="lb_description">
                <?php if ( $photo['Photo']['type'] == 'Group_Group' ): ?>
                    <a class="lb_photo-title" href="<?php echo $this->request->base?>/groups/view/<?php echo $photo['Photo']['target_id']?>/<?php echo seoUrl($photo['Group']['name'])?>"><?php echo __( 'Photos of %s', ($photo['Group']['name']))?></a>
                <?php else: ?>
                    <a class="lb_photo-title" href="<?php echo $this->request->base?>/albums/view/<?php echo $photo['Photo']['target_id']?>/<?php echo seoUrl($photo['Album']['moo_title'])?>"><?php echo ($photo['Album']['moo_title'])?></a>
                <?php endif; ?>
                <div class="lb_action_lists">
                    <?php if ( $can_tag ): ?>
                        <div id="tagPhoto" class="lb_action_item hidden-xs hidden-sm"><a href="javascript:void(0)"><span class="tag-photo-icon material-icons moo-icon moo-icon-local_offer">local_offer</span><span class="tag-photo-text"><?php echo __( 'Tag Photo')?></span></a></div>
                    <?php endif; ?>
                    <?php if ( !empty( $photo['Photo']['original'] ) ): ?>
                        <div class="lb_action_item"><a href="<?php echo $this->request->webroot?><?php echo $photo['Photo']['original']?>" target="_blank"><span class="material-icons moo-icon moo-icon-file_download">file_download</span> <?php echo __( 'Download Hi-res')?></a></div>
                    <?php endif; ?>
                    <?php if ( !empty($uid) ): ?>
                        <div class="lb_action_item">
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.photos.renderLikeButton', $this,array('uid' => $uid,'photo' => $photo, 'item_type' => 'Photo_Photo' ))); ?>
                            <?php $this->getEventManager()->dispatch(new CakeEvent('element.photos.renderLikeReview', $this,array('uid' => $uid,'photo' => $photo, 'item_type' => 'Photo_Photo' ))); ?>
                            <?php if(empty($hide_like)): ?>
                                <a href="javascript:void(0)" id="photo_like_count" data-thumb-up="1" data-id="<?php echo $photo['Photo']['id']?>" class="likePhoto <?php if ( !empty( $uid ) && !empty( $like['Like']['thumb_up'] ) ): ?>active<?php endif; ?>"><span class="material-icons moo-icon moo-icon-thumb_up">thumb_up</span></a>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "likes",
                                        "action" => "ajax_show",
                                        "plugin" => false,
                                        'Photo_Photo',
                                        $photo['Photo']['id'],
                                    )),
                                    'title' => __( 'People Who Like This'),
                                    'innerHtml'=> '<span id="photo_like_count2">' . $photo['Photo']['like_count'] . '</span>',
                                    'data-dismiss' => 'modal'
                                ));
                                ?>
                            <?php endif; ?>
                        </div>
                        <?php if(empty($hide_dislike)): ?>
                            <div class="lb_action_item">
                                <a href="javascript:void(0)" id="photo_dislike_count" data-thumb-up="0" data-id="<?php echo $photo['Photo']['id']?>" class="likePhoto <?php if ( !empty( $uid ) && isset( $like['Like']['thumb_up'] ) && $like['Like']['thumb_up'] == 0 ): ?>active<?php endif; ?>"><span class="material-icons moo-icon moo-icon-thumb_down">thumb_down</span></a>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "likes",
                                        "action" => "ajax_show",
                                        "plugin" => false,
                                        'Photo_Photo',
                                        $photo['Photo']['id'],
                                        1
                                    )),
                                    'title' => __( 'People Who Dislike This'),
                                    'innerHtml'=> '<span id="photo_dislike_count2">' . $photo['Photo']['dislike_count'] . '</span>',
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($uid == $photo['Photo']['user_id'] && $this->Storage->isLocalStorage()): ?>
                        <div class="lb_action_item">
                            <a href="#" id="rotate_left" data-id="<?php echo $photo['Photo']['id']?>" data-mode="left" aria-haspopup="true" role="button" aria-expanded="false" class="rotate_img" title="<?php echo __('Rotate Left');?>">
                                <span class="lb_rotate_icon material-icons moo-icon moo-icon-rotate_left">rotate_left</span>
                            </a>
                        </div>
                        <div class="lb_action_item">
                            <a href="#" id="rotate_right" data-id="<?php echo $photo['Photo']['id']?>" data-mode="right" aria-haspopup="true" role="button" aria-expanded="false" class="rotate_img" title="<?php echo __('Rotate Right');?>">
                                <span class="lb_rotate_icon material-icons moo-icon moo-icon-rotate_right">rotate_right</span>
                            </a>
                        </div>
                    <?php endif; ?>
                    <!-- New hook -->
                    <?php $this->getEventManager()->dispatch(new CakeEvent('photo.element.ajax.renderActionMenu', $this,array('photo'=>$photo))); ?>
                    <!-- New hook -->
                </div>
            </div>
            <!--
            <?php //if ( ( $photo['Photo']['type'] == 'Group_Group' ) ):?>
                <a href="<?php //echo $this->request->base?>/groups/view/<?php //echo $photo['Photo']['target_id']?>" id="photo_close_icon" class="lb_icon"><span class="photo-close-icon material-icons moo-icon moo-icon-clear">clear</span>KK</a>
            <?php //elseif ( ( $photo['Photo']['type'] == 'Photo_Album' ) ): ?>
                <a href="<?php //echo $this->request->base?>/albums/view/<?php //echo $photo['Photo']['target_id']?>/<?php //echo seoUrl($photo['Album']['moo_title'])?>" id="photo_close_icon" class="lb_icon"><span class="photo-close-icon material-icons moo-icon moo-icon-clear">clear</span>KK</a>
            <?php //endif; ?>
            -->
        <?php else:?>
            <div id="lb_description">
                <a href="#"><?php echo __("You can't view or interact with this image because of view privacy.");?></a>
            </div>
        <?php endif;?>

        <?php if (!empty($neighbors['next']['Photo']['id'])): ?>
            <a href="javascript:void(0)" data-id="<?php echo $neighbors['next']['Photo']['id']?>" id="photo_left_arrow" class="showPhoto lb_icon"><span class="photo_arrow_icon material-icons moo-icon moo-icon-keyboard_arrow_left">keyboard_arrow_left</span></a>
        <?php endif; ?>

        <?php if (!empty($neighbors['prev']['Photo']['id'])): ?>
            <a href="javascript:void(0)" data-id="<?php echo $neighbors['prev']['Photo']['id']?>" id="photo_right_arrow" class="showPhoto lb_icon"><span class="photo_arrow_icon material-icons moo-icon moo-icon-keyboard_arrow_right">keyboard_arrow_right</span></a>
        <?php endif; ?>
        <?php
        $nextPhoto = '';
        if(!empty($neighbors['next']['Photo']['id']))
            $nextPhoto = $neighbors['next']['Photo']['id'];
        else if(empty($neighbors['next']['Photo']['id']) && !empty($neighbors['prev']['Photo']['id']))
            $nextPhoto = $neighbors['prev']['Photo']['id'];
        ?>
    </div>
<!--</div>-->

<?php if ($is_show_full_photo):?>
    <?php $photoActor = $this->getEventManager()->dispatch(new CakeEvent('View.PhotoDetails.renderPhotoActor', $this, array('photo' => $photo, 'params' => $this->request->query))); ?>
<div class="photo-detail-warp">
    <div class="row">
        <div class="photo_right col-md-3">
<!--            <div class="bar-content">-->
                <div class="box2 bar-content-warp">
                    <div class="box_content photo_comments">
                        <?php if(!empty($photo['Photo']['caption'])): ?>
                        <div class="photo_caption">
                            <?php echo $this->Moo->formatText( $photo['Photo']['caption'], false, true, array('no_replace_ssl' => 1) )?>
                        </div>
                        <?php endif; ?>

                        <div id="tags" class="photo-tags" style="display: none;">
                            <div class="photo_view_info"><?php echo __( 'In this photo')?>: </div>
                            <div class="photo-list-tags">
                                <?php if(count($photo_tags)) : ?>
                                <?php $count = 0;
                                foreach ( $photo_tags as $tag ): ?>
                                    <span class="photoDetailTags" data-tag-id="<?php echo $tag['PhotoTag']['id']?>" id="hotspot-item-0-<?php echo $tag['PhotoTag']['id']?>">
                                <?php
                                if ( $tag['PhotoTag']['user_id'] )
                                    echo $this->Moo->getName( $tag['User'], false );
                                else
                                    echo h($tag['PhotoTag']['value']);

                                if (( $uid && $cuser['Role']['is_admin'] ) || $uid == $tag['PhotoTag']['tagger_id'] || $uid == $tag['PhotoTag']['user_id'] ):
                                    ?><a class="photoDetailRemoveTags" data-id="<?php echo $tag['PhotoTag']['id']?>" href="javascript:void(0)"><span class="photo-remove-tag-icon material-icons moo-icon moo-icon-clear">clear</span></a>
                                <?php
                                endif;
                                ?>
                            </span>
                                    <?php $count++;
                                endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <span class="photo_view_info">
                            <?php
                                $posted_by = '';
                                if (!empty($photoActor->result['name'])) {
                                    $posted_by = $photoActor->result['name'];
                                }
                                else {
                                    $posted_by = $this->Moo->getName($photo['User'], false);
                                }
                                echo __( 'Posted by %s', $posted_by)?> <?php echo $this->Moo->getTime( $photo['Photo']['created'], Configure::read('core.date_format'), $utz )
                            ?>
                        </span>

                        <?php $this->Html->rating($photo['Photo']['id'],'photos','Photo'); ?>

                        <ul class="photo-view-option">
                            <?php if ($uid == $photo['Photo']['user_id']): ?>
                                <li><a href="javascript:void(0);" class="set_cover"><?php echo __( 'Set as cover')?></a><span id="set_cover"></span></li>
                                <li><a href="javascript:void(0);" class="set_avatar"><?php echo __( 'Set as profile picture')?></a><span id="set_avatar"></span></li>
                            <?php endif; ?>

                            <?php if ( ( $uid && $cuser['Role']['is_admin'] ) || ( !empty( $admins ) && in_array( $uid, $admins ) ) ): ?>

                                <li><a href="javascript:void(0)" data-next-photo="<?php echo  $nextPhoto; ?>" id="delete_photo"><?php echo __( 'Delete Photo')?></a></li>
                            <?php endif; ?>
                            <li>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "reports",
                                        "action" => "ajax_create",
                                        "plugin" => false,
                                        'photo_photo',
                                        $photo['Photo']['id'],
                                    )),
                                    'title' => __( 'Report Photo'),
                                    'innerHtml'=> __( 'Report Photo'),
                                ));
                                ?>
                            </li>

                            <?php if ($photo['Album']['privacy'] != PRIVACY_ME && $photo['Group']['moo_privacy'] != PRIVACY_RESTRICTED && $photo['Group']['moo_privacy'] != PRIVACY_PRIVATE): ?>

                                <li>
                                    <a href="javascript:void(0);" share-url="<?php echo $this->Html->url(array(
                                        'plugin' => false,
                                        'controller' => 'share',
                                        'action' => 'ajax_share',
                                        'Photo_Photo',
                                        'id' => $photo['Photo']['id'],
                                        'type' => 'photo_item_detail'
                                    ), true); ?>" class="shareFeedBtn"><?php echo __('Share'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
<!--            </div>-->
        </div>
        <div class="photo_left col-md-9">
<!--            <div class="bar-content">-->
                <div class="box2 bar-content-warp">
                    <div class="box_content core_comments photo_comments">
                        <?php echo $this->renderComment();?>
                    </div>
                </div>
<!--            </div>-->
        </div>
    </div>
</div>

<?php endif;?>