
<?php foreach($arrData as $key => $value ): ?>
<p>
<?php $form=$this->beginWidget('CActiveForm'); ?>
<label><?php echo $key?></label>
<input type="text" name="value" value="<?php echo $value?>" />
<input type="hidden" name="setting" value="<?php echo $key; ?>" />
<input type="submit" name="save" value="Save" /> 
<?php $this->endWidget(); ?>
</p>
<?php endforeach; ?>