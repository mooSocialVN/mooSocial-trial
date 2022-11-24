<?php
echo $this->Html->css(array('visualize'), null, array('inline' => false));
echo $this->Html->script(array('enhance', 'excanvas', 'visualize.jQuery'), array('inline' => false));
?>

<script>
function clearNotifications()
{
	$.get('<?php echo $this->request->base?>/admin/admin_notifications/ajax_clear');
	$("#notifications_list").slideUp();
}

$(function(){
    $('#reg_content .admin_chart').visualize({type: 'line', width: '480px'});
    
    $('.chart-tabs li a').click(function(){
        $('.chart-tabs li a').removeClass('current');
        $(this).addClass('current');
        $('.tab').hide();
        $('#'+$(this).attr('id')+'_content').show();
        
        $('.visualize').remove();
        $('#'+$(this).attr('id')+'_content .admin_chart').visualize({type: 'line', width: '480px'});
    });
});
</script>

<?php echo $this->element('admin/adminnav', array("cmenu" => "dashboard"));?>

<div id="center">
	<div style="float:right;width:235px">
	    <div class="box2 box_style3">
    		<h3><?php echo __('Admin Notifications') ?><a href="javascript:void(0)" style="float:right" class="tip" title="Clear all notifications" onclick="clearNotifications()"><i class="icon-check icon-large"></i></a></h3>
    		<div class="box_content">
        		<?php if ( empty($admin_notifications) ): ?>
        			<div style="margin-bottom:10px"><?php echo __('No new notifications')?></div>
        		<?php else: ?>
        		<ul class="list2" id="notifications_list" style="margin: -8px 0 10px 0;max-height: 190px;overflow: auto;">
        		<?php foreach ($admin_notifications as $noti): ?>
        			<li style="border-bottom:1px solid #DFDFDF;" <?php if (!$noti['AdminNotification']['read']) echo 'class="unread"';?>>
        				<a href="<?php echo $this->request->base?>/admin/admin_notifications/ajax_view/<?php echo $noti['AdminNotification']['id']?>" <?php if ( !empty($noti['AdminNotification']['message']) ):?>class="overlay" title="<?php echo __('Notification Detail');?>"<?php endif; ?>>
        					<b><?php echo $noti['User']['name']?></b> <?php echo $noti['AdminNotification']['text']?><br />
        					<span class="date"><?php echo $this->Moo->getTime( $noti['AdminNotification']['created'], Configure::read('core.date_format'), $utz )?></span>
        				</a>
        			</li>
        		<?php endforeach; ?>
        		</ul>
        		<?php endif; ?>
    		</div>
    	</div>
		
		<?php if ( !empty( $feeds ) ): ?>
		<div class="box2">
    		<h3>mooSocial News</h3>
    		<div class="box_content">
        		<ul class="list6 list6sm" style="margin-bottom:5px;max-height: 190px;overflow: auto;">
        		<?php 
        		foreach ($feeds->item as $feed):
        		?>
        			<li style="border-bottom:1px solid #DFDFDF; padding-bottom: 5px">
        				<a href="<?php echo $feed->link?>" target="_blank"><?php echo $feed->title?></a><br />
        				<span class="date"><small><?php echo $feed->pubDate?></small></span>
        			</li>
        		<?php
        		endforeach;
        		?>
        		</ul>    			
        		<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fmoosocial&amp;send=false&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=185109971574792" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>
        	</div>
		</div>
		<?php endif; ?>   

		<div class="box2">
    		<h3>Tools & Support</h3>
    		<div class="box_content">
        		<div style="line-height: 1.5">
        		    <a href="<?php echo $this->request->base?>/admin/tools/clear_cache">Clear Global Caches</a><br />
                    <a href="<?php echo $this->request->base?>/admin/tools/clean_tmp" class="overlay" title="Cleaning Temp Upload Folder">Clean Temp Upload Folder</a><br />
                    <a href="<?php echo $this->request->base?>/admin/tools/remove_notifications">Remove Old Notifications</a><br />
        		</div>
        		<div class="box4" style="line-height: 1.5">
            		<a href="http://www.moosocial.com" target="_blank">mooSocial.com</a><br />
            		<a href="http://clients.moosocial.com" target="_blank">Clients Area</a><br />
            		<a href="http://community.moosocial.com" target="_blank">mooCommunity</a><br />
            		<a href="http://community.moosocial.com/topics" target="_blank">Themes & Plugins</a><br />
                </div>
            </div>
        </div>
	</div>
	
	<div style="line-height:1.5; float: left; width: 510px">
		<h1>Admin Dashboard</h1>
		<div style="font-size: 12px;margin-bottom: 20px">
			<iframe src="https://www.moosocial.com/version.php?version=<?php echo Configure::read('core.version')?>" frameborder="0" scrolling="no" height="25" width="100%"></iframe>
			<br />
			<ul class="list8 admin_stats">
			    <li><i class="icon-user icon-large"></i><br />
			        <span><?php echo $user_count?></span><br />
			        Users
			    </li>
			    <li><i class="icon-edit icon-large"></i><br />
                    <span><?php echo $blog_count?></span><br />
                    Blogs
                </li>
			    <li><i class="icon-picture icon-large"></i><br />
                    <span><?php echo $photo_count?></span><br />
                    Photos
                </li>
                <li><i class="icon-facetime-video icon-large"></i><br />
                    <span><?php echo $video_count?></span><br />
                    Videos
                </li>
                <li><i class="icon-comment icon-large"></i><br />
                    <span><?php echo $topic_count?></span><br />
                    Topics
                </li>
                <li><i class="icon-group icon-large"></i><br />
                    <span><?php echo $group_count?></span><br />
                    Groups
                </li>
                <li><i class="icon-calendar icon-large"></i><br />
                    <span><?php echo $event_count?></span><br />
                    Events
                </li>
			</ul>
		</div>
		
		<ul class="list7 chart-tabs" id="feed-type" style="float:right;margin:-5px 0 5px 0">
            <li><a href="javascript:void(0)" class="current" id="reg">Registration</a></li>
            <li><a href="javascript:void(0)" id="act">Activities</a></li>
        </ul>
		<h2>Site Stats</h2>
		
		<div style="margin:30px 0 60px 10px">
		    <div id="reg_content" class="tab" style="display:block">
        		<table class="admin_chart" style='display:none'>
                    <caption>Registration Over Past 7 Days</caption>
                    <thead>
                        <tr>
                            <td></td>
                            <?php foreach ( $stats as $day => $stat ): ?>
                            <th scope="col"><?php echo $day?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">New Users</th>
                            <?php foreach ( $stats as $day => $stat ): ?>
                            <td><?php echo $stat['users']?></td>
                            <?php endforeach; ?> 
                        </tr>     
                    </tbody>
                </table>
            </div>
            
            <div id="act_content" class="tab">
                <table class="admin_chart" style='display:none'>
                    <caption>Activities Over Past 7 Days</caption>
                    <thead>
                        <tr>
                            <td></td>
                            <?php foreach ( $stats as $day => $stat ): ?>
                            <th scope="col"><?php echo $day?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>   
                        <tr>
                            <th scope="row">Activities</th>
                            <?php foreach ( $stats as $day => $stat ): ?>
                            <td><?php echo $stat['activities']?></td>
                            <?php endforeach; ?> 
                        </tr>    
                    </tbody>
                </table>
            </div>
        </div>
		
		<h2>Admin Notes</h2>
		<form action="<?php echo $this->request->base?>/admin/settings" method="post">
		<?php echo $this->Form->textarea('admin_notes', array('value' => Configure::read('core.admin_notes'), 'style' => 'width:500px;height:200px')); ?>
		<div align="center" style="margin-top:10px"><input type="submit" class="button button-action button-medium" value="Save Notes"></div>
		</form>
	</div>
</div>