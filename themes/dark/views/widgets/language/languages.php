<?php /* @var $languages array */ ?>
<p>Languages from template</p>
<ul>
    <?php foreach($languages as $language): ?>
        <li><a href="<?php echo $language['url']; ?>"><?php echo $language['prefix']; ?></a></li>
    <?php endforeach; ?>
</ul>