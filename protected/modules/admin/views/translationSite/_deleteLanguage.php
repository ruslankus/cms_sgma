<form method="post" action="/<?php echo $lang_prefix ?>/admin/TranslationSite/DelAdminLanguage/<?php echo $id ?>" >
<div class="message">
	<?php echo ATrl::t()->getLabel('delete language confirm')?> : <?php echo $lang_name?>?
</div>
<a href="#" class="button cancel"><?php echo ATrl::t()->getLabel('cancel')?></a>
<button type="submit" data-prefix="<?php echo $lang_prefix?>" class="button confirm delete-label-popup"><?php echo ATrl::t()->getLabel('confirm')?></button>
</form>