<div class="alert alert-info">
	<?php echo __('Please set one of the the following commands to run in crontab about every 1 minute:');?>
	<ul>
		<?php $request = Router::getRequest();?>
		<li>
			<?php echo __('Requires wget command line utility:');?> "wget -qO- '<?php echo FULL_BASE_URL.$request->webroot.'cron/task/run?key='.Configure::read('Cron.cron_key'); ?>' >/dev/null 2>&1"
		</li>
		<li>
			<?php echo __('Requires command line utility:')?> "cd <?php echo APP;?> & Console/cake cron run <?php echo Configure::read('Cron.cron_key');?>"
		</li>
	</ul>
</div>
