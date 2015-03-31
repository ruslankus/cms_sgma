<table>
	<tr>
		<td class="label">Title</td>
		<td class="value"><input type="text" name="title" value="<?php echo $objPage->title?>" /></td>
	</tr>
</table>
<textarea name="name"><?php echo $objPage->text?></textarea>
<table>
	<tr>
		<td class="label">Note</td>
		<td class="value"><input type="text" name="note" /></td>
	</tr>
</table>
<input id="save-content" type="submit" value="Save" />
