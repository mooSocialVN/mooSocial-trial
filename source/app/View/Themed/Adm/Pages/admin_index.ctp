<?php
echo $this->Html->css(array('jquery-ui', 'footable.core.min'), null, array('inline' => false));
echo $this->Html->script(array('jquery-ui', 'footable'), array('inline' => false));

$this->Html->addCrumb('Site Manager');
$this->Html->addCrumb('Pages Manager', array('controller' => 'pages', 'action' => 'admin_index'));

$this->startIfEmpty('sidebar-menu');
echo $this->element('admin/adminnav', array("cmenu" => "pages"));
$this->end();
?>

<script>
jQuery(document).ready(function(){
    jQuery( ".mooTable" ).sortable( {
        items: "tr:not(.tbl_head)", 
        handle: ".reorder",
        update: function(event, ui) {
            var list = jQuery('.mooTable').sortable('toArray');
            jQuery.post('<?php echo $this->request->base?>/admin/pages/ajax_reorder', { pages: list });
        }
    });
    
    $('.footable').footable();
});
</script>

<!--
<div class="portlet box grey-cascade">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-globe"></i>Managed Pages
        </div>

    </div>-->
    <div class="portlet-body">
        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-6">
                    <div class="btn-group">
                        <a class="btn btn-gray"  href="<?php echo $this->request->base?>/admin/pages/create">
                            <?php echo __('Create New Page')?>
                        </a>
                    </div>

                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="padding-top: 5px;">
                    <div class="note note-info hide">

                        <p>
                            You can enable Spam Challenge to force user to answer a challenge question in order to register. <br/>
                            To enable this feature, click System Settings -> Security -> Enable Spam Challenge
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-striped table-bordered table-hover" id="sample_1">
            <thead>
            <tr>
                <th width="50px"><?php echo $this->Paginator->sort('Page.id', 'ID'); ?></th>
                <th><?php echo $this->Paginator->sort('Page.title', 'Title'); ?></th>
                <th><?php echo $this->Paginator->sort('Page.alias', 'Alias'); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('Page.menu', 'Menu'); ?></th>
                <th data-hide="phone"><?php echo $this->Paginator->sort('Page.modified', 'Last Updated'); ?></th>
                <th data-hide="phone" width="50px">Actions</th>
            </tr>
            </thead>
            <tbody>

            <?php $count = 0;
            foreach ($pages as $page): ?>
                <tr class="gradeX <?php (++$count % 2 ? "odd" : "even") ?>" id="<?php echo $page['Page']['id']?>">
                    <td width="50px"><?php echo $page['Page']['id']?></td>
                    <td><a href="<?php echo $this->request->base?>/admin/pages/create/<?php echo $page['Page']['id']?>"><?php echo $page['Page']['title']?></a></td>
                    <td class="reorder"><?php echo $page['Page']['alias']?></td>
                    <td class="reorder"><?php if ($page['Page']['menu']) echo 'Yes'; else echo 'No'; ?></td>
                    <td class="reorder"><?php echo $this->Moo->getTime($page['Page']['modified'], Configure::read('core.date_format'), $utz)?></td>
                    <td width="70">
                        <a href="<?php echo $this->request->base?>/pages/<?php echo $page['Page']['alias']?>" target="_blank" class="tip" title="View"><i class="icon-file-alt icon-small"></i></a>&nbsp;
                        <a href="javascript:void(0)" class="tip" title="Delete" onclick="mooConfirm('<?php echo addslashes(__('Are you sure you want to delete this page?')) ?>', '<?php echo $this->request->base?>/admin/pages/delete/<?php echo $page['Page']['id']?>')"><i class="icon-trash icon-small"></i></a>
                    </td>
                </tr>
            <?php endforeach ?>

            </tbody>
        </table>

        <div class="pagination pull-right">
            <?php echo $this->Paginator->prev('« '.__('Previous'), null, null, array('class' => 'disabled')); ?>
			<?php echo $this->Paginator->numbers(); ?>
			<?php echo $this->Paginator->next(__('Next').' »', null, null, array('class' => 'disabled')); ?>
        </div>
    </div>



