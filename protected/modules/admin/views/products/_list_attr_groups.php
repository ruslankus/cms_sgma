<?php /* @var $items ExtProductFieldGroups */ ?>

<?php foreach($items as $item): ?>
    <div class="menu-table" data-menu="<?php echo $item->id ?>">

        <div class="cell draggable"><span class="ficoned drag"></span></div>
        <div class="cell block">
            <div class="inner-table">
                <div class="row root" data-id="<?php echo $item->id; ?>">
                    <div class="name"><?php echo $item->label; ?></div>
                    <div class="type">0</div>
                    <div class="action">
                        <a href="<?php echo Yii::app()->createUrl('admin/products/editattrgroup',array('id' => $item->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                        <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/delattrgroup',array('id' => $item->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                    </div>
                </div><!--/row root-->
            </div><!--/inner-table-->
        </div><!--/menu-table-->
    </div><!--table-->
<?php endforeach; ?>