<?php

    if(!empty($friends)){
        $tip = 'tip';
                if (Configure::read('core.profile_popup')){
                    $tip = '';
                }
        $response = array();
        foreach ($friends as $friend){
            $response[]= array(
                'id'=>$friend['User']['id'],
                'name'=>mb_convert_encoding($friend['User']['name'],'UTF-8'),
                'avatar'=>$this->Moo->getItemPhoto(array('User' => $friend['User']),array('class' => "user_avatar_small $tip", 'prefix' => '50_square'),array(),true),
            );
        }
        echo  json_encode(array('data'=>$response));
    }
?>