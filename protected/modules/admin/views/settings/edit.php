<?php /* @var $arrData array */ ?>
<?php /* @var $selectable_items array */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Settings'); ?></h1>
        <ul class="actions">
            <li><a href="" class="action undo"></a></li>
            <li><a href="" class="action del" data-id="1"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content widget-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Theme settings'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <span><a href="<?php echo Yii::app()->createUrl('admin/settings/index') ?>"><?php echo ATrl::t()->getLabel('Themes'); ?></a></span>
            <span><a href="<?php echo Yii::app()->createUrl('admin/settings/registration') ?>"><?php echo ATrl::t()->getLabel('Widgets positions'); ?></a></span>
            <span class="active"><a href="<?php echo Yii::app()->createUrl('admin/settings/edit') ?>"><?php echo ATrl::t()->getLabel('General settings'); ?></a></span>
        </div><!--/tab-line-->

        <div class="inner-content">
            <form method="post">
                <?php foreach($arrData as $key => $value ): ?>
                    <div class="gen-item">
                        <?php if($key != 'home_page_item'): ?>
                            <span><?php echo $key; ?></span>
                            <input type="submit" value="Save" name="save[<?php echo $key; ?>]" class="save float-right"/>
                            <input type="text" name="settings[<?php echo $key; ?>]" value="<?php echo $value?>" />
                        <?php else: ?>
                            <span><?php echo $key; ?></span>
                            <input type="submit" value="Save" name="save[<?php echo $key; ?>]" class="save float-right"/>
                            <select name="settings[<?php echo $key; ?>]">
                                <?php foreach($selectable_items as $id => $option): ?>
                                <option <?php if(!is_numeric($id)): ?> disabled <?php endif; ?> <?php if($value == $id): ?> selected <?php endif; ?>  value="<?php echo $id ?>"><?php echo $option; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div><!--/gen-item-->
                <?php endforeach; ?>
            </form>
        </div><!--/inner-content-->

    </div><!--/content menu-->
</main>