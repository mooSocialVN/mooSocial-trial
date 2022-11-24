<?php
$videoHelper = MooCore::getInstance()->getHelper('Video_Video');
?>

<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery', 'mooVideo', 'hideshare'), 'object' => array('$', 'mooVideo'))); ?>
$(".sharethis").hideshare({media: '<?php echo $videoHelper->getImage($video, array('prefix' => '300_square'));?>', linkedin: false});
mooVideo.initOnView();
<?php $this->Html->scriptEnd(); ?> 

<?php $this->setNotEmpty('east');?>
<?php $this->start('east'); ?>
    
    <?php if(!empty($tags)): ?>
        <div class="box2 bar-content-warp">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Tags') ?></h3>
                </div>
            </div>
            <div class="box_content">
                <?php echo $this->element( 'blocks/tags_item_block' ); ?>
            </div>
        </div>
    <?php endif; ?>
	<?php if ( !empty( $similar_videos ) ): ?>
        <div class="box2 bar-content-warp box_style2">
            <div class="box_header">
                <div class="box_header_main">
                    <h3 class="box_header_title"><?php echo __('Similar Videos') ?></h3>
                </div>
            </div>
            <div class="box_content">
                <?php echo $this->element('blocks/videos_block', array('videos' => $similar_videos)); ?>
            </div>
        </div>
	<?php endif; ?>
<?php $this->end(); ?>
<div class="box2">
    <div class="video-detail">
        <?php echo $this->element('Video./video_snippet', array('video' => $video)); ?>
    </div>
</div>

<div class="box2 box_view bar-content-warp">
    <div class="box_header mo_breadcrumb">
        <div class="box_header_main">
            <h1 class="box_header_title"><?php echo $video['Video']['title']?></h1>
            <div class="box_action">
                <div class="box-dropdown">
                    <div class="dropdown">
                        <a class="box-btn btn-header_icon" href="javascript:void(0);" data-target="#" data-toggle="dropdown">
                            <span class="btn-icon material-icons moo-icon moo-icon-more_vert">more_vert</span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($video['User']['id'] == $uid || ( !empty($cuser) && $cuser['Role']['is_admin'] ) || ( !empty($admins) && in_array($uid, $admins) )): ?>
                            <li>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "videos",
                                        "action" => "create",
                                        "plugin" => 'video',
                                        $video['Video']['id']

                                    )),
                                    'title' => __( 'Edit Video Details'),
                                    'innerHtml'=> __( 'Edit Video'),
                                ));
                                ?>
                            </li>
                            <li><a href="javascript:void(0)" class="deleteVideo" data-id="<?php echo $video["Video"]["id"]; ?>"><?php echo __( 'Delete Video')?></a></li>
                            <?php endif; ?>
                            <li>
                                <?php
                                $this->MooPopup->tag(array(
                                    'href'=>$this->Html->url(array("controller" => "reports",
                                        "action" => "ajax_create",
                                        "plugin" => false,
                                        'Video_Video',
                                        $video['Video']['id']
                                    )),
                                    'title' => __( 'Report Video'),
                                    'innerHtml'=> __( 'Report Video'),
                                ));
                                ?>
                            </li>

                            <?php if ($video['Video']['privacy'] != PRIVACY_ME): ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box_content">
        <div class="post_body">
            <?php if (isset($group) && $group):?>
            <div class="post_header">
                <?php echo __('In group');?>: <a href="<?php echo $group['Group']['moo_href']?>"><?php echo $group['Group']['moo_title']?></a>
            </div>
            <?php endif;?>
            <div class="post_content">
                <div class="video-description truncate" data-more-text="<?php echo __( 'Show More')?>" data-less-text="<?php echo __( 'Show Less')?>">
                    <?php echo $this->Moo->formatText( $video['Video']['description'], false, true, array('no_replace_ssl' => 1) )?>
                </div>
            </div>
            <div class="extra_info">
                <?php echo __( 'Posted by %s', $this->Moo->getName($video['User']))?> <?php echo __( 'in')?> <a href="<?php echo $this->request->base?>/videos/index/<?php echo $video['Video']['category_id']?>/<?php echo seoUrl($video['Category']['name'])?>"><?php echo $video['Category']['name']?></a> <?php echo $this->Moo->getTime($video['Video']['created'], Configure::read('core.date_format'), $utz)?>
                &nbsp;&middot;&nbsp;<?php if ($video['Video']['privacy'] == PRIVACY_PUBLIC): ?>
                    <?php echo __('Public') ?>
                <?php elseif ($video['Video']['privacy'] == PRIVACY_ME): ?>
                    <?php echo __('Private') ?>
                <?php elseif ($video['Video']['privacy'] == PRIVACY_FRIENDS): ?>
                    <?php echo __('Friend Only') ?>
                <?php endif; ?>
            </div>
            <?php $this->Html->rating($video['Video']['id'],'videos', 'Video'); ?>
        </div>
    </div>
</div>
<div class="box2 bar-content-warp">
    <div class="box_content">
        <?php echo $this->element('likes', array('shareUrl' => $this->Html->url(array(
            'plugin' => false,
            'controller' => 'share',
            'action' => 'ajax_share',
            'Video_Video',
            'id' => $video['Video']['id'],
            'type' => 'video_item_detail'
        ), true), 'item' => $video['Video'], 'type' => $video['Video']['moo_type'])); ?>
    </div>
</div>
<div class="box2 bar-content-warp">
    <div class="box_content core_comments video-comment">
        <?php echo $this->renderComment();?>
    </div>
</div>