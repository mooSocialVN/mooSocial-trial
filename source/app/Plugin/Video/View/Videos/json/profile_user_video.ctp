<?php

$v = '';

if ($data['page'] > 1)
    $v = $this->render('/Elements/lists/videos_list');
else
    $v = $this->render('Video.Videos/profile_user_video');

echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
