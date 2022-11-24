<?php
$v = '';
if ( $data['page'] == 1 && $data['type'] == 'home' )
	$v = $this->render('/Elements/ajax/home_blog');
else
	$v = $this->render('/Elements/lists/blogs_list');

echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);