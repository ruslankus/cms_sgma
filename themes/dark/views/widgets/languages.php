<?php /* @var $languages array */ ?>

<ul>
    <?php foreach($languages as $language): ?>
        <li><a href="<?php $language['url']; ?>"><?php echo $language['prefix']; ?></a></li>
    <?php endforeach; ?>
</ul>