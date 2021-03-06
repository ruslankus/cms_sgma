<?php /* @var $items ExtProductFieldGroups */ ?>
<?php /* @var $this ProductsController */ ?>

<style>
    .content > .tab-line
    {
        margin: 0;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>

<main>

    <div class="content">
        <div class="tab-line">
            <span class="active"><a href="<?php echo Yii::app()->createUrl('admin/products/attrgroups'); ?>"><?php echo ATrl::t()->getLabel('Groups'); ?></a></span>
            <span><a href="<?php echo Yii::app()->createUrl('admin/products/fields'); ?>"><?php echo ATrl::t()->getLabel('Fields'); ?></a></span>
        </div><!--/tab-line-->
    </div>

    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Attribute groups'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/products/addattrgroup'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
        <div class="content">
            <div class="title-table">
                <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
                <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
                <div class="cell type"><?php echo ATrl::t()->getLabel('Item QNT'); ?></div>
                <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
            </div><!--table-->
            <div class="sortable">
                <?php echo $this->renderPartial('_list_attr_groups',array('items' => $items)); ?>
            </div><!--/sortable-->
        </div><!--/content-->
    <?php else: ?>
        <div class="content list">
            <div class="list-row">
                <div class="cell"><?php echo ATrl::t()->getLabel('List is empty'); ?></div>
            </div><!--/list-row-->
        </div>
    <?php endif; ?>

    <?php if(CPaginator::getInstance()->getTotalPages() > 1): ?>
    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <a href="<?php echo Yii::app()->createUrl('admin/products/atrgroups',array('page' => $i+1)); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->
    <?php endif; ?>

    <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/products/attrgroups',array('page' => CPaginator::getInstance()->getCurrentPage())); ?>">
    <input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('/admin/products/ajaxorderattrgroups'); ?>">

</main>