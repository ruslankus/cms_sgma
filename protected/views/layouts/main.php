<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <meta name="description" content="<?php echo $this->description; ?>">
    <meta name="keywords" content="<?php echo $this->keywords ?>">
    <title><?php echo $this->title?></title>
</head>

<body>
CORE LAYOUT
<?php echo DynamicWidgets::get('Additional'); ?>
<?php echo DynamicWidgets::get('Main'); ?>
<?php echo DynamicWidgets::get('Bottom'); ?>
<?php echo $content; ?>
</body>

</html>
