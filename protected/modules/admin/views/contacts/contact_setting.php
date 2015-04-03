<?php $prefix = SiteLng::lng()->getCurrLng()->prefix ?>
<main>
	<div class="title-bar world">
		<h1>Edit contacts content</h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span>Some title</span>
				<a href="#" class="active">Contact Form images</a>
				<a href="/<?php echo $prefix;?>/admin/contacts/editcontent/<?php echo $page_id;?>">Contact settings</a>
		</div><!--/header-->
		
		<div class="inner-content">
						<div class="form-zone">
						<!--/ <form enctype="multipart/form-data"> -->
                                                <?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data'));?>
							<table>
								<tr>
									<td class="label">Template:</td>
									<td class="value">
										<select name="template">
                                            <option value="">------------</option>
                                            <option value="template.php">template.php</option>
                                            <option value="template.php">template.php</option>
                                            <option value="template.php">template.php</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="label">Choose image:</td>
									<td class="value">
                                                                            
                                                                            <?php echo CHtml::activeFileField($model,'file', array(
                                                                                'id'=>'file-input','data-label'=>'Browse...'
                                                                            ))?>
                                                                            <?php echo Chtml::error($model, 'file')?>
                                                                           
                                                                        </td>
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
                                        <img src="/uploads/images/<?php echo $item['filename']?>" alt="" />
                                        <a href="#" class="delete active" data-id="<?php echo $item['id']; ?>" data-contact_id="<?php echo $page_id; ?>" data-prefix="<?php echo $prefix; ?>"></a>
                                    </div>
                                <?php else:?>
                                    <div class="image">
                                        <img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
                                        <a href="#" class="delete"></a>
                                    </div>                                
                                <?php endif;?>
                            <?php endforeach; ?>  						
							</div><!--/list-->
						</div><!--/image-zone-->
		</div><!--/inner-content-->
	</div><!--/content translate-->
</main>