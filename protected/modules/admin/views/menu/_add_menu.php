<?php /* @var $this MenuController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_model AddMenuForm */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $statuses array() */ ?>

<?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>true,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

<?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'))); ?>
<span class="errorMessage"><?php echo $form->error($form_model,'label'); ?></span>

<?php echo $form->labelEx($form_model,'status_id'); ?>
<?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>''));?>
<?php echo $form->error($form_model,'status_id'); ?>

<?php echo $form->labelEx($form_model,'template_name'); ?>
<?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>''));?>
<?php echo $form->error($form_model,'template_name'); ?>

<?php echo CHtml::link(ATrl::t()->getLabel('Cancel'),'#',array('class' => 'button cancel')); ?>
<?php echo CHtml::submitButton('Submit',array('class' => 'button confirm unique-class-name', 'value' => ATrl::t()->getLabel('Confirm'))); ?>

<?php $this->endWidget(); ?>