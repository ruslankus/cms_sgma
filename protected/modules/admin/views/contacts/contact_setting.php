<?php $prefix = SiteLng::lng()->getCurrLng()->prefix ?>
<main>
	<div class="title-bar world">
		<h1>Edit contacts content</h1>
		<ul class="actions">
			<li><a href="/<?php echo $prefix;?>/admin/contacts/pages" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">

			<span><?php echo $arrPage['label'];?></span>
				<a href="#" class="active"><?php echo ATrl::t()->getLabel('contact form images')?></a>
				<a href="/<?php echo $prefix;?>/admin/contacts/editcontent/<?php echo $page_id;?>"><?php echo ATrl::t()->getLabel('contact settings')?></a>
				<a href="/<?php echo $prefix;?>/admin/contacts/editsetup/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact settings')?></a>
		</div><!--/header-->
		
		<div class="inner-content">
						<div class="form-zone">
						<!--/ <form enctype="multipart/form-data"> -->
                                                <?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data'));?>
							<table>
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
									<td class="label"><strong><?php echo ATrl::t()->getLabel('caption')?>:</strong></td>
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
							<input type="submit" value="<?php echo ATrl::t()->getLabel('save')?>" />
					
                        <?php echo CHtml::endForm(); ?>
						</div><!--/form-zone-->
						<div class="image-zone">
							<strong><?php echo ATrl::t()->getLabel('preview')?></strong>
                             <a href="#"  data-page="<?php echo $page_id; ?>" data-prefix="<?php echo $prefix?>" class="add-image">Add local image</a>
							<div class="list">
                           
                                <?php if(!empty($arrImage)):?>
                                    <div class="image">
                                        <img src="/uploads/images/<?php echo $arrImage['filename']?>" alt="" />
                                        <a href="#" class="delete active" data-id="<?php echo $arrImage['id']; ?>" data-contact_id="<?php echo $page_id; ?>" data-prefix="<?php echo $prefix; ?>"></a>
                                    </div>
                                <?php else:?>
                                    <div class="image">
                                        <img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
                                        <a href="#" class="delete"></a>
                                    </div>                                
                                <?php endif;?>
                          				
							</div><!--/list-->
						</div><!--/image-zone-->
		</div><!--/inner-content-->
	</div><!--/content translate-->
</main>