	<main>
		<div class="title-bar world">
			<h1>Edit page content</h1>
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
			
				<div class="inner-top">
					<select name="language" id="styled-language-editor" class="float-left">
                    
                    <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
					  <option value="<?php echo $objLng->id;?>" data-page="<?php echo $page_id ?>"><?php echo  ucwords($objLng->name); ?> </option>
                    <?php endforeach;?>  
					 
					</select>
					<span>Don't forget to save content before choosing another language.</span>
				</div><!--/inner-top-->
                <form method="post" id="content-form">
               
				<div class="inner-editor">
               
                <?php echo CHtml::activeHiddenField($model,'lngId',array('value' => $siteLng));?>
                <?php echo CHtml::activeHiddenField($model,'pageId',array('value' => $page_id));?>
               	<table>
						<tr>
							<td class="label">Title</td>
							<td class="value">                           
                            <?php echo CHtml::activeTextField($model,'title',array('value' => $arrPage['title'])); ?>
                            </td>
						</tr>
					</table>
					
                     <?php echo CHtml::activeTextArea($model,'content',array('value' => $arrPage['content'],'class' => 'ckeditor', 'id'=> 'edit')); ?>
					<table>
						<tr>
							<td class="label">Note</td>
							<td class="value">                           
                            <?php echo CHtml::activeTextField($model,'note')?>
                            </td>
						</tr>
					</table>
					<input id="save-content" type="submit" value="Save" />
				</div><!--/inner-editor-->
		        </form>  
		</div><!--/content translate-->
	</main>
