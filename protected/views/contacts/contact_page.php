<h2><?php echo $title?></h2>
<div><?php echo $description ?></div>
<?php if(!empty($imgs[0])): ?>
<div>
    <?php echo Image::tag($imgs[0], array('class' => 'test','width' => '250'))?>
</div>
<div>
    <?php foreach($arrBlocks as $block ):?>
    <div style="margin-bottom: 20px;">
        <?php foreach($block as $field):?>
            <?php echo "{$field['name']}   {$field['value']}" ?><br />
        <?php endforeach;?>
    </div>    
    <?php endforeach;?>
</div>
<?php endif; ?>