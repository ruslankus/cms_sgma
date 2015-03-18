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
    <script src="js/html5shiv.js"></script>
	<link href="css/style-ie.css" rel="stylesheet">
	<![endif]-->
  </head>
  <body>
    <header>
		<nav>
			<div class="left">
				<a class="logo" href="index.html" title="Home"></a>
				<div class="slice"></div>
				<a href="index.html" title="Menu" class="nav-item menu"><div></div></a>
			</div><!--/left -->
			<div class="right">
				<div class="slice"></div>
				<a href="gde-kupit.html" title="Cart" class="nav-cart">
					<div></div>
					<span>Перейти в<br/>магазин онлайн<br/>(<span>за пределами украины</span>)</span>
				</a><!-- /nav-cart -->
				<div class="slice"></div>
				<a href="#" title="Search" class="nav-item search"></a>
				<div class="slice"></div>
				<a href="#" title="Language" class="nav-item language"><div class="hover"></div></a>
				<div class="slice"></div>
				<div class="lang-bar">
					<a href="#" class="uk"></a>
					<a href="#" class="ru"></a>
					<a href="#" class="ua"></a>
				</div>
			</div><!--/right -->
		</nav><!--/Navigation-->
	</header><!--/Header-->
	<nav class="sidebar">
		<ul>
			<li data-for="1"><a href="javascript:void(0);">Каталог товаров</a></li>
			<li data-for="2" class="active"><a href="javascript:void(0);">Поддержка</a></li>
			<li><a href="gde-kupit.html">Где купить</a></li>
			<li><a href="press.html">Пресс-центр</a></li>
			<li><a href="contacts.html">Контакты</a></li>
			<li><a href="about.html">О бренде</a></li>
		</ul>
		<div class="mini">
			<div>
				<ul data-mini="1">
					<li><a href="catalog.html">Защищенные телефоны</a></li>
					<li><a href="catalog.html">Защищенные планшеты</a></li>
					<li><a href="catalog.html">Телефоны с функцией SOS</a></li>
					<li><a href="catalog.html">Аксессуары и комплектующие</a></li>
				</ul>
				<ul data-mini="2">
					<li><a href="service.html">сервис-центры</a></li>
					<li><a href="warranty.html">гарантия</a></li>
					<li><a href="instructions.html">настройки и инструкции</a></li>
					<li><a href="faq.html">FAQ</a></li>
				</ul>
			</div>
		</div><!-- / mini -->
	</nav><!--/sidebar -->
	<section class="slider">
		<?php $this->widget('BanersWidget'); ?>
	</section><!--/slider -->
	<section class="news">
		<div class="row products">
			<?php $this->widget('NewsWidget'); ?>
		</div><!--/row products -->
		<hr/>
		<div class="row updates">
			<?php $this->widget('LastnewsWidget'); ?>
		</div><!--/row updates-->
	</section><!--/New-->
	<section class="contact">
		<?php $this->widget('ContformWidget'); ?>
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