<div id="pop-body">
	<form method="post" >
	<div class="message">
		<?php echo Trl::t()->getLabel('Reset widget positions')?>?
	</div>
	<a href="#" class="button cancel"><?php echo Trl::t()->getLabel('cancel')?></a>
	<button type="submit" data-prefix="<?php echo $prefix?>" class="button confirm reset-confirm"><?php echo Trl::t()->getLabel('reset')?></button>
	</form>
</div>