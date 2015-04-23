<?php /* @var $this ComplexController */ ?>
<?php /* @var $item ExtComplexPage */ ?>
<?php /* @var $groups ExtProductFieldGroups */ ?>
<?php /* @var $active_ids array */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('News'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/complex/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content">
        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit item'); ?></span>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/editprodfields',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attributes'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/editpageattrgroup',array('id' => $item->id)); ?>" class="active"><?php echo ATrl::t()->getLabel('Attribute groups'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/edititemtrl',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Content'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/edit',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Settings'); ?></a>
        </div><!--/header-->

        <div class="inner-content">
            <div class="form-zone">
                <form method="post">
                    <div class="content list">
                        <?php foreach($groups as $group): ?>
                            <div class="list-row h94">
                                <div class="cell checkbox"><input type="checkbox" name="active[<?php echo $group->id; ?>]" <?php if(in_array($group->id,$active_ids)): ?> checked <?php endif; ?>></div>
                                <div class="cell"><?php echo $group->label; ?></div>
                            </div><!--/list-row-->
                        <?php endforeach; ?>
                    </div><!--/content-->
                    <br>
                    <input type="submit" value="<?php echo ATrl::t()->getLabel('Save'); ?>">
                </form>
            </div>
        </div>


    </div><!--/content translate-->
</main>