	<main>
		<div class="title-bar world">
			<h1>Edit page content</h1>
			<ul class="actions">
				<li><a href="" class="action undo"></a></li>
			</ul>
		</div><!--/title-bar-->
		
		<div class="content page-content">
			<div class="header">
				<span>Some title</span>
				<a href="edit-page.html">Page Settings</a>
				<a href="edit-page-content.html" class="active">Content</a>
			</div><!--/header-->
			
				<div class="inner-top">
					<select name="language" id="styled-language-editor" class="float-left">
                    
                    <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
					  <option value="<?php echo $objLng->id;?>" data-page="<?php echo $page_id ?>"><?php echo  ucwords($objLng->name); ?> </option>
                    <?php endforeach;?>  
					 
					</select>
					<span>Don't forget to save content before choosing another language.</span>
				</div><!--/inner-top-->
                <form method="post" id="content-form">
                <?php print_r($arrPage);?>
                <input type="hidden" name="lngId"  value="<?php echo $siteLng ?>"/>
                <input type="hidden" name="pageId"  value="<?php echo $page_id ?>"/>
				<div class="inner-editor">
					<table>
						<tr>
							<td class="label">Title</td>
							<td class="value"><input type="text" name="title" value="<?php echo $arrPage['title']; ?>" /></td>
						</tr>
					</table>
					<textarea name="text"><?php echo $arrPage['text']; ?></textarea>
					<table>
						<tr>
							<td class="label">Meta</td>
							<td class="value"><input type="text" name="meta" value="<?php echo $arrPage['meta_description']; ?>" /></td>
						</tr>
					</table>
					<input id="save-content" name="save-content" type="submit" value="Save" />
				</div><!--/inner-editor-->
		        </form>  
		</div><!--/content translate-->
	</main>
