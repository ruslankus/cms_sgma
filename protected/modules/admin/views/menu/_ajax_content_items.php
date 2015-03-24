<?php /* @var $objContentItems ExtPage|ExtNewsCategory|ExtProductCategory */ ?>

<label for="type_id">Select object</label>
<select name="EditItemForm[obj]" id="type_id">
    <?php foreach($types as $type): ?>
        <option value="<?php echo $type->id; ?>" <?php if($type->id == $curItem->type_id): ?> selected <?php endif; ?>><?php echo $type->label; ?></option>
    <?php endforeach; ?>
</select>