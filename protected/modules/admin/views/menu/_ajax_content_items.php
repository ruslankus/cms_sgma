<?php /* @var ExtPage[]|ExtNewsCategory[]|ExtProductCategory[] $objContentItems */ ?>

<label for="type_id">Select object</label>
<select name="EditItemForm[obj]" id="type_id">
    <?php foreach($objContentItems as $objItem): ?>
        <option value="<?php $objItem->id; ?>" selected><?php echo $objItem->label; ?></option>
    <?php endforeach; ?>
</select>