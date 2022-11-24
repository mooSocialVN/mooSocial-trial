<?php
if ( empty( $noti['Notification']['action'] ) ) // backward compability (prior to 1.1)
	echo $noti['Notification']['text'];				

switch ( $noti['Notification']['action'] )
{
	case 'profile_comment':
		echo __('wrote on your profile');
		break;
		
	case 'status_comment':
		$params = unserialize( $noti['Notification']['params'] );
		echo __('commented on %s status', possession( $params['actor'], $params['owner'] ));
		break;
		
	case 'own_status_comment':
		echo __('commented on your status');
		break;
		
	case 'message_reply':
		echo __('replied to "%s"', $noti['Notification']['params']);
		break;
		
	case 'photo_comment':
		$params = unserialize( $noti['Notification']['params'] );
		echo __( 'commented on %s photo', possession( $params['actor'], $params['owner'] ) );
		break;
		
	case 'own_photo_comment':
		echo __('commented on your photo');
		break;
		
	case 'item_comment':
		echo __( 'commented on "%s"', $noti['Notification']['params'] );
		break;
		
	case 'photo_like':
		echo __( 'likes your photo' );
		break;
		
	case 'item_like':
		echo __( 'likes "%s"', $noti['Notification']['params']);
		break;
		
	case 'activity_like':
		echo __( 'likes your status' );
		break;
		
	case 'message_send':
		echo __('sent you a message');
		break;
		
	case 'conversation_add':
		echo __('added you to a conversation');
		break;
		
	case 'event_invite':
		echo __( 'invited you to "%s"', $noti['Notification']['params']);
		break;
		
	case 'friend_add':
		echo __('wants to be friends with you');
		break;
		
	case 'friend_accept':
		echo __('accepted your friend request');
		break;
            
    case 'tagged_status':
        echo __('tagged you to a post');
        break;

    case 'like_tagged_status':
        echo __('liked a status you are tagged in');
        break;

    case 'like_mentioned_post':
        echo __('liked a post you are mentioned in');
        break;

    case 'like_mentioned_comment':
        echo __('liked a comment you are mentioned in');
        break;

	case 'comment_tagged_status':
            echo __('commented on a status you are tagged in');
            break;

    case 'comment_mentioned_post':
        echo __('commented on a post that you are mentioned in');
        break;

    case 'group_request':
		echo __( 'requested to join "%s"', $noti['Notification']['params']);
		break;
		
	case 'group_invite':
		echo __( 'invited you to join "%s"', $noti['Notification']['params']);
		break;
	case 'status_comment_of_comment':
		echo __( 'also commented on %s\'s post', $noti['Notification']['params'] );
		break;
		
	case 'photo_tag':
		echo __('tagged you in a photo');
		break;
        case 'tagged_group_status' : 
            echo __('tagged you in a post');
            break;
        case 'like_photo_user_tagged_in':
            echo __('liked a photo you are tagged in');
            break;
        case 'comment_photo_user_tagged_in':
            echo __('commented a photo you are tagged in');
            break;
        case 'mention_user':
            echo __('mentioned you to a post');
            break;
        case 'mention_user_comment':
            echo __('mentioned you in a comment');
            break;
        case 'shared_to_friend_wall':
            echo __('shared items on your wall');
            break;
        case 'shared_your_post':
            echo __('shared your post');
            break;
	default :
		$options = array();
		if ($noti['Notification']['plugin'])
		{
			$options = array('plugin' => $noti['Notification']['plugin']);
		}
		
		echo $this->element('notification/' . $noti['Notification']['action'], array('notification' => $noti),$options);
		
		break;
}