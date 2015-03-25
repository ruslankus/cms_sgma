<?php /* @var $this MenuController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_model AddMenuForm */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $statuses array() */ ?>

<?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array())); ?>

<?php echo $form->label($form_model,'label'); ?>
<?php echo $form->textField($form_model,'label'); ?>
<?php echo $form->error($form_model,'label'); ?>

<?php echo $form->label($form_model,'status_id'); ?>
<?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>''));?>
<?php echo $form->error($form_model,'status_id'); ?>

<?php echo $form->label($form_model,'template_name'); ?>
<?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>''));?>
<?php echo $form->error($form_model,'template_name'); ?>

<?php echo CHtml::submitButton('Submit'); ?>

<?php $this->endWidget(); ?>