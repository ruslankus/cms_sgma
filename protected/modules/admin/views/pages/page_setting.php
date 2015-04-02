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
						<a href="edit-page.html" class="active">Page Settings</a>
						<a href="/en/admin/editcontent/<?php echo $page_id?>">Content</a>
					</div><!--/header-->
					
					<div class="inner-content">
						<div class="form-zone">
						<form enctype="multipart/form-data">
							<table>
								<tr>
									<td class="label">Choose image:</td>
									<td class="value"><input name="file" type="file" id="file-input" data-label="Browse..." /></td>
								</tr>
								<tr>
									<td class="label"><strong>Caption:</strong></td>
									<td class="value"></td>
								</tr>
								<tr>
									<td class="label">English</td>
									<td class="value"><input type="text" name="lang_en" /></td>
								</tr>
								<tr>
									<td class="label">Russian</td>
									<td class="value"><input type="text" name="lang_ru" /></td>
								</tr>
								<tr>
									<td class="label">Lithuanian</td>
									<td class="value"><input type="text" name="lang_lt" /></td>
								</tr>
							</table>
							<input type="submit" value="Save" />
						</form>
						</div><!--/form-zone-->
						<div class="image-zone">
							<strong>Preview</strong>
							<div class="list">
								<div class="image">
									<img src="/uploads/Koala.jpg" alt="" />
									<a href="#" class="delete active" data-id="1"></a>
								</div>
								<div class="image">
									<img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
									<a href="#" class="delete"></a>
								</div>
								<div class="image">
									<img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
									<a href="#" class="delete"></a>
								</div>
								<div class="image">
									<img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
									<a href="#" class="delete"></a>
								</div>
								<div class="image">
									<img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
									<a href="#" class="delete"></a>
								</div>
							</div><!--/list-->
						</div><!--/image-zone-->
					</div><!--/inner-content-->
				</div><!--/content translate-->
			</main>
