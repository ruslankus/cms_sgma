<hr>
<?php
$form=$this->beginWidget('CActiveForm',array(
   'id'=>'user-form',
   'enableAjaxValidation'=>false,
 ));
?>

 <div class="row">
 <div class="form-result"></div>
<input type="hidden" id="lang_prefix" value="<?php echo $lang_prefix;?>">

<?php echo $form->labelEx($model,'email'); ?>
<div>
<?php echo $form->textField($model,'email', array('id'=>'email')); ?>
<?php echo $form->error($model,'email'); ?>
</div>

<?php echo $form->labelEx($model,'text'); ?>
<div>
	<?php echo $form->textArea($model,'text', array('id'=>'text')); ?>
	<?php echo $form->error($model,'text'); ?>
</div>

  <?php echo $form->labelEx($model,'code'); ?>
  <div>
	<?php echo $form->textField($model,'code', array('id'=>'code')); ?>
	<?php $this->widget('CCaptcha',array('captchaAction'=>'/'.$lang_prefix.'/mail/captcha')); ?>
	<?php echo $form->error($model,'code'); ?>
  </div>
 <?php
 
 ?>
 </div>
<?php echo CHtml::submitButton(Trl::t()->getLabel('Send'),array('class'=>'send-data')); ?>

<?php
$this->endWidget();
?>