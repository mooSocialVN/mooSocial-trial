<?php echo $this->element('admin/adminnav', array("cmenu" => "spam_challenges"));?>

<div id="center">	
	<a href="<?php echo $this->request->base?>/admin/spam_challenges/ajax_create" class="overlay button button-action topButton" title="Add New Challenge">Add New Challenge</a>
	<h1>Spam Challenges</h1>
	
	<div class="box1 member_message" style="margin-top: 15px;">
		You can enable Spam Challenge to force user to answer a challenge question in order to register.<br />
		To enable this feature, click System Settings -> Security -> Enable Spam Challenge 
	</div>
	
	<table class="mooTable" cellpadding="0" cellspacing="0">
		<tr class="tbl_head">
			<th width="20px">ID</th>
			<th>Question</th>
			<th width="50px">Active</th>
			<th width="50px">Actions</th>
		</tr>
		<?php
		foreach ($challenges as $challenge):
		?>
		<tr>
			<td width="20px"><?php echo $challenge['SpamChallenge']['id']?></td>
			<td><a href="<?php echo $this->request->base?>/admin/spam_challenges/ajax_create/<?php echo $challenge['SpamChallenge']['id']?>" class="overlay" title="<?php echo $challenge['SpamChallenge']['question']?>"><?php echo $challenge['SpamChallenge']['question']?></a></td>
			<td width="50px"><?php echo ($challenge['SpamChallenge']['active']) ? 'Yes' : 'No'?></td>
			<td width="50px"><a href="javascript:void(0)" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this challenge?')) ?>', '<?php echo $this->request->base?>/admin/spam_challenges/delete/<?php echo $challenge['SpamChallenge']['id']?>')"><i class="icon-trash icon-small"></i></a></td>
		</tr>
		<?php endforeach ?>
	</table>
</div>