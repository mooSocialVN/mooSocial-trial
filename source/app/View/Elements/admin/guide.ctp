<?php 
$data = file_get_contents('https://moosocial.com/guild.json');
$data = json_decode($data,true);

$project_id = '';
require( APP . 'Config/config.php' );
if (!empty($CONFIG['project_id']))
{
    $project_id = $CONFIG['project_id'] ;
}
    
?>

<div class="make-guide-section-body hidden-xs hidden-sm">
    <div class="make-guide-section-body-left">
        <ul class="make-guide-section-menu nav nav-tabs" role="tablist">
            <?php $i = 0;?>
            <?php foreach ($data as $key => $item): ?>
                <?php 
                    if ($key == 'enable_ssl')
                    {
                        if ($project_id) 
                        {
                            continue;
                        }
                    }
                    if ($key == 'domain')
                    {
                        if (!$project_id) 
                        {
                            continue;
                        }
                    }

                    if ($key == 'change_landing_page')
                    {
                        if (!$project_id) 
                        {
                            continue;
                        }
                    }
                ?>
                <?php if (!isset($item['link'])):?>
                    <li role="presentation" <?php if (!$i):?>class="active"<?php endif;?>><a href="#<?php echo $key;?>" aria-controls="<?php echo $key;?>" role="tab" data-toggle="tab"><span class="material-icons btn-admin-icon"> check_circle_outline </span><?php echo $item['name'];?></a></li>
                <?php else: ?>
                    <li role="presentation"><a target="_blank" href="<?php echo $item['link'];?>"><span class="material-icons btn-admin-icon"> check_circle_outline </span><?php echo $item['name'];?></a></li>
                <?php endif; ?>
                <?php $i++;?>
            <?php endforeach;?>            
        </ul>
    </div>
    <div class="make-guide-section-body-right tab-content">
        <?php $i = 0;?>
        <?php foreach ($data as $key => $item): ?>
            <?php if (!isset($item['title'])) continue; ?>
            <?php 
                if ($key == 'enable_ssl')
                {
                    if ($project_id) 
                    {
                        continue;
                    }
                }
                if ($key == 'domain')
                {
                    if (!$project_id) 
                    {
                        continue;
                    }

                    $item['button_link'] = $item['button_link'].$project_id;
                    $item['description'] = str_replace('{domain}',$_SERVER['SERVER_NAME'],$item['description']);
                }

                if ($key == 'change_landing_page')
                {
                    if (!$project_id) 
                    {
                        continue;
                    }
                }
            ?>
            <div role="tabpanel" class="tab-pane <?php if (!$i): ?>active<?php endif;?>" id="<?php echo $key;?>">
                <h5><?php echo $item['title']?></h5>
                <p><?php echo $item['description'];?></p>
                <?php 
                    $url = $item['button_link'];
                    if (!filter_var($url, FILTER_VALIDATE_URL)) {
                        $url = $this->request->base.$item['button_link'];
                    }
                ?>
                <a href="<?php echo $url?>" class="btn-admin-filled-blue"><?php echo $item['button_name']?></a>
                <?php if ($item['guild_name']):?>
                    <a target="_blank" href="<?php echo $item['guild_link'];?>"><i><?php echo $item['guild_name']?></i></a>
                <?php endif;?>
            </div>
            <?php $i++;?>
        <?php endforeach;?>

    </div>
</div>

<div class="make-guide-section-body hidden-md hidden-lg">
    <div class="make-guide-section-content-mb">
        <?php $i = 0;?>
        <?php foreach ($data as $key => $item): ?>
            <?php 
                if ($key == 'enable_ssl')
                {
                    if ($project_id) 
                    {
                        continue;
                    }
                }
                if ($key == 'domain')
                {
                    if (!$project_id) 
                    {
                        continue;
                    }
                }
                
                if ($key == 'change_landing_page')
                {
                    if (!$project_id) 
                    {
                        continue;
                    }
                }
            ?>
            <div class="make-guide-section-item">
                <?php if (!isset($item['link'])):?>
                    <a class="make-guide-section-item-link <?php echo (!$i)?'':'collapsed'?>" role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $key;?>-mb" aria-expanded="false" aria-controls="<?php echo $key;?>-mb"><span class="material-icons btn-admin-icon"> check_circle_outline </span><?php echo $item['name'];?></a>
                <?php else: ?>
                    <a class="make-guide-section-item-link collapsed" target="_blank" href="<?php echo $item['link'];?>"><span class="material-icons btn-admin-icon"> check_circle_outline </span><?php echo $item['name'];?></a>
                <?php endif; ?>
                <?php if (!isset($item['title'])) continue; ?>
                <?php 
                    if ($key == 'enable_ssl')
                    {
                        if ($project_id) 
                        {
                            continue;
                        }
                    }
                    if ($key == 'domain')
                    {
                        if (!$project_id) 
                        {
                            continue;
                        }

                        $item['button_link'] = $item['button_link'].$project_id;
                        $item['description'] = str_replace('{domain}',$_SERVER['SERVER_NAME'],$item['description']);
                    }

                    if ($key == 'change_landing_page')
                    {
                        if (!$project_id) 
                        {
                            continue;
                        }
                    }
                ?>
                <div class="panel-collapse collapse <?php echo (!$i)?'in':'' ?>" id="<?php echo $key;?>-mb">
                    <div class="make-guide-section-body-right">
                        <h5><?php echo $item['title']?></h5>
                        <p><?php echo $item['description'];?></p>
                        <?php 
                            $url = $item['button_link'];
                            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                                $url = $this->request->base.$item['button_link'];
                            }
                        ?>
                        <a href="<?php echo $url?>" class="btn-admin-filled-blue"><?php echo $item['button_name']?></a>
                        <?php if ($item['guild_name']):?>
                            <a target="_blank" href="<?php echo $item['guild_link'];?>"><i><?php echo $item['guild_name']?></i></a>
                        <?php endif;?>
                    </div>
                </div>                         
            </div>
            <?php $i++;?>
        <?php endforeach;?>            
    </div>
</div>