			<main>
				
				<div class="title-bar">
					<h1>Uploaded images</h1>
					<ul class="actions">
						<li><a href="" class="action undo" data-id="1"></a></li>
					</ul>
				</div><!--/title-bar-->
				
				<div class="content editor">
					<div class="header"><span>Some title</span></div><!--/header-->
					<div class="inner-content">
                    <?php if (Yii::app()->user->hasFlash('error')): ?>
                    <div class="clearfix">
                         <?php echo CHtml::encode(Yii::app()->user->getFlash('error')); ?>
                    </div>
                    <?php endif;?>
						<div class="images">
						<?php foreach($objImgs as $objImg):?>
							<div class="image">
								<img src="/uploads/images/<?php echo $objImg->filename; ?>" alt="" />
								<input type="checkbox" name="image[]" value="1"/>
								<a href="#" class="delete"></a>
								<a href="#" class="edit"></a>
							</div><!--/image-->
						<?php endforeach; ?>	
							
							
						</div><!--/images-->
						
						<a href="#" class="add-images"></a>
						<input type="submit" class="delete-images" disabled="disabled" value=" " />
					</div><!--/inner-content-->
				</div><!--/content editor-->
			
			</main>
		</div><!--/content-fluid-->
