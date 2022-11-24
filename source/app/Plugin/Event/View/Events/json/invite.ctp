<?php
$v = '';
$v = $this->render('Event.Events/invite');
echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);