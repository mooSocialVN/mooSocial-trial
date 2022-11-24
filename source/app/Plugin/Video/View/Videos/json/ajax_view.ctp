<?php
$v = '';
$v = $this->render('Video.Videos/aj_view');
echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);