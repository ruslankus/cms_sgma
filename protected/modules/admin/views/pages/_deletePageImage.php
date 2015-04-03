<form method="post" action="/<?php echo $lang_prefix ?>/admin/pages/DelImagePage/<?php echo $link_id; ?>" >

<input type="hidden" name="page_id" value="<?php echo $page_id;?>"/>
<div class="message">
	<?php echo ATrl::t()->getLabel('delete image')?>?
</div>
<a href="#" class="button cancel"><?php echo ATrl::t()->getLabel('cancel')?></a>
<button type="submit" data-prefix="<?php echo $lang_prefix?>" class="button confirm delete-label-popup"><?php echo Trl::t()->getLabel('confirm')?></button>
</form>