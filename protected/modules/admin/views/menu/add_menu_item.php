<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $parent_items array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $form_model MenuItemForm */ ?>
<?php /* @var $menu ExtMenu */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $content_items ExtPage[]|ExtNewsCategory[]|ExtProductCategory[]|array */ ?>
<?php /* @var $first_type ExtMenuItemType  */ ?>
<?php /* @var $this MenuController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Edit menu'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/menu/menuitems',array('id' => $menu->id)); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Add menu item'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-item-form','enableAjaxValidation'=>true,'htmlOptions'=>array('data-update_url' => Yii::app()->createUrl('/admin/menu/AjaxContentItemsByType')),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <div class="tabs">
                    <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="MenuItemForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="" /></td>
                        </tr>
                    </table>
                    <?php endforeach; ?>
                </div><!--/tabs-->

                <table>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                        <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'))); ?></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'status_id'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>''));?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'type_id'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'type_id',$types,array('class'=>'load-items-selector'));?>
                        </td>
                    </tr>

                    <tr id="loadable-selector">
                        <?php echo $form->hiddenField($form_model,'content_item_id',array('value' => '')); ?>
                        <?php $this->renderPartial('_ajax_content_items',array('objContentItems' => $content_items, 'type' => $first_type)); ?>
                    </tr>

                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'parent_id'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'parent_id',$parent_items,array('class'=>''));?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'type_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'parent_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'content_item_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'link_string',array('class'=>'float-right errorMessage')); ?>
                        </td>
                    </tr>
                </table>
            <?php echo $form->hiddenField($form_model,'menu_id',array('value' => $menu->id)); ?>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>