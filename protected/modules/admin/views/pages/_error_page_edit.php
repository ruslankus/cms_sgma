        <?php echo CHtml::activeHiddenField($model,'lngId',array('value' => $objPage->lng_id));?>
        <?php echo CHtml::activeHiddenField($model,'pageId',array('value' => $objPage->page_id));?>
    	<table>
    		<tr>
    			<td class="label">Title</td>
    			<td class="value">                
                    <?php echo CHtml::activeTextField($model,'title',array('value' => $objPage->title)); ?>
                    <?php echo CHtml::error($model,'title')?>
                </td>
    		</tr>
    	</table>
    	 <?php echo CHtml::activeTextArea($model,'content',array('value' => $objPage->content,'class' => 'ckeditor', 'id'=> 'edit')); ?>
         <?php echo CHtml::error($model,'content')?>
    	<table>
    		<tr>
    			<td class="label">Note</td>
    			<td class="value">
                  <?php echo CHtml::activeTextField($model,'note')?>
                  <?php echo CHtml::error($model,'note')?>
                </td>
    		</tr>
    	</table>
    	<input id="save-content" type="submit" value="Save" />
  