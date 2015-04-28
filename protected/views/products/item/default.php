<?php /* @var $this ProductsController */ ?>
<?php /* @var $content array */ ?>

    <h1><?php echo $content['trl_name']; ?></h1>
    <p><?php echo $content['trl_summary']; ?></p>
    <p><?php echo $content['trl_text']; ?></p>

    <?php if($content['discount_price'] > 0): ?>
        <b>Price - <strike><?php echo Number::FormatPrice($content['price']); ?></strike> &nbsp; <?php echo Number::FormatPrice($content['discount_price']); ?> </b>
    <?php else: ?>
        <b>Price - <?php echo Number::FormatPrice($content['price']); ?></b>
    <?php endif; ?>

    <b>Tags</b>
    <ul>
        <?php foreach($content['tags'] as $tagArr): ?>
            <li class="<?php echo $tagArr['label']; ?>"><?php echo $tagArr['trl_name']; ?></li>
        <?php endforeach; ?>
    </ul>

<?php foreach($content['images'] as $imageArr): ?>
    <img width="250" src="<?php echo $imageArr['url']; ?>">
<?php endforeach ?>

<?php Debug::out($content); ?>