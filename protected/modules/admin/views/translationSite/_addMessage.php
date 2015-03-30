<form method="post" action="/<?php echo $lang_prefix ?>/admin/TranslationSite/AddAdminMessage" >
<input type="hidden" name="sel_lng" value="<?php echo $sel_lng; ?>">
<input type="text" value="" id="label-popup" name="label_name" placeholder="<?php echo Trl::t()->getLabel('Message name');?>"/>
<span class="errorMessage add-label-err"><?php echo $error; ?></span>
<a href="#" class="button cancel"><?php echo Trl::t()->getLabel('cancel')?></a>
<button type="submit" data-prefix="<?php echo $lang_prefix?>" class="button confirm add-label-popup"><?php echo Trl::t()->getLabel('confirm')?></button>
</form>