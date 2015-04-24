<?php /* @var $items ExtProduct[] */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $category int */ ?>
<?php /* @var $breadcrumbs array */ ?>
<?php /* @var $form_mdl TagForm */ ?>

<?php $params = array(); ?>
<?php $params['page'] = CPaginator::getInstance()->getCurrentPage(); ?>

<main>
    <div class="title-bar">
        <h1 class="breadcrumbs"><?php echo ATrl::t()->getLabel('All tags'); ?> </h1>
        <ul class="actions">
            <li><a href="#" class="action add"></a></li>
            <li><a data-message="<?php echo ATrl::t()->getLabel('Delete all selected items ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/deletealltags',$params); ?>" class="action del delete-all" data-id="checkbox"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
    <div class="content list">
        <div class="list-row title">
            <div class="cell checkbox"><input type="checkbox" value="0" name="checkbox[]" id="checkall_products"/></div>
            <div class="cell"><span class="order asc"><?php echo ATrl::t()->getLabel('Tag name'); ?><span></span></span></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Action'); ?></div>
        </div><!--/list-row-->

        <?php foreach($items as $item): ?>
            <div class="list-row h94">
                <div class="cell checkbox"><input class="del-all-cb" type="checkbox" name="delete[<?php echo $item->id; ?>]"></div>
                <div class="cell"><?php echo $item->label; ?></div>
                <div class="cell action">
                    <a href="<?php echo Yii::app()->createUrl('admin/products/edittag',array('id' => $item->id)); ?>" class="action edit"></a>
                    <?php $params['id'] = $item->id; ?>
                    <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/deletetag',$params); ?>" class="action delete"></a>
                    <?php unset($params['id']); ?>
                </div>
            </div><!--/list-row-->
        <?php endforeach; ?>

    </div><!--/content-->
    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <?php $params['page'] = $i + 1; ?>
            <a href="<?php echo Yii::app()->createUrl('admin/products/tags',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->
    <?php else: ?>
    <div class="content list">
        <div class="list-row">
            <div class="cell"><?php echo ATrl::t()->getLabel('List is empty'); ?></div>
        </div><!--/list-row-->
    </div>
    <?php endif; ?>

    <?php $this->renderPartial('_add_tag',array('form_model' => $form_mdl)); ?>
</main>