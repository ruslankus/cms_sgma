<?php /* @var $this MainController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_mdl LoginForm */ ?>

<?php $form=$this->beginWidget('CActiveForm', array('id' =>'login-form','enableAjaxValidation'=>false,'htmlOptions'=>array())); ?>

<?php echo $form->textField($form_mdl,'username',array('placeholder' => 'Login'));?>
<?php echo $form->passwordField($form_mdl, 'password', array('placeholder' => 'Password')); ?>

<input type="submit" value="<?php echo "Enter"; ?>">

<?php if($form_mdl->hasErrors()): ?>
    <?php $passwordErr = $form->error($form_mdl,'password'); ?>
    <?php $usernameErr = $form->error($form_mdl,'username'); ?>
    <?php if($usernameErr): ?>
        <?php echo $usernameErr; ?>
    <?php elseif($passwordErr): ?>
        <?php echo $passwordErr; ?>
    <?php endif ?>
<?php endif; ?>

<?php $this->endWidget(); ?>