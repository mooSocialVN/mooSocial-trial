<?php
$groupHelper = MooCore::getInstance()->getHelper('Group_Group');
$topic_id = !empty( $this->request->named['topic_id'] ) ? $this->request->named['topic_id'] : 0;
$video_id = !empty( $this->request->named['video_id'] ) ? $this->request->named['video_id'] : 0;
$comment_id = !empty( $this->request->named['comment_id'] ) ? $this->request->named['comment_id'] : 0;
$reply_id = !empty( $this->request->named['reply_id'] ) ? $this->request->named['reply_id'] : 0;
$tab = !empty( $tab ) ? $tab : '';
$is_edit = !empty( $this->request->named['edit'] ) ? $this->request->named['edit'] : 0;
?>

<?php if($this->request->is('ajax')): ?>
<script>
    require(["jquery","mooGroup", "hideshare"], function($,mooGroup) {
        mooGroup.initOnView();
        $(".sharethis").hideshare({media: '<?php echo $groupHelper->getImage($group,array('prefix' => '300_square'))?>', linkedin: false});
    });
</script>
<?php else: ?>
    <?php $this->Html->scriptStart(array('inline' => false,'requires'=>array('jquery','mooGroup', 'hideshare'),'object'=>array('$','mooGroup'))); ?>
    mooGroup.initOnView();
    $(".sharethis").hideshare({media: '<?php echo $groupHelper->getImage($group,array('prefix' => '300_square'))?>', linkedin: false});
    <?php $this->Html->scriptEnd(); ?>
<?php endif; ?>

<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
    <?php
        $display = true;
        if ($group['Group']['type'] == PRIVACY_PRIVATE) {
            if (empty($is_member)) {
                $display = false;
                if(!empty($cuser) && $cuser['Role']['is_admin'])
                    $display = true;
            }
        }
    ?>
    
    <?php if($display): ?>
    <div class="box2 bar-content-warp">
        <div class="box_content box_about">
            <div class="core-about-info">
                <div class="core-about-figure">
                    <img class="core-about-img" src="<?php echo $groupHelper->getImage($group, array('prefix' => '300_square'))?>">
                </div>
                <div class="core-about-main">
                    <div class="core-about-head"><?php echo $group['Group']['name']?></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
<?php $this->end(); ?>

<?php echo $this->element('view_browse_tabs')?>

<div id="profile-content" class="group-detail">
    <?php if ( empty( $tab ) ): ?>
    <?php
    if ( !empty( $this->request->named['topic_id'] ) || !empty( $this->request->named['video_id'] ) )
        echo __( 'Loading...');
    else
        echo $this->element('ajax/group_detail');
    ?>
    <?php else: ?>
        <?php echo __( 'Loading...')?>
    <?php endif; ?>
    <div class="groupId" data-id="<?php echo $group['Group']['id']; ?>"></div>
    <div class="topicId" data-id="<?php echo $topic_id; ?>"></div>
    <div class="videoId" data-id="<?php echo $video_id; ?>"></div>
    <div class="commentId" data-id="<?php echo $comment_id; ?>"></div>
    <div class="replyId" data-id="<?php echo $reply_id; ?>"></div>
    <div class="tab" data-id="<?php echo $tab; ?>"></div>
    <div class="isEdit" data-id="<?php echo $is_edit; ?>"></div>
</div>