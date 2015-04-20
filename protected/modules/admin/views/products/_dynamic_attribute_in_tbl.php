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
        <td class="label"><label><?php echo $field->field_name; ?></label></td>
        <td class="value trl">
            <?php foreach($languages as $index => $lng): ?>
                <?php $value = $field->getValueObjForItem($item->id); ?>
                <?php $trl = $value->getOrCreateTrl($lng->id); ?>
                <input id="<?php echo $field->id."_".$lng->id; ?>" <?php if($index == 0): ?>class="active"<?php endif; ?> type="text" value="<?php echo $trl->translatable_text; ?>" name="DynamicFields[<?php echo $field->id; ?>][<?php echo $lng->id; ?>]">
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
        <td class="value"><input value="<?php echo $value->numeric_value; ?>" id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id ?>]" type="text"></td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_SELECTABLE): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value">
            <select id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id; ?>]">
                <?php foreach($field->productFieldSelectOptions as $option): ?>
                    <option <?php if($value->selected_option_id == $option->option_value): ?> selected <?php endif; ?> value="<?php echo $option->option_value; ?>"><?php echo $option->option_name; ?></option>
                <?php endforeach; ?>
            </select>
        </td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_DATE): ?>
    <tr>
        <?php $value = $field->getValueObjForItem($item->id); ?>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value"><input value="<?php echo $value->time_value; ?>" id="<?php echo $field->id; ?>" name="DynamicFields[<?php echo $field->id ?>]" type="text"></td>
        <td class="value"></td>
    </tr>
<?php elseif($field->type_id == ExtProductFieldTypes::TYPE_IMAGES): ?>
    <tr>
        <td class="label"><label for="<?php echo $field->id; ?>"><?php echo $field->field_name; ?></label></td>
        <td class="value">
            <div class="image-zone">
                <a href="#" data-count="2" class="add-image"><?php echo ATrl::t()->getLabel('Add local image'); ?></a>
                <div class="list">
                    <div class="image">
                        <img src="<?php echo Image::getUrlOf('no-image-upload.png',true); ?>" alt="">
                        <a href="#" class="delete"></a>
                    </div>
                </div><!--/list-->
            </div><!--/image-zone-->
        </td>
        <td class="value"></td>
    </tr>
<?php endif; ?>