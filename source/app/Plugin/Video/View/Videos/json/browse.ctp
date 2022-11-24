<?php
$v = '';
if ( $data['page'] == 1 && $data['type'] == 'home' )
			$v = $this->render('/Elements/ajax/home_video');
		elseif ( $data['page'] == 1 && $data['type'] == 'group' )
			$v = $this->render('/Elements/ajax/group_video');
		else
			$v = $this->render('/Elements/lists/videos_list');
echo json_encode(
    array('data' => $v,
        'error' => null,
    )
);