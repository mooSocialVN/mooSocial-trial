<?php

$v = '';
if(empty($data['group_id']))
    $v = $this->render('Video.Videos/aj_fetch');
else
    $v = $this->render('Video.Videos/group_fetch');
echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
