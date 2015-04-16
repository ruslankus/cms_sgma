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
		<?php if(!empty($item['label'])){?>
		    <div class="overlay" style="display:none;"></div>
		    <div class="ic_caption">
		      <h3><?php echo $item['label']?></h3>
		      
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
