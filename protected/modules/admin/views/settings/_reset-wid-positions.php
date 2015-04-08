<div id="pop-body">
	<form method="post" action="/<?php echo $prefix;?>/admin/settings/">
	<div class="message">
		<?php echo Trl::t()->getLabel('Reset widget positions')?>?
	</div>
	<a href="#" class="button cancel"><?php echo Trl::t()->getLabel('cancel')?></a>
	<button type="submit" name="reset" value="reset" class="button confirm reset-confirm"><?php echo Trl::t()->getLabel('reset')?></button>
	</form>
</div>