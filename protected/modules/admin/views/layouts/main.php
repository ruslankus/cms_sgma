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
<div class="fluid">
   	<header>
			<div class="wrapper">
				<div class="menu">
					<span class="bar a"></span>
					<span class="bar b"></span>
					<span class="bar c"></span>
					<span class="bar d"></span><!--triangle-->
				</div><!--/menu-->
				<span class="logo">Voyaje CMS</span><!--/logo-->
				
				<a href="" class="calendar"></a>
				<a href="" class="messages"><span class="bubble">305</span></a>
				<a href="" class="notices"><span class="bubble">305</span></a>
				<a href="" class="user"></a>
				
				 <?php $this->widget('admin.widgets.UsrMenu'); ?>
				
                 <?php $this->widget('admin.widgets.LngMenu'); ?>
                
			</div><!--/wrapper-->
		</header>
    <div class="content-fluid">
        <aside>
            <?php $this->widget('admin.widgets.MainMenu',array('currentController' => Yii::app()->controller->id, 'currentAction' => Yii::app()->controller->action->id)); ?>
        </aside>
        <?php echo $content; ?>
    </div><!--/content-fluid-->
</div><!--fluid-->
<div class="lightbox">
    <div class="wrap">
        
    </div><!--/wrap -->
</div><!--/lightbox -->
</body>


