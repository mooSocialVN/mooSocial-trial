<table width="620" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="background:#E7E7DE;color:#000000;font-weight:bold;font-family:'lucida grande',tahoma,verdana,arial,sans-serif;vertical-align:middle;padding:4px 8px;font-size:16px;letter-spacing:-0.03em;text-align:left;border:1px solid #CCCCCC">
			<?php echo Configure::read('core.site_name'); ?>
		</td>
	</tr>
	<tr>
		<td style="background-color:#FFFFFF;border-bottom:1px solid #333333;border-left:1px solid #CCCCCC;border-right:1px solid #CCCCCC;font-family:'lucida grande',tahoma,verdana,arial,sans-serif;padding:15px">
			<?php echo $content_for_layout; ?>
		</td>
	</tr>
</table>

<div style="color:#999999;padding:10px;font-size:12px;font-family:'lucida grande',tahoma,verdana,arial,sans-serif">
	<?php echo __('This is an automated generated email. Please do not respond to it.')?><br />
	<?php echo __('If you don\'t want to receive these emails in the future, please visit')?> <a href="<?php echo FULL_BASE_URL . $this->request->base;?>"><?php echo Configure::read('core.site_name')?></a> <?php echo __('and change your email setting.')?>
</div> 