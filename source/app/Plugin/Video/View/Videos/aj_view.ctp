<?php
if (Configure::read('UploadVideo.uploadvideo_enabled')) {
    echo $this->Html->css(array('video-js/video-js'), null, array('inline' => false));
    echo $this->Html->script(array('video-js/video-js'), array('inline' => false));
}

$videoHelper = MooCore::getInstance()->getHelper('Video_Video');

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
<script>
    window.history.pushState({}, "", "<?php echo $video['Video']['moo_href'] ?>");

    require(["jquery","mooVideo","mooComment"], function($, mooVideo,mooComment) {
        mooVideo.initOnView();
        mooComment.initReplyCommentItem();
        mooComment.initCloseComment();
    });
</script>
<div class="bar-content video_group_detail">
    <div class="box2 bar-content-warp">
        <div class="video-detail">
            <?php echo $this->element('Video./video_snippet', array('video' => $video)); ?>
        </div>
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo $video['Video']['title']?></h1>
                <div class="box_action">
                    <?php if ($uid == $video['Video']['user_id'] || ( !empty($cuser['Role']['is_admin']) ) || in_array($uid, $admins) ): ?>
                    <div class="box-dropdown">
                        <div class="dropdown">
                            <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                                <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <?php
                                    $this->MooPopup->tag(array(
                                        'href'=>$this->Html->url(array("controller" => "videos",
                                            "action" => "create",
                                            "plugin" => 'video',
                                            $video['Video']['id']

                                        )),
                                        'title' => __('Edit Video'),
                                        'innerHtml'=> __( 'Edit Video'),
                                    ));
                                    ?>
                                </li>
                                <li>
                                    <a href="javascript:void(0)" class="deleteVideo" data-id="<?php echo $video['Video']['id']?>">
                                        <?php echo __('Delete Video');?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="box_content">
            <div class="post_body">
                <div class="post_content">
                    <?php echo $this->Moo->formatText( $video['Video']['description'], false, true , array('no_replace_ssl' => 1))?>
                </div>
                <div class="extra_info">
                    <?php echo __( 'Posted by %s', $this->Moo->getName($video['User']))?> <?php echo $this->Moo->getTime($video['Video']['created'], Configure::read('core.date_format'), $utz)?>
                </div>
                <?php echo $this->element('likes', array('item' => $video['Video'], 'type' => 'Video_Video', 'hide_container' => true)); ?>
            </div>
        </div>
    </div>

    <div class="box2 bar-content-warp">
        <div class="box_content">
            <?php if ($video['Group']['moo_privacy'] == PRIVACY_PUBLIC): ?>
                <?php echo $this->element('likes', array('shareUrl' => $this->Html->url(array(
                    'plugin' => false,
                    'controller' => 'share',
                    'action' => 'ajax_share',
                    'Video_Video',
                    'id' => $video['Video']['id'],
                    'type' => 'video_item_detail'
                ), true), 'item' => $video['Video'], 'type' => $video['Video']['moo_type'])); ?>
            <?php else: ?>
                <?php echo $this->element('likes', array('doNotShare' => true, 'shareUrl' => $this->Html->url(array(
                    'plugin' => false,
                    'controller' => 'share',
                    'action' => 'ajax_share',
                    'Video_Video',
                    'id' => $video['Video']['id'],
                    'type' => 'video_item_detail'
                ), true), 'item' => $video['Video'], 'type' => $video['Video']['moo_type'])); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="box2 bar-content-warp">
        <div class="box_content core_comments video-comment">
            <div class="comment_header_title">
                <?php echo __( 'Comments (%s)', $video['Video']['comment_count'])?>
            </div>
            <div class="comment_holder content_comment">
                <?php if ($is_owner ): ?>
                <a class="closeComment" data-id="<?php echo $video['Video']['id']?>" data-type="<?php echo $video['Video']['moo_type']?>" data-close="<?php echo $is_close_comment;?>" href="javascript:void(0)" >
                    <?php echo $title; ?>
                </a>
                <?php endif; ?>

                <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>

                    <?php
                    if ( !isset( $is_member ) || $is_member  ){
                        if($is_close_comment && !$is_owner){
                            echo '<div class="closed-comment">'.__('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User'])). '</div>';
                        }else {
                            echo $this->element('comment_form', array('target_id' => $video['Video']['id'], 'type' => 'Video_Video'));
                        }
                    } else {
                        echo __('This a group video. Only group members can leave comment');
                    }
                    ?>
                    <div id="comments" class="comment_lists comment_parent_lists">
                        <?php echo $this->element('comments');?>
                    </div>

                <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>

                    <div id="comments" class="comment_lists comment_parent_lists">
                        <?php echo $this->element('comments_chrono');?>
                    </div>
                    <?php
                    if ( !isset( $is_member ) || $is_member  ) {
                        if($is_close_comment && !$is_owner){
                            echo '<div class="closed-comment">'.__('%s turned off commenting for this post', $this->Moo->getName($item_close_comment['User'])). '</div>';
                        }else {
                            echo $this->element('comment_form', array('target_id' => $video['Video']['id'], 'type' => 'Video_Video'));
                        }
                    }else {
                        echo __('This a group video. Only group members can leave comment');
                    }
                    ?>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>