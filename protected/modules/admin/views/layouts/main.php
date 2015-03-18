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
    <header role="header">
        <div class="wrapper">
            <div class="left-zone">
                <div class="menu">
                    <span class="bar a"></span>
                    <span class="bar b"></span>
                    <span class="bar c"></span>
                    <span class="bar d"></span><!--triangle-->
                </div><!--/menu-->
                <span class="logo">Voyage CMS</span><!--/logo-->
            </div><!--/left-zone-->
            <div class="right-zone">
                <div class="items">
                    <a href="" class="calendar"></a>
                    <a href="" class="messages">
                        <span class="bubble">305</span>
                    </a>
                    <a href="" class="notices">
                        <span class="bubble">305</span>
                    </a>
                    <a href="" class="user"></a>
                    <ul class="user-open">
                        <li><a href="">Atsijungti</a><span class="icon out"></span></li>
                        <li><a href="">Duomenys</a><span class="icon pencil"></span></li>
                        <li><a href="">Parinktys</a><span class="icon gear"></span></li>
                    </ul>
                </div><!--/items-->
                <div class="langlist">
                    <a href="">LT</a>
                    <ul>
                        <li><a href="">EN</a></li>
                        <li><a href="">РУ</a></li>
                    </ul>
                </div>
            </div><!--/left-zone-->
        </div><!--/wrapper-->
    </header>
    <div class="content-fluid">
        <aside>
            <?php $this->widget('admin.widgets.MainMenu',array('currentController' => Yii::app()->controller->id, 'currentAction' => Yii::app()->controller->action->id)); ?>
        </aside>
        <?php echo $content; ?>
    </div><!--/content-fluid-->
</div><!--fluid-->
</body>


