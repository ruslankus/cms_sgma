			<main>
				<div class="title-bar world">
					<h1>Add new page</h1>
					<ul class="actions">
						<li><a href="" class="action undo"></a></li>					
					</ul>
				</div><!--/title-bar-->
				
				<div class="content menu-content">
				
					<div class="tab-line">
                    <?php foreach(SiteLng::lng()->getLngs() as $index => $objLng): ?>
						<span class="<?php echo ($index == 0)? "active" : ""?>" data-lang="<?php echo $objLng->prefix?>">
                            <?php echo $objLng->name ?>
                        </span>
					
                    <?php endforeach; ?>    
					</div><!--/tab-line-->
					
					<div class="inner-content">
                    
						<?php $form=$this->beginWidget('CActiveForm'); ?>
							<div class="tabs">
                            <?php foreach(SiteLng::lng()->getLngs() as  $index => $objLng):?>
								<table data-tab="<?php echo $objLng->prefix?>" class="<?php echo ($index == 0)? "active" : ""?>">
									<tr>
										<td class="label">Title <?php echo $objLng->prefix ?>:</td>
										<td class="value">
                                        <input type="text" name="AddPageForm[title_<?php echo $objLng->prefix ?>]" placeholder="Enter holder" />
                                       
                                        </td>
									</tr>
								</table>
                             <?php endforeach; ?>   
							
							</div><!--/tabs-->
							
							<table>							
								<tr>
									<td class="label">label</td>
									<td class="value">                                   
                                    <?php echo $form->textField($model,'page_label');?>
                                    <?php echo $form->error($model,'page_label');?>
                                    </td>
								</tr>
								<tr>
									<td class="label">&nbsp;</td>
									<td class="value"><input name="save" type="submit" value="Save" /></td>
								</tr>
							</table>
                         
							
						<?php $this->endWidget(); ?>
						
					</div><!--/inner-content-->
					
				</div><!--/content translate-->
			</main>
