<table>
	<tr>
		<td class="label">Title</td>
		<td class="value"><input type="text" name="title" value="<?php echo $objPage->title?>" /></td>
	</tr>
</table>
<textarea name="name"><?php echo $objPage->text?></textarea>
<table>
	<tr>
		<td class="label">Meta</td>
		<td class="value"><input type="text" name="meta" value="<?php echo $objPage->meta_description?>" /></td>
	</tr>
</table>
<input id="save-content" name="save-content" type="submit" value="Save" />
