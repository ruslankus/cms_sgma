<form method="post" action="/<?php echo $lang_prefix ?>/admin/contacts/DeleteContactImage/" >
<input type="hidden" name="image_id" value="<?php echo $image_id;?>"/>
<input type="hidden" name="contact_id" value="<?php echo $contact_id;?>"/>
<div class="message">
	<?php echo ATrl::t()->getLabel('delete image')?>?
</div>
<a href="#" class="button cancel"><?php echo ATrl::t()->getLabel('cancel')?></a>
<button type="submit" data-prefix="<?php echo $lang_prefix?>" class="button confirm delete-label-popup"><?php echo Trl::t()->getLabel('confirm')?></button>
</form>