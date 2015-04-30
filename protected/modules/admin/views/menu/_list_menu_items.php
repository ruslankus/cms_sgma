<?php /* @var $items array() */ ?>
<?php /* @var $children ExtMenuItem */ ?>
<?php /* @var $pages int  */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $menu ExtMenu */ ?>
<?php /* @var $current_page int */ ?>
<?php /* @var $this ControllerAdmin */ ?>
<?php /* @var $parent_id int */ ?>

<?php foreach($items as $id => $item): ?>
    <div class="menu-table" data-menu="<?php echo $id; ?>">
        <div class="cell draggable"><span class="ficoned drag"></span></div>
        <div class="cell block">
            <div class="inner-table">

                <?php foreach($item as $children): ?>
                    <?php if(!$children->hasParent($parent_id)): ?>
                        <div class="row root" data-id="<?php echo $children->id; ?>">
                            <div class="name">
                                <?php if($children->hasChildren()): ?>
                                    <a href="<?php echo Yii::app()->createUrl('admin/menu/menuitems',array('id' => $children->menu_id, 'pid' => $children->id)); ?>"><?php echo $children->label; ?></a>
                                <?php else: ?>
                                    <?php echo $children->label; ?>
                                <?php endif; ?>
                            </div>
                            <div class="sequen">
                                <?php if($children->status_id == ExtStatus::VISIBLE): ?>
                                    <img src="<?php echo $this->assetsPath.'/images/eye-icon-on.png'; ?>">
                                <?php else: ?>
                                    <img src="<?php echo $this->assetsPath.'/images/eye-icon-off.png'; ?>">
                                <?php endif; ?>
                            </div>
                            <div class="sequen"></div>
                            <div class="type"><?php echo Trl::t()->getLabel($children->type->label); ?></div>
                            <div class="action">
                                <a href="<?php echo Yii::app()->createUrl('admin/menu/editmenuitem',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                                <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/menu/deleteitem',array('id' => $children->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                            </div>
                        </div><!--/row root-->
                    <?php else: ?>
                        <div class="row" data-id="<?php echo $children->id; ?>" data-parent="<?php echo $children->parent_id; ?>">
                            <div class="name"><?php echo $children->label; ?></div>
                            <div class="sequen">
                                <?php if($children->status_id == ExtStatus::VISIBLE): ?>
                                    <img src="<?php echo $this->assetsPath.'/images/eye-icon-on.png'; ?>">
                                <?php else: ?>
                                    <img src="<?php echo $this->assetsPath.'/images/eye-icon-off.png'; ?>">
                                <?php endif; ?>
                            </div>
                            <div class="sequen">
                                <a href="<?php echo Yii::app()->createUrl('admin/menu/move',array('id' => $children->id,'dir' => 'up')); ?>" class="go-up move-item"><span class="ficoned arrow-up"></span></a>
                                <a href="<?php echo Yii::app()->createUrl('admin/menu/move',array('id' => $children->id,'dir' => 'down')); ?>" class="go-down move-item"><span class="ficoned arrow-down"></span></a>
                            </div><!--/sequen-->
                            <div class="type"><?php echo Trl::t()->getLabel($children->type->label); ?></div>
                            <div class="action">
                                <a href="<?php echo Yii::app()->createUrl('admin/menu/editmenuitem',array('id' => $children->id)); ?>" class="edit"><span class="ficoned pencil"></span></a>
                                <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/menu/deleteitem',array('id' => $children->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                            </div>
                        </div><!--/row-->
                    <?php endif; ?>
                <?php endforeach; ?>
            </div><!--/inner-table-->
        </div><!--/menu-table-->
    </div><!--table-->
<?php endforeach; ?>
