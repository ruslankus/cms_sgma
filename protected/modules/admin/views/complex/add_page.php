<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form_model ComplexPageForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this ComplexController */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $product_code string */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Products'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->request->urlReferrer; ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Add item'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-item-form','enableAjaxValidation'=>true,'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <div class="tabs">
                <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="ComplexPageForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="" /></td>
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
                    <td class="label"><?php echo $form->labelEx($form_model,'template_name'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>''));?>
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
                        <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'template_name',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>