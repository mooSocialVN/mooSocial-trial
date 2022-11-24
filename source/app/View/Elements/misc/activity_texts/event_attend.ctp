<?php
$data = $activity['TextContent'];
echo __('is attending') . ' ';

foreach ( $data as $key => $event )
{
	if ( count( $data ) > 1 && $key > ( count( $data ) - 2 ) )
		echo ' ' . __('and') . ' ';
		
	echo '<a href="' . $this->request->base . '/events/view/' . $event['Event']['id'] . '">' . h($event['Event']['title']) . '</a>';
	
	if ( $key < ( count( $data ) - 2 ) )
		echo ', ';
}
?> 