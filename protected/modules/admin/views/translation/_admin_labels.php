<?php
$pagesArr = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<div class="translate-content">
	<div class="translate-row">
		<div class="translate-cell id">#</div>
		<div class="translate-cell labels">Labels</div>
		<div class="translate-cell translations">Translations</div>
		<div class="translate-cell actions">Actions</div>
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
