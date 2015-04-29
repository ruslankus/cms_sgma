<h2><?php echo $title?></h2>
<h3>core render</h3>
<div><?php echo $description ?></div>
<?php if(!empty($imgs[0])): ?>
<div>
    <?php echo Image::tag($imgs[0], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>
<div>
    <?php foreach($arrBlocks as $block ):?>
    <div style="margin-bottom: 20px;">
        <?php foreach($block as $field):?>
            <?php echo "{$field['name']}   {$field['value']}" ?><br />
        <?php endforeach;?>
    </div>    
    <?php endforeach;?>
</div>
<h2>Testing Form</h2>
