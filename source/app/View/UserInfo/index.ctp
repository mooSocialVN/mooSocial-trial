<?php echo $this->element('user/info_tabs')?>
<?php $this->setBodyClass('floating-menu'); ?>
<?php 
	switch ($type)
	{
		case "notifications":
			echo $this->renderFile('/Notifications/ajax_show',array('type'=>$type));
			break;
		case "messages":
			echo $this->renderFile('/Conversations/ajax_browse');
			break;
		case "friends":
			echo $this->element('ajax/home_user');
			break;
		case "invite_friends":
			echo $this->renderFile('/Friends/ajax_invite');
			break;
		case "request_friends":
			echo $this->renderFile('/Friends/ajax_requests');
			break;
	}
?>