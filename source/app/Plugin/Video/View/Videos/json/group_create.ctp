<?php
$v = '';
if (!empty($data['id'])) // editing
    $v = $this->render('Video.Videos/group_fetch');
else
    $v = $this->render('Video.Videos/aj_create');
echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);