<?php /* @var $this NewsController */ ?>
<?php /* @var $item ExtNews */ ?>
<?php /* @var $languages Languages[] */ ?>
<?php /* @var $currentLng Languages */ ?>
<?php /* @var $itemTrl NewsTrl */ ?>

<tr>
    <td class="label"><label for="title"><?php echo ATrl::t()->getLabel('Title'); ?></label></td>
    <td class="value"><input id="title" type="text" name="NewsFormTrl[<?php echo $currentLng->id; ?>][title]" value="<?php echo $itemTrl->title; ?>"></td>
</tr>
<tr>
    <td class="label"><label for="summary"><?php echo ATrl::t()->getLabel('Summary'); ?></label></td>
    <td class="value"><textarea id="summary" name="NewsFormTrl[<?php echo $currentLng->id; ?>][summary]"><?php echo $itemTrl->summary; ?></textarea></td>
</tr>
<tr>
    <td class="label"><label for="text"><?php echo ATrl::t()->getLabel('Text'); ?></label></td>
    <td class="value"><textarea id="text" name="NewsFormTrl[<?php echo $currentLng->id; ?>][text]"><?php echo $itemTrl->text; ?></textarea></td>
</tr>