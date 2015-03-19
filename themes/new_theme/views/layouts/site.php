<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/media.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery-ui.min.css" rel="stylesheet">
    <title>Sigma</title>
	<!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5shiv.js"></script>
	<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style-ie.css" rel="stylesheet">
	<![endif]-->
  </head>
  <body>
    <header>
		<div class="wrapper">
			<a href="index.html" title="Home" class="logo"></a>
			<a href="index.html" title="Menu" class="menu"><span></span></a>
			<div class="language ru">
				<span></span>
				<ul>
					<li class="ru"><a href="ru.html"></a></li>
					<li class="ua"><a href="ua.html"></a></li>
					<li class="en"><a href="en.html"></a></li>
				</ul>
			</div><!--/language-->
			
			<div class="search"><a href="search.html"></a></div>
			<div class="cart"><a href="gde-kupit.html"><span>Перейти в<br/>магазин онлайн<br/>(<span>за пределами украины</span>)</span></a></div>
		</div><!--/wrapper-->
	</header><!--/Header-->
	<nav class="sidebar">
		<ul>
			<li class="active"><a href="catalog.html">Каталог товаров</a>
				<ul>
					<li><a href="catalog.html">Защищенные телефоны</a></li>
					<li><a href="catalog.html">Защищенные планшеты</a></li>
					<li><a href="catalog.html">Телефоны с функцией SOS</a></li>
					<li><a href="catalog.html">Аксессуары и комплектующие</a></li>
				</ul>
			</li>
			<li><a href="service.html">Поддержка</a>
				<ul>
					<li><a href="service.html">сервис-центры</a></li>
					<li><a href="warranty.html">гарантия</a></li>
					<li><a href="instructions.html">настройки и инструкции</a></li>
					<li><a href="faq.html">FAQ</a></li>
				</ul>
			</li>
			<li><a href="gde-kupit.html">Где купить</a></li>
			<li><a href="press.html">Пресс-центр</a></li>
			<li><a href="contacts.html">Контакты</a></li>
			<li><a href="about.html">О бренде</a></li>
		</ul>
	</nav><!--/sidebar -->
	<section class="slider">
		<?php $this->widget('application.widgets.BanersWidget'); ?>
	</section><!--/slider -->
	<section class="news">
		<div class="row products">
			<?php $this->widget('application.widgets.NewsWidget'); ?>
		</div><!--/row products -->
		<hr/>
		<div class="row updates">
			<?php $this->widget('application.widgets.LastnewsWidget'); ?>
		</div><!--/row updates-->
	</section><!--/New-->
	<section class="contact">
		<?php $this->widget('application.widgets.ContformWidget'); ?>
	</section><!--/contact -->
	<footer>
		<div>
			Офійний сайт ТМ Sigma mobile.<br/>Copyright ©2013 Sigma mobile. Всі права захищені.<br/>
			<a href="">Умови користування сайтом</a>
		</div>
	</footer><!--/footer -->
	<span id="go-to-top"></span><!-- /go to top element -->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/sigma.js" type="text/javascript"></script>
  </body>
</html>