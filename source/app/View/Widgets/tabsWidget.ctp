<!-- Nav tabs -->
<?php
//$tabs = Hash::extract($widgets,'{n}[parent_id = '.$tabId.'].params');//'{n}.parent_id'
if(!empty($widgets)):
    $tabs = Hash::combine($widgets,'{n}.id','{n}.params','{n}.parent_id');//'{n}.parent_id'
    ?>
    <?php if(!empty($tabs[$tabId])): ?>
    <ul class="nav nav-tabs" role="tablist">
        <?php
            $i = 0;//used as flag to find out if this is the first element in tab array or not
            foreach($tabs[$tabId] as $id => $param):
                $attr = '';
                if($i == 0)
                    $attr = 'active';
                $param = json_decode($param, true);
        ?>
                <li class="<?php echo  $attr; ?>" role="presentation"><a href="#<?php echo  $id ?>" aria-controls="<?php echo  $param['title']; ?>" role="tab" data-toggle="tab"><?php echo  $param['title']; ?></a></li>
        <?php $i++; endforeach; ?>

    </ul>
    <div class="tab-content">
            <?php $this->_helpingLoadingBlocks($widgets,$tabId,$invisible,1); ?>
    </div>
    <?php endif; ?>
<?php endif; ?>