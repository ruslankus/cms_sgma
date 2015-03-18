<?php /* @var $menu array */ ?>
<?php /* @var $current_action string */ ?>
<?php /* @var $current_controller string */ ?>

<ul class="root">
    <?php foreach($menu as $controller => $controller_data): ?>
        <?php $title = $controller_data['title']; ?>
        <?php $action = $controller_data['default']; ?>
        <?php $class = $controller_data['html_class']; ?>
        <?php $icon = $controller_data['icon']; ?>
        <?php $actions = isset($controller_data['actions']) ? $controller_data['actions'] : array(); ?>
        <li>
            <span class="icon dashboard"></span><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><span><?php echo ATrl::t()->getLabel($title); ?></span></a>
            <?php if(!empty($actions) && count($actions) > 1): ?>
                <ul>
                    <?php foreach($actions as $action => $action_data): ?>
                        <?php $title = $action_data['title']; ?>
                        <?php $class = $action_data['html_class']; ?>
                        <?php $icon = $action_data['icon']; ?>
                        <li><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><?php echo ATrl::t()->getLabel($title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>