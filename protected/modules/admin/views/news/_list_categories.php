<?php /* @var $items array() */ ?>
<?php /* @var $children ExtNewsCategory */ ?>

<?php foreach($items as $id => $item): ?>
<div class="menu-table" data-menu="<?php echo $id; ?>">
    <div class="cell draggable"><span class="ficoned drag"></span></div>
    <div class="cell block">
        <div class="inner-table">
            <?php foreach($item as $children): ?>
                <?php if(!$children->hasParent()): ?>
                    <div class="row root" data-id="<?php echo $children->id; ?>">
                        <div class="name"><?php echo $children->label; ?></div>
                        <div class="sequen"></div>
                        <div class="type"><?php echo $children->countOfItems(); ?></div>
                        <div class="action">
                            <a href="<?php echo Yii::app()->createUrl('admin/news/editcat',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                            <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/news/deletecat',array('id' => $children->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                        </div>
                    </div><!--/row root-->
                <?php else: ?>
                    <div class="row" data-id="<?php echo $children->id; ?>" data-parent="<?php echo $children->parent_id; ?>">
                        <div class="name"><?php echo $children->label; ?></div>
                        <div class="sequen">
                            <a href="<?php echo Yii::app()->createUrl('admin/news/move',array('id' => $children->id,'dir' => 'up')); ?>" class="go-up move-item"><span class="ficoned arrow-up"></span></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/news/move',array('id' => $children->id,'dir' => 'down')); ?>" class="go-down move-item"><span class="ficoned arrow-down"></span></a>
                        </div><!--/sequen-->
                        <div class="type"><?php echo $children->countOfItems(); ?></div>
                        <div class="action">
                            <a href="<?php echo Yii::app()->createUrl('admin/news/editcat',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                            <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/news/deletecat',array('id' => $children->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                        </div>
                    </div><!--/row-->
                <?php endif; ?>
            <?php endforeach; ?>
        </div><!--/inner-table-->
    </div><!--/menu-table-->
</div><!--table-->
<?php endforeach; ?>
