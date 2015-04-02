<?php /* @var $items array() */ ?>
<?php /* @var $children ExtMenuItem */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $this NewsController */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Categories'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/news/addcat'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">
            <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
            <div class="cell sequen"><?php echo ATrl::t()->getLabel('Order'); ?></div>
            <div class="cell type"><?php echo ATrl::t()->getLabel('Item QNT'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
        </div><!--table-->

        <div class="sortable">
            <?php echo $this->renderPartial('_list_categories',array('items' => $items)); ?>
        </div><!--/sortable-->

    </div><!--/content-->

    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <a href="<?php echo Yii::app()->createUrl('admin/news/categories/',array('page' => $i+1)); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->

    <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/news/categories',array('page' => CPaginator::getInstance()->getCurrentPage())); ?>">
    <input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('/admin/news/ajaxorderitems'); ?>">

</main>