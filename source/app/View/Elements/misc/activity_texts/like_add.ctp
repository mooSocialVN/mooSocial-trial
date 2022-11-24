<?php
$model = ucfirst( $activity['Activity']['item_type'] );

switch ( $activity['Activity']['item_type'] ) 
{
	case APP_BLOG:
		echo __('likes %s blog', possession( $activity['User'], $activity['Content']['User'] ) );
		break;	
		
	case APP_ALBUM:
		echo __('likes %s album', possession( $activity['User'], $activity['Content']['User'] ) );
		break;	
		
	case APP_PHOTO:
		echo __('likes %s photo', possession( $activity['User'], $activity['Content']['User'] ) );
		break;	
		
	case APP_TOPIC:
		echo __('likes %s topic', possession( $activity['User'], $activity['Content']['User'] ) );
		break;	
		
	case APP_VIDEO:
		echo __('likes %s video', possession( $activity['User'], $activity['Content']['User'] ) );
		break;		
}

if ( $activity['Activity']['item_type'] != APP_PHOTO ):
?> 
<a href="<?php echo $this->request->base?>/<?php echo $activity['Activity']['item_type']?>s/view/<?php echo $activity['Activity']['item_id']?>/<?php echo seoUrl($activity['Content'][ucfirst($activity['Activity']['item_type'])]['title'])?>"><?php echo h($activity['Content'][$model]['title'])?></a>
<?php
endif;
?>