<?php /* @var $label string */ ?>
<?php /* @var $items_inline Array */ ?>
<?php /* @var $items_nested Array */ ?>

<ul style="list-style: none">
    <?php foreach($items_nested as $item): ?>
        <li <?php if($item['active']): ?> class="active" <?php endif; ?> style="display: block; float: left; padding: 5px; font-weight: bold;">
            <a href="<?php echo $item['url'] ?>"><?php echo $item['name'] ?></a>
        </li>
    <?php endforeach; ?>
</ul>