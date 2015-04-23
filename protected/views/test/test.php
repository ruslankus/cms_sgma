<hr>
<?php
$form=$this->beginWidget('CActiveForm',array(
   'id'=>'user-form',
   'enableAjaxValidation'=>false,
 ));
?>
<?php if(extension_loaded('gd')): ?>
 <div class="row">
  <?php echo $form->labelEx($model,'verifyCode'); ?>
  <div>
   <?php $this->widget('CCaptcha'); ?>
   <?php echo $form->error($model,'verifyCode'); ?>
   <?php echo $form->textField($model,'verifyCode'); ?>
  </div>
 
 </div>

<?php endif ?>
<?php
$this->endWidget();
?>