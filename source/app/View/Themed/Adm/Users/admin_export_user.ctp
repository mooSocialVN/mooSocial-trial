<?php

// app/Views/Subscribers/export.ctp

function convertUtf8($string)
{
	return iconv(mb_detect_encoding($string, mb_detect_order(), true), "UTF-8", $string);
}

foreach ($data as $i => $row):
	if (!$i)
	{
		echo '"Email","Name"'."\n";
	}
	$tmp = array();
	$tmp[] = '"' . preg_replace('/"/','""',$row['User']['email']) . '"';
	$tmp[] = '"' . convertUtf8(preg_replace('/"/','""',$row['User']['name'])) . '"';
	
	echo implode(',', $tmp) . "\n";
endforeach;

?>