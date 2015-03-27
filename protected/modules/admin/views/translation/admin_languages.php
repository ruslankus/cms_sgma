<main>
	<div class="title-bar world">
		<h1>Settings</h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content translation">
		<div class="header">
			<span><?php echo Trl::t()->getLabel('Languages');?></span>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/AdminLanguages" class="languages active"><?php echo Trl::t()->getLabel('Languages');?></a>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/AdminMessages" class="messages"><?php echo Trl::t()->getLabel('Messages');?></a>
			<a href="/<?php echo $lang_prefix?>/admin/Translation/Admin" class="labels"><?php echo Trl::t()->getLabel('Labels');?></a>
		</div><!--/header-->
		<div class="translate-actions">
			<form>
				<div class="wrap-language">
					<ul class="editor-language">
						<li data-language="en"><img src="images/flag-uk.png" alt="" /><a href="#">English</a></li>
						<li data-language="ru" class="active"><img src="images/flag-uk.png" alt="" /><a href="#">Russian</a></li>
						<li data-language="lt"><img src="images/flag-uk.png" alt="" /><a href="#">Lithuanian</a></li>
						<li data-language="en"><img src="images/flag-uk.png" alt="" /><a href="#">English</a></li>
						<li data-language="en"><img src="images/flag-uk.png" alt="" /><a href="#">English</a></li>
					</ul>
				</div>
				<input name="language_id" type="hidden" value="" id="editor_language_input" />
				<input type="submit" class="add-label" value="Add language" />
			</form>
			<form>
				<input type="text" class="search-label" value="" placeholder="Search language" />
				<input type="submit" class="search-label-button" value="Search" />
			</form>
		</div><!--/translate-actions-->
		<div class="translate-content">
			<div class="translate-row">
				<div class="translate-cell id">#</div>
				<div class="translate-cell labels">Languages</div>
				<div class="translate-cell translations">Translations</div>
				<div class="translate-cell actions">Actions</div>
			</div><!--/translate-row-->
			
			<div class="translate-row">
				<div class="translate-cell id">1</div>
				<div class="translate-cell labels">Lorem ipsum</div>
				<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="1"/></div>
				<div class="translate-cell actions">
					<a href="edit.html" class="action save" data-actfor="1"></a>
					<a href="index.html" class="action delete" data-actfor="1"></a>
				</div><!--/translate-cell actions-->
			</div><!--/translate-row-->
			<div class="translate-row">
				<div class="translate-cell id">2</div>
				<div class="translate-cell labels">Lorem ipsum</div>
				<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="2"/></div>
				<div class="translate-cell actions">
					<a href="edit.html" class="action save" data-actfor="2"></a>
					<a href="index.html" class="action delete" data-actfor="2"></a>
				</div><!--/translate-cell actions-->
			</div><!--/translate-row-->
			<div class="translate-row">
				<div class="translate-cell id">3</div>
				<div class="translate-cell labels">Lorem ipsum</div>
				<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="3"/></div>
				<div class="translate-cell actions">
					<a href="edit.html" class="action save" data-actfor="3"></a>
					<a href="index.html" class="action delete" data-actfor="3"></a>
				</div><!--/translate-cell actions-->
			</div><!--/translate-row-->
			<div class="translate-row">
				<div class="translate-cell id">4</div>
				<div class="translate-cell labels">Lorem ipsum</div>
				<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="4"/></div>
				<div class="translate-cell actions">
					<a href="edit.html" class="action save" data-actfor="4"></a>
					<a href="index.html" class="action delete" data-actfor="4"></a>
				</div><!--/translate-cell actions-->
			</div><!--/translate-row-->
			<div class="translate-row">
				<div class="translate-cell id">5</div>
				<div class="translate-cell labels">Lorem ipsum</div>
				<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="5"/></div>
				<div class="translate-cell actions">
					<a href="edit.html" class="action save" data-actfor="5"></a>
					<a href="index.html" class="action delete" data-actfor="5"></a>
				</div><!--/translate-cell actions-->
			</div><!--/translate-row-->
			
		</div><!--/translate-content-->
		
	<div class="pagination from-labels">
		<a href="pages.html" class="active">1</a>
		<a href="pages.html">2</a>
		<a href="pages.html">3</a>
		<a href="pages.html">4</a>
	</div><!--/pagination-->
	</div><!--/content translate-->
	
</main>