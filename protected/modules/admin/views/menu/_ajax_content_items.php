<?php /* @var ExtPage[]|ExtNewsCategory[]|ExtProductCategory[] $objContentItems */ ?>
<?php /* @var $type ExtMenuItemType */ ?>
<?php /* @var $selected int */ ?>
<?php /* @var $value int */ ?>

<?php if(!empty($type) && !empty($objContentItems)): ?>
<td class="label"><label for="MenuItemForm_content_item_id"></label><?php echo ATrl::t()->getLabel($type->label); ?></td>
<td class="value">
    <select id="MenuItemForm_content_item_id" name="MenuItemForm[content_item_id]">
        <?php foreach($objContentItems as $item): ?>
            <option <?php if($selected == $item->id): ?> selected <?php endif; ?> value="<?php echo $item->id; ?>"><?php echo $item->label; ?></option>
        <?php endforeach; ?>
    </select>
</td>
<?php else: ?>
    <?php if($type->id == ExtMenuItemType::TYPE_LINK): ?>
        <td class="label"><label for="MenuItemForm_link_string"></label><?php echo ATrl::t()->getLabel($type->label); ?></td>
        <td class="value"><input value="<?php echo !empty($value) ? $value : ''; ?>" name="MenuItemForm[link_string]" id="MenuItemForm_link_string" type="text"></td>
    <?php endif; ?>
    <input value="" name="MenuItemForm[content_item_id]" id="MenuItemForm_content_item_id" type="hidden">
<?php endif; ?>