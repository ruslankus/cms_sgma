<?php /* @var $items ExtProduct[] */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $category int */ ?>
<?php /* @var $breadcrumbs array */ ?>


<?php $params = array(); ?>
<?php if($category != 0): ?> <?php $params['cat'] = $category; ?> <?php endif; ?>
<?php $params['page'] = CPaginator::getInstance()->getCurrentPage(); ?>

<main>
    <div class="title-bar">
        <?php if(!empty($breadcrumbs)): ?>
            <h1 class="breadcrumbs">
                <a style="text-decoration: none; color: inherit;" href="<?php echo Yii::app()->createUrl('admin/products/categories') ?>"><?php echo ATrl::t()->getLabel('Categories'); ?></a>
                <?php foreach($breadcrumbs as $id => $title): ?>
                    > <a style="text-decoration: none; color: inherit;" href="<?php echo Yii::app()->createUrl('admin/products/list',array('cat' => $id)) ?>"><?php echo $title; ?></a>
                <?php endforeach; ?>
            </h1>
        <?php else: ?>
            <h1 class="breadcrumbs">
                <?php echo ATrl::t()->getLabel('All items'); ?>
            </h1>
        <?php endif; ?>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/products/add'); ?>" class="action add"></a></li>
            <li><a data-message="<?php echo ATrl::t()->getLabel('Delete all selected items ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/deleteall',$params); ?>" class="action del delete-all" data-id="checkbox"></a></li>
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
                <div class="cell checkbox"><input class="del-all-cb" type="checkbox" name="delete[<?php echo $item->id; ?>]"></div>

                <div class="cell image">
                    <?php if($item->getFirstImage() != null && $item->getFirstImage()->isFileExist()): ?>
                        <img style="width: 60px; height: 60px;" src="<?php echo $item->getFirstImage()->getUrl(); ?>" alt="<?php $item->getFirstImage()->trl->caption; ?>">
                    <?php else: ?>
                        <img style="width: 60px; height: 60px;" src="<?php echo ExtImages::model()->getUrlOf('no-image.png',true); ?>" alt="<?php $item->getFirstImage()->trl->caption; ?>">
                    <?php endif; ?>
                </div>

                <div class="cell"><?php echo $item->label; ?></div>
                <div class="cell category"><?php echo $item->category->label; ?></div>
                <div class="cell price">&euro;<?php echo Number::FormatPrice($item->price); ?></div>
                <div class="cell status"><?php echo ATrl::t()->getLabel($item->status->label); ?></div>
                <div class="cell action">
                    <a href="<?php echo Yii::app()->createUrl('admin/products/edit',array('id' => $item->id)); ?>" class="action edit"></a>
                    <?php $params['id'] = $item->id; ?>
                    <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/delete',$params); ?>" class="action delete"></a>
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