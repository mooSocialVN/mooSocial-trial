<?php
$v = '';
if ( $data['page'] == 1 && $data['type'] == 'home' )
	$v = $this->render('Event./Elements/ajax/home_event');
else
	$v = $this->render('Event./Elements/lists/events_list');

echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);