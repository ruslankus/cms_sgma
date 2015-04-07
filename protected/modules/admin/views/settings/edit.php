			<main>
				<div class="title-bar">
					<h1>Settings</h1>
					<ul class="actions">
						<li><a href="" class="action undo"></a></li>
						<li><a href="" class="action del" data-id="1"></a></li>
					</ul>
				</div><!--/title-bar-->
				
				<div class="content widget-content">
				
					<div class="header">
						<span>Theme settings</span>
					</div><!--/header-->
					
					<div class="tab-line">
						<span><a href="edit-widgets-templates.html">Templates</a></span>
						<span><a href="/<?php echo $prefix ?>/admin/settings/registration">Positions</a></span>
						<span class="active"><a href="edit-widgets-general.html">General settings</a></span>
					</div><!--/tab-line-->
					
					<div class="inner-content">
                    <?php foreach($arrData as $key => $value ): ?>
						<div class="gen-item">
							<span><?php echo $key; ?></span>
							
							<input type="submit" value="Save" class="save float-right"/>
							<input type="text" name="value" value="<?php echo $value?>" />
                            <input type="hidden" name="setting" value="<?php echo $key; ?>" />
						</div><!--/gen-item-->
                     <?php endforeach; ?>  
                      
					
					
					</div><!--/inner-content-->
					
				</div><!--/content menu-->
			</main>


