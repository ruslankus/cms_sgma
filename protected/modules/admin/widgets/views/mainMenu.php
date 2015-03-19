<?php /* @var $menu array */ ?>
<?php /* @var $current_action string */ ?>
<?php /* @var $current_controller string */ ?>

<ul class="root">
    <?php foreach($menu as $controller => $controller_data): ?>
        <?php $title = !empty($controller_data['title']) ? $controller_data['title'] : 'untitled'; ?>
        <?php $action = !empty($controller_data['default']) ? $controller_data['default'] : 'index'; ?>
        <?php $class = !empty($controller_data['html_class']) ? $controller_data['html_class'] : ''; ?>
        <?php $icon = !empty($controller_data['icon']) ? $controller_data['icon'] : ''; ?>
        <?php $actions = isset($controller_data['actions']) ? $controller_data['actions'] : array(); ?>
        <li>
            <span class="icon <?php echo $class; ?>"></span><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><span><?php echo ATrl::t()->getLabel($title); ?></span></a>
            <?php if(!empty($actions) && count($actions) > 1): ?>
                <ul>
                    <?php foreach($actions as $action => $action_data): ?>
                        <?php $title = !empty($action_data['title']) ? $action_data['title'] : 'untitled'; ?>
                        <li><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><?php echo ATrl::t()->getLabel($title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>