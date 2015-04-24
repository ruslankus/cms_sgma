<main>
	<div class="title-bar world">
		<h1><?php echo ATrl::t()->getLabel('edit contact block field')?></h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span><?php echo $arrPage['name'];?></span>
			<a href="#" class="active"><?php echo ATrl::t()->getLabel('contact settings')?></a>
		</div><!--/header-->
        
		<div class="contact-img">
		
		</div>
			<?php echo CHtml::beginForm(); ?>
			<div class="inner-top">
                <select name="language" id="styled-language-editor" class="float-left">
                    <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
                    <option value="<?php echo $objLng->id;?>" data-page="<?php echo $page_id ?>">
                        <?php echo  ucwords($objLng->name); ?> 
                    </option>
                    <?php endforeach;?>
                </select>  
                
				<span><?php echo ATrl::t()->getLabel('save before switch lang')?></span>
			</div><!--/inner-top-->


			<div class="inner-editor inner-content">
            <?php echo Chtml::activeHiddenField($model,'field_id',array('value' => $arrField['id']))?>
				<table>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('block')?>:</td>
						<td class="value">
                        <select name="language" id="styled-language-editor" class="float-left">
                        <?php foreach($objBlocks as $block):?>
                            <?php if($block->id == $arrField['block_id']):?>
                            <option selected="true" value="<?php echo $block->id;?>"><?php echo $block->label?></option>                            
                            <?php else:?>
                            <option value="<?php echo $block->id;?>"><?php echo $block->label?></option>      
                            <?php endif;?>
                        <?php endforeach;?>
                        </select>
					
						</td>
					</tr>	
					<tr>
						<td class="label">Value</td>
						<td class="value">
							<?php echo CHtml::activeTextField($model,'value',array('value'=> $arrField['value'])); ?>
							<?php echo Chtml::error($model,'value'); ?>
						</td>
					</tr>
					<tr>
						<td class="label">Name</td>
						<td class="value">
							<?php echo CHtml::activeTextField($model,'name',array('value'=> $arrField['name'])); ?>
							<?php echo Chtml::error($model,'name'); ?>
						</td>
					</tr>

				</table>
				<?php echo CHtml::submitButton('Save'); ?>
			</div><!--/inner-editor-->
			<?php echo CHtml::endForm(); ?>
	</div><!--/content translate-->
</main>
