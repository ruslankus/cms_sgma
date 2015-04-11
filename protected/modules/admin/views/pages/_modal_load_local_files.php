		<div class="wrap"><div class="middle" id="model">
			<div class="content-images">
				<form>
				<span class="header">Choose image(-s)</span>
				<div class="images">
                                    <?php foreach ($objPhotos as $image):?>
					<div class="image">
						<img src="/uploads/images/<?php echo $image->filename; ?>" alt="" />
						<input type="checkbox" name="image[<?php echo $image->id ?>]" value="1"/>
					</div><!--/image-->
                                    <?php endforeach;?>        
				</div><!--/images-->
				<input type="submit" class="load-images" value="Load"/>
				<a href="#" class="cancel-images">Cancel</a>
				</form>
			</div><!--/content-->
		</div></div><!--/wrap/middle-->
