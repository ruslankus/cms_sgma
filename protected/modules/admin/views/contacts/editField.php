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
		<?php
/*
		
			if($arrPage->imageLink->image->id)
			{
		?>
			
				<img height="100" src="/uploads/images/<?php echo $arrPage->imageLink->image->name;?>">
				<a class="del-image" data-id="<?php echo $arrPage->id;?>" data-prefix="<?php echo $prefix;?>" href="#">Delete Image</a>

		<?php
			}
*/			
		?>

		</div>
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'save-contact-form-SaveContactFieldForm-form',
				'enableAjaxValidation'=>false,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			));?>
			<div class="inner-top">
			<?php
				if($_POST['SaveContactFieldForm']['lngId']){
					$selected = $_POST['SaveContactFieldForm']['lngId'];
				}
				else
				{
					$selected = $siteLng;
				}
			    echo $form->dropDownList($model,
			      'lngId',
			      CHtml::listData(SiteLng::lng()->getLngs(),'id','name'),array('id'=>'styled-language-editor', 'class'=>'float-left', 'data-prefix' => $prefix, 'data-page'=>$contact_id,'options' => array($selected=>array('selected'=>true)))
			    );
			?>
				<span><?php echo ATrl::t()->getLabel('save before switch lang')?></span>
			</div><!--/inner-top-->


			<div class="inner-editor inner-content">
				<table>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('block')?>:</td>
						<td class="value">
						<?php

						    echo $form->dropDownList($model,
						      'block_id',
						      CHtml::listData(ContactsBlock::model()->findAll(),'id','label'),array('class'=>'float-left', 'empty'=> ATrl::t()->getLabel('Select Block'), 'options' => array($block_id=>array('selected'=>true)))
						    );
						    echo $form->error($model,'block_id');

						?>
						</td>
					</tr>	
					<tr>
						<td class="label">Value</td>
						<td class="value">
							<?php echo $form->textField($model,'value',array('value'=>$arrPage['value'],'id'=>'value')); ?>
							<?php echo $form->error($model,'value'); ?>
						</td>
					</tr>
					<tr>
						<td class="label">Name</td>
						<td class="value">
							<?php echo $form->textField($model,'name',array('value'=>$arrPage['name'],'id'=>'name')); ?>
							<?php echo $form->error($model,'name'); ?>
						</td>
					</tr>

				</table>
				<?php echo CHtml::submitButton('Save'); ?>
			</div><!--/inner-editor-->
			<?php $this->endWidget(); ?>
	</div><!--/content translate-->
</main>
