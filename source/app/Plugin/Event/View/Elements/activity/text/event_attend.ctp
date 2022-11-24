<?php

$ids = explode(',', $activity['Activity']['items']);
$eventsModel = MooCore::getInstance()->getModel('Event_Event');
$eventsModel->cacheQueries = true;
$events = $eventsModel->find('all', array('conditions' => array('Event.id' => $ids),
        ));

echo __('is attending') . ' ';

$attending1 = '%s';
$attending2 = __('%s and %s');
$attending3 = __('%s and %s');
$attending = '';
switch (count($events)){
case 1:
    $attending = sprintf($attending1, '<a href="' . $events[0]['Event']['moo_href'] . '">' . $events[0]['Event']['title'] . '</a>');
    break;
case 2:
    $attending = sprintf($attending2, '<a href="' . $events[0]['Event']['moo_href'] . '">' . $events[0]['Event']['title'] . '</a>', '<a href="' . $events[1]['Event']['moo_href'] . '">' . $events[1]['Event']['title'] . '</a>');
    break;
case 3:
default :
    $attending = sprintf($attending3, '<a href="' . $events[0]['Event']['moo_href'] . '">' . $events[0]['Event']['title'] . '</a>', '<a data-toggle="modal" data-target="#themeModal" href="' . $this->Html->url(array('controller' => 'events', 'action' => 'ajax_event_joined', 'plugin' => 'event', 'activity_id' => $activity['Activity']['id'])) . '">' . abs(count($events) -1) . ' ' . __('others') . '</a>');
    break;
}

echo $attending;
?>
