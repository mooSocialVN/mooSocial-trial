<?php
$v = $this->render('/Elements/ajax/user_overlay');
echo json_encode(array(
    'data' => $v,
    'error' => null
));