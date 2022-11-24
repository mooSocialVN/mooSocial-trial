<style>
#content {
	overflow: visible;
</style>

<?php echo $this->element('admin/adminnav', array("cmenu" => "users"));?>

<form action="<?php echo $this->request->base?>/admin/users/edit" method="post">
<?php echo $this->Form->hidden('id', array('value' => $user['User']['id'])); ?>
<div id="center">	
	<span class="button-dropdown topButton" data-buttons="dropdown">
	    <a href="#" class="button">Actions <i class="icon-caret-down"></i></a>
	    <ul>
	    	<li><a href="<?php echo $this->request->base?>/admin/users/resend/<?php echo $user['User']['id']?>">Resend Validation Email</a></li>
	    	<li><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to remove all contents of this user?<br />This action cannot be undone!')) ?>', '<?php echo $this->request->base?>/admin/users/delete_content/<?php echo $user['User']['id']?>')">Remove All Contents</a></li>
	    </ul>   
	</span>		
	<a href="<?php echo $this->request->base?>/users/view/<?php echo $user['User']['id']?>" target="_blank" class="button button-action topButton">View Profile</a>
	
	<h1>Edit User</h1>	
	
	<h2>Basic Information</h2>
	<div style="float:right;line-height:1.5" align="center">
		<?php echo $this->Moo->getItemPhoto(array('User' => $user['User']), array("height" => "100px",  "class" => "img_wrapper", 'prefix' => '100_square'))?>
		<a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to remove avatar of this user?')) ?>', '<?php echo $this->request->base?>/admin/users/avatar/<?php echo $user['User']['id']?>')">Remove Avatar</a><br />
	</div>
	<ul class="list6">		
		<li><label>Registered Date</label><?php echo $this->Moo->getTime($user['User']['created'], Configure::read('core.date_format'), $utz)?></li>
		<li><label>Last Online</label><?php echo $this->Moo->getTime($user['User']['last_login'], Configure::read('core.date_format'), $utz)?></li>
		<li><label>Stats</label><?php echo $user['User']['friend_count']?> friends, <?php echo $user['User']['photo_count']?> photos,
			<?php echo $user['User']['blog_count']?> blog entries, <?php echo $user['User']['topic_count']?> topics, <?php echo $user['User']['video_count']?> videos
		</li>
		<li><label>Registered IP Address</label><?php echo $user['User']['ip_address']?> &nbsp;</li>
		<li><label>Role</label><?php echo $this->Form->select('role_id', $roles, 
																		 array( 'value' => $user['User']['role_id'],
																		 	    'empty' => false ) ); ?>
		</li>		
		<li><label>Active</label><?php echo $this->Form->select('active', array( 0 => 'No', 
																				 1 => 'Yes'), 
																		  array( 'value' => $user['User']['active'],
																		  		 'empty' => false ) ); ?>
		</li>	
		<li><label>Confirmed</label><?php echo $this->Form->select('confirmed', array( 0 => 'No', 
																				       1 => 'Yes'), 
																		  		array( 'value' => $user['User']['confirmed'],
																					   'empty' => false ) ); ?>
		</li>	
		<li><label>Featured</label><?php echo $this->Form->select('featured', array( 0 => 'No', 
																				     1 => 'Yes'), 
																		      array( 'value' => $user['User']['featured'],
																		  		     'empty' => false ) ); ?>
		<li><label>Password</label><a href="<?php echo $this->request->base?>/admin/users/ajax_password/<?php echo $user['User']['id']?>" class="overlay" title="Change User Password">Change Password</a></li>
	</ul>
	
	<?php echo $this->element('ajax/profile_edit', array('cuser' => $user['User']));?>
</div>
</form>