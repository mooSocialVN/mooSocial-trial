<?php
    $had_comment_message = (!empty($had_comment_message)) ? $had_comment_message : 0;
  echo $this->element('activity/content/photos_add', array('activity' => $activity,'object'=>$object, 'had_comment_message' => $had_comment_message),array('plugin'=>'Photo'));
?>