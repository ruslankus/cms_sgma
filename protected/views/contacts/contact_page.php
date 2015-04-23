<h2><?php echo $title?></h2>
<div><?php echo $description ?></div>
<?php if(!empty($imgs[0])): ?>
<div>
    <?php echo Image::tag($imgs[0], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>