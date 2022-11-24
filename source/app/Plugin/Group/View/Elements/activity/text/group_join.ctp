<?php

$ids = explode(',', $activity['Activity']['items']);
$groupModel = MooCore::getInstance()->getModel('Group_Group');
$groupModel->cacheQueries = true;
$groups = $groupModel->find('all', array('conditions' => array('Group.id' => $ids),
        ));

echo __('joined group') . ' ';
$joined1 = '%s';
$joined2 = __('%s and %s');
$joined3 = __('%s and %s');
$joined = '';
switch (count($groups)){
case 1:
    $joined = sprintf($joined1, '<a href="' . $groups[0]['Group']['moo_href'] . '">' . $groups[0]['Group']['name'] . '</a>');
    break;
case 2:
    $joined = sprintf($joined2, '<a href="' . $groups[0]['Group']['moo_href'] . '">' . $groups[0]['Group']['name'] . '</a>', '<a href="' . $groups[1]['Group']['moo_href'] . '">' . $groups[1]['Group']['name'] . '</a>');
    break;
case 3:
default :
    $joined = sprintf($joined3, '<a href="' . $groups[0]['Group']['moo_href'] . '">' . $groups[0]['Group']['name'] . '</a>', '<a data-toggle="modal" data-target="#themeModal" href="' . $this->Html->url(array('controller' => 'groups', 'action' => 'ajax_group_joined', 'plugin' => 'group', 'activity_id' => $activity['Activity']['id'])) . '">' . abs(count($groups) -1) . ' ' . __('others') . '</a>');
    break;
}

echo $joined;

?>
