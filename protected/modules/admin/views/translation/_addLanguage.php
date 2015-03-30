<form method="post" action="/<?php echo $lang_prefix ?>/admin/Translation/AddAdminLanguage" >
<input type="text" value="" id="label_name" name="label_name" placeholder="<?php echo ATrl::t()->getLabel('language name');?>"/>
<span class="errorMessage add-lang-name-err"><?php echo $error; ?></span>
<input type="text" value="" id="label_prefix" name="label_prefix" placeholder="<?php echo ATrl::t()->getLabel('language prefix');?>"/>
<span class="errorMessage add-lang-prefix-err"><?php echo $error; ?></span>
<a href="#" class="button cancel"><?php echo ATrl::t()->getLabel('cancel')?></a>
<button type="submit" data-prefix="<?php echo $lang_prefix?>" class="button confirm add-label-popup"><?php echo ATrl::t()->getLabel('confirm')?></button>
</form>