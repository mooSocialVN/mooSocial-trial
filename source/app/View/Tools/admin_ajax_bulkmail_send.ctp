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
	
	<?php foreach ( $users as $user ): ?>
	Sending email to <?php echo $user['User']['email']?>... <span style="color:green">Done!</span><br />
	<?php endforeach; ?>
	<br /><img src="<?php echo $this->request->webroot?>img/indicator.gif" id="createLoading" align="absmiddle"> Proceeding next cycle... Please wait...
<?php else: ?>
	<span style="color:green">Done! All emails have been sent!</span>
<?php endif; ?>