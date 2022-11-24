<?php

    if(!empty($groups)){
        $response = array();
        foreach ($groups as $group){
            $response[]= array(
                'id'=>$group['Group']['id'],
                'name'=>$group['Group']['name'],
                'avatar'=>$this->Moo->getItemPhoto(array('Group' => $group['Group']),array('class' => ' tip', 'prefix' => '75_square'),array(),true),
            );
        }
        echo  json_encode(array('data'=>$response));
    }
?>