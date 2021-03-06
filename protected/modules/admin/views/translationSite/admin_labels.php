<?php
Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.labelsSite.css');
Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.labelsSite.js',CClientScript::POS_END);
$pagesArr = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<main>
	<div class="title-bar world">
		<h1><?php echo ATrl::t()->getLabel('Settings')?></h1>
		<ul class="actions">
			<li><a href="/<?php echo $lang_prefix?>/admin/translationSite/admin" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->

	<div class="content translation">
		<div class="header">
			<span><?php echo ATrl::t()->getLabel('Label translation')?></span>
			<a href="/<?php echo $lang_prefix?>/admin/TranslationSite/AdminLanguages" class="languages"><?php echo ATrl::t()->getLabel('Languages')?></a>
			<a href="/<?php echo $lang_prefix?>/admin/TranslationSite/AdminMessages" class="messages"><?php echo ATrl::t()->getLabel('Messages')?></a>
			<a href="/<?php echo $lang_prefix?>/admin/TranslationSite/Admin" class="labels active"><?php echo ATrl::t()->getLabel('Labels')?></a>
		</div><!--/header-->
		<div class="translate-actions">
			<form>
				<select name="language" id="styled-language" data-prefix="<?php echo $lang_prefix?>" class="float-left">
		        <?php foreach($arrSelect as $key => $value):?>
		            <?php if($key == $select_lng):?>     
		                <option selected="true" value="<?php echo $key?>" data-image="<?php echo $this->assetsPath; ?>/images/flag-uk.png"><?php echo $value?></option>
		            <?php else:?>
		                <option value="<?php echo $key?>" data-image="<?php echo $this->assetsPath; ?>/images/flag-uk.png"><?php echo $value?></option> 
		            <?php endif;?>
		        <?php endforeach;?> 
				</select>

			</form>
				<input type="submit" data-prefix="<?php echo $lang_prefix?>" class="add-label" value="<?php echo ATrl::t()->getLabel('Add label');?>" />
			<form>
				<input type="text" class="search-label" id="search_label" value="" placeholder="<?php echo ATrl::t()->getLabel('Search label');?>" />
				<input type="submit" class="search-label-button" value="<?php echo ATrl::t()->getLabel('Search');?>" data-prefix="<?php echo $lang_prefix?>" />
			</form>
		</div><!--/translate-actions-->
		<div class="translation-list">
			<div class="translate-content">
				<div class="translate-row">
					<div class="translate-cell id">#</div>
					<div class="translate-cell labels"><?php echo ATrl::t()->getLabel('Labels')?></div>
					<div class="translate-cell translations"><?php echo ATrl::t()->getLabel('Translations')?></div>
					<div class="translate-cell actions"><?php echo ATrl::t()->getLabel('Actions')?></div>
				</div><!--/translate-row-->

				<?php 
					$n = $currentPage*$perPage-$perPage+1; // first number on page
					foreach($pagesArr as $row):?>
						<div class="translate-row">
							<div class="translate-cell id"><?php echo $n; ?></div>
							<div class="translate-cell labels"><?php echo $row['label'];?></div>
							<div class="translate-cell translations"><input type="text" id="tr-<?php echo $row['id'];?>" value="<?php echo $row['value']; ?>" name="translation"/></div>
							<div class="translate-cell actions">
								<a href="edit.html" class="action save" data-id="<?php echo $row['id'];?>" data-prefix="<?php echo $lang_prefix; ?>"></a>
								<a href="index.html" class="action delete" data-id="<?php echo $row['translation_id'];?>" data-prefix="<?php echo $lang_prefix; ?>" data-label="<?php echo $row['label']?>"></a>
							</div><!--/translate-cell actions-->
						</div><!--/translate-row-->
				<?php $n++; endforeach;?>
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