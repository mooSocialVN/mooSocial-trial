<?php
$params = json_decode($notification['Notification']['params'],true);
if ($params['type']!= APP_PAGE)
{
	$object = MooCore::getInstance()->getItemByType($params['type'], $params['id']);
}
else
{
	$object = MooCore::getInstance()->getItemByType('Page_Page', $params['id']);
}
if ($object)
{
	if ($params['type'] == 'Photo_Photo')
	{
		if ($notification['Notification']['user_id'] == $object['Photo']['user_id'])
		{
			$title = __('also replied to your comment on your photo');
		}
		else
		{
			$title = __('also replied to your comment on %s photo',possession( $notification['Sender'], $object['User']));
		}
	}
	else
	{
		$title = __('also replied to your comment on').' "'.$object[key($object)]['moo_title'].'"';
	}
}
else
{
	$title = __('also replied to your comment on').' "'.__('Deleted item').'"';
}
?>

<?php echo $title;?>