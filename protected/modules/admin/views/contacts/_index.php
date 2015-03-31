<?php
$objContacts = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<div class="content list">
	<div class="list-row title">
		<div class="cell checkbox"><input type="checkbox" id="checkall_pages"/></div>
		<div class="cell">Pages name</div>
		<div class="cell action">Action</div>
	</div><!--/list-row-->
	
    
    <?php foreach($objContacts as $contact): ?>
    
	<div class="list-row">
		<div class="cell checkbox"><input type="checkbox"/></div>
		<div class="cell"><a href="/<?php echo $currLng?>/admin/contacts/editcontent/<?php echo $contact->id?>" ><?php echo $contact->contactsTrls[0]->title ?> <?php echo $i ?></a></div>
		<div class="cell action">
			<a  href="/<?php echo $currLng?>/admin/contacts/editcontent/<?php echo $contact->id?>" class="action edit"></a>
			<a href="#" data-id="<?php echo $contact->id?>" data-prefix="<?php echo $currLng?>" class="action delete"></a>
		</div>
	</div><!--/list-row-->
    
    <?php endforeach ?>
	
	
</div><!--/content-->

<?php
if($totalPages>1)
{
?>
<div class="pagination">
<?php
	for($i=1; $i<=$totalPages; $i++):
?>
	<a href="" data-page="<?php echo $i;?>" class="links-pages<?php if(($i) == $currentPage): ?> active<?php endif; ?>" data-prefix="<?php echo $currLng; ?>"><?php echo $i;?></a>
<?php
	endfor;
?>
</div>
<?php
}
?>