<?php /* @var $languages array */ ?>

<ul>
    <?php foreach($languages as $language): ?>
        <li><a href="<?php echo $language['url']; ?>"><?php echo $language['prefix']; ?></a></li>
    <?php endforeach; ?>
</ul>