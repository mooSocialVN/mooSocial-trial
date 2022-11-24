<?php
$data = array_slice($activity['TextContent'], 0, 10);	
echo __('is now friends with') . ' ';

foreach ( $data as $key => $user )
{
	if ( count( $data ) > 1 && $key > ( count( $data ) - 2 ) )
		echo ' ' . __('and') . ' ';
		
	echo $this->Moo->getName( $user['User'], false );
	
	if ( $key < ( count( $data ) - 2 ) )
		echo ', ';
}
?>