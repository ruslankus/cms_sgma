    <div class="wrap"><div class="middle" id="model">
        <div class="content" id="delete-images" style="">
        <?php echo  CHtml::beginForm();?>
            <div class="message">Delete selected items?</div>
            <?php foreach($objImgs as $obj):?>
            <input type="hidden" name="image[<?php echo $obj->id?>]" value="<?php echo $obj->filename ?>" />
            <?php endforeach; ?>
            <input type="submit" value="Yes" class="float-left confirm" id="save-lightbox"/>
            <input type="button" value="Cancel" class="float-left cancel" id="cancel-lightbox"/>
        <?php echo Chtml::endForm();?>    
        </div><!--/content delete all selected-->
    </div></div><!--/wrap/middle-->