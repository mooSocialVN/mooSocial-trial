<?php

$v = '';

if ($data['page'] == 1 && $data['type'] == 'home')
    $v = $this->render('/Elements/ajax/home_activity');
else
    $v = $this->render('/Elements/activities');

echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
