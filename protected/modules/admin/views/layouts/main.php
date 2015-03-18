<?php /* @var $this ControllerAdmin */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="en">
	<title><?php echo $this->title." - ".$this->description; ?></title>
</head>

<body>

<span>Menu(controllers):</span>
<?php $this->widget('admin.widgets.AdminControllersMenu',array('current' => Yii::app()->controller->id)); ?>
<br>
<span>Sub-menu(actions):</span>
<?php $this->widget('admin.widgets.AdminActionsMenu',array('currentController' => Yii::app()->controller->id, 'currentAction' => Yii::app()->controller->action->id)); ?>
<br>

<?php echo $content; ?>
</body>

</html>
