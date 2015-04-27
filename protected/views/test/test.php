<hr>
<?php
$form=$this->beginWidget('CActiveForm',array(
   'id'=>'user-form',
   'enableAjaxValidation'=>false,
 ));
?>

 <div class="row">

<?php echo $form->textField($model,'email'); ?>
<?php echo $form->error($model,'email'); ?>
<br>

<?php echo $form->textField($model,'text'); ?>
<?php echo $form->error($model,'text'); ?>
<br>

  <?php echo $form->labelEx($model,'code'); ?>
  <div>
<?php echo $form->textField($model,'code'); ?>
<?php $this->widget('CCaptcha'); ?>
<?php echo $form->error($model,'code'); ?>
  </div>
 
 </div>
<?php echo CHtml::submitButton('Save'); ?>

<?php
$this->endWidget();
?>