<?php
/**
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 */
?>
<div style="text-align: center;"><?php echo __('The access token provided has expired');?></div>
<?php
	if ($this->request->is('androidApp')):
		?>
		<script>
			Android.refeshToken();
		</script>
		<?php
	endif;
?>