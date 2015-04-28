			<main>
				<div class="title-bar">
					<h1>Pages</h1>
					<ul class="actions">
						<li><a href="/<?php echo $currLng?>/admin/pages/create" class="action add"></a></li>
						<li><a href="" class="action refresh"></a></li>
						<li><a href="" class="action copy"></a></li>
						<li><a href="" class="action del"></a></li>
					</ul>
				</div><!--/title-bar-->
				<div class="content list">
					<div class="list-row title">
						<div class="cell checkbox"><input type="checkbox" id="checkall_pages"/></div>
						<div class="cell">Pages name</div>
						<div class="cell action">Action</div>
					</div><!--/list-row-->
					
                    
                    <?php foreach($objPages as $page): ?>
                    
					<div class="list-row">
						<div class="cell checkbox"><input type="checkbox"/></div>
						<div class="cell">
                            <a href="/<?php echo $currLng?>/admin/pages/editcontent/<?php echo $page->id?>" >
                                <?php echo $page->pageTrls[0]->title ?> <?php echo $i ?>
                            </a>
                        </div>
						<div class="cell action">
							<a  href="/<?php echo $currLng?>/admin/pages/editcontent/<?php echo $page->id?>" class="action edit"></a>
							<a href="index.html" class="action delete"></a>
						</div>
					</div><!--/list-row-->
                    
                    <?php endforeach ?>
					
					
				</div><!--/content-->
                <?php if($showPaginator):?>
				<div class="pagination">
                    <?php for($p=1; $p <= $totalPages; $p++): ?>
                        <?php if($p == $currentPage):?>
                            <?php echo CHtml::link($p,array('/admin/pages/index',
                                'page'=> $p),array('class'=>'active')); ?>
                        <?php else:?>
                            <?php echo CHtml::link($p,array('/admin/pages/index',
                                'page'=> $p)); ?>
                        <?php endif;?>
                    <?php endfor;?>

				</div><!--/pagination-->
                <?php endif;?>
			</main>
