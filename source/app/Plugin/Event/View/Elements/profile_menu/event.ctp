<?php
$rsvpModel = MooCore::getInstance()->getModel('Event.EventRsvp');
$event_count = $rsvpModel->getProfileEventsCount($user['User']['id']);
$event_count = (int)$event_count;
?>
<li>
	<a class="horizontal-menu-link core-menu-ajax" data-url="<?php echo $this->request->base?>/events/profile_user_event/<?php echo $user['User']['id']?>" rel="profile-content" href="#events" data-anchor="#events" autoload="false">
		<span class="horizontal-menu-icon material-icons hidden">event</span>
		<span class="horizontal-menu-text"><?php echo __('Events')?></span>
		<span class="badge_counter"><?php echo $event_count?></span>
	</a>
</li>