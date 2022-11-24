<?php
switch ( $activity['Activity']['action'] )
{
	case 'user_create':
		echo __('joined %s', Configure::read('core.site_name'));
		break;	
		
	case 'user_avatar':
		echo __('changed %s profile picture', possession( $activity['User'] ) );
		break;
		
	case 'event_attend':
		echo __('is attending %s', $activity['Activity']['params']);
		break;
		
	case 'group_join':
		echo __('joined group %s', $activity['Activity']['params']);
		break;
		
	case 'photos_add':
		$new_photos = explode(',', $activity['Activity']['items']);
		
		if ( $activity['Activity']['type'] == APP_USER )
			echo __n( 'added %s new photo to album', 'added %s new photos to album', count($new_photos), count($new_photos) ) . ' <a href="' . $this->request->base . '/albums/view/' . $activity['Content'][0]['Album']['id'] . '/' . seoUrl($activity['Content'][0]['Album']['title']) . '">' . h($activity['Content'][0]['Album']['title']) . '</a>';
		else
			echo __n( 'added %s new photo', 'added %s new photos', count($new_photos), count($new_photos) ); 
		
		break;
	
	case 'photos_tag':
		echo __('was tagged in a photo');
		break;
		
	case 'friend_add':
		echo __('and %s are now friends', $activity['Activity']['params']); 						
		break;
}