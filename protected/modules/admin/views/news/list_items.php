<?php /* @var $items ExtNews[] */ ?>
<?php /* @var $this NewsController */ ?>
<?php /* @var $category int */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('News'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/news/add'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">
            <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
            <div class="cell type"><?php echo ATrl::t()->getLabel('Status'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
        </div><!--table-->

        <div class="sortable">
            <?php echo $this->renderPartial('_list_items',array('items' => $items)); ?>
        </div><!--/sortable-->

    </div><!--/content-->

    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <?php $params = array(); ?>
            <?php $params['page'] = $i + 1; ?>
            <?php if($category != null): ?> <?php $params['cat'] = $category; ?> <?php endif; ?>
            <a href="<?php echo Yii::app()->createUrl('admin/news/list/',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->

    <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/news/list',array('page' => CPaginator::getInstance()->getCurrentPage())); ?>">
    <input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('/admin/news/ajaxorderitems'); ?>">

</main>