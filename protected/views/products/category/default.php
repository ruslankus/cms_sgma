<?php /* @var $this ProductsController */ ?>
<?php /* @var $content array */ ?>

<h1><?php echo $content['trl_name'] ?></h1>

<?php foreach($content['items'] as $itemArr): ?>
    <a href="<?php echo $itemArr['url']; ?>"><?php echo $itemArr['trl_name']; ?></a><br>

    <?php if($itemArr['discount_price'] > 0): ?>
        <b>Price - <strike><?php echo Number::FormatPrice($itemArr['price']); ?></strike> &nbsp; <?php echo Number::FormatPrice($itemArr['discount_price']); ?> </b>
    <?php else: ?>
        <b>Price - <?php echo Number::FormatPrice($itemArr['price']); ?></b>
    <?php endif; ?>

    <b>Tags</b><br>
    <ul>
    <?php foreach($itemArr['tags'] as $tarArr): ?>
        <li class="<?php echo $tarArr['label']; ?>"><?php echo $tarArr['trl_name']; ?></li>
    <?php endforeach; ?>
    </ul>

    <p><?php echo $itemArr['trl_summary'];?></p>
    <p><?php echo $itemArr['trl_text']; ?></p><br>
    <?php foreach($itemArr['images'] as $imageArr): ?>
        <img width="150" src="<?php echo $imageArr['url']; ?>">
    <?php endforeach ?>
    <hr>
<?php endforeach; ?>