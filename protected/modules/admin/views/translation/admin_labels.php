<?php
Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/labels.js',CClientScript::POS_END);
?>
<main>
<div class="title-bar world">
	<h1>Settings</h1>
	<ul class="actions">
		<li><a href="" class="action undo"></a></li>
	</ul>
</div><!--/title-bar-->

<div class="content translation">
	<div class="header">
		<span>Label translation</span>
		<a href="languages.html" class="languages">Languages</a>
		<a href="messages.html" class="messages">Messages</a>
		<a href="labels.html" class="labels active">Labels</a>
	</div><!--/header-->
	<div class="translate-actions">
		<form>
			<select name="language" id="styled-language" class="float-left">
	        <?php foreach($arrSelect as $key => $value):?>
	            <?php if($key == $select_lng):?>     
	                <option selected="true" value="<?php echo $key?>" data-image="<?php echo $this->assetsPath; ?>/images/flag-uk.png"><?php echo $value?></option>
	            <?php else:?>
	                <option value="<?php echo $key?>" data-image="<?php echo $this->assetsPath; ?>/images/flag-uk.png"><?php echo $value?></option> 
	            <?php endif;?>
	        <?php endforeach;?> 
			</select>

		</form>
			<input type="submit" class="add-label" value="Add Label" />
		<form>
			<input type="text" class="search-label" value="" placeholder="Search label" />
			<input type="submit" class="search-label-button" value="Search" />
		</form>
	</div><!--/translate-actions-->
	<div class="translate-content">
		<div class="translate-row">
			<div class="translate-cell id">#</div>
			<div class="translate-cell labels">Labels</div>
			<div class="translate-cell translations">Translations</div>
			<div class="translate-cell actions">Actions</div>
		</div><!--/translate-row-->
		
		<div class="translate-row">
			<div class="translate-cell id">1</div>
			<div class="translate-cell labels">Lorem ipsum</div>
			<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="1"/></div>
			<div class="translate-cell actions">
				<a href="edit.html" class="action save" data-id="1"></a>
				<a href="index.html" class="action delete" data-id="1"></a>
			</div><!--/translate-cell actions-->
		</div><!--/translate-row-->
		<div class="translate-row">
			<div class="translate-cell id">2</div>
			<div class="translate-cell labels">Lorem ipsum</div>
			<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="2"/></div>
			<div class="translate-cell actions">
				<a href="edit.html" class="action save" data-id="2"></a>
				<a href="index.html" class="action delete" data-id="2"></a>
			</div><!--/translate-cell actions-->
		</div><!--/translate-row-->
		<div class="translate-row">
			<div class="translate-cell id">3</div>
			<div class="translate-cell labels">Lorem ipsum</div>
			<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="3"/></div>
			<div class="translate-cell actions">
				<a href="edit.html" class="action save" data-id="3"></a>
				<a href="index.html" class="action delete" data-id="3"></a>
			</div><!--/translate-cell actions-->
		</div><!--/translate-row-->
		<div class="translate-row">
			<div class="translate-cell id">4</div>
			<div class="translate-cell labels">Lorem ipsum</div>
			<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="4"/></div>
			<div class="translate-cell actions">
				<a href="edit.html" class="action save" data-id="4"></a>
				<a href="index.html" class="action delete" data-id="4"></a>
			</div><!--/translate-cell actions-->
		</div><!--/translate-row-->
		<div class="translate-row">
			<div class="translate-cell id">5</div>
			<div class="translate-cell labels">Lorem ipsum</div>
			<div class="translate-cell translations"><input type="text" value="Hot product" name="translation" data-input="5"/></div>
			<div class="translate-cell actions">
				<a href="edit.html" class="action save" data-id="5"></a>
				<a href="index.html" class="action delete" data-id="5"></a>
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
<div class="popup-box">
	<div class="popup-input">
		<form>
			<input name="label_name" type="text" placeholder="Label name" />
			<div class="errorMessage">Something went wrong.</div>
			<input type="submit" value="Create" />
			
			<input class="popup-cancel" type="button" value="Cancel" />
		</form>
		<div class="clearfix"></div>
	</div>
	<div class="popup-confirm">
		<span class="message">Delete #<span id="object">1</span> ?</span>
		<input type="submit" value="Confirm" />
		<input class="popup-cancel" type="button" value="Cancel" />
		<div class="clearfix"></div>
	</div>
</div><!--/popup-box-->
</main>