<?php
$objContacts = $pager->getPreparedArray();
$totalPages = $pager->getTotalPages();
$perPage = $pager->getPerPage();
$currentPage = $pager->getCurrentPage();
?>
<style>
    .content > .tab-line
    {
        margin: 0;
        margin-bottom: 10px;
        margin-top: 10px;
    }
</style>
<main>

    <div class="content">
        <div class="tab-line">
            <span class="active"><a href="<?php echo Yii::app()->createUrl('admin/contacts/pages'); ?>"><?php echo ATrl::t()->getLabel('Groups'); ?></a></span>
            <span><a href="<?php echo Yii::app()->createUrl('admin/contacts/blocks'); ?>"><?php echo ATrl::t()->getLabel('Fields'); ?></a></span>
        </div><!--/tab-line-->
    </div>

	<div class="title-bar">
		<h1><?php echo ATrl::t()->getLabel('contacts pages')?></h1>
		<ul class="actions">
			<li><a href="/<?php echo $currLng?>/admin/contacts/create" class="action add"></a></li>
		</ul>
	</div><!--/title-bar-->
	<div class="contacts-box">
		<div class="content">

	        <div class="title-table">
	            <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
	            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
	            <div class="cell type"><?php echo ATrl::t()->getLabel('Priority'); ?></div>
	            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
	        </div><!--table-->

	        <div class="sortable">
	            <?php echo $this->renderPartial('_index',array('objContacts' => $objContacts, 'currLng'=>$currLng)); ?>
	        </div><!--/sortable-->

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
		<input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/contacts/pages',array('page' => CPaginator::getInstance()->getCurrentPage())); ?>">
		<input type="hidden" id="ajax-swap-link" value="<?php echo Yii::app()->createUrl('/admin/contacts/ajaxorderpages'); ?>">
	</div>
</main>