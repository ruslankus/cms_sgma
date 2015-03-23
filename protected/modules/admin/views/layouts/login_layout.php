<?php /* @var $this ControllerAdmin */ ?>
<?php /* @var $content string */ ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <title><?php echo $this->title." - ".$this->description; ?></title>
  </head>
  <body>
	<div class="login-wrapper">
		<div class="login-middle">
		
        <?php echo $content;?>
        
		</div><!--/login-middle-->
	</div><!--/login-wrapper-->
  </body>
</html>