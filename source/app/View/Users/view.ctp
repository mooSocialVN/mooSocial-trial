<?php echo $this->Html->css(array('cropper.min'), null, array('inline' => false));?>
<style>
    #themeModal .modal-body{
        padding:15px;
    }
</style>

<?php if (empty($profile_has_activity)):?>

<?php if($this->request->is('ajax')): ?>
<script type="text/javascript">
    require(["jquery","mooUser"], function($,mooUser) {
        mooUser.initOnUserView();
    });
</script>
<?php else: ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery','mooUser'), 'object' => array('$', 'mooUser'))); ?>
mooUser.initOnUserView();
<?php $this->Html->scriptEnd(); ?> 
<?php endif; ?>


<?php $this->setNotEmpty('west');?>
<?php $this->start('west'); ?>
	<?php if ( $canView ): ?>

	<?php if ($user['User']['friend_count']): ?>
	<div class="box2 bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title"><?php echo __('Friends')?> <span class="box_header_count">(<?php echo $user['User']['friend_count']?>)</span></h3>
            </div>
        </div>
		<div class="box_content box_friend box-region-west">
		    <?php echo $this->element( 'blocks/users_block', array( 'users' => $friends ) ); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if ( !empty( $mutual_friends ) ): ?>
	<div class="box2 bar-content-warp">
        <div class="box_header">
            <div class="box_header_main">
                <h3 class="box_header_title">
                    <?php $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "friends",
                            "action" => "ajax_show_mutual",
                            "plugin" => false,
                            $user['User']['id']

                        )),
                        'title' => __('Mutual Friends'),
                        'innerHtml'=> __('Mutual Friends'),
                    ));
                    ?>
                </h3>
            </div>
        </div>
		<div class="box_content box_mutual-friend box-region-west">
		    <?php echo $this->element( 'blocks/users_block', array( 'users' => $mutual_friends ) ); ?>
		</div>
	</div>
	<?php endif; ?>
    <?php endif; ?>

	<?php if ( $canView ): ?>
	    
		 <?php echo $this->element('Video.blocks/videos_block', array('title' => __('Videos'), 'region' => 'west')); ?>
	
		<?php echo $this->element('Blog.blocks/blogs_block', array('title' => __('Blogs'), 'region' => 'west')); ?>
	
		<?php echo $this->element('Group.blocks/group_block', array('title' => __('Groups'), 'region' => 'west')); ?>
		
	<?php endif; ?>
	
<?php $this->end(); ?>
<?php elseif (!empty($friend_suggestions)):?>
<?php $this->setNotEmpty('east');?>
<?php $this->start('east'); ?>
	<?php echo $this->renderFile('/Widgets/user/suggestions',array('title_enable'=>true,'title'=>__('People You May Know'), 'region' => 'east'))?>
<?php $this->end(); ?>
<?php endif;?>
<div class="profilePage">
	<div id="profile-content">
		<?php 
		if ( !empty( $activity ) )
		{   
			echo '<div class="feed-entry-lists" id="list-content">';
                        ?>
                        <?php if (isset($groupTypeItem['type'])): ?>
                            <?php if($groupTypeItem['type'] == PRIVACY_RESTRICTED && !$groupTypeItem['is_member']): ?>
                            <div class="privacy_mess">
                                <div class="m_b_5"><?php echo __('This content is private'); ?></div>
                                <a href="javascript:void(0);" onclick="return requestJoinGroup(<?php echo $groupTypeItem['id']; ?>);" class="btn btn-action"><?php echo __('Join Group to access'); ?></a>
                            </div>
                            <?php elseif($groupTypeItem['type'] == PRIVACY_PRIVATE && !$groupTypeItem['is_member']): ?>
                                <div class="privacy_mess"><?php echo __('This is a private group. You must be invited by a group admin in order to join'); ?></div>

                            <?php else: ?>
                                <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                                    <?php echo $this->element( 'activities', array( 'activities' => array( $activity ) ) ); ?>
                                <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                                    <?php echo $this->element( 'activities_chrono', array( 'activities' => array( $activity ) ) ); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php elseif(isset($eventTypeItem) && empty($eventTypeItem)): ?>
                            <div class="privacy_mess"><?php echo __('This is a private event.'); ?></div>
                        <?php else: ?>
                            <?php if (Configure::read('core.comment_sort_style') == COMMENT_RECENT): ?>
                                <?php echo $this->element( 'activities', array( 'activities' => array( $activity ) ) ); ?>
                            <?php elseif(Configure::read('core.comment_sort_style') == COMMENT_CHRONOLOGICAL): ?>
                                <?php echo $this->element( 'activities_chrono', array( 'activities' => array( $activity ) ) ); ?>
                            <?php endif; ?>
                        <?php endif; ?>
			<?php echo '</ul>';
		}
		else
		{
			if ( $canView ){
                echo $this->element('ajax/profile_detail');
            }
			else{
                echo '<div class="privacy_profile box2 bar-content-warp"><div class="box_content">';
                printf( __('%s only shares some information with everyone'), $user['User']['name'] );
                echo '</div></div>';
            }
		}
		?>
	</div>
</div> 