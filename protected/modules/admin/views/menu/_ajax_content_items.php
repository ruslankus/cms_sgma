<?php /* @var ExtPage[]|ExtNewsCategory[]|ExtProductCategory[] $objContentItems */ ?>
<?php /* @var $type ExtMenuItemType */ ?>

<label for="type_id">Select object</label>
<select name="EditItemForm[obj]" id="type_id">
    <?php foreach($objContentItems as $objItem): ?>
        <option value="<?php $objItem->id; ?>" selected><?php echo $objItem->label; ?></option>
    <?php endforeach; ?>
</select>

<?php if(!empty($type) && !empty($objContentItems)): ?>
<td class="label"><?php echo ATrl::t()->getLabel($type->label); ?></td>
<td class="value">
    <select name="type">
        <option>First article</option>
        <option>First article</option>
        <option>First article</option>
        <option>First article</option>
        <option>First article</option>
    </select>
</td>
<?php endif; ?>