<?php $form=$this->beginWidget('CActiveForm'); ?>
    
    <?php foreach($arrData as $key => $value ): ?>
<p><label><?php echo $key?></label><input type="text" name="<?php echo $key ?>" value="<?php echo $value?>" /></p>

<?php endforeach; ?>



<?php $this->endWidget(); ?>