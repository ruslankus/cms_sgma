<?php /* @var $languages Languages[] */ ?>
<?php /* @var $field ExtProductFields */ ?>
<?php /* @var $item ExtProduct */ ?>

<?php if($field->type_id == ExtProductFieldTypes::TYPE_TEXT): ?>
    <tr>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value">
            <?php $value = $field->getValueObjForItem($item->id); ?>
            <textarea id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id ?>]"><?php echo $value->text_value; ?></textarea>
        </td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_TRL_TEXT):  ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label><?php echo $field->field_name; ?></label></td>
        <td class="value trl">
            <?php foreach($languages as $index => $lng): ?>
                <?php $trl = $value->getOrCreateTrl($lng->id); ?>
                <div id="<?php echo $field->id."_".$lng->id; ?>" <?php if($index == 0): ?>class="active"<?php endif; ?>>
                    <textarea name="DynamicFields[<?php echo $field->id; ?>][<?php echo $lng->id; ?>]"><?php echo $trl->translatable_text; ?></textarea>
                </div>
            <?php endforeach; ?>
        </td>
        <td class="value">
            <?php foreach($languages as $index => $lng): ?>
                <a data-id="<?php echo $field->id."_".$lng->id; ?>" class="lng-switcher <?php if($index == 0): ?>active<?php endif; ?>" href="#"><?php echo $lng->prefix; ?></a>
            <?php endforeach; ?>
        </td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_NUMERIC): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value"><input class="numeric_field" value="<?php echo $value->numeric_value; ?>" id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id ?>]" type="text"></td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_SELECTABLE): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value">
            <select id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id; ?>]">
                <?php foreach($field->productFieldSelectOptions as $option): ?>
                    <option <?php if($value->selected_option_id == $option->id): ?> selected <?php endif; ?> value="<?php echo $option->id; ?>"><?php echo $option->option_name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_DATE): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value"><input style="display: block;" class="ui-datepicker" value="<?php echo date('m/d/Y',$value->time_value); ?>" id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id ?>]" type="text"></td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_IMAGES): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value">
            <div class="image-zone">
                <input type="file" data-delete="<?php echo Yii::app()->createUrl('admin/products/delfieldimage'); ?>" data-upload="<?php echo Yii::app()->createUrl('admin/products/uploadfieldimage',array('id' => $item->id, 'fid' => $field->id)); ?>" class="add-remote-image" name="DynamicFields[<?php echo $field->id; ?>]" data-label="<?php echo ATrl::t()->getLabel('Browse'); ?>">
                <a href="#" data-delete="<?php echo Yii::app()->createUrl('admin/products/delfieldimage'); ?>" data-update="<?php echo Yii::app()->createUrl('admin/products/assignfieldimage'); ?>" data-field="<?php echo $field->id; ?>" data-item="<?php echo $item->id ?>" data-images="<?php echo Yii::app()->createUrl('admin/products/listimagesbox'); ?>" class="add-image"><?php echo ATrl::t()->getLabel('Local'); ?></a>
                <div class="list">
                    <div class="image">

                        <?php if(!empty($value->imagesOfProductFieldsValues)): ?>
                            <?php $imageOfValue = $value->imagesOfProductFieldsValues[0]; ?>
                            <img data-id="<?php echo $imageOfValue->id; ?>" src="<?php echo $imageOfValue->image->getUrl(); ?>" alt="<?php echo $imageOfValue->image->label; ?>">
                            <a href="<?php echo Yii::app()->createUrl('admin/products/delfieldimage',array('id' => $imageOfValue->id)); ?>" class="delete-btn delete active"></a>
                        <?php else: ?>
                            <img data-id="" src="<?php echo Image::getUrlOf('no-image-upload.png',true); ?>" alt="">
                            <a href="#" class="delete-btn delete"></a>
                        <?php endif; ?>

                    </div>
                </div><!--/list-->
            </div><!--/image-zone-->
        </td>
        <td class="value"></td>
    </tr>
<?php endif; ?>

<input type="hidden" class="no-image-url" value="<?php echo Image::getUrlOf('no-image-upload.png',true); ?>">