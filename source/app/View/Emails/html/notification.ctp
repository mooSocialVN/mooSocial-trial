<div style="line-height:1.5;color:#999999">
<?php foreach ($data as $noti): ?>
	<a href="<?php echo /*FULL_BASE_URL . $request->base*/FULL_BASE_URL .$this->request->base . $noti['Notification']['url']?>"><?php echo $noti['Sender']['name']?> <?php echo $this->element('misc/notification_texts', array( 'noti' => $noti ));	?></a>
	<small><?php echo $this->Moo->getTime($noti['Notification']['created'], $moo_setting['date_format'], $noti['User']['timezone'])?></small><br />
<?php endforeach; ?>
</div>
<br /><br />
<a href="<?php echo FULL_BASE_URL .$this->request->base;//FULL_BASE_URL . $request->base?>/home/index/tab:notifications"><?php echo __('Click here')?></a> <?php echo __('to view all your notifications')?>
