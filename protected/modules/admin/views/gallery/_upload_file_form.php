    <div class="wrap"><div class="middle" id="model">
    	<div class="content" id="upload-images">
    		<span class="header">Upload image</span>
    		 <?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
    			<table>
    				<tr>
    					<td class="label">Choose image:</td>
    					<td class="value">
                       
                        <?php echo CHtml::activeFileField($model,'file', array(
                        'id'=>'file-input','data-label'=>'Browse...'
                        ))?>
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
                            <?php echo CHtml::activeTextField($model,"captions[{$objLng->prefix}]",array('class' => 'text-field'))?>                       
                        </td>
                    </tr>
                    <?php endforeach; ?>
    				
    			</table>
    			<input type="submit" value="Save" class="float-left" id="save-lightbox"/>
    			<input type="button" value="Cancel" class="float-left cancel" id="cancel-lightbox"/>
    			
    			<div class="errorMessage float-right"></div>
    		<?php echo CHtml::endForm(); ?>
    	</div><!--/content-->
    
    </div></div><!--/wrap/middle-->