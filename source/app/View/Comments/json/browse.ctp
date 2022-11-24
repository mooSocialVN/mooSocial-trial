<?php

$v = $this->render('/Elements/comments');
echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
