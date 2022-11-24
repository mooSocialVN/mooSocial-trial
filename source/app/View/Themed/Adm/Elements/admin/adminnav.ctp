<!-- BEGIN SIDEBAR MENU -->
<ul class="page-sidebar-menu " data-auto-scroll="true" data-slide-speed="200">
<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
<li class="sidebar-toggler-wrapper">
    <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
    <div class="sidebar-toggler">
    </div>
    <!-- END SIDEBAR TOGGLER BUTTON -->
</li>
<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
    <li class="sidebar-search-wrapper">
        <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
        <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
        <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
        <form method="POST" action="" class="sidebar-search ">
            <a class="remove" href="javascript:;">
                <i class="spicon-close"></i>
            </a>
            <div class="input-group">
                <input type="text" placeholder="Search..." class="form-control hide">
							<span class="input-group-btn">
							<a class="btn submit hide" href="javascript:;"><i class="spicon-magnifier"></i></a>
							</span>
            </div>
        </form>
        <!-- END RESPONSIVE QUICK SEARCH FORM -->
    </li>
<li class="start ">
    <a href="javascript:;">
        <i class="spicon-home"></i>
        <span class="title"><?php echo  __('System Admin');?></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li <?php if ($cmenu == 'dashboard') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/home"><i class="spicon-home"></i> <?php echo  __('Admin Home');?></a>
        </li>
        <?php if ( $cuser['Role']['is_super'] ): ?>
            <li <?php if ($cmenu == 'make_guide') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/make_guide"><i class="spicon-question"></i> <?php echo  __('Setup Guide');?></a>
            </li>
            <li <?php if ($cmenu == 'settings') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/system_settings/view/"><i class="fa fa-cog"></i> <?php echo __("System Settings");?></a>
            </li>
            <li <?php if ($cmenu == 'social_integration') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/social/facebook/"><i class="fa fa-share-alt-square"></i> <?php echo __("Social Integration");?></a>
            </li>
			<li <?php if ($cmenu == 'subscription' || $cmenu == 'packages' || $cmenu == 'transactions' || $cmenu == 'subgateways' || $cmenu == 'subscribes' || $cmenu == 'packagecomparecolumns' || $cmenu == 'packagecompare') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/subscription/subscription_settings/"><i class="fa  fa-check"></i> <?php echo __('Subscription')?></a>
            </li>
            <li <?php if ($cmenu == 'currencies') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/billing/currencies/"><i class="fa fa-credit-card"></i> <?php echo __('Billing')?></a>
            </li>
            <li <?php if ($cmenu == 'payment_gateway') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/payment_gateway/manages/"><i class="fa fa-paypal"></i> <?php echo __('Gateways Manage')?></a>
            </li>
            <li <?php if ($cmenu == 'coupon') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/coupon/"><i class="fa fa-money"></i> <?php echo __('Coupons Manage')?></a>
            </li>
            <li <?php if ($cmenu == 'menu') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/menu/manage/"><i class="fa fa-sitemap"></i> <?php echo __('Menu')?></a>
                <span class="arrow "></span>
                <ul class="sub-menu">
	                <li <?php if ($cmenu == 'menu_profile') echo 'class="active"'; ?>>
	                    <a style="margin-right:2px;" href="<?php echo $this->request->base?>/admin/menu/manage/profile">
	                        <i class="fa fa-columns"></i> <?php echo  __('Menu Profile');?>
	                    </a>
	                </li>             
	            </ul>
            </li>
            <li <?php if ($cmenu == 'storage') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/storage/storages"><i class="fa fa-file"></i> <?php echo __('Storage System')?></a>
            </li>
            <li <?php if ($cmenu == 'cache') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/cache"><i class="fa fa-file"></i> <?php echo __('Cache')?></a>
            </li>
            <li <?php if ($cmenu == 'notification') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/admin_notifications"><i class="fa fa-list-ul"></i> <?php echo __('Admin Notifications')?></a>
            </li>
			<li <?php if ($cmenu == 'cron') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/cron/task"><i class="fa fa-list-ul"></i> <?php echo __('Tasks')?></a>
            </li>
            <li <?php if ($cmenu == 'mail') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/mail/mail_plugins"><i class="spicon-envelope"></i> <?php echo __('Mails')?></a>
            </li>
            <li <?php if ($cmenu == 'profile_fields') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/profile_fields"><i class="spicon-check"></i> <?php echo  __('Profile Types');?></a>
            </li>
            <li <?php if ($cmenu == 'bulkmail') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/tools/bulkmail"><i class="spicon-envelope"></i> <?php echo  __('Bulk Mail');?></a>
            </li>
            <li <?php if ($cmenu == 'spam_challenges') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/spam_challenges"><i class="spicon-question"></i> <?php echo  __('Spam Challenges');?></a>
            </li>
<!--            <li --><?php //if ($cmenu == 'ratings') echo 'class="active"'; ?>
<!--                <a href="--><?php //echo $this->request->base?><!--/admin/ratings"><i class="fa fa-star"></i> --><?php //echo  __('Rating Manager');?><!--</a>-->
<!--            </li>-->
        <?php else:?>
            <li <?php if ($cmenu == 'notification') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/admin_notifications"><i class="fa fa-list-ul"></i> <?php echo __('Admin Notifications')?></a>
            </li>
        <?php endif; ?>
        <li <?php if ($cmenu == 'users') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/users"><i class="spicon-user"></i> <?php echo  __('Users Manager');?></a>
        </li>       
    </ul>
</li>
<?php if ( $cuser['Role']['is_super'] ): ?>
<li>
    <a href="javascript:;">
        <i class="fa fa-gears"></i>
        <span class="title"><?php echo  __('Site Manager');?></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <li <?php if ($cmenu == 'roles') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/roles"><i class="spicon-briefcase"></i> <?php echo  __('User Roles');?></a>
        </li>

        <li <?php if ($cmenu == 'themes') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/themes"><i class="spicon-rocket"></i> <?php echo  __('Themes Manager');?></a>
            <span class="arrow "></span>
            <ul class="sub-menu">
                <li <?php if ($cmenu == 'layout') echo 'class="active"'; ?>>
                    <a style="margin-right:2px;" href="<?php echo $this->request->base?>/admin/layout">
                        <i class="fa fa-columns"></i> <?php echo  __('Layout Editor');?>
                    </a>
                </li>
                <li <?php if ($cmenu == 'themes_create') echo 'class="active"'; ?>>
                    <?php
      $this->MooPopup->tag(array(
             'href'=>$this->Html->url(array("controller" => "themes",
                                            "action" => "admin_ajax_create",
                                            "plugin" => false,
                                     
                                        )),
             'title' => '',
             'innerHtml'=> '<i class="fa fa-plus"></i>' .  __('Create New Theme'),
     ));
 ?>

                </li>                
            </ul>
        </li>
        <li <?php if ($cmenu == 'languages') echo 'class="active"'; ?>>
            <a href="<?php echo $this->request->base?>/admin/languages"><i class="spicon-globe "></i> <?php echo  __('Languages Manager');?></a>
        </li>
    </ul>
</li>
<?php endif; ?>

<?php $pluginMenus = $this->requestAction('plugins/pluginMenu');?>
<?php $totalNewVersion = $this->requestAction('plugins/totalNewVersion');?>
<li class="last ">
    <a href="javascript:;">
        <i class="spicon-puzzle"></i>
        <span class="title"><?php echo  __('Plugins Manager');?></span>
        <span class="arrow "></span>
    </a>
    <ul class="sub-menu">
        <?php if ( $cuser['Role']['is_super'] ): ?>
            <li <?php if ($cmenu == 'plugins') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/plugins">
                    <i class="spicon-puzzle"></i> <?php echo  __('Manager');?>
                    <?php if($totalNewVersion > 0):?>
                        <b style="color: red">(<?php echo $totalNewVersion;?>)</b>
                    <?php endif;?>
                </a>
            </li>
            <li <?php if ($cmenu == 'addon_upload') echo 'class="active"'; ?>>
                <a href="<?php echo $this->request->base?>/admin/addon_upload"><i class="spicon-cloud-upload"></i> <?php echo __('Upload Addons')?></a>
            </li>
        <?php endif; ?>
        <?php
        $array_plugin = array(
        		'Blog' => array(
        				'class' => 'spicon-speech',
        				'key' => 'Blog',
        				'title' => __('Blogs Manager'),
        				'link' => '/admin/blog/blog_plugins'
        		),
        		'Page' => array(
        				'class' => 'fa fa-file-o',
        				'key' => 'Page',
        				'title' => __('Pages Manager'),
        				'link' => '/admin/page/page_plugins'
        		),
        		'Video' => array(
        				'class' => 'spicon-social-youtube',
        				'key' => 'Video',
        				'title' => __('Videos Manager'),
        				'link' => '/admin/video/video_plugins'
        		),
        		'Topic' => array(
        				'class' => 'spicon-social-tumblr',
        				'key' => 'Topic',
        				'title' => __('Topics Manager'),
        				'link' => '/admin/topic/topic_plugins'
        		),
        		'Photo' => array(
        				'class' => 'spicon-social-tumblr',
        				'key' => 'Photo',
        				'title' => __('Albums Manager'),
        				'link' => '/admin/photo/photo_plugins'
        		),
        		'Group' => array(
        				'class' => 'spicon-users',
        				'key' => 'Group',
        				'title' => __('Groups Manager'),
        				'link' => '/admin/group/group_plugins'
        		),
        		'Event' => array(
        				'class' => 'spicon-calendar',
        				'key' => 'Event',
        				'title' => __('Events Manager'),
        				'link' => '/admin/event/event_plugins'
        		),
        		'tags' => array(
        				'class' => 'spicon-tag',
        				'key' => 'tags',
        				'title' => __('Tags Manager'),
        				'link' => '/admin/tags'
        		),
        		'countries' => array(
        				'class' => 'spicon-globe',
        				'key' => 'countries',
        				'title' => __('Country Manager'),
        				'link' => '/admin/countries'
        		),
        )
        ?>
        <?php 
        if($pluginMenus != null)
        	$array_plugin = array_merge($pluginMenus,$array_plugin);
        ?>
        <?php
        function cmp($a, $b)
        {
        	$v_a = '';
        	if (isset($a['Plugin']))
        	{
        		$v_a = $a['Plugin']['name'];
        	}
        	else
        	{
        		$v_a = $a['title'];
        	}
        	
        	$v_b = '';
        	if (isset($b['Plugin']))
        	{
        		$v_b = $b['Plugin']['name'];
        	}
        	else
        	{
        		$v_b = $b['title'];
        	}
        	$v_a = strtolower($v_a);
        	$v_b = strtolower($v_b);
        	return ($v_a > $v_b);
        }
        usort($array_plugin, "cmp");        
        ?>
        
        <?php foreach ($array_plugin as $item):?>
        	<?php  if (isset($item['Plugin'])) :?>
        		<?php
        		$pluginMenu = $item['Plugin'];
        		$active = ($cmenu == $pluginMenu['name']) ? $pluginMenu['name'] : '';
        		echo $this->Moo->renderMenu($pluginMenu['key'], $active, 'admin', 'vertical');
        		?>
        	<?php else:?>
        		<li <?php if ($item['key']== $cmenu) echo 'class="active"'; ?>>
		            <a href="<?php echo $this->request->base.$item['link']?>"><i class="<?php echo $item['class']?>"></i> <?php echo  $item['title'];?></a>
		        </li>
        	<?php endif;?>
        <?php endforeach;?>
    </ul>
</li>

    <?php
    if ( $this->elementExists('menu/admin') )
        echo $this->element('menu/admin');
    ?>

</ul>
<!-- END SIDEBAR MENU -->
