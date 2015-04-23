<?php /* @var $this ComplexController */ ?>
<?php /* @var $item ExtComplexPage */ ?>
<?php /* @var $languages Languages[] */ ?>
<?php /* @var $currentLng Languages */ ?>
<?php /* @var $itemTrl ComplexPageTrl */ ?>

<tr>
    <td class="label"><label for="title"><?php echo ATrl::t()->getLabel('Title'); ?></label></td>
    <td class="value"><input id="title" type="text" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][title]" value="<?php echo $itemTrl->title; ?>"></td>
</tr>
<tr>
    <td class="label"><label for="summary"><?php echo ATrl::t()->getLabel('Keywords'); ?></label></td>
    <td class="value"><textarea id="summary" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][keywords]"><?php echo $itemTrl->meta_keywords; ?></textarea></td>
</tr>
<tr>
    <td class="label"><label for="text"><?php echo ATrl::t()->getLabel('Text'); ?></label></td>
    <td class="value"><textarea id="text" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][text]"><?php echo $itemTrl->text; ?></textarea></td>
</tr>