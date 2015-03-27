<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $parent_items array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $form_model MenuItemForm */ ?>
<?php /* @var $menu ExtMenu */ ?>
<?php /* @var $form CActiveForm */ ?>

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
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-item-form','enableAjaxValidation'=>true,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>
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
                            <?php echo $form->dropDownList($form_model,'type_id',$types,array('class'=>''));?>
                        </td>
                    </tr>
                    <tr id="loadable-selector">
                        <?php echo $form->hiddenField($form_model,'content_item_id',array('value' => '')); ?>
<!--                        <td class="label">Select article</td>-->
<!--                        <td class="value">-->
<!--                            <select name="type">-->
<!--                                <option>First article</option>-->
<!--                                <option>First article</option>-->
<!--                                <option>First article</option>-->
<!--                                <option>First article</option>-->
<!--                                <option>First article</option>-->
<!--                            </select>-->
<!--                        </td>-->
                    </tr>
                    <tr>
                        <td class="label"><?php echo ATrl::t()->getLabel('Link'); ?></td>
                        <td class="value"><input type="text" name="link" class="link" /></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'parent_id'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'parent_id',$parent_items,array('class'=>''));?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value"><input type="submit" value="<?php echo ATrl::t()->getLabel('Save'); ?>" /></td>
                    </tr>
                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <div class="errorMessage float-right">
                                <?php echo $form->error($form_model,'label'); ?>
                                <?php echo $form->error($form_model,'status_id'); ?>
                                <?php echo $form->error($form_model,'type_id'); ?>
                                <?php echo $form->error($form_model,'parent_id'); ?>
                                <?php echo $form->error($form_model,'content_item_id'); ?>
                            </div>
                        </td>
                    </tr>
                </table>
            <?php echo $form->hiddenField($form_model,'menu_id',array('value' => $menu->id)); ?>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>