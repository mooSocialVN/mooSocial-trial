<?php
$class_menu = 'menu_' . $menu_id;
echo $this->Menu->generate(null, $menu_id, array('class' => "$class_menu core_menu"));
?>