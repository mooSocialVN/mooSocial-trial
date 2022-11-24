<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooAlert','mooAjax'), 'object' => array('$', 'mooAlert','mooAjax'))); ?>
    $('#form_contact').submit(function( event ) {
        if ( jQuery('#contact_name').val().trim() == '' || jQuery('#contact_email').val().trim() == '' || jQuery('#subject').val().trim() == '' || jQuery('#message').val().trim() == '' )
        {
            mooAlert.alert('<?php echo addslashes(__('All fields are required'))?>');
            event.preventDefault();
            return;
        }

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        if( reg.test( jQuery('#contact_email').val() ) == false ) {
            mooAlert.alert('<?php echo addslashes(__('Invalid email address'))?>');
            event.preventDefault();
            return;
        }

        mooAjax.post({
            url : mooConfig.url.base + "/contact",
            data: $("#form_contact").serialize()
        }, function(data){
            var json = $.parseJSON(data);
            if ( json.status){
                window.location = mooConfig.url.base + "/contact";
            }
            else
            {
                mooAlert.alert(json.message);
            }
        });
        event.preventDefault();
        return;
    });
<?php $this->Html->scriptEnd(); ?>

<?php
if ( !$uid )
{
	$cuser['name']  = '';
	$cuser['email'] = '';
}
?>
<div class="bar-content">
    <div class="box2 bar-content-warp">
        <div class="box_header mo_breadcrumb">
            <div class="box_header_main">
                <h1 class="box_header_title"><?php echo __('Contact Us')?></h1>
                <div class="box_action"></div>
            </div>
        </div>
        <div class="box_content">
            <div class="create_form">
                <form id="form_contact" class="form-horizontal" action="<?php echo $this->request->base?>/contact" method="post">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Your Name')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('name', array('value' => html_entity_decode($cuser['name']), 'id' => 'contact_name', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Email Address')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('sender_email', array('value' => $cuser['email'], 'id' => 'contact_email', 'class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Subject')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->text('subject', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"><?php echo __('Message')?></label>
                        <div class="col-sm-9">
                            <?php echo $this->Form->textarea('message', array('class' => 'form-control')); ?>
                        </div>
                    </div>
                    <?php $recaptcha_publickey = Configure::read('core.recaptcha_publickey');
                    if ( $this->Moo->isRecaptchaEnabled()): ?>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-9">
                            <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                            <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_publickey?>" <?php if($this->isThemeDarkMode()): ?>data-theme="dark"<?php endif; ?>></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <div class="create-form-actions">
                                <?php echo $this->Form->submit(__('Send'), array('class' => 'btn btn-primary')); ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>