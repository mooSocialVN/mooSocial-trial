<style>
body {
	margin: 0;
	font-family: verdana;
	font-size: 11px;
	color: #333;
}
</style>

<?php if ( !empty( $users ) ): ?> 
	<meta http-equiv="refresh" content="5; url=<?php echo $this->request->base?>/admin/tools/ajax_bulkmail_send/<?php echo $page?>">
	<br /><img src="<?php echo $this->request->webroot?>img/indicator.gif" id="createLoading" align="absmiddle"> <?php echo __('Proceeding next cycle... Please wait...');?>
<?php else: ?>	
	<div>
		<script>
			parent.$('.modal-body').html('<?php echo __('All emails are added into temp place. Email sending is started running. It will take a few hours to finish. You can close web browser or go to other page now.')?>' + '<br/><br/>' + '<span style="color:green"><?php echo __('Done! All emails have been sent!');?></span>');
		</script>		
	</div>
<?php endif; ?>