<?php /* @var $menu array */ ?>
<?php /* @var $current_controller string */ ?>

<ul>
    <?php foreach($menu as $controller => $params): ?>
        <li <?php if($controller == $current_controller):?> style="font-weight: bold"; <?php endif; ?>><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$params['default']); ?>"><?php echo $params['title'] ?></a></li>
    <?php endforeach; ?>
</ul>
