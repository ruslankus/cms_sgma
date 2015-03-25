<div class="translate-content">
	<div class="translate-row">
		<div class="translate-cell id">#</div>
		<div class="translate-cell labels">Labels</div>
		<div class="translate-cell translations">Translations</div>
		<div class="translate-cell actions">Actions</div>
	</div><!--/translate-row-->
	<?php $n = 1;  foreach($arrLabel as $row):?> 
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

<div class="pagination from-labels">
	<a href="pages.html" class="active">1</a>
	<a href="pages.html">2</a>
	<a href="pages.html">3</a>
	<a href="pages.html">4</a>
</div><!--/pagination-->
