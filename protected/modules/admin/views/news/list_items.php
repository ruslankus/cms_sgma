<?php /* @var $items ExtNews[] */ ?>
<?php /* @var $this NewsController */ ?>
<?php /* @var $category int */ ?>
<?php /* @var $breadcrumbs array */ ?>


<?php $params = array(); ?>
<?php if($category != 0): ?> <?php $params['cat'] = $category; ?> <?php endif; ?>

<main>
    <div class="title-bar">

        <?php if(!empty($breadcrumbs)): ?>
        <h1 class="breadcrumbs">
            <a href="<?php echo Yii::app()->createUrl('admin/news/categories') ?>"><?php echo ATrl::t()->getLabel('Categories'); ?></a>
            <?php foreach($breadcrumbs as $id => $title): ?>
                > <a href="<?php echo Yii::app()->createUrl('admin/news/list',array('cat' => $id)) ?>"><?php echo $title; ?></a>
            <?php endforeach; ?>
        </h1>
        <?php else: ?>
            <h1 class="breadcrumbs">
                <?php echo ATrl::t()->getLabel('All items'); ?>
            </h1>
        <?php endif; ?>

        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/news/add',$params); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">

            <?php if($category != 0): ?>
            <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
            <?php endif; ?>

            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
            <div class="cell type"><?php echo ATrl::t()->getLabel('Status'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
        </div><!--table-->

        <div class="sortable">
            <?php echo $this->renderPartial('_list_items',array('items' => $items, 'category' => $category)); ?>
        </div><!--/sortable-->

    </div><!--/content-->

    <?php if(CPaginator::getInstance()->getTotalPages() > 1): ?>
        <div class="pagination">
            <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
                <?php $params['page'] = $i + 1; ?>
                <a href="<?php echo Yii::app()->createUrl('admin/news/list/',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
            <?php endfor; ?>
        </div><!--/pagination-->
    <?php endif; ?>

    <?php $params['page'] = CPaginator::getInstance()->getCurrentPage(); ?>
    <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/news/list',$params); ?>">
    <input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('admin/news/ajaxorderitems',$params); ?>">

</main>