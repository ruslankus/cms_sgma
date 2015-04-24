<form method="post" action="<?php echo Yii::app()->createUrl('search/do'); ?>">
    <input type="text" placeholder="<?php echo Trl::t()->getLabel('Your query here'); ?>">
    <input type="submit" value="<?php echo Trl::t()->getLabel('Search'); ?>">
</form>