<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<title><?php echo $this->title." - ".$this->description; ?></title>
</head>

<body>
<?php echo $content; ?>
</body>

</html>
