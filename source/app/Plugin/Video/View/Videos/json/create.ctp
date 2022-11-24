<?php
$v = '';
$v = $this->render('Video.Videos/aj_fetch');
echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);