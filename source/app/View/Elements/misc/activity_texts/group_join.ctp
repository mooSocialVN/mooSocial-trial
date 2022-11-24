<?php
$data = $activity['TextContent'];	
echo __('joined group') . ' ';

foreach ( $data as $key => $group )
{
	if ( count( $data ) > 1 && $key > ( count( $data ) - 2 ) )
		echo ' ' . __('and') . ' ';
		
	echo '<a href="' . $this->request->base . '/groups/view/' . $group['Group']['id'] . '">' . h($group['Group']['name']) . '</a>';
	
	if ( $key < ( count( $data ) - 2 ) )
		echo ', ';
}
?>