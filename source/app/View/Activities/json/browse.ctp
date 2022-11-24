<?php

$v = $this->render('/Elements/activities/activities');
echo json_encode(
        array('data' => $v,
            'error' => null,
        )
);
