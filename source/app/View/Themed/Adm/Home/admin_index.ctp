<?php
echo $this->Html->css(array('visualize'), null, array('inline' => false));
echo $this->Html->css(array('plugin-site'), null, array('inline' => false));
echo $this->Html->script(
    array(
        'enhance',
        'excanvas',
        'visualize.jQuery',
        'global/flot/jquery.flot.min',
        'global/flot/jquery.flot.resize.min',
        'global/flot/jquery.flot.categories.min',
        'admin/controller/index'
    ),
    array('inline' => false )
);

$this->Html->addCrumb(__('System Admin'));
$this->Html->addCrumb(__('Admin Home'), array('controller' => 'home', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "dashboard"));
$this->end();
?>

<?php
$active = '';
$regiter = '';
$i = 1;
foreach($stats as $day => $stat){
    $sUser = $stat['users'];
    $sActivities= $stat['activities'];
    if($i>1){
        $active.=  ",['$day', $sActivities]";
        $regiter.= ",['$day', $sUser]";
    }else{
        $i=2;
        $active =  "['$day', $sActivities]";
        $regiter=  "['$day', $sUser]";
    }

}
?>
<?php if (!$show_guild):?>
    <div class="make-guide-section">
        <div class="make-guide-section-header">
            <div class="make-guide-section-header-left">
                <h3><?php echo __('Completing moosocial setup')?></h3>
                <p><?php echo __('Only a few more tasks to go. You got this!')?></p>
            </div>
            <div class="make-guide-section-header-right">
                <a href="javascript:void(0);" id="dismiss" class="btn-admin-outlined-black"><?php echo __('Dismiss')?></a>
            </div>
        </div>
        <?php echo $this->element('admin/guide'); ?>
    </div>
    <?php $this->Html->scriptStart(array('inline' => false)); ?>
        $('.make-guide-section-menu a').click(function(){
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        $('#dismiss').click(function(){
            $.ajax({url: "<?php echo $this->request->base?>/make_guide/dismiss", success: function(result){
                location.reload();
            }});
        });
    <?php $this->Html->scriptEnd(); ?>
    <?php return; ?>
<?php endif;?>
<?php $this->Html->scriptStart(array('inline' => false)); ?>

mooPhrase.add("users", '<?php echo __('users');?>');

var activities = [<?php echo $active?>];
var registration = [<?php echo $regiter?>];
mooIndex.init(activities,registration);
$('#site-stats a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
mooIndex.init(activities,registration);
})
<?php $this->Html->scriptEnd(); ?>
<div class="row">
    <div class="col-md-9">
        <?php if (!Configure::read('core.hide_version')):?>
            <div class="row">
                <div class="col-md-12">
                    <div class="note note-info">
                        <h4 class="block">
                            <iframe src="https://www.moosocial.com/version.php?version=<?php echo  Configure::read('core.version') ?>"
                                    frameborder="0" scrolling="no" height="25" width="100%"></iframe>
                        </h4>
                    </div>

                </div>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="col-md-12">
                <div class="tiles">
                    <div class="tile  bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Users');?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('controller'=>'users','action'=>'admin_index')); ?>">
                            <div class="tile-body">
                                <i class="icon-users"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $user_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Blogs');?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'blog', 'controller'=>'blog_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-blog"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $blog_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Photos');?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'photo', 'controller'=>'photo_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-camera"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $photo_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Videos');?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'video', 'controller'=>'video_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-facetime-video"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $video_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Topics');?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'topic', 'controller'=>'topic_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-topic"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $topic_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Groups'); ?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'group', 'controller'=>'group_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-group"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $group_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="tile bg-gray">
                        <div class="tile-title">
                            <?php echo  __('Events') ?>
                        </div>
                        <a href="<?php echo  $this->Html->url(array('admin' => true,'plugin' => 'event', 'controller'=>'event_plugins')) ?>">
                            <div class="tile-body">
                                <i class="icon-calendar"></i>
                            </div>
                            <div class="tile-object">
                                <div class="number">
                                    <?php echo  $event_count ?>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php if(is_array($plugin_statistics) && count($plugin_statistics)): ?>
                        <?php foreach ($plugin_statistics as $statis): ?>
                            <div class="tile bg-gray">
                                <div class="tile-title">
                                    <?php echo $statis['name'] ?>
                                </div>
                                <a href="<?php echo  $statis['href'] ?>">
                                    <div class="tile-body">
                                        <?php echo $statis['icon'] ?>
                                    </div>
                                    <div class="tile-object">
                                        <div class="number">
                                            <?php echo  $statis['item_count'] ?>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class='tabbable tabbable-custom boxless tabbable-reversed'>
                    <ul id="site-stats" class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab_registration" data-toggle="tab">
                                <?php echo  __('Registration') ?> </a>
                        </li>
                        <li class="">
                            <a href="#tab_activities" data-toggle="tab">
                                <?php echo  __('Activities') ?> </a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <div id="tab_registration" class="tab-pane active">
                            <h2><?php echo  __('Site Stats - Registration Over Past 7 Days');?></h2>
                            <div id="site_registration" class="chart" style="width:100%" ></div>
                        </div>
                        <div id="tab_activities" class="tab-pane " >
                            <h2><?php echo  __('Site Stats - Activities Over Past 7 Days');?></h2>
                            <div id="site_activities" class="chart" style="width:100%;"></div>

                        </div>
                    </div>







                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bg-inverse">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase"><?php echo  __('Admin Notes')?></span>

                        </div>

                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <form class="form-horizontal" action="<?php echo  $this->request->base ?>/admin/system_settings/quick_save" method="post">

                            <div class="form-body">

                                <?php foreach ($settings as $setting):
                                    $setting = $setting['Setting']; ?>


                                    <div class="form-group">
                                        <?php echo $this->Form->hidden('setting_id.', array('value' => $setting['id'], 'id' => false)); ?>
                                        <?php echo $this->Form->hidden('type_id.'.$setting['id'], array('value' => $setting['type_id'], 'id' => false)); ?>
                                        <label class="col-md-3 control-label">
                                            <?php echo __d('setting',$setting['label']);?>
                                        </label>
                                        <div class="col-md-9">
                                            <?php
                                            switch($setting['type_id'])
                                            {
                                                case 'textarea':
                                                    echo $this->Form->textarea('textarea.'.$setting['id'], array(
                                                        'value' => $setting['value_actual'],
                                                        'class' => 'form-control',
                                                        'label' => false
                                                    ));
                                                    break;

                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-4">
                                            <input type="submit" class="btn green" value="<?php echo  __('Save Notes');?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!Configure::read('core.hide_plugin_admin')):?>
        <div class="row">
            <div id="plugin_list">

            </div>
        </div>
        <?php $this->Html->scriptStart(array('inline' => false)); ?>
            $.ajax({url: "<?php echo $this->request->base?>/admin/plugin_site/list", success: function(result){
                $("#plugin_list").html(result);
            }});
        <?php $this->Html->scriptEnd(); ?>
        <?php endif;?>
    </div>
    <div class="col-md-3">

        <div class="portlet-body">
            <h4 class="block"><?php echo  __('Tools') ?></h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="<?php echo  $this->request->base ?>/admin/tools/clear_cache"><?php echo  __('Clear Global Caches');?></a>
                </li>
                <li class="list-group-item">
                    <?php
                    $this->MooPopup->tag(array(
                        'href'=>$this->Html->url(array("controller" => "tools",
                            "action" => "admin_clean_tmp",
                            "plugin" => false,

                        )),
                        'title' => __('Clean Temp Upload Folder'),
                        'innerHtml'=> __('Clean Temp Upload Folder'),
                    ));
                    ?>

                </li>
                <li class="list-group-item">
                    <a href="<?php echo  $this->request->base ?>/admin/tools/remove_notifications"><?php echo  __('Remove Old Notifications')?></a>
                </li>
            </ul>
            <?php if (Configure::read('core.show_credit')):?>
                <h4 class="block"><?php echo  __('Support');?></h4>
                <ul class="list-group">
                    <li class="list-group-item">
                        <?php echo  $this->Html->link('mooSocial.com', "http://www.moosocial.com", array('target'=>'_blank')); ?>
                    </li>
                    <li class="list-group-item">
                        <?php echo  $this->Html->link(__('Clients Area'), "http://clients.moosocial.com", array('target'=>'_blank')); ?>
                    </li>
                    <li class="list-group-item">
                        <?php echo  $this->Html->link('mooWiki', "https://www.moosocial.com/wiki/doku.php?id=start", array('target'=>'_blank')); ?>
                    </li>
                    <li class="list-group-item">
                        <?php echo  $this->Html->link('mooCommunity', "http://community.moosocial.com", array('target'=>'_blank')); ?>
                    </li>
                    <li class="list-group-item">
                        <?php echo  $this->Html->link(__('Themes & Plugins'), "http://community.moosocial.com/topics", array('target'=>'_blank')); ?>
                    </li>
                </ul>

                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0';
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-page" data-href="https://www.facebook.com/moosocial" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/moosocial" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/moosocial">mooSocial</a></blockquote></div>
            <?php endif;?>
        </div>
        <!--</div>-->
    </div>
</div>