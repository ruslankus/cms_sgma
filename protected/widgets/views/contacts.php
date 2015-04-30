<hr>
<?php
$form=$this->beginWidget('CActiveForm',array(
   'id'=>'form-'.$model_id,
   'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
      'class'=>'captcha-form',
    )
 ));
?>

 <div class="row">
 <div class="form-result"></div>
<input type="hidden" class="lang_prefix" value="<?php echo $lang_prefix;?>">

<?php echo $form->labelEx($model,'name'); ?>
<div>
<?php echo $form->textField($model,'name', array('class'=>'name')); ?>
<?php echo $form->error($model,'name'); ?>
</div>


<?php echo $form->labelEx($model,'email'); ?>
<div>
<?php echo $form->textField($model,'email', array('class'=>'email')); ?>
<?php echo $form->error($model,'email'); ?>
</div>

<?php echo $form->labelEx($model,'text'); ?>
<div>
	<?php echo $form->textArea($model,'text', array('class'=>'text')); ?>
	<?php echo $form->error($model,'text'); ?>
</div>

  <?php echo $form->labelEx($model,'code'); ?>
  <div>
	<?php echo $form->textField($model,'code', array('class'=>'code', 'data-id'=>'form-'.$model_id)); ?>
	<?php $this->widget('CCaptcha',array('captchaAction'=>'/'.$lang_prefix.'/mail/captcha')); ?>
	<?php echo $form->error($model,'code'); ?>
  </div>
 <?php
 
 ?>
 </div>
<?php echo CHtml::submitButton(Trl::t()->getLabel('Send'),array('class'=>'send-data', 'data-id'=>'form-'.$model_id)); ?>

<?php
$this->endWidget();
?>