<h2>core template</h2>
<div><?php echo $content?></div>

<?php if(!empty($imgs[0])): ?>
<div>
    <?php echo Image::tag($imgs[0], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>

<?php if(!empty($imgs[1])): ?>
<div>
    <?php echo Image::tag($imgs[1], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>

<?php if(!empty($imgs[2])): ?>
<div>
    <?php echo Image::tag($imgs[2], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>

<?php if(!empty($imgs[3])): ?>
<div>
    <?php echo Image::tag($imgs[3], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>

<?php if(!empty($imgs[4])): ?>
<div>
    <?php echo Image::tag($imgs[4], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>