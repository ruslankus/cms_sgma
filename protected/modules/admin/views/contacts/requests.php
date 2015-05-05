<?php $prefix = SiteLng::lng()->getCurrLng()->prefix ?>
<main>
	<div class="title-bar world">
		<h1><?php echo ATrl::t()->getLabel('Form requests')?></h1>
		<ul class="actions">
			<li><a href="/<?php echo $prefix;?>/admin/contacts/pages" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span><?php echo $arrPage['title'];?></span>
			<a href="/<?php echo $prefix;?>/admin/contacts/requests/<?php echo $contact_id;?>" class="active"><?php echo ATrl::t()->getLabel('Requests')?></a>
			<a href="/<?php echo $prefix;?>/admin/contacts/contactsettings/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact form images')?></a>
			<a href="/<?php echo $prefix;?>/admin/contacts/editcontent/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact page')?></a>
			<a href="/<?php echo $prefix;?>/admin/contacts/editsetup/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact settings')?></a>
		</div><!--/header-->
	</div>

	<div class="content list page-content topmar">

		<div class="list-row title">
			<div class="cell"><?php echo ATrl::t()->getLabel('IP address')?>/<?php echo ATrl::t()->getLabel('Created at')?></div>
			<div class="cell"><?php echo ATrl::t()->getLabel('Name')?></div>
			<div class="cell"><?php echo ATrl::t()->getLabel('From')?></div>
			<div class="cell"><?php echo ATrl::t()->getLabel('Content')?></div>
			<div class="cell"><?php echo ATrl::t()->getLabel('Menu')?></div>
		</div><!--/list-row-->

        <?php foreach($objPages as $page): ?>
        
		<div class="list-row">
			<div class="cell">
			    <?php echo $page->ip;?><br>
			    <?php echo $page->created_at;?>
            </div>
   			<div class="cell">
			    <?php echo $page->name;?>
            </div>

			<div class="cell">
			    <?php echo $page->email_from;?>
            </div>
			<div class="cell">
			    <?php echo $page->content;?>
			</div>
			<div class="cell">
			    <?php echo $page->pageMenu();?>
            </div>
		</div><!--/list-row-->
        
        <?php endforeach; ?>
		
		
	</div><!--/content-->
    <?php if($showPaginator):?>
	<div class="pagination">
        <?php for($p=1; $p <= $totalPages; $p++): ?>
            <?php if($p == $currentPage):?>
                <?php echo CHtml::link($p,array('/admin/contacts/requests/',
                    'page'=> $p),array('class'=>'active')); ?>
            <?php else:?>
                <?php echo CHtml::link($p,array('/admin/contacts/requests/',
                    'page'=> $p,'id'=>$contact_id)); ?>
            <?php endif;?>
        <?php endfor;?>
    <?php endif;?>

	</div><!--/pagination-->

	</div><!--/content translate-->
</main>
