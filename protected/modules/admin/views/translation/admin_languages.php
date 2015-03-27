<?php
Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.labels.css');
Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.language.js',CClientScript::POS_END);
$pagesArr = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<main>
	<div class="title-bar world">
		<h1><?php echo Trl::t()->getLabel('Settings')?></h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->

	<div class="content translation">
		<div class="header">
			<span><?php echo Trl::t()->getLabel('Languages')?></span>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/AdminLanguages" class="languages active"><?php echo Trl::t()->getLabel('Languages')?></a>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/AdminMessages" class="messages"><?php echo Trl::t()->getLabel('Messages')?></a>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/Admin" class="labels"><?php echo Trl::t()->getLabel('Labels')?></a>
		</div><!--/header-->
		<div class="translate-actions">
				<input type="submit" data-prefix="<?php echo $lang_prefix?>" class="add-label" value="<?php echo Trl::t()->getLabel('Add language');?>" />

		</div><!--/translate-actions-->
		<div class="translation-list">
			<div class="translate-content">
				<div class="translate-row">
					<div class="translate-cell id">#</div>
					<div class="translate-cell labels"><?php echo Trl::t()->getLabel('Language name')?></div>
					<div class="translate-cell translations"><?php echo Trl::t()->getLabel('Prefix')?></div>
					<div class="translate-cell actions"><?php echo Trl::t()->getLabel('Actions')?></div>
				</div><!--/translate-row-->

				<?php 
					$n = $currentPage*$perPage-$perPage+1; // first number on page
					foreach($pagesArr as $row): ?>
						<div class="translate-row">
							<div class="translate-cell id"><?php echo $n; ?></div>
							<div class="translate-cell labels" id="lang-<?php echo $row['id'];?>">
								<input type="text" value="<?php echo $row['name']; ?>" name="lang_name" disabled/>
								<div class="errorMessage"></div>
							</div>
							<div class="translate-cell translations"><input type="text" value="<?php echo $row['prefix']; ?>" name="lang_prefix" disabled/><div class="errorMessage"></div> </div>
							<div class="translate-cell actions">
								<a href="#" class="action edit edit-page" data-id="<?php echo $row['id'];?>" data-prefix="<?php echo $lang_prefix; ?>"></a>
								<a href="#" class="action save" data-id="<?php echo $row['id'];?>" data-prefix="<?php echo $lang_prefix; ?>"></a>
								<a href="#" class="action delete" data-id="<?php echo $row['id'];?>" data-prefix="<?php echo $lang_prefix; ?>"></a>
							</div><!--/translate-cell actions-->
						</div><!--/translate-row-->
				<?php  $n++; endforeach;?>
			</div><!--/translate-content-->
			<?php
			if($totalPages>1)
			{
			?>
			<div class="pagination from-labels">
			<?php
				for($i=1; $i<=$totalPages; $i++):
			?>
				<a href="" data-page="<?php echo $i;?>" class="links-pages<?php if(($i) == $currentPage): ?> active<?php endif; ?>" data-prefix="<?php echo $lang_prefix; ?>"><?php echo $i;?></a>
			<?php
				endfor;
			?>
			</div>
			<?php
			}
			?>
		</div>
	</div><!--/content translate-->
</main>