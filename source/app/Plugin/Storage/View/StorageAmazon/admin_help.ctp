<div class="hidden" id="remove-hidden-after-loading">
    <?php

    echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
    echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));
    $this->Html->addCrumb(__d("setting",'Storage System'), null);
    $url = Router::url(array(
        'plugin'=>'storage',
        'controller' => 'storages',
        'action' => 'admin_index'),true);
    $this->Html->addCrumb(__('Manage Storage Services'), $url);
    $this->Html->addCrumb(__('Amazon S3'), null);
    $this->startIfEmpty('sidebar-menu');
    echo $this->element('admin/adminnav', array('cmenu' => 'storage'));
    $this->end();
    ?>
    <?php echo $this->Moo->renderMenu('Storage', __('Settings'));?>
    <div class="row">
        <div class="col-md-8">
            <div>
                <!-- BEGIN GENERAL PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-social-dribbble font-blue-sharp"></i>
                            <span class="caption-subject font-blue-sharp bold uppercase"><?php echo __('Troubleshooting'); ?></span>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3><?php echo __('Failed to load resource: the server responded with a status of 403 (Forbidden)'); ?> </h3>
                                <h5><?php echo __('THE PROBLEM'); ?> </h5>
                                <div class="note note-danger">
                                    <p>
                                        <?php echo __('If you ever see this error in your browser, you should know that you must push your missing file to Amazon S3 '); ?>
                                    </p>
                                </div>
                                <img src="<?php echo $this->Storage->getImage("storage/img/failed-to-load-resource.png") ?>" class="img-responsive" alt="Responsive image">
                                <h5><?php echo __('THE SOLUTION'); ?> </h5>
                                <div class="note note-info">
                                    <p> <?php echo __('You should already be at your Home > Storage System > Manage Storage Services. Click on "Synchronise webroot directory", and you should receive a modal prompt.'); ?></p>
                                    <p><?php echo __("You need to chose js file type and webroot/js folder .After that , you have something like :"); ?></p>

                                </div>
                                <img src="<?php echo $this->Storage->getImage("storage/img/sync-amazon-action.png") ?>" class="img-responsive" alt="Responsive image">
                                <br/>
                                <div class="note note-info">
                                    <p><?php echo __("Click OK and see \"Sync in progress\" section for checking file syncing status."); ?></p>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h3><?php echo __('Amazon S3 CORS (Cross-Origin Resource Sharing) and cross-domain font loading'); ?> </h3>
                                <h5><?php echo __('THE PROBLEM'); ?> </h5>
                                <div class="note note-danger">
                                    <p>
                                        <?php echo __('Usually web browsers forbids cross-domain requests, due the same origin security policy.If you ever see this error in your browser, you should know that cross-origin policy is applied.'); ?>
                                    </p>
                                </div>
                                <img src="<?php echo $this->Storage->getImage("storage/img/cross-domain-fonts.png") ?>" class="img-responsive" alt="Responsive image">
                                <h5><?php echo __('THE SOLUTION'); ?> </h5>
                                <div class="note note-info">
                                    <p> <?php echo __('You should already be at your Amazon Management Console at http:// console.aws.amazon.com. Click on Properties→Permissions→Edit CORS configuration, and you should receive a modal prompt.'); ?></p>
                                    <p><?php echo __("You need to edit AllowedHeader string in the rule like this 	&lt;AllowedHeader&gt;*	&lt;/AllowedHeader&gt; . After that , you have something like :"); ?></p>

                                </div>
                                <img src="<?php echo $this->Storage->getImage("storage/img/cors-configuration-editor.png") ?>" class="img-responsive" alt="Responsive image">
                                <br/>
                                <div class="note note-info">
                                    <p><?php echo __("Click save, switch over to your site, refresh it, and then observe the changes."); ?></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END GENERAL PORTLET-->

        </div>
        <div class="col-md-4">

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bars"></i><?php echo __('Topics'); ?> </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <ul>
                        <li> <?php echo __('Troubleshooting'); ?>
                            <ul>
                                <li><?php echo __("Failed to load resource: the server responded with a status of 403 (Forbidden)"); ?></li>
                                <li><?php echo __("Amazon S3 CORS (Cross-Origin Resource Sharing) and cross-domain font loading"); ?></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $this->Html->scriptStart(array('inline' => false)); ?>
    $( document ).ready(function() {
    $(".tab-2 >a").text("<?php echo __('Amazon S3'); ?>");
    $("#remove-hidden-after-loading").removeClass("hidden");
    });
<?php $this->Html->scriptEnd(); ?>