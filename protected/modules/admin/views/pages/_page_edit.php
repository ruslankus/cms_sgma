   
    	<table>
    		<tr>
    			<td class="label">Title</td>
    			<td class="value">               
                    <?php echo CHtml::activeTextField($model,'title',array('value' => $objPage->title)); ?>
                </td>
    		</tr>
    	</table>
    	
        <?php echo CHtml::activeTextArea($model,'content',array('value' => $objPage->content,'class' => 'ckeditor', 'id'=> 'edit')); ?>
    	<table>
    		<tr>
    			<td class="label">Note</td>
    			<td class="value"><input type="text" name="note" /></td>
    		</tr>
    	</table>
    	<input id="save-content" type="submit" value="Save" />
  