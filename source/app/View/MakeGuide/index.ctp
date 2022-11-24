<link href="<?php echo $this->request->base?>/theme/adm/css/plugins.css" rel="stylesheet">
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_content">
            <div class="make-guide-section">
                <div class="make-guide-section-header">
                    <div class="make-guide-section-header-left">
                        <h3><?php echo __('Completing moosocial setup')?></h3>
                        <p><?php echo __('Only a few more tasks to go. You got this!')?></p>
                    </div>
                    <?php if (!$show_guild): ?>
                        <div class="make-guide-section-header-right">
                            <a href="javascript:void(0);" id="dismiss" class="btn btn-profile"><?php echo __('Dismiss')?></a>
                        </div>
                    <?php endif;?>
                </div>
                <?php echo $this->element('admin/guide'); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires'=>array('jquery'), 'object' => array('$'))); ?>
    $('.make-guide-section-menu a').click(function(){
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    $('#dismiss').click(function(){
        $.ajax({url: "<?php echo $this->request->base?>/make_guide/dismiss", success: function(result){
            window.location.href = "<?php echo $this->request->base ?>";
        }});
    });
<?php $this->Html->scriptEnd(); ?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>
    
<?php $this->Html->scriptEnd(); ?>
<?php return; ?>