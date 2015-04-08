<main>
	<div class="title-bar">
		<h1>Settings</h1>
		<ul class="actions">
			<li><a href="" class="action undo"></a></li>
		</ul>
	</div><!--/title-bar-->
	
	<div class="content widget-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Theme settings'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <span class="active"><a href="<?php echo Yii::app()->createUrl('admin/settings/index') ?>"><?php echo ATrl::t()->getLabel('Templates'); ?></a></span>
            <span><a href="<?php echo Yii::app()->createUrl('admin/settings/registration') ?>"><?php echo ATrl::t()->getLabel('Widgets positions'); ?></a></span>
            <span><a href="<?php echo Yii::app()->createUrl('admin/settings/edit') ?>"><?php echo ATrl::t()->getLabel('General settings'); ?></a></span>
        </div><!--/tab-line-->


		<div class="inner-content">
			<form>
				<?php foreach ($arrData as $item): ?>
					<div class="template"><label for="a1"><?php echo $item['name'];?></label> <input type="radio" name="raio" id="<?php echo $item['name'];?>" /></div>
				<?php endforeach;?>
				<input type="submit" value="Save" class="save float-left" />
				<?php
				/*
				<div class="errorMessage float-left">Somthing wrong.</div>
				*/
				?>
			</form>
		</div><!--/inner-content-->
		
	</div><!--/content menu-->
</main>
<?php
/*

<?php foreach($arrData as $key => $value ): ?>
<p><strong><?php echo $key?></strong>&nbsp;<?php echo $value?></p>

<?php endforeach; ?>

*/
?>