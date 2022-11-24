<?php
echo $this->Html->css(array('codemirror','spectrum'), null, array('inline' => false));
echo $this->Html->script(array('scripts.js',
    'codemirror/codemirror',
    'codemirror/javascript',
    'codemirror/css',
    'codemirror/clike',
    'codemirror/xml',
    'codemirror/php',
    'codemirror/htmlmixed',
    'codemirror/htmlembedded',
    'spectrum'), array('inline' => false));

$this->Html->addCrumb(__('Site Manager'));
$this->Html->addCrumb(__('Themes Manager'), array('controller' => 'themes', 'action' => 'admin_index'));
$this->Html->addCrumb(__('Setting'), array('controller' => 'themes', 'action' => 'admin_setting',$theme['Theme']['id']));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "themes"));
$this->end();
$theme_setting = '';
?>

<div class="col-xs-12">
    <h4 style="margin: 0 0 10px 0; font-weight: bold;"><?php echo $theme['Theme']['name']; ?></h4>
    <?php echo $this->element('admin/themenav', array("cmenu" => "setting", "theme_id" => $theme['Theme']['id'])); ?>

    <div class="form-group">
        <div class="col-xs-12X">
            <?php echo __('Please make sure you clear global cache after making color change. If amazon s3 is enabled, the changes only apply if you switch site to production mode and clear global cache.') ?>
        </div>
    </div>

    <div class="portlet-body">
        <div class=" portlet-tabs">
            <div class="tabbablex tabbable-customx boxlessx tabbable-reversedx">
                <div class="tab-content">
                    <div class="tab-pane active" id="portlet_tab1">
                        <?php
                        echo $this->Form->create('Theme', array(
                            'id' => 'theme_setting_form',
                            'class' => 'form-horizontal',
                            'url' => 'save_custom_css/',
                            'enctype' => 'multipart/form-data'
                        ));
                        ?>
                        <?php echo $this->Form->hidden('theme_id', array('id' => 'theme_id', 'value' => $theme['Theme']['id'])); ?>

                        <!-- ------------ -->
                        <?php if($appearance == 'light'): ?>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <?php
                                        echo $this->Form->checkbox('custom_css_enable', array(
                                            'value' => 1,
                                            'checked' => $theme['Theme']['custom_css_enable'],
                                        ));
                                        ?>
                                        <?php echo __('Enable'); ?>  (<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __("Uncheck if you don't want to apply the custom colors and background image setup here. Use default color and background of the theme.") ?>" data-placement="right">?</a>)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox">
                                    <label>
                                        <?php
                                        echo $this->Form->checkbox('custom_css_landing', array(
                                            'value' => 1,
                                            'checked' => $theme['Theme']['custom_css_landing'],
                                        ));
                                        ?>
                                        <?php echo __('Apply to Landing Page'); ?> (<a data-html="true" href="javascript:void(0)" class="tooltips" data-original-title="<?php echo __("Uncheck if you don't want to apply custom colors and set background images here for the landing page. Use the default color and background of the theme.") ?>" data-placement="right">?</a>)
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div style="margin-bottom: 15px">
                            <div class="form-inline">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <h4><strong><?php echo __('Appearance') ?></strong>:</h4>
                                    </div>
                                </div>
                                <a class="btn btn-appearance <?php if($appearance == 'light'): ?>btn-light<?php endif; ?>" href="<?php echo $this->request->base?>/admin/themes/setting/<?php echo $theme['Theme']['id']?>/light"><?php echo __('Light') ?></a>
                                <?php if($theme_enable_appearance): ?>
                                <a class="btn btn-appearance <?php if($appearance == 'dark'): ?>btn-dark<?php endif; ?>" href="<?php echo $this->request->base?>/admin/themes/setting/<?php echo $theme['Theme']['id']?>/dark"><?php echo __('Dark') ?></a>
                                <?php endif; ?>
                                <?php echo $this->Form->hidden('appearance', array('id' => 'appearance', 'value' => $appearance)); ?>
                            </div>
                        </div>

                        <div class="form-body form-body-setting">
                            <?php
                            $current_theme = $this->theme;
                            $this->theme = $theme['Theme']['key'];
                            $this->_paths = array();
                            echo $this->element('admin/theme_settings', array("theme_id" => $theme['Theme']['id']));
                            $this->theme = $current_theme;
                            $this->_paths = array();
                            ?>
                        </div>
                        <!-- ------------ -->

                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-9">
                                    <button id="createButton" class="btn btn-danger" type="submit"><i class="icon-save"></i> <?php echo __('Save'); ?></button>
                                    <button id="reset_settings" class="btn btn-primary btn-circle" type="button"><?php echo __('Reset Setting'); ?></button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <div class="alert alert-danger error-message" style="display:none;margin-top:10px"></div>
                                </div>
                            </div>
                        </div>
                        <?php echo $this->Form->end(); ?>
                        <!-- END FORM-->
                        <div style="display: none;">
                            <a target="_blank" href="<?php echo $this->request->base?>/themes/theme_setting_array/<?php echo $theme['Theme']['id'].'/'.$appearance ?>">Default data</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if($this->request->is('ajax')): ?>
<script>
<?php else: ?>
<?php //$this->Html->scriptStart(array('inline' => false));   ?>
<?php $this->Html->scriptStart(array('inline' => false, 'domReady' => true, 'requires' => array('jquery', 'mooPhrase', 'simplemodal'),  'object' => array('$', 'mooPhrase', 'simplemodal'))); ?>
<?php endif; ?>

$('input.color-picker').each(function () {
    $(this).spectrum({
        showInput: true,
        allowEmpty:true
    });
});

$('.reset-upload_image_review').each(function (index) {
    $(this).click(function (e) {
        e.preventDefault();
        var eleReview = $(this).parents('.upload_image_review');
        eleReview.find('.image_review-thumb').hide();
        eleReview.find('.review-img').attr('src', '');
        eleReview.find('input.upload_image_value').val('');
    });
});

$('#reset_settings').click(function(e){
    $.fn.SimpleModal({
        title:  '<?php echo __('Reset Setting') ?>',
        contents: '<?php echo __('Are you sure you want to reset this setting?') ?>',
        model: 'content',
        hideFooter: false,
        closeButton: false
    }).addButton( '<?php echo __('OK') ?>', "btn blue ok", function() {
        $('#reset_settings').attr('disabled', 'disabled');
        $('#createButton').attr('disabled', 'disabled');

        var _this = this;
        var appearance = $('#appearance').val();

        $('input.color-picker').each(function () {
            $(this).spectrum("set", '');
        });
        //$('#theme_setting_form').find("input[type=text]").val("");
        $('#theme_setting_form').find("input[type=file]").val("");
        $('#theme_setting_form').find("input.upload_image_value").val("");
        $('#theme_setting_form').find("select").val("");

        $.post("<?php echo $this->request->base?>/admin/themes/ajax_reset_setting", {theme_id: $('#theme_id').val(), appearance: appearance}, function(data){
            var json = $.parseJSON(data);

            json.forEach(function(item){
                if(item.type == 'color'){
                    $('#frm-'+item.key).spectrum("set", item.value);
                }else{
                    $('#frm-'+item.key).val(item.value);
                }
            });

            _this.hideModal();
            $('#theme_setting_form').submit();
        });
    }).addButton('<?php echo __('Close') ?>', "btn default").showModal();

});

<?php if($this->request->is('ajax')): ?>
</script>
<?php else: ?>
<?php $this->Html->scriptEnd();  ?>
<?php endif; ?>

<style type="text/css">
    .simple-modal-footer .btn{
        margin-left: 3px;
        margin-right: 3px;
    }
    .btn-appearance{
        font-size: 17px;
    }
    .btn-light{
        color: #ffffff;
        background-color: #428bca;
        border: 1px solid #357ebd;
    }
    .btn-light:hover, .btn-light:focus, .btn-light:active{
        color: #357ebd;
        background-color: #ffffff;
        border: 1px solid #357ebd;
    }
    .btn-dark{
        color: #ffffff;
        background-color: #000000;
        border: 1px solid #000000;
    }
    .btn-dark:hover, .btn-dark:focus, .btn-dark:active{
        color: #000000;
        background-color: #ffffff;
        border: 1px solid #000000;
    }
    .form-body-setting{
        margin-bottom: 15px;
    }
    .form-content-setting{
        border: 1px solid #dddddd;
    }
    .nav-tab-setting > li.active > a,
    .nav-tab-setting > li.active > a:hover,
    .nav-tab-setting > li.active > a:focus,
    .nav-tab-setting > li.active > a:active{
        background-color: #eeeeee;
        border-color: #eeeeee;
    }
    .tab-content-setting .tab-pane{
        padding: 15px;
    }

    .upload_image_review{

    }

    .image_review-thumb .review-img{
        max-height: 100px;
        display: block;
    }
    .reset-upload_image_review{
        display: inline-block;
        margin-bottom: 5px;
        margin-top: 5px;
    }

    .panel-heading-review{
        float: right;
        display: block;
        margin-top: -8px;
    }
    .panel-heading-review .material-icons{
        font-size: 35px;
        display: block;
    }
    .panel-heading-review:hover, .panel-heading-review:active, .panel-heading-review:focus{
        text-decoration: none;
    }
    .panel-review{
        padding: 10px;
        background-color: #fbfbfb;
    }
    .image-review{
        margin: 0 auto 10px auto;
        display: block;
        max-width: 100%;
    }
    .panel-review-close{
        text-align: center;
        padding: 5px;
    }
    .panel-review-close .material-icons{
        font-size: 30px;
    }
    .panel-review-link{
        display: block;
    }

</style>
