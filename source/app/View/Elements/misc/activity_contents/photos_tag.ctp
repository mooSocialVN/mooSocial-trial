<ul class="list4 activity_content p_photos tagged_photo">
<?php foreach ( $activity['Content'] as $photo ): ?>
    <li class="col-xs-6 col-sm-4 col-md-3">
            <div class="p_2">
	
	   <a class="layer_square" style="background-image:url(<?php echo $this->request->webroot?><?php echo $photo['Photo']['thumb']?>)" href="<?php echo $this->request->base?>/photos/view/<?php echo $photo['Photo']['id']?>/uid:<?php echo $activity['Activity']['user_id']?>#content"></a>
		
            </div>
    </li>
<?php endforeach; ?>

</ul>
