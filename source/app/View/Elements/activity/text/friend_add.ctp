<?php

$ids = explode(',', $activity['Activity']['items']);
$userModel = MooCore::getInstance()->getModel('User');
$userModel->cacheQueries = false;
$users = $userModel->find('all', array('conditions' => array('User.id' => $ids)));
echo __('is now friends with') . ' ';

$friend_add1 = '%s';
$friend_add2 = __('%s and %s');
$friend_add3 = __('%s and %s');
$friend_add = '';
$name1 = isset($users[0]['User']) ? $this->Moo->getName($users[0]['User']) : '<a href="javascript:void(0);">'.__('deleted user').'</a>';
$name2 = isset($users[1]['User']) ? $this->Moo->getName($users[1]['User']) : '<a href="javascript:void(0);">'.__('deleted user').'</a>';

switch (count($users)) {
	case 0:
		$friend_add = sprintf($friend_add1, $name1);
		break;
    case 1:
    	$friend_add = sprintf($friend_add1, $name1);
        break;
    case 2:
    	$friend_add = sprintf($friend_add2, $name1, $name2);
        break;
    case 3:
    	$friend_add = sprintf($friend_add3, $name1, '<a data-toggle="modal" data-target="#themeModal" href="' . $this->Html->url(array('controller' => 'users', 'action' => 'ajax_friend_added', 'activity_id' => $activity['Activity']['id'])) . '">' . abs(count($users) - 1) . ' ' . __('others') . '</a>');
        break;
    default :
    	$friend_add = sprintf($friend_add3, $name1, '<a data-toggle="modal" data-target="#themeModal" href="' . $this->Html->url(array('controller' => 'users', 'action' => 'ajax_friend_added', 'activity_id' => $activity['Activity']['id'])) . '">' . abs(count($users) - 1) . ' ' . __('others') . '</a>');
    	break;
}

echo $friend_add;

?>