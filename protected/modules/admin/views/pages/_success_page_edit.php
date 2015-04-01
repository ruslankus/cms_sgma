     <?php echo CHtml::activeHiddenField($model,'lngId',array('value' => $objPage->lng_id, 'class'=> 'lngId'));?>
     <?php echo CHtml::activeHiddenField($model,'pageId',array('value' => $objPage->page_id, 'class'=>'pageId' ));?>
    <div class="e-message">Your data has been saved.</div>
    <input type="submit" id="edit-more" value="Continue" />