<?php $form=$this->beginWidget('CActiveForm'); ?>
    
    <?php foreach($arrData as $key => $value ): ?>
<p><label><?php echo $key?></label><input type="text" name="<?php echo $key ?>" value="<?php echo $value?>" /> <button type="submit" name="sub_<?echo $key?>">"Save_<?php echo $key?></button></p>

<?php endforeach; ?>



<?php $this->endWidget(); ?>