<?php /* @var $actions array */ ?>
<?php /* @var $current_action string */ ?>
<?php /* @var $current_controller string */ ?>

<?php if(!empty($actions)): ?>
    <ul>
        <?php foreach($actions as $action => $params): ?>
            <li <?php if($action == $current_action):?> style="font-weight: bold"; <?php endif; ?>><a href="<?php echo Yii::app()->createUrl('/admin/'.$current_controller.'/'.$action); ?>"><?php echo $params['title'] ?></a></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
