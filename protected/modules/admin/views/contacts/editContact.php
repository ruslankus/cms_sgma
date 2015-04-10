<main>
	<div class="title-bar world">
		<h1><?php echo ATrl::t()->getLabel('edit contact content')?></h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span><?php echo $arrPage['title'];?></span>
			<a href="/<?php echo $prefix;?>/admin/contacts/contactsettings/<?php echo $arrPage->block->id;?>"><?php echo ATrl::t()->getLabel('contact form images')?></a>
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
				<span><?php echo ATrl::t()->getLabel('save before switch lang')?></span>
			</div><!--/inner-top-->


			<div class="inner-editor inner-content">
				<table>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('page')?>:</td>
						<td class="value">
							<select name="template">
                                <option value="">------------</option>
                                <option value="1">Page 1</option>
                                <option value="2">Page 2</option>
                                <option value="3">Page 3</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('template')?>:</td>
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
						<td class="label">Title</td>
						<td class="value">
							<?php echo $form->textField($model,'title',array('value'=>$arrPage['title'],'id'=>'title')); ?>
							<?php echo $form->error($model,'title'); ?>
						</td>
					</tr>
					<tr>
						<td class="label">Email</td>
						<td class="value">
							<?php echo $form->textField($model,'email',array('value'=>$arrPage['email'],'id'=>'email')); ?>
							<?php echo $form->error($model,'email'); ?>
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
