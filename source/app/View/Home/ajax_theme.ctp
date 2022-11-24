<?php if($this->request->is('ajax')) $this->setCurrentStyle(4);?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
    <div class="title-modal"><?php echo __('Change Theme')?></div>
</div>
<div class="modal-body">
    <ul class="list-group">
    <?php
    foreach ($site_themes as $theme_id => $theme):
        if ( $theme_id != 'mobile' ):
            ?>
            <li><a href="<?php echo $this->request->base?>/home/do_theme/<?php echo $theme_id?>"><?php echo $theme?></a></li>
        <?php
        endif;
    endforeach;
    ?>
    </ul>
</div>
           
