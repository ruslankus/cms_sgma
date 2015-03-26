<?php /* @var $items array() */ ?>
<?php /* @var $children ExtMenuItem */ ?>
<?php /* @var $pages int  */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $menu ExtMenu */ ?>
<?php /* @var $current_page int */ ?>

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
                        <div class="type"><?php echo Trl::t()->getLabel($children->type->label); ?></div>
                        <div class="action">
                            <a href="<?php echo Yii::app()->createUrl('admin/menu/edititem',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                            <a data-popup="<?php echo Yii::app()->createUrl('admin/menu/popdel',array('type' => 'item', 'id' => $children->id)); ?>" href="#" class="delete"><span class="ficoned trash-can"></span></a>
                        </div>
                    </div><!--/row root-->
                <?php else: ?>
                    <div class="row" data-id="<?php echo $children->id; ?>" data-parent="<?php echo $children->parent_id; ?>">
                        <div class="name"><?php echo $children->label; ?></div>
                        <div class="sequen">
                            <a href="#" class="go-up"><span class="ficoned arrow-up"></span></a>
                            <a href="#" class="go-down"><span class="ficoned arrow-down"></span></a>
                        </div><!--/sequen-->
                        <div class="type"><?php echo Trl::t()->getLabel($children->type->label); ?></div>
                        <div class="action">
                            <a href="<?php echo Yii::app()->createUrl('admin/menu/edititem',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                            <a data-popup="<?php echo Yii::app()->createUrl('admin/menu/popdel',array('type' => 'item','id' => $children->id)); ?>" href="#" class="delete"><span class="ficoned trash-can"></span></a>
                        </div>
                    </div><!--/row-->
                <?php endif; ?>
            <?php endforeach; ?>
        </div><!--/inner-table-->
    </div><!--/menu-table-->
</div><!--table-->
<?php endforeach; ?>
