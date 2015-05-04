<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $form_mdl AttrFieldForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this ComplexController */ ?>
<?php /* @var $groups array */ ?>
<?php /* @var $group int */ ?>
<?php /* @var $types array */ ?>

<style>
    .text-input-in-form
    {
        width: 360px;
        height: 100px;
        padding-left: 3px;
        padding-right: 3px;
        background-color: #FFF;
        border-radius: 3px;
        border: 1px solid #DDD;
        color: #968B8B;
        font-size: 15px;
        font-family: "Open_sans";
        resize: none;
    }
    .addable .input-block
    {
        margin-bottom: 5px;
    }
    .content .inner-content .addable td
    {
        vertical-align: top;
    }
    .content .inner-content .addable .input-block .input-name{width: 135px; display: block; float: left;}
    .content .inner-content .addable .input-block .input-value{width: 130px; display: block; float: left; margin-left: 5px;}
    .content .inner-content .addable .input-block .input-delete{min-width: 70px; display: block; float: left; margin-left: 5px; background-color: #ff3a36; border: 1px solid #cd0000; visibility: hidden; padding: 0;}
</style>

<?php $params = array(); ?>
<?php if($group != 0): ?> <?php $params['group'] = $group; ?> <?php endif; ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Attribute fields'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/complex/fields',$params) ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Add attribute field'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-field-form','enableAjaxValidation'=>true,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <div class="tabs">
                    <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="AttrFieldForm[field_titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your name'); ?>" value="" /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Description'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value">
                                <textarea class="text-input-in-form" placeholder="<?php echo ATrl::t()->getLabel('Your description'); ?>" name="AttrFieldForm[field_descriptions][<?php echo $language->id; ?>]"></textarea>
                            </td>
                        </tr>
                    </table>
                    <?php endforeach; ?>
                </div><!--/tabs-->

                <table>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_mdl,'group_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($form_mdl,'group_id',$groups,array('options' => array($group => array('selected' => true)))); ?></td>
                        <td class="value"></td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_mdl,'field_name'); ?></td>
                        <td class="value"><?php echo $form->textField($form_mdl,'field_name',array('placeholder' => ATrl::t()->getLabel('Name of field'))); ?></td>
                        <td class="value"></td>
                    </tr>
                    <tr class="addable">
                        <td class="label"><?php echo $form->labelEx($form_mdl,'type_id'); ?></td>
                        <td class="value"><?php echo $form->dropDownList($form_mdl,'type_id',$types,array('data-show_variants_for' => ExtProductFieldTypes::TYPE_SELECTABLE)); ?></td>
                        <td class="value hidden-selector" style="visibility: hidden">
                            <div class="field-in-addable">
                                <div class="input-block">
                                    <input class="input-name" placeholder="<?php echo ATrl::t()->getLabel('Name'); ?>" name="AttrFieldForm[variants][option_name][0]" type="text">
                                    <input class="input-value" placeholder="<?php echo ATrl::t()->getLabel('Value'); ?>" name="AttrFieldForm[variants][option_value][0]" type="text">
                                    <input class="input-delete" type="submit" value="<?php echo ATrl::t()->getLabel('Delete'); ?>">
                                    <div style="clear: both"></div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="for-text-item">
                        <td class="label"><?php echo $form->labelEx($form_mdl,'use_editor'); ?></td>
                        <td class="value">
                            <?php echo $form->checkBox($form_mdl,'use_editor'); ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array()); ?>
                        </td>
                        <td class="value hidden-selector" style="visibility: hidden">
                            <input data-count="0" data-ploname="<?php echo ATrl::t()->getLabel('Name'); ?>" data-ploval="<?php echo ATrl::t()->getLabel('Value'); ?>" data-delname="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-oname="AttrFieldForm[variants][option_name]" data-oval="AttrFieldForm[variants][option_value]" class="add-select-option-button" type="submit" value="<?php echo ATrl::t()->getLabel('Add field'); ?>">
                        </td>
                    </tr>

                    <tr>
                        <td class="label">&nbsp;</td>
                        <td class="value">
                            <?php echo $form->error($form_mdl,'group_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_mdl,'field_name',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_mdl,'type_id',array('class'=>'float-right errorMessage')); ?>
                        </td>
                        <td class="value"></td>
                    </tr>
                </table>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>