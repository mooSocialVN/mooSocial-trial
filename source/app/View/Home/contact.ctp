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
            url : mooConfig.url.base + "/home/contact",
            data: $("#form_contact").serialize()
        }, function(data){
            var json = $.parseJSON(data);
            if ( json.status){
                window.location = mooConfig.url.base + "/home/contact";
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
<div class="page-padding content_center full_content p_m_10">
    <div class="create_form">
    <form id="form_contact" action="<?php echo $this->request->base?>/home/contact" method="post">
    <h1><?php echo __('Contact Us')?></h1>
    
    <ul class="form_content ">
    	<li>
            <div class="col-md-2">
                <label><?php echo __('Your Name')?></label>
            </div>
            <div class="col-md-10">
                <?php echo $this->Form->text('name', array('value' => $cuser['name'], 'id' => 'contact_name')); ?>
            </div>
            <div class="clear"></div>
    	</li>
    	<li>
            <div class="col-md-2">
                <label><?php echo __('Email Address')?></label>
            </div>
            <div class="col-md-10">
                <?php echo $this->Form->text('sender_email', array('value' => $cuser['email'], 'id' => 'contact_email')); ?>
            </div>
            <div class="clear"></div>
    	</li>
    	<li>
            <div class="col-md-2">
                <label><?php echo __('Subject')?></label>
            </div>
            <div class="col-md-10">
                <?php echo $this->Form->text('subject'); ?>
            </div>
            <div class="clear"></div>
    	</li>
    	<li>
            <div class="col-md-2">
                <label><?php echo __('Message')?></label>
            </div>
            <div class="col-md-10">
                <?php echo $this->Form->textarea('message'); ?>
            </div>  
            <div class="clear"></div>
    	</li>
        <li>
            <div class="col-md-2">
                <label></label>
            </div>
            <div class="col-md-10">
                <?php $recaptcha_publickey = Configure::read('core.recaptcha_publickey');

                if ( $this->Moo->isRecaptchaEnabled()): ?>

                    <div>
                        <script src='<?php echo $this->Moo->getRecaptchaJavascript();?>'></script>
                        <div class="g-recaptcha" data-sitekey="<?php echo $recaptcha_publickey?>"></div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="clear"></div>
        </li>
    	<li>
            <div class="col-md-2">
                <label>&nbsp;</label>
            </div>
            <div class="col-md-10">
                <?php echo $this->Form->submit(__('Send'), array('class' => 'button button-action')); ?>
            </div>
            <div class="clear"></div>
    	</li>
    </ul>	
    </form>
    </div>
</div>
</div>