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
						<div class="cell"><a href="/<?php echo $currLng?>/admin/pages/edit/<?php echo $page->id?>" ><?php echo $page->pageTrls[0]->title ?> <?php echo $i ?></a></div>
						<div class="cell action">
							<a  href="/<?php echo $currLng?>/admin/pages/edit/<?php echo $page->id?>" class="action edit"></a>
							<a href="index.html" class="action delete"></a>
						</div>
					</div><!--/list-row-->
                    
                    <?php endforeach ?>
					
					
				</div><!--/content-->
                
				<div class="pagination">
					<a href="pages.html" class="active">1</a>
					<a href="pages.html">2</a>
					<a href="pages.html">3</a>
					<a href="pages.html">4</a>
				</div><!--/pagination-->
			</main>
