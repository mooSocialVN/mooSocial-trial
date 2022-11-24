<?php

$form = $this->Form->create('Page', array(
                    'class' => 'form-horizontal',
                    //'url'=>array('controller'=>'','action'=>'')
    )
);
$this->Form->inputDefaults(array(
        'label' => array("class" => "col-lg-3 control-label"),
        'div' => array("class" => 'form-group'),
        'class' => 'form-control',
        'between' => '<div class="col-lg-9">',
        'after' => '</div>',

    )
);
$form .= $this->Form->input('id');
$form .= $this->Form->input('alias', array(
        'label' => array(
            'text' => __('Page Name :'),
            "class" => "col-lg-3 control-label"),
        'after' => '<span class="help-block blue">'.__('Page Name for your reference only').'</span></div>',
    )
);
$meta_disable = '';
if(in_array($data['Page']['alias'], array('albums_view', 'blogs_view', 'events_view', 'groups_view', 'photos_view', 'users_view', 'topics_view', 'videos_view')))
    $meta_disable = 'disabled';
$form .= $this->Form->input('title',
    array(
        'label' => array(
            'text' => __('Page Title :'),
            "class" => "col-lg-3 control-label"),
        'after' => '<span class="help-block blue"><a href="'.$this->request->base.'/admin/layout/ajax_translate/'.$data['Page']['id'].'" data-target="#ajax-page-translate" data-toggle="modal" class="" title="Translation" data-dismiss="" data-backdrop="true">'.__('Translate').'</a></span><span class="help-block blue">'.__('Title tag').'</span></div>',
        'title' => 'Automatically generated',
        $meta_disable
    )
);
$disable = '';
$url = 'url';
if($data['Page']['type']=='core')
    $disable = 'disabled';
else
    $url = 'alias';
$form .= $this->Form->input($url,
    array(
        'label' => array(
            'text' => __('Page URL:'),
            "class" => "col-lg-3 control-label"),
        'after' => '<span class="help-block blue">'.__('The URL may only contain alphanumeric characters and dashes - any other characters will be stripped.
                    The full url will be mooSite/PageURL').'</span></div>',
        $disable
    )
);
$form .= $this->Form->input('description',
    array(
        'label' => array(
            'text' => __('Page Description :'),
            "class" => "col-lg-3 control-label"),
        'after' => '<span class="help-block blue">'.__('Meta tag').'</span></div>',
        'title' => 'Automatically generated',
        //$meta_disable
    )
);

$form .= $this->Form->input('keywords',
    array(
        'label' => array(
            'text' => __('Page Keywords :'),
            "class" => "col-lg-3 control-label"),
        'after' => '<span class="help-block blue">'.__('Meta tag').'</span></div>',
    )
);
$form .= "</form>";
$form .= '<div style="display:none;margin-top:10px;" class="alert alert-danger error-message" id="page-edit-error"> </div>';
//$form .= $this->Form->end(__('Save'));

echo json_encode(
    array('data' => $form,
        'error' => null,
    )
);
?>