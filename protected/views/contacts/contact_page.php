<h2><?php echo $title?></h2>
<h3>core render</h3>
<div><?php echo $description ?></div>
<?php if(!empty($imgs[0])): ?>
<div>
    <?php echo Image::tag($imgs[0], array('class' => 'test','width' => '250'))?>
</div>
<?php endif; ?>
<div>
    <?php foreach($arrBlocks as $block ):?>
    <div style="margin-bottom: 20px;">
        <?php foreach($block as $field):?>
            <?php echo "{$field['name']}   {$field['value']}" ?><br />
        <?php endforeach;?>
    </div>    
    <?php endforeach;?>
</div>
<h2>Testing Form</h2>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
<?php
$form=$this->beginWidget('CActiveForm',array(
   'enableAjaxValidation'=>false,
 ));
?>

 <div class="row">
 <div class="form-result"></div>
<input type="hidden" id="lang_prefix" value="<?php echo $lang_prefix;?>">

<?php echo $form->labelEx($model,'name'); ?>
<div>
<?php echo $form->textField($model,'name'); ?>
<?php echo $form->error($model,'name'); ?>
</div>


<?php echo $form->labelEx($model,'email_from'); ?>
<div>
<?php echo $form->textField($model,'email_from'); ?>
<?php echo $form->error($model,'email_from'); ?>
</div>

<?php echo $form->labelEx($model,'content'); ?>
<div>
	<?php echo $form->textArea($model,'content'); ?>
	<?php echo $form->error($model,'content'); ?>
</div>

  <?php echo $form->labelEx($model,'code'); ?>
  <div>
	<?php echo $form->textField($model,'code'); ?>
	<?php $this->widget('CCaptcha',array('captchaAction'=>'/'.$lang_prefix.'/contacts/captcha')); ?>
	<?php echo $form->error($model,'code'); ?>
  </div>
 </div>
<?php echo CHtml::submitButton(Trl::t()->getLabel('Send')); ?>

<?php
$this->endWidget();
?>
