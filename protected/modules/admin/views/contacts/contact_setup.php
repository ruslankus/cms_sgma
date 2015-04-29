<?php $prefix = SiteLng::lng()->getCurrLng()->prefix ?>
<main>
	<div class="title-bar world">
		<h1><?php echo ATrl::t()->getLabel('edit contact page')?></h1>
		<ul class="actions">
			<li><a href="/<?php echo $prefix;?>/admin/contacts/pages" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content page-content">
		<div class="header">
			<span><?php echo $arrPage['title'];?></span>
			<a href="/<?php echo $prefix;?>/admin/contacts/contactsettings/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact form images')?></a>
			<a href="/<?php echo $prefix;?>/admin/contacts/editcontent/<?php echo $contact_id;?>"><?php echo ATrl::t()->getLabel('contact page')?></a>
			<a href="/<?php echo $prefix;?>/admin/contacts/editsetup/<?php echo $contact_id;?>" class="active"><?php echo ATrl::t()->getLabel('contact settings')?></a>
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
				'enableAjaxValidation'=>false,
			)); ?>

			<div class="inner-editor inner-content">
				<table> 
                <?php if(!empty($arrTemplates)):?>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('template')?>:</td>
						<td class="value">
                            <?php echo CHtml::activeDropDownList($model,'template_name',$arrTemplates);  ?>						
						</td>
					</tr>
                    <?php endif; ?>
					<tr>
						<td class="label"><?php echo ATrl::t()->getLabel('Save in db');?>:</td>
						<td class="value">
                            <?php echo $form->checkBox($model,'save_form',array("checked"=>($objContact->save_form==1)?"checked":"")); ?>		
						</td>
					</tr>
				</table>
				<?php echo CHtml::submitButton('Save'); ?>
			</div><!--/inner-editor-->
			<?php $this->endWidget(); ?>
	</div><!--/content translate-->
</main>
