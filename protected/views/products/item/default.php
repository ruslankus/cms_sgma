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

    <b>Tags:</b>
    <ul>
        <?php foreach($content['tags'] as $tagArr): ?>
            <li class="<?php echo $tagArr['label']; ?>"><?php echo $tagArr['trl_name']; ?></li>
        <?php endforeach; ?>
    </ul>
    <br>

    <b>Groups:</b>
    <?php foreach($content['attribute_groups'] as $groupArr): ?>
        <h3><u><?php echo $groupArr['trl_name']; ?></u></h3>
        <p><?php echo $groupArr['trl_text']; ?></p>

        <?php foreach($groupArr['attributes'] as $fieldArr): ?>
            <h4>
                <?php echo $fieldArr['trl_name'] ?> -
                <?php if(is_array($fieldArr['value'])): ?>
                    <?php if(isset($fieldArr['value']['url'])): ?>
                        <img width="100" src="<?php echo $fieldArr['value']['url']; ?>">
                    <?php else: ?>
                        <?php echo $fieldArr['value']['option_name']; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php echo $fieldArr['value'] ?>
                <?php endif; ?>
            </h4>
            <br>
        <?php endforeach; ?>
    <?php endforeach; ?>

<?php foreach($content['images'] as $imageArr): ?>
    <img width="250" src="<?php echo $imageArr['url']; ?>">
<?php endforeach ?>