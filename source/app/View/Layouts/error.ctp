<?php

/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	<?php echo $this->Html->charset(); ?>
        <title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
        </title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('config');
		echo $this->fetch('script');
	?>
    </head>
    <body class="error_page">
	<?php if (Configure::read("debug") != 0):?>
        <div id="container">
            <div id="header">
                <h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
            </div>
            <div id="content">

				<?php echo $this->Session->flash(); ?>

				<?php echo $this->fetch('content'); ?>
            </div>
            <div id="footer">
				<?php echo $this->Html->link(
						$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
						'http://www.cakephp.org/',
						array('target' => '_blank', 'escape' => false)
					);
				?>
            </div>
        </div>
		<?php echo $this->element('sql_dump'); ?>
	<?php else:?>
        <style type="text/css">
            @media (min-width: 992px){
                .error_page {
                    background-color: #e9e9eb;
                }
                .error_sorry_wrapper {
                    width: 660px;
                    border-radius: 4px;
                    background-color: #ffffff;
                    border: solid 1px #d4d4d4;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    -moz-transition: all ease .3s;
                    -webkit-transition: all ease .3s;
                    transition: all ease .3s;
                    position:absolute;
                    padding: 50px 0;
                    text-align: center;
                    font-size: 24px;
                }
                .error_sorry_wrapper i {
                    font-size: 64px;
                    font-style: normal;
                    display: block;
                    margin-bottom: 30px;
                }
            }
            @media (max-width: 991px){
                .error_sorry_wrapper i {
                    font-style: normal;
                }
            }
        </style>
        <div id="container">
            <div class="error_sorry_wrapper"><?php echo __('<i>Sorry :( </i> Looks like something went wrong on our end.');?></div>
        </div>
	<?php endif;?>
    </body>
</html>
