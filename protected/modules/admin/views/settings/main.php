<?php /* @var $arrData array */ ?>

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
			<form method="post">
                <?php $themeUsed = false; ?>
				<?php foreach ($arrData as $index => $item): ?>
					<div class="template">
                        <label for="<?php echo ($index+1).'_theme'; ?>"><?php echo $item['name'];?></label>
                        <input id="<?php echo ($index+1).'_theme'; ?>" type="radio" name="radio" <?php if($item['active']): ?> <?php echo "checked"; $themeUsed = true; ?> <?php endif; ?> value="<?php echo $item['folder_name'];?>">
                    </div>
				<?php endforeach;?>

                <div class="template">
                    <label for="0_theme"><?php echo ATrl::t()->getLabel('No theme'); ;?></label>
                    <input id="0_theme" type="radio" <?php if(!$themeUsed): ?> checked <?php endif; ?> name="radio" value=""/>
                </div>

<!--                --><?php //Debug::out($arrData); ?>
                
				<input type="submit" value="Save" name="save" class="save float-left action-save" style="margin-right: 5px;"/>

				<input type="submit" value="Reset" name="save" data-prefix="<?php echo $prefix;?>" class="save float-left action-reset" />
		
					<?php if(Yii::app()->user->hasFlash('reset')):?>
						<div class="errorMessage float-left">
					      <?php echo Yii::app()->user->getFlash('reset'); ?>
					    </div>
					<?php endif; ?>

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