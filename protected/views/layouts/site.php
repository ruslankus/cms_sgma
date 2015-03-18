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
		<div class="carousel">
			<div class="items">
				<a href="item.html">
					<img src="banner/banner_1.png" alt="slide" />
					<span>Comfort 50 Light</span>
					<div class="params">
						<div class="param az"></div>
						<div class="param battery"></div>
						<div class="param bluetooth"></div>
						<div class="param fm"></div>
						<div class="param sos"></div>
						<div class="param lighter"></div>
					</div><!--/params-->
				</a>
				<a href="item.html">
					<img src="banner/banner_2.png" alt="slide" />
					<span>Sigma Gold</span>
					<div class="params">
						<div class="param az"></div>
						<div class="param battery"></div>
						<div class="param bluetooth"></div>
						<div class="param fm"></div>
						<div class="param sos"></div>
						<div class="param lighter"></div>
					</div><!--/params-->
				</a>
				<a href="item.html">
					<img src="banner/banner_3.png" alt="slide" />
					<span>Comfort</span>
					<div class="params">
						<div class="param bluetooth"></div>
					</div><!--/params-->
				</a>
			</div><!-- /items -->
		</div><!-- /carousel -->
		<div class="thumbs">
			<div class="items">
				<a href="#"><img src="banner/banner_1_thumb.png" alt="slide" /></a>
				<a href="#"><img src="banner/banner_2_thumb.png" alt="slide" /></a>
				<a href="#"><img src="banner/banner_3_thumb.png" alt="slide" /></a>
			</div><!-- /items -->
		</div><!-- /thumbs -->
		<div class="clearfix"></div>
		<hr/>
	</section><!--/slider -->
	<section class="news">
		<div class="row products">
			<h1>Новинки</h1>
			<div class="carousel">
				<div class="items">
					<a href="item.html" style="background-image: url('products/thumb_1.png')">
						<span class="name">X-treme PQ15</span>
						<span class="stock bg-red">СКОРО !!!</span>
						<div class="params small">
							<div class="param bluetooth"></div>
							<div class="param dualsim"></div>
							<div class="param ips"></div>
							<div class="param android"></div>
							<div class="param navi"></div>
							<div class="param usb"></div>
						</div><!--/params-->
					</a><!-- /product item -->
					<a href="item.html" style="background-image: url('products/thumb_2.png')">
						<span class="name">X-treme AT67 Kantri</span>
						<span class="stock bg-blue">Новинка</span>
						<div class="params small">
							<div class="param w95"></div>
							<div class="param bluetooth"></div>
							<div class="param fm"></div>
							<div class="param ip67"></div>
							<div class="param lighter"></div>
						</div><!--/params-->
					</a><!-- /product item -->
					<a href="item.html" style="background-image: url('products/thumb_3.png')">
						<span class="name">Comfort 50 Light</span>
						<span class="stock bg-blue">Новинка</span>
						<div class="icon"></div>
						<div class="params small">
							<div class="param az"></div>
							<div class="param battery"></div>
							<div class="param bluetooth"></div>
							<div class="param fm"></div>
							<div class="param sos"></div>
							<div class="param lighter"></div>
						</div><!--/params-->
					</a><!-- /product item -->
				</div><!--/items -->
			</div><!-- /carousel -->
			<div class="nav">
				<span class="back"></span>
				<span class="forward"></span>
			</div><!--/Nav-->
		</div><!--/row products -->
		<hr/>
		<div class="row updates">
			<h1>Последние новости</h1>
			<div class="carousel">
				<div class="items">
					<div>
						<img src="images/update_1.png" alt="update" />
						<article>
							<header>Новинка от Sigma mobile – X-treme AT67 Kantri – самый маленький защищенный мобильный телефон с функцией Bluetooth-терминала</header>
							<time>2014.10.24</time>
							<p>Новинка от Sigma mobile- X-treme AT67 Kantri – самый маленький защищенный мобильный телефон ... </p>
						</article>
						<div><a href="press-more.html">Читать дальше</a></div><!-- / button -->
					</div><!-- / update item -->
					<div>
						<img src="images/update_2.png" alt="update" />
						<article>
							<header>Защищенная Bluetooth стерео  гарнитура AvantreeJogger</header>
							<time>2014.10.24</time>
							<p>Украинский поставщик прочных смартфонов Sigma Mobile вывел на рынок свою версию водонепроницаемой Bluetooth – гарнитуры под названием AvantreeJogger. </p>
						</article>
						<div><a href="press-more.html">Читать дальше</a></div><!-- / button -->
					</div><!-- / update item -->
					<div>
						<img src="images/update_1.png" alt="update" />
						<article>
							<header>Новинка в линейке аксессуаров Sigma mobile – Bluetooth стереогарнитура Avantree Jogger</header>
							<time>2014.10.24</time>
							<p>Линейка аксессуаров к телефонам Sigma mobile пополнилась новинкой – Bluetooth стереогарнитурой Avantree Jogger.</p>
						</article>
						<div><a href="press-more.html">Читать дальше</a></div><!-- / button -->
					</div><!-- /update item -->
				</div><!-- /items-->
			</div><!--/updates carousel -->
			<div class="nav">
				<span class="back"></span>
				<span class="forward"></span>
			</div><!--/Nav-->
			<div class="mar-30"></div>
		</div><!--/row updates-->
	</section><!--/New-->
	<section class="contact">
		<div class="col feedback">
			<div>
				<h1>Обратная связь</h1>
				<form>
					<label for="name">Ваше имя<span>*</span></label>
					<input type="text" name="name" id="name" />
					<label for="email">Email<span>*</span></label>
					<input type="text" name="email" id="email" />
					<label for="message">Сообщение<span>*</span></label>
					<textarea name="message" id="message"></textarea>
					<label for="code">Проверочный код<span>*</span></label>
					<input type="text" name="code" id="code" />
					<img src="images/captcha.jpg" alt="Captcha" />
					<div class="clearfix mar-30"></div>
					<label class="info"><span>*</span>- звездочкой отмечены поля, обязательные к заполнению!</label>
					<input type="submit" value="Отравить" />
					<div class="clearfix mar-30"></div>
				</form>
			</div><!-- /feedback centering -->
		</div><!--/col feedback -->
		<div class="col contacts">
			<div>
				<h1>Контакты</h1>
				<div class="col-x-1">
					<span>Sigma mobile-Украина  (Главный офис)</span>
					<div>04073, г.Киев, пр-т.<br/>Московский, 8<br/>Телефон: +38(044) 383-47-54</div>
					<address>
						<a href="mailto:info@sigmamobile.net">info@sigmamobile.net</a><br/>
						<a href="mailto:service@sigmamobile.net">service@sigmamobile.net</a><br/>
						<a href="mailto:sales@sigmamobile.net">sales@sigmamobile.net</a>
					</address>
				</div><!--/col-x-1 -->
				<hr/>
				<div class="col-x-2">
					<span>График работы:</span>
					<div class="clearfix mar-15"></div>
					<div class="left">Понедельник – Четверг<br/>Пятница<br/>Суббота-Воскресенье</div>
					<div class="right">10.00-18.00<br/>10.00-17.00<br/>выходной</div>
					<div class="clearfix mar-15"></div>
				</div><!--/col-x-2 -->
				<hr class="hides"/>
				<div class="col-x-3">
					<address>
						<a class="skype" href="skype:lol?chat" title="Skype"></a>
						<a class="twitter" href="#" title="Twitter"></a>
						<a class="facebook" href="#" title="Facebook"></a>
					</address>
				</div><!--/col-x-3 -->
				<div class="vr"></div>
				<div class="clearfix"></div>
			</div><!-- / contact centering -->
		</div><!--/col contacts -->
		<div class="clearfix"></div>
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