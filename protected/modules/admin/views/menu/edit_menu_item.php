<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $curItem ExtMenuItem */ ?>
<?php /* @var $items ExtMenuItem[] */ ?>
<?php /* @var $types MenuItemType[] */ ?>

<label for="parent_id">Select parent</label>
<select name="EditItemForm[parent_id]" id="parent_id">
    <option>ROOT</option>
    <?php foreach($items as $item): ?>
        <option <?php if($item->id == $curItem->id): ?> disabled <?php endif; ?> <?php if($item->id == $curItem->parent_id):?> selected <?php endif; ?>>
            <?php for($i=0; $i < $item->nestingLevel(); $i++): ?>-<?php endfor; ?>
            <?php echo $item->label; ?>
        </option>
    <?php endforeach; ?>
</select>
<br><br>

<label for="type_id">Select type</label>
<select name="EditItemForm[type_id]" id="type_id">
    <?php foreach($types as $type): ?>
        <option value="<?php echo $type->id; ?>" <?php if($type->id == $curItem->type_id): ?> selected <?php endif; ?>><?php echo $type->label; ?></option>
    <?php endforeach; ?>
</select>
<br><br>

<div class="loadable-by-type">

</div>

<?php foreach($languages as $language): ?>
    <?php $lngId = $language->id; ?>
    <label>Name [<?php echo $language->prefix; ?>]</label>
    <input type="text" name="EditItemForm[names][<?php echo $lngId; ?>]" value="<?php echo $curItem->trlName($lngId); ?>">
    <br>
<?php endforeach; ?>