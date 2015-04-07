<?php /* @var $items ExtProduct[] */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $category int */ ?>
<?php /* @var $breadcrumbs array */ ?>


<?php $params = array(); ?>
<?php if($category != 0): ?> <?php $params['cat'] = $category; ?> <?php endif; ?>

<main>
    <div class="title-bar">
        <?php if(!empty($breadcrumbs)): ?>
            <h1 class="breadcrumbs">
                <a href="<?php echo Yii::app()->createUrl('admin/products/categories') ?>"><?php echo ATrl::t()->getLabel('Categories'); ?></a>
                <?php foreach($breadcrumbs as $id => $title): ?>
                    > <a href="<?php echo Yii::app()->createUrl('admin/products/list',array('cat' => $id)) ?>"><?php echo $title; ?></a>
                <?php endforeach; ?>
            </h1>
        <?php else: ?>
            <h1 class="breadcrumbs">
                <?php echo ATrl::t()->getLabel('All items'); ?>
            </h1>
        <?php endif; ?>
        <ul class="actions">
            <li><a href="" class="action add" data-id="checkbox"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
    <div class="content list">
        <div class="list-row title">
            <div class="cell checkbox"><input type="checkbox" value="0" name="checkbox[]" id="checkall_products"/></div>
            <div class="cell image"><?php echo ATrl::t()->getLabel('Image'); ?></div>
            <div class="cell"><span class="order asc"><?php echo ATrl::t()->getLabel('Product name'); ?><span></span></span></div>
            <div class="cell category"><?php echo ATrl::t()->getLabel('Category'); ?></div>
            <div class="cell price"><?php echo ATrl::t()->getLabel('Price'); ?></div>
            <div class="cell status"><?php echo ATrl::t()->getLabel('Status'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Action'); ?></div>
        </div><!--/list-row-->

        <?php foreach($items as $item): ?>
            <div class="list-row h94">
                <div class="cell checkbox"><input type="checkbox" name="checkbox[]" value="1"/></div>
                <div class="cell image"><img src="images/no-image.png" alt=" " /></div>
                <div class="cell"><a href="edit.html">Lorem ipsum</a></div>
                <div class="cell category">Hot product</div>
                <div class="cell price">&euro; 1.500</div>
                <div class="cell status">Enabled</div>
                <div class="cell action">
                    <a href="edit.html" class="action edit" data-id="1"></a>
                    <a href="index.html" class="action delete" data-id="1"></a>
                </div>
            </div><!--/list-row-->
        <?php endforeach; ?>

    </div><!--/content-->
    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <?php $params['page'] = $i + 1; ?>
            <a href="<?php echo Yii::app()->createUrl('admin/products/list/',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->
    <?php else: ?>
    <div class="content list">
        <div class="list-row">
            <div class="cell"><?php echo ATrl::t()->getLabel('List is empty'); ?></div>
        </div><!--/list-row-->
    </div>
    <?php endif; ?>
</main>