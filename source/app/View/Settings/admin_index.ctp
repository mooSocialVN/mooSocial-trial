<script>
jQuery(document).ready(function(){
	initTabs('settings_index');
});
</script>

<style>
.list6 label {
	width: 190px;
}
</style>

<?php echo $this->element('admin/adminnav', array("cmenu" => "settings"));?>

<div id="center">
<form action="<?php echo $this->request->base?>/admin/settings" enctype="multipart/form-data" method="post">
	<h1>System Settings</h1>
	
	<div id="settings_index">
    	<div class="tabs-wrapper">
    		<ul class="tabs">
    			<li id="general" class="active">General</li>
    			<li id="features">Features</li>			
    			<li id="security">Security</li>
    			<li id="ad">Custom Blocks</li>
    			<li id="integration">Integration</li>
    			<li id="siteLogo">Logo</li>
    		</ul>
    	</div>
    	<div id="general_content" class="tab" style="display:block">
    		<ul class="list6">
    			<li><label>Site Name</label>
    				<?php echo $this->Form->text('site_name', array('value' => Configure::read('core.site_name'))); ?>
    			</li>
    			<li><label>Site Email</label>
    				<?php echo $this->Form->text('site_email', array('value' => Configure::read('core.site_email'))); ?>
    			</li>
    			<li><label>Site Keywords</label>
    				<?php echo $this->Form->textarea('site_keywords', array('value' => Configure::read('core.site_keywords'))); ?>
    			</li>
    			<li><label>Site Description</label>
    				<?php echo $this->Form->textarea('site_description', array('value' => Configure::read('core.site_description'))); ?>
    			</li>
    			<li><label>Take Site Offline</label>
    				<?php echo $this->Form->checkbox('site_offline', array('checked' => Configure::read('core.site_offline'))); ?>
    			</li>	
    			<li><label>Offline Message</label>
    				<?php echo $this->Form->textarea('offline_message', array('value' => Configure::read('core.offline_message'))); ?>
    			</li>    			
    			<li><label>Popular Items Interval (<a href="javascript:void(0)" class="tip" title="Display popular items within X days">?</a>)</label>
    				<?php echo $this->Form->text('popular_interval', array('value' => Configure::read('core.popular_interval'))); ?>
    			</li>
    			<li><label>Default Profile Privacy</label>
    				<?php echo $this->Form->select('profile_privacy', array( PRIVACY_EVERYONE => 'Everyone', PRIVACY_FRIENDS => 'Friends & Me', PRIVACY_ME => 'Only Me' ), array('value' => Configure::read('core.profile_privacy'), 'empty' => false)); ?>
    			</li>
    			<li><label>Default Theme</label>
    				<?php echo $this->Form->select('default_theme', $site_themes, array('value' => Configure::read('core.default_theme'), 'empty' => false)); ?>
    			</li>			
    			<li><label>Default Home Feed</label>
    				<?php echo $this->Form->select('default_feed', array( 'everyone' => 'Everyone', 'friends' => 'Friends & Me' ), array('value' => Configure::read('core.default_feed'), 'empty' => false)); ?>
    			</li>
    			<li><label>Time Format</label>
    				<?php echo $this->Form->select('time_format', array( '12h' => '12-hour', '24h' => '24-hour' ), array('value' => Configure::read('core.time_format'), 'empty' => false)); ?>
    			</li>
    			<li><label>Date Format (<a href="http://php.net/manual/en/function.date.php" target="_blank" class="tip" title="Refer to PHP date function for more information about<br />date format. Click this for more details">?</a>)</label>
    				<?php echo $this->Form->text('date_format', array('value' => Configure::read('core.date_format'))); ?>
    			</li>	
    			<li><label>Default Timezone</label>
    			    <?php 
                    $timezones = $this->Time->listTimezones(null, null, false);
                    asort($timezones);
                    echo $this->Form->select('timezone', $timezones, array('value' => Configure::read('core.timezone'), 'empty' => false)); 
                    ?>
                </li>  
                <li><label>Enable Timezone Selection (<a href="javascript:void(0)" class="tip" title="If your users live in different timezones then enable this">?</a>)</label>
                    <?php echo $this->Form->checkbox('enable_timezone_selection', array('checked' => Configure::read('core.enable_timezone_selection'))); ?>
                </li>
                <li><label>Default Language</label>
                    <?php echo $this->Form->select('default_language', $site_langs, array('value' => Configure::read('core.default_language'), 'empty' => false)); ?>
                </li>
                <li><label>Show "Powered by" link (<a href="javascript:void(0)" class="tip" title="Check this to support mooSocial :)">?</a>)</label>
                    <?php echo $this->Form->checkbox('show_credit', array('checked' => Configure::read('core.show_credit'))); ?>
                </li>
                <br /> 
                <h2>Mail Settings</h2> 
                <li><label>Mail Transport</label>
                    <?php echo $this->Form->select('mail_transport', array( 'Mail' => 'PHP Mail', 'Smtp' => 'SMTP' ), array('value' => Configure::read('core.mail_transport'), 'empty' => false)); ?>
                </li>	
                <li><label>SMTP Host (<a href="javascript:void(0)" class="tip" title="In some cases, you might need to include ssl:// in the hostname">?</a>)</label>
                    <?php echo $this->Form->text('smtp_host', array('value' => Configure::read('core.smtp_host'))); ?>
                </li>
                <li><label>SMTP Username</label>
                    <?php echo $this->Form->text('smtp_username', array('value' => Configure::read('core.smtp_username'))); ?>
                </li>
                <li><label>SMTP Password</label>
                    <?php echo $this->Form->text('smtp_password', array('value' => Configure::read('core.smtp_password'))); ?>
                </li>	
                <li><label>SMTP Port</label>
                    <?php echo $this->Form->text('smtp_port', array('value' => Configure::read('core.smtp_port'))); ?>
                </li>   
    		</ul>
    	</div>	
    	<div id="features_content" class="tab">
    		<ul class="list6">			
    			<li><label>Allow Guests To Search</label>
    				<?php echo $this->Form->checkbox('guest_search', array('checked' => Configure::read('core.guest_search'))); ?>
    			</li>					
    			<li><label>Enable Activities Feed Selection</label>
    				<?php echo $this->Form->checkbox('feed_selection', array('checked' => Configure::read('core.feed_selection'))); ?>
    			</li>	
    			<li><label>Hide Activities Feed From Guests</label>
    				<?php echo $this->Form->checkbox('hide_activites', array('checked' => Configure::read('core.hide_activites'))); ?>
    			</li>			
    			<li><label>Save Original Image (<a href="javascript:void(0)" class="tip" title="Check this to store original image when users upload photos<br />You might wanna disable if you are concerned about server space">?</a>)</label>
                    <?php echo $this->Form->checkbox('save_original_image', array('checked' => Configure::read('core.save_original_image'))); ?>
                </li>   
    			<li><label>Force Login (<a href="javascript:void(0)" class="tip" title="Check this to force users to login to view the site">?</a>)</label>
    				<?php echo $this->Form->checkbox('force_login', array('checked' => Configure::read('core.force_login'))); ?>
    			</li>
    			<li><label>Disable Registration</label>
    				<?php echo $this->Form->checkbox('disable_registration', array('checked' => Configure::read('core.disable_registration'))); ?>
    			</li>			
    			<li><label>Registration Notification (<a href="javascript:void(0)" class="tip" title="Check this to enable the system to send a notification<br />email to the site email whenever a new user signs up">?</a>)</label>
    				<?php echo $this->Form->checkbox('registration_notify', array('checked' => Configure::read('core.registration_notify'))); ?>
    			</li>
    			<li><label>Allow Users To Select Theme</label>
    				<?php echo $this->Form->checkbox('select_theme', array('checked' => Configure::read('core.select_theme'))); ?>
    			</li>	
    			<li><label>Allow Users To Select Language</label>
    				<?php echo $this->Form->checkbox('select_language', array('checked' => Configure::read('core.select_language'))); ?>
    			</li>
    			<li><label>Allow Name Change (<a href="javascript:void(0)" class="tip" title="Check this to allow users to change name">?</a>)</label>
                    <?php echo $this->Form->checkbox('name_change', array('checked' => Configure::read('core.name_change'))); ?>
                </li>
    			<li><label>Allow Username Change</label>
                    <?php echo $this->Form->checkbox('username_change', array('checked' => Configure::read('core.username_change'))); ?>
                </li>
                <li><label>Require Birthday</label>
                    <?php echo $this->Form->checkbox('require_birthday', array('checked' => Configure::read('core.require_birthday'))); ?>
                </li> 
    		</ul>
    	</div>	
    	<div id="security_content" class="tab">
    		<ul class="list6">
    			<li><label>Require Email Validation</label>
    				<?php echo $this->Form->checkbox('email_validation', array('checked' => Configure::read('core.email_validation'))); ?>
    			</li>
    			<li><label>Enable reCaptcha (<a href="http://www.google.com/recaptcha" target="_blank" class="tip" title="You must enter recaptcha public and private key if you<br/>enable this. Click this for more details">?</a>)</label>
    				<?php echo $this->Form->checkbox('recaptcha', array('checked' => Configure::read('core.recaptcha'))); ?>
    			</li>
    			<li><label>reCaptcha Public Key</label>
    				<?php echo $this->Form->text('recaptcha_publickey', array('value' => Configure::read('core.recaptcha_publickey'))); ?>
    			</li>
    			<li><label>reCaptcha Private Key</label>
    				<?php echo $this->Form->text('recaptcha_privatekey', array('value' => Configure::read('core.recaptcha_privatekey'))); ?>
    			</li>
    			<li><label>Ban IP Addresses (<a href="javascript:void(0)" class="tip" title="Enter xyz.xyz.xyz.xyz to ban the exact ip address<br />Or xyz.xyz.xyz to ban ip addresses that start with xyz.xyz.xyz<br />One ip address per line">?</a>)</label>
    				<?php echo $this->Form->textarea('ban_ips', array('value' => Configure::read('core.ban_ips'))); ?>
    			</li>
    			<li><label>Remove Admin Link (<a href="javascript:void(0)" class="tip" title="Check this box to remove Admin link from user menu">?</a>)</label>
    				<?php echo $this->Form->checkbox('hide_admin_link', array('checked' => Configure::read('core.hide_admin_link'))); ?>
    			</li>
    			<li><label>Restricted Usernames (<a href="javascript:void(0)" class="tip" title="Enter usernames that you do not want users<br />to register with. One username per line">?</a>)</label>
    				<?php echo $this->Form->textarea('restricted_usernames', array('value' => Configure::read('core.restricted_usernames'))); ?>
    			</li>
    			<li><label>Enable Registration Code (<a href="javascript:void(0)" class="tip" title="Check this box to force users to enter the correct<br />registration code defined below in order to register">?</a>)</label>
    				<?php echo $this->Form->checkbox('enable_registration_code', array('checked' => Configure::read('core.enable_registration_code'))); ?>
    			</li>
    			<li><label>Registration Code</label>
    				<?php echo $this->Form->text('registration_code', array('value' => Configure::read('core.registration_code'))); ?>
    			</li>
    			<li><label>Enable Spam Challenge (<a href="<?php echo $this->request->base?>/admin/spam_challenges" class="tip" title="Check this box to force users to answer a<br />challenge question in order to register<br />Click here to manage challenge questions/answers">?</a>)</label>
    				<?php echo $this->Form->checkbox('enable_spam_challenge', array('checked' => Configure::read('core.enable_spam_challenge'))); ?>
    			</li>
    		</ul>	
    	</div>
    	
    	<div id="integration_content" class="tab">
    		<ul class="list6">
    			<li><label>Enable Facebook Registration (<a href="javascript:void(0)" class="tip" title="You must enter FB application ID and<br />secret if you enable this">?</a>)</label>
    				<?php echo $this->Form->checkbox('fb_integration', array('checked' => Configure::read('core.fb_integration'))); ?>
    			</li>
    			<li><label>FB Application ID</label>
    				<?php echo $this->Form->text('fb_app_id', array('value' => Configure::read('core.fb_app_id'))); ?>
    			</li>
    			<li><label>FB Application Secret</label>
    				<?php echo $this->Form->text('fb_app_secret', array('value' => Configure::read('core.fb_app_secret'))); ?>
    			</li>
    			<li><label>Analytics Code (<a href="http://www.google.com/analytics/" target="_blank" class="tip" title="Enter your analytics code here<br />Click this to visit Google Analytics">?</a>)</label>
    				<?php echo $this->Form->textarea('analytics_code', array('value' => Configure::read('core.analytics_code'))); ?> 
    			</li>	
    			<li><label>Google Developer Key</label>
                    <?php echo $this->Form->text('google_dev_key', array('value' => Configure::read('core.google_dev_key'))); ?>
                </li>
    		</ul>	
    	</div>
    	<div id="siteLogo_content" class="tab">
    		<ul class="list6">
    			<?php $logo = Configure::read('core.logo');
                    if ( !empty($logo) ): ?>
    			<li><label>Current Logo</label>
    				<img src="<?php echo $this->request->webroot . Configure::read('core.logo')?>">
    			</li>
    			<li><label>Remove Logo</label>
    				<?php echo $this->Form->checkbox('remove_logo'); ?>
    			</li>
    			<?php endif; ?>	
    			<li><label>Upload New Logo</label>
    				<input type="file" name="Filedata">
    			</li>					
    		</ul>
    	</div>
    </div>
	
	<div class="regSubmit">
	    <input type="submit" value="Save Settings" class="button button-action button-medium">
    </div>
</form>
</div>