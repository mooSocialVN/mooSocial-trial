<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-edit"></i><?php echo  __('Linkedin Integration') ?>
        </div>
    </div>
    <div class="portlet-body form">
        <?php  
            echo $this->Form->create('SocialIntegration.SocialProvider', array(
                'class' => 'form-horizontal',
                'url' => array('plugin' => 'social_integration', 'controller' => 'providers', 'action' => 'save', 'admin' => true)
            ));
        ?>
        
        <?php echo $this->Form->hidden('id', array('value' => isset($provider)?$provider['id']:'')); ?>
        <?php echo $this->Form->input('key', array('type' => 'hidden', 'value' => 'linkedin')) ?>
        
        <p class="form-description">You can now integrate MooSocial to Linkedin. To do so, create an Application through the <a target="_blank" href="https://www.linkedin.com/secure/developer">Linkedin Developers</a> page.
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Linkedin Key');?></label>
            <div class="col-md-4">
                <?php
                    echo $this->Form->input('client_api', array(
                        'class' => 'form-control',
                        'label' => false
                    ));
                ?>
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label"><?php echo __('Linkedin Secret');?></label>
            <div class="col-md-4">
                <?php
                    echo $this->Form->input('client_secret', array(
                        'class' => 'form-control',
                        'label' => false
                    ));
                ?>
            </div>
        </div>
        
        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button id="createButton" class="btn btn-circle blue"><i class="icon-save"></i> <?php echo __('Save');?></button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-3 col-md-6">
                    <div class="alert alert-danger error-message" style="display:none;margin-top:10px"></div>
                </div>
            </div>
        </div>
        
        <?php echo $this->Form->end(); ?>
    </div>
</div>