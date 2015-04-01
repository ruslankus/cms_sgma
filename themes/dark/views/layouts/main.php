<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<title><?php echo $this->title." - ".$this->description; ?></title>
</head>

<body>
DARK LAYOUT
<?php echo DynamicWidgets::get('GGGGGGG'); ?>
<?php echo DynamicWidgets::get('Top-right'); ?>
<?php echo $content; ?>
</body>

</html>
