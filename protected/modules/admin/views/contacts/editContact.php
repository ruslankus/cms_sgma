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
			<a href="edit-page.html">Page Settings</a>
			<a href="edit-page-content.html" class="active">Content</a>
		</div><!--/header-->
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'save-contact-form-SaveContactForm-form',
				'enableAjaxValidation'=>false,
			)); ?>
			<div class="inner-top">
<?php
/*
				<select name="language" id="styled-language-editor" class="float-left">
                
                <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
				  <option value="<?php echo $objLng->id;?>" data-page="<?php echo $page_id ?>"><?php echo  ucwords($objLng->name); ?> </option>
                <?php endforeach;?>  
				 
				</select>
				<?php
*/
				?>
			    <?php
			    echo $form->dropDownList($model,
			      'lngId',
			      CHtml::listData(SiteLng::lng()->getLngs(),'id','name'),array('id'=>'styled-language-editor', 'class'=>'float-left')
			    );
			    ?>
				<span>Don't forget to save content before choosing another language.</span>
			</div><!--/inner-top-->


			<div class="inner-editor">
				<table>
					<tr>
						<td class="label">Title</td>
						<td class="value">
							<?php echo $form->textField($model,'title',array('value'=>$arrPage['title'])); ?>
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
							<?php echo $form->textField($model,'meta',array('value'=>$arrPage['meta_description'])); ?>
							<?php echo $form->error($model,'meta_description'); ?>

						</td>
					</tr>
				</table>
				<?php echo CHtml::submitButton('Save'); ?>
			</div><!--/inner-editor-->
			<?php $this->endWidget(); ?>
	</div><!--/content translate-->
</main>
