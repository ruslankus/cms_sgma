<?php /* @var $items ExtProductFieldGroups */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $group int  */ ?>

<style>
    .content > .tab-line
    {
        margin: 0;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>

<?php $params = array(); ?>
<?php if($group != 0): ?> <?php $params['group'] = $group; ?> <?php endif; ?>

<main>

    <div class="content">
        <div class="tab-line">
            <span><a href="<?php echo Yii::app()->createUrl('admin/products/attrgroups'); ?>"><?php echo ATrl::t()->getLabel('Groups'); ?></a></span>
            <span class="active"><a href="<?php echo Yii::app()->createUrl('admin/products/fields'); ?>"><?php echo ATrl::t()->getLabel('Fields'); ?></a></span>
        </div><!--/tab-line-->
    </div>

    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Attribute fields'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/products/addfield',$params); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">
            <?php if($group != 0): ?><div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div><?php endif; ?>
            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
            <div class="cell type"><?php echo ATrl::t()->getLabel('Type'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
        </div><!--table-->

        <div class="sortable">
            <?php echo $this->renderPartial('_list_attr_fields',array('items' => $items, 'group' => $group)); ?>
        </div><!--/sortable-->

    </div><!--/content-->

    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <?php $params['page'] = $i+1; ?>
            <a href="<?php echo Yii::app()->createUrl('admin/products/fields',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->

    <?php $params['page'] = CPaginator::getInstance()->getCurrentPage(); ?>
    <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/products/fields',$params); ?>">
    <input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('admin/products/ajaxorderfields'); ?>">

</main>