<p>Banner core template</p>
<?php 
if(count($images)>0){
?>
	<div class="banners-box">
<?php
	foreach($images as $item):
?>
		<div class="item">
			<img src="/uploads/images/<?php echo $item['filename']?>"/>
		<?php if(!empty($item['caption'])){?>
		    <div class="overlay" style="display:none;"></div>
		    <div class="ic_caption">
		      <?php echo $item['caption']?>
		      
		    </div>
		 <?php
		 		}
		 ?>
		</div>
<?php
	endforeach;
?>
	</div>
<?php
} 

?>
