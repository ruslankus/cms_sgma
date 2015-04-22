<?php /* @var $products array */ ?>
<?php /* @var $breadcrumbs array */ ?>
<?php /* @var $subcategories array */ ?>
<?php /* @var $category array */ ?>
<?php /* @var $pagination array */ ?>


<h1><?php echo $category['trl']['header']; ?></h1>
<br>
<?php foreach($breadcrumbs as $index => $breadcrumb): ?>
    <?php if($index > 0): ?> => <?php endif; ?>
    <a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['name']; ?></a>
<?php endforeach; ?>
<br>

<ul>
    <?php foreach($subcategories as $sub): ?>
        <li><a href="<?php echo $sub['link']; ?>"><?php echo $sub['name']; ?></a></li>
    <?php endforeach; ?>
</ul>
<br>
<table>
    <?php foreach($products as $product): ?>
        <tr>
            <td><a href="<?php echo Yii::app()->createUrl('products/one',array('id' => $product['id'])); ?>"><?php echo $product['trl']['title']; ?></a></td>
            <td><img width="100" src="<?php echo Image::getUrlOf($product['first_image']['filename']); ?>"></td>
            <td><?php echo Number::FormatPrice($product['price']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<br>
<ul>
    <?php foreach($pagination as $index => $link): ?>
        <li><a href="<?php echo $link; ?>"><?php echo $index; ?></a></li>
    <?php endforeach; ?>
</ul>
