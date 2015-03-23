<?php /* @var $items ExtMenuItem[] */ ?>
<?php /* @var $pages int  */ ?>
<?php /* @var $templates array() */ ?>

<?php foreach($items as $item): ?>
    <ul>
        <li style="text-indent: <?php echo ($item->nestingLevel() - 1) * 20; ?>px"><?php echo $item->label; ?></li>
    </ul>
<?php endforeach; ?>

<?php //Debug::out($items); ?>
<?php //Debug::out($templates); ?>
<?php //Debug::out($pages); ?>