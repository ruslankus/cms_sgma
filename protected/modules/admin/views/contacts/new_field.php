			<main>
				<div class="title-bar world">
					<h1><?php echo ATrl::t()->getLabel('add new page block')?></h1>
					<ul class="actions">
						<li><a href="/<?php echo $prefix;?>/admin/contacts/pages" class="action undo"></a></li>				
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
										<td class="label">Name <?php echo $objLng->prefix ?>:</td>
										<td class="value">
                                        <input type="text" name="AddPageFieldForm[title_<?php echo $objLng->prefix ?>]" placeholder="Enter holder" />
                                       
                                        </td>
									</tr>
								</table>
                             <?php endforeach; ?>   
							
							</div><!--/tabs-->

							<table>	
								<tr>
									<td class="label"><?php echo ATrl::t()->getLabel('block')?>:</td>
									<td class="value">
									<?php
									
									    echo $form->dropDownList($model,
									      'block_id',
									      CHtml::listData(ContactsBlock::model()->findAll(),'id','label'),array('class'=>'float-left', 'empty'=> ATrl::t()->getLabel('Select block'), 'options' => array($group_id=>array('selected'=>true)))
									    );
									    echo $form->error($model,'block_id');

									?>
									</td>
								</tr>	
				
								<tr>
									<td class="label"><?php echo ATrl::t()->getLabel('label')?></td>
									<td class="value">                                   
                                    <?php echo $form->textField($model,'page_label');?>
                                    <?php echo $form->error($model,'page_label');?>
                                    </td>
								</tr>
								<tr>
									<td class="label">&nbsp;</td>
									<td class="value"><input name="save" type="submit" value="<?php echo ATrl::t()->getLabel('save')?>" /></td>
								</tr>
							</table>
                         
							
						<?php $this->endWidget(); ?>
						
					</div><!--/inner-content-->
					
				</div><!--/content translate-->
			</main>
