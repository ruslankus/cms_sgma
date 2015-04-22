<?php /* @var $products array */ ?>
<?php /* @var $breadcrumbs array */ ?>
<?php /* @var $subcategories array */ ?>
<?php /* @var $category array */ ?>

<?php //Debug::out($products);  ?>
<?php //Debug::out($breadcrumbs); ?>
<?php //Debug::out($subcategories); ?>
<?php //Debug::out($category); ?>

<h1><?php echo $category['trl']['header']; ?></h1>

<table>
    <?php foreach($products as $product): ?>
        <tr>
            <td><?php echo $product['trl']['title']; ?></td>
            <td><img width="100" src="<?php echo Image::getUrlOf($product['first_image']['filename']); ?>"></td>
            <td><?php echo Number::FormatPrice($product['price']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

