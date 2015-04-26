<?php echo CHtml::hiddenField('field_id', $arrField['id'])?>
<?php echo CHtml::hiddenField('prefix', $lngPrefix)?>
<table>
    <tr>
        <td class="label"><?php echo ATrl::t()->getLabel('block')?>:</td>
        <td class="value">
            <select name="blocks" id="styled-language-editor" class="float-left">
            <?php foreach($objBlocks as $block):?>
            <?php if($block->id == $arrField['block_id']):?>
            <option selected="true" value="<?php echo $block->id;?>"><?php echo $block->label?></option>                            
            <?php else:?>
            <option value="<?php echo $block->id;?>"><?php echo $block->label?></option>      
            <?php endif;?>
            <?php endforeach;?>
            </select>

        </td>
    </tr>	
    <tr>
        <td class="label">Value</td>
        <td class="value">
                <?php echo CHtml::activeTextField($model,'value',array('value'=> $arrField['value'])); ?>
                <?php echo Chtml::error($model,'value'); ?>
        </td>
    </tr>
    <tr>
        <td class="label">Name</td>
        <td class="value">
            <?php echo CHtml::activeTextField($model,'name',array('value'=> $arrField['name'])); ?>
            <?php echo Chtml::error($model,'name'); ?>
        </td>
    </tr>

</table>
<?php echo CHtml::submitButton('Save',array('id'=>'save-data')); ?>