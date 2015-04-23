This is contact form !
<?php
print_r($_POST);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'SendContactForm',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
	<?php echo $form->textField($model,'email',array('value'=>$arrPage['email'],'id'=>'email')); ?>
	<?php echo $form->error($model,'email'); ?>

	<?php echo $form->textArea($model,'text',array('id'=>'text','value'=>$arrPage['text'])); ?>
	<?php echo $form->error($model,'text'); ?>
	<?php echo CHtml::submitButton('Save'); ?>

<?php
	$this->endWidget();
?>