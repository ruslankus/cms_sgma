<?php
Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.contacts.js',CClientScript::POS_END);
$objContacts = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<main>
	<div class="title-bar">
		<h1><?php echo ATrl::t()->getLabel('contacts pages')?></h1>
		<ul class="actions">
			<li><a href="/<?php echo $currLng?>/admin/contacts/create" class="action add"></a></li>
			<li><a href="" class="action refresh"></a></li>
			<li><a href="" class="action copy"></a></li>
			<li><a href="" class="action del"></a></li>
		</ul>
	</div><!--/title-bar-->
	<div class="contacts-box">
		<div class="content list">
			<div class="list-row title">
				<div class="cell checkbox"><input type="checkbox" id="checkall_pages"/></div>
				<div class="cell"><?php echo ATrl::t()->getLabel('pages names')?></div>
				<div class="cell action"><?php echo ATrl::t()->getLabel('action')?></div>
			</div><!--/list-row-->
			
	        
	        <?php foreach($objContacts as $contact): ?>
	        
			<div class="list-row">
				<div class="cell checkbox"><input type="checkbox"/></div>
				<div class="cell"><a id="name-<?php echo $contact->id?>" href="/<?php echo $currLng?>/admin/contacts/editcontent/<?php echo $contact->id?>"><?php echo $contact->contactsTrls[0]->title ?></a></div>
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
	</div>
</main>
