<?php if (!empty($uid)): ?>
    <!-- BEGIN USER LOGIN DROPDOWN -->
    <li class="dropdown dropdown-user">
        <a href="<?php echo $this->Moo->getProfileUrl( $cuser )?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
           <?php echo $this->Moo->getImage(array('User' => $cuser), array( "alt" => $cuser['name'], "class" => "", 'prefix' => '50_square'))?>
					<span class="username username-hide-on-mobile"><?php echo $cuser['name'];?></span>
            <i class="material-icons">expand_more</i>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?php echo $this->Moo->getProfileUrl( $cuser )?>">
                     <?php echo __('My Profile');?> </a>
            </li>
            <li>
                <a href="<?php echo $this->request->base?>/admin/home">
                    <?php echo __('Admin Dashboard')?> </a>
            </li>

            <li>
                <a href="<?php echo  $this->request->base; ?>/home/index/tab:notifications">
                    <?php echo __('Notification');?>  <?php if (!empty($cuser['notification_count'])): ?><span class="badge badge-danger"><?php echo $cuser['notification_count']?></span><?php endif; ?></a>
            </li>
            <li>
                <a href="<?php echo  $this->request->base; ?>/home/index/tab:messages">
                     <?php echo __('My Inbox');?> <?php if ( $cuser['conversation_user_count'] > 0 ): ?> <span class="badge badge-danger">
							<?php echo  $cuser['conversation_user_count'];?></span> <?php endif; ?></a>
            </li>
            <li>
                <a href="<?php echo $this->request->base?>/users/profile">
                     <?php echo __('Profile Information')?>
                </a>
            </li>
            <?php if ( $cuser['friend_request_count'] > 0 ): ?>
                <li>
                    <a href="<?php echo $this->request->base?>/home/index/tab:friend-requests">
                         <?php echo __('Friend Requests')?> <span class="badge badge-danger">
							<?php echo $cuser['friend_request_count']?> </span>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="<?php echo $this->request->base?>/home/index/tab:invite-friends">
                    <?php echo __('Invite Friends')?>
                </a>
            </li>
            <li class="divider">
            </li>

            <li>
                <a href="<?php echo $this->request->base?>/users/do_logout">
                     <?php echo __('Log Out')?> </a>
            </li>
        </ul>
    </li>
    <!-- END USER LOGIN DROPDOWN -->
<?php endif; ?>

