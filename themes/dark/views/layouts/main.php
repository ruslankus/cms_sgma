<?php /* @var $this Controller */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="en">
    <title><?php echo $this->title." - ".$this->description; ?></title>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/jcapSlide/css/style.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.theme.css">
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/banners.css">
</head>

<body>
DARK LAYOUT
<?php echo DynamicWidgets::get('Left'); ?>
<?php echo DynamicWidgets::get('Top'); ?>
<?php echo DynamicWidgets::get('Central-left'); ?>

<?php echo $content; ?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jcapSlide/jquery.capSlide.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/owl-carousel/owl.carousel.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/banners.js"></script>
</body>

</html>
