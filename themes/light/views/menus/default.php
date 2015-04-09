<?php /* @var $label string */ ?>
<?php /* @var $items_inline Array */ ?>
<?php /* @var $items_nested Array */ ?>

<ul>
    <?php foreach($items_inline as $item): ?>
        <li <?php if($item['active']): ?> class="active" <?php endif; ?> style="text-indent: <?php echo ($item['nesting_level']-1)*10; ?>px">
            <a href="<?php echo $item['url'] ?>"><?php echo $item['name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>