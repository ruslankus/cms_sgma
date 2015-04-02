<main>
	<div class="title-bar world">
		<h1>Edit contact content</h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span>Some title</span>
			<a href="/<?php echo $prefix;?>/admin/contacts/contactsettings/<?php echo $arrPage->id;?>">Contact settings</a>
			<a href="#" class="active">Contact Form fields</a>
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
				'id'=>'save-contact-form-SaveContactForm-form',
				'enableAjaxValidation'=>false,
				'htmlOptions' => array('enctype' => 'multipart/form-data'),
			)); ?>
			<div class="inner-top">
			<?php
				if($_POST['SaveContactForm']['lngId']){
					$selected = $_POST['SaveContactForm']['lngId'];
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
				<span>Don't forget to save content before choosing another language.</span>
			</div><!--/inner-top-->


			<div class="inner-editor">
				<table>
					<tr>
						<td class="label">image</td>
						<td class="value">
							<?php echo $form->fileField($model, 'image'); ?>
							<?php echo $form->error($model, 'image'); ?>
						</td>
					</tr>
				</table>
				<table>
					<tr>
						<td class="label">Title</td>
						<td class="value">
							<?php echo $form->textField($model,'title',array('value'=>$arrPage['title'],'id'=>'title')); ?>
							<?php echo $form->error($model,'title'); ?>
						</td>
					</tr>
				</table>
				<?php echo $form->textArea($model,'text',array('id'=>'edit','value'=>$arrPage['text'])); ?>
				<?php echo $form->error($model,'text'); ?>
				<table>
					<tr>
						<td class="label">Meta</td>
						<td class="value">
							<?php echo $form->textField($model,'meta',array('value'=>$arrPage['meta_description'],'id'=>'meta')); ?>
							<?php echo $form->error($model,'meta_description');?>
						</td>
					</tr>
				</table>
				<?php echo CHtml::submitButton('Save'); ?>
			</div><!--/inner-editor-->
			<?php $this->endWidget(); ?>
	</div><!--/content translate-->
</main>
