<?php /* @var $this ProductsController */ ?>
<?php /* @var $item ExtProduct */ ?>
<?php /* @var $active ExtProductFieldGroupsActive[] */ ?>
<?php /* @var $languages Languages[] */ ?>

<main xmlns="http://www.w3.org/1999/html">
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('News'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/products/list',array('cat' => $item->category_id)); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit item'); ?></span>
            <a href="<?php echo Yii::app()->createUrl('admin/products/editprodfields',array('id' => $item->id)); ?>" class="active"><?php echo ATrl::t()->getLabel('Attributes'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/editprodattrgroup',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attribute groups'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/edititemtrl',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Content'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/edit',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Settings'); ?></a>
        </div><!--/header-->


        <div class="tab-line">
            <?php foreach($active as $index => $activeGroup): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $activeGroup->id; ?>"><?php echo $activeGroup->group->label; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <div class="form-zone">
                <form method="post" class="ajax-form-saving">
                    <div class="tabs">
                        <?php foreach($active as $index => $activeGroup): ?>
                        <table data-tab="<?php echo $activeGroup->id; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                            <?php foreach($activeGroup->group->productFields as $field): ?>
                                <?php $this->renderPartial('_dynamic_attribute_in_tbl',array('field' => $field, 'languages' => $languages , 'item' => $item)); ?>
                            <?php endforeach; ?>
                        </table>
                        <?php endforeach; ?>
                    </div><!--/tabs-->
                <input type="submit" value="<?php echo ATrl::t()->getLabel('Save'); ?>">
                </form>
            </div><!--/form-zone-->
        </div><!--/inner-content-->


    </div><!--/content translate-->
</main>