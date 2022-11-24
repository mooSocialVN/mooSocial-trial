<?php
$form = $this->Form->create('CoreContent', array(
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

$names = '';
$type = '';
$oKey = 0;
$label = '';

$form .= $this->Form->input('id');
        $block_info = json_decode($data[0]['CoreContent']['blockFormat'],true);
        $blockPathView = $data[0]['CoreContent']['blockPathView'];
        if($block_info != null){
            foreach($block_info as $key=> $value){
                if (isset($value['element']))
                {
                    $form.=$this->element($plugin.".".$value['element']);
                    continue;
                }
                $options = array();
                if($value['input'] == 'radio' || $value ['input'] == 'checkbox' || $value ['input'] == 'select'){
                    if($value['input'] == 'select'){
                        $options[] = $value['value'];

                        // Hook for top rating item and tag item;
                        if( ($blockPathView == 'topItemRating' || $blockPathView == 'core.tags') && $value['name'] == 'type'){
                            $event = new CakeEvent('View.Adm.Layout.adminGetContentInfo',$this);
                            $result = $this->getEventManager()->dispatch($event);
                            if ($blockPathView == 'topItemRating') {
                                if(!empty($result->result['rating']['type']) && is_array($result->result['rating']['type']) ){
                                    $options = array_merge($options[0],$result->result['rating']['type']);
                                }
                            }
                            else {
                                if(!empty($result->result['tag']['type']) && is_array($result->result['tag']['type']) ){
                                    $options = array_merge($options[0],$result->result['tag']['type']);
                                }
                            }

                        }

                    }else{
                        $aValue = explode(',',$value['value']);
                        $options = $aValue;
                    }
                    $name = $value['name'];
                    $type = $value['input'];
                    $oKey = $key;
                    $label = $value['label'];
                    ///////////////////////////
                    $aa = array(
                        'label' => array(
                            //'text' => $value['label'],
                            "class" => "col-lg-9 text-left pull-right"),
                        'type' => $type,
                        'options' => $options,
                        'before' => '<div class="row">',
                        'separator' =>'</div><div class="row">',
                        'after' => '</div>',
                        'name' => $name,
                        'class' => 'col-lg-3 text-right pull-left',
                        'legend' => false,
                        'value' => 0,
                    );
                    if($type =='checkbox'){
                        $aa['multiple'] = 'checkbox';
                        $aa['type'] = 'select';
                        $aa['label'] = array('text'=>$label,"class" => "col-lg-3 control-label");
                        $aa['div'] = array("class" => 'form-group');
                        $aa['class'] = '';
                        $aa['between'] = '<div class="col-lg-9">';
                        $aa['before'] = '';
                        $aa['after'] = '</div>';
                        //$aa['hiddenField'] = false;
                    }
                    if($type == 'select'){
                        $aa['type'] = $type;
                        $aa['label'] = array('text'=>$label,"class" => "col-lg-3 control-label");
                        $aa['div'] = array("class" => 'form-group');
                        $aa['class'] = 'form-control';
                        $aa['between'] = '<div class="col-lg-9">';
                        $aa['before'] = '';
                        $aa['separator'] = '';
                        $aa['after'] = '</div>';
                    }
                    //To do: redesign enable title
                    if($value['name'] == 'title_enable'){
                        $form .= '<div class="form-group">';
                        $form .= $this->Form->label('Enable Title', null, array('class' => 'col-lg-3 control-label'));
                        $form .= '<div class="col-lg-9">';
                        $form .= $this->Form->checkbox($name,array('name'=>$name.'[]','checked'=>'checked'));
                        $form .= '</div>';
                        $form .= '</div>';
                    }elseif($value['name'] == 'member_only'){ //To do: redesign show member only
                        $form .= '<div class="form-group">';
                        $form .= $this->Form->label(__('Show member only'), null, array('class' => 'col-lg-3 control-label'));
                        $form .= '<div class="col-lg-9">';
                        $form .= $this->Form->checkbox($name,array('name'=>$name.'[]','checked'=>'checked'));
                        $form .= '</div>';
                        $form .= '</div>';
                    }else{
                        $form .= $this->Form->input('input'.$oKey,$aa);
                    }
                    //////////////////////////
                }else{
                    if ($value['input'] == 'hidden'){
                        $form .= $this->Form->input('input' . $key, array(
                            'label' => array(
                                'text' => 'abc',
                                "class" => "col-lg-3 control-label"),
                            'type' => 'text',//$value['input'],
                            'value' => $value['value'],
                            'name' => $value['name'],
                            'div' => array("class" => 'form-group', "style" =>'display:none'),
                            'class' => 'form-control',
                            'between' => '<div class="col-lg-9">',
                            'after' => '</div>',
                        ));
                    }else{
                        $options = '';
                        $tip = array();
                        $convertValue;
                        if($value['name'] == 'title' || $value['name'] == 'html_block' || $value['name'] == 'menu_id' || $value['name'] == 'plugin'){
                            //$disable = 'disabled';
                            $convertValue = $data[0]['CoreContent']['blockName'];
                            if($value['name'] == 'title' || $value['name'] == 'html_block')
                            {
                                if(!empty($data[0]['CoreContent']['contentId']))
                                    $tip = array('after' => '</div><div class="tips" style="margin-left: 165px;"><a data-dismiss="modal" href="'.$this->request->base.'/admin/core_contents/ajax_translate/'.$data[0]['CoreContent']['contentId'].'/'.$value['name'].'"  data-toggle="modal" data-target="#ajax-translate2" >'.__('Translation').'</a></div>');
                                else
                                    $tip = array('after' => '</div><div class="tips" style="margin-left: 165px;">'.__('*You can add translation language after save changes').'</a></div>');
                            }
                        }else $convertValue = $value['value'];
                        $form .= $this->Form->input('input'.$key, array_merge(array(
                                'label' => array(
                                    'text' => $value['label'],
                                    "class" => "col-lg-3 control-label"),
                                'type' => $value['input'],
                                'value' => $convertValue,
                                'name' => $value['name']
                            ),$tip)
                        );
                    }
                }
            }
            $form .= $this->Form->input('roles',array(
                'type' => 'select',
                'multiple' => 'checkbox',
                'options' => $roles,
                'value' => array('all'),
                'name'=>'role_access',
                'label' => array('text'=>__('User Group Access'),"class" => "col-lg-3 control-label"),
                'div' => array("class" => 'form-group'),
                'class' => '',
                'between' => '<div class="col-lg-9 block_popup">',
                'before' => '',
                'after' => '</div>'
            ));
            $options = '';
            $form.= $this->Form->label('','Note: Block is only shown when there is related contents','note');
            $form .=$this->Form->hidden('pathview',array('value'=>$blockPathView));
        }

echo json_encode(
    array(
        'data' => $form,
        'pathview' => $blockPathView,
        'headerTitle'=>$data[0]['CoreContent']['blockName'],
        'error' => ""
//die();
    )
);
/*         $form = "<form name='abc' id='abc'>";
            foreach($data as &$data){

                $form .= "<input type='text' name='".$data['CoreContent']['name']."' value='".$data['CoreContent']['value']."'/>";

            }
        $form .= "</form>";

echo json_encode(
array('data' => $form,
'error' => $data['CoreContent']['blockFormat'],
)
);*/
?>