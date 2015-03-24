    <div class="langlist">
    	<a href=""><?php echo strtoupper($current)?></a>
    	<ul>
            <?php foreach($objLngs as $lng):?>
            <?php if($lng->prefix == $current){ continue;}?>
    		<li><a href="/<?php echo $lng->prefix ?>/<?php echo $url?>"><?php echo strtoupper($lng->prefix)?></a></li>    	
            <?php endforeach; ?>
    	</ul>
    </div><!--/langlist-->