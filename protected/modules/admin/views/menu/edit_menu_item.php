<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $parent_items ExtMenuItem[] */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $form_model MenuItemForm */ ?>
<?php /* @var $menu ExtMenu */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $content_items ExtPage[]|ExtNewsCategory[]|ExtProductCategory[]|array */ ?>
<?php /* @var $first_type ExtMenuItemType  */ ?>
<?php /* @var $menuItem ExtMenuItem */ ?>
<?php /* @var $this MenuController */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Edit menu'); ?></h1>
        <ul class="actions">
            <li><a href="" class="action undo"></a></li>
            <li><a href="" class="action del" data-id="1"></a></li>
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
                            <td class="value"><input type="text" name="MenuItemForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="<?php echo $menuItem->getTrl($language->id)->value; ?>" /></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </div><!--/tabs-->

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'), 'value' => $menuItem->label)); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'status_id'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>'','options' => array($menuItem->status_id =>array('selected'=>true))));?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'type_id'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'type_id',$types,array('class'=>'load-items-selector','options' => array($menuItem->type_id =>array('selected'=>true))));?>
                    </td>
                </tr>
                <tr id="loadable-selector">
                    <?php echo $form->hiddenField($form_model,'content_item_id',array('value' => '')); ?>
                    <?php $this->renderPartial('_ajax_content_items',array('objContentItems' => $content_items, 'type' => $first_type, 'selected' => $menuItem->content_item_id)); ?>
                </tr>
                <tr>
                    <td class="label"><?php echo ATrl::t()->getLabel('Link'); ?></td>
                    <td class="value"><input type="text" name="link" class="link" /></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'parent_id'); ?></td>
                    <td class="value">
                        <select id="MenuItemForm_parent_id" name="MenuItemForm[parent_id]">
                            <option value="0"><?php echo $menu->label; ?></option>
                            <?php foreach($parent_items as $item): ?>
                                <option <?php if($item->id == $menuItem->parent_id): ?> selected <?php endif; ?> <?php if($item->id == $menuItem->id): ?> disabled <?php endif; ?> value="<?php echo $item->id; ?>">
                                    <?php for($i = 0; $i < $item->nestingLevel(); $i++): ?>-<?php endfor; ?>
                                    <?php echo $item->label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                    </td>
                </tr>
            </table>
            <?php echo $form->hiddenField($form_model,'menu_id',array('value' => $menu->id)); ?>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>