<?php
/**
 * mooSocial - The Web 2.0 Social Network Software
 * @website: http://www.moosocial.com
 */
?>

<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>mooSocial</title>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css"
          href="<?php echo  $this->request->webroot ?>css/bootstrap.3.2.0/css/bootstrap.min.css?2.0.3"/>
    <link rel="stylesheet" type="text/css" href="<?php echo  $this->request->webroot ?>css/install/install.css"/>
</head>
<style type="text/css">
    .bs-callout {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #EEEEEE;
        border-image: none;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px 1px 1px 5px;
        margin: 20px 0;
        padding: 20px;
    }
    .bs-callout-danger h4 {
        color: #D9534F;
    }
    .bs-callout h4 {
        margin-bottom: 5px;
        margin-top: 0;
    }
    .bs-callout code {
        border-radius: 3px
    }

    .bs-callout + .bs-callout {
        margin-top: -5px
    }

    .bs-callout-danger {
        border-left-color: #d9534f;
    }

    .bs-callout-danger h4 {
        color: #d9534f;
    }

    .bs-callout-warning {
        border-left-color: #f0ad4e;
    }

    .bs-callout-warning h4 {
        color: #f0ad4e;
    }

    .bs-callout-info {
        border-left-color: #5bc0de;
    }

    .bs-callout-info h4 {
        color: #5bc0de;
    }

    .color-swatches {
        margin: 0 -5px;
        overflow: hidden;
    }
</style>
<body>

<?php echo $this->fetch('content'); ?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>
