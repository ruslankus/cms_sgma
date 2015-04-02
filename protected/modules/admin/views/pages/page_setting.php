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
						<a href="edit-page-content.html">Content</a>
					</div><!--/header-->
					
					<div class="inner-content">
						<div class="form-zone">
						<!--/ <form enctype="multipart/form-data"> -->
                        <?php echo CHtml::beginForm(); ?>
							<table>
								<tr>
									<td class="label">Template:</td>
									<td class="value">
										<select name="template">
											<option>------------</option>
											<option>template.php</option>
											<option>template.php</option>
											<option>template.php</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="label">Choose image:</td>
									<td class="value"><input name="file" type="file" id="file-input" data-label="Browse..." /></td>
								</tr>
								<tr>
									<td class="label"><strong>Caption:</strong></td>
									<td class="value"></td>
								</tr>
                                <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
								<tr>
									<td class="label"><?php echo $objLng->name?></td>
									<td class="value">                                    
                                    <?php echo CHtml::activeTextField($model,"captions[{$objLng->prefix}]")?>
                                    <?php echo CHtml::error($model,"captions[{$objLng->prefix}]") ?>
                                    </td>
								</tr>
                                <?php endforeach; ?>
								
							</table>
							<input type="submit" value="Save" />
					
                        <?php echo CHtml::endForm(); ?>
						</div><!--/form-zone-->
						<div class="image-zone">
							<strong>Preview</strong>
							<div class="list">
                            <?php foreach($arrImages as $item):?>
                                <?php if(!empty($item)):?>
								<div class="image">
									<img src="/uploads/images/Koala.jpg" alt="" />
									<a href="#" class="delete active" data-id="1"></a>
								</div>
                                <?php else:?>
                                <div class="image">
									<img src="images/no-image-upload.png" alt="" />
									<a href="#" class="delete"></a>
								</div>                                
                                <?php endif;?>
                            <?php endforeach; ?>  						
							</div><!--/list-->
						</div><!--/image-zone-->
					</div><!--/inner-content-->
				</div><!--/content translate-->
			</main>
