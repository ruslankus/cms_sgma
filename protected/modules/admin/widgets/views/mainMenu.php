<?php /* @var $menu array */ ?>
<?php /* @var $current_action string */ ?>
<?php /* @var $current_controller string */ ?>

<ul class="root">
    <?php foreach($menu as $itemInfo): ?>
        <?php $title = !empty($itemInfo['title']) ? $itemInfo['title'] : 'untitled'; ?>
        <?php $action = !empty($itemInfo['action']) ? $itemInfo['action'] : 'index'; ?>
        <?php $controller = !empty($itemInfo['controller']) ? $itemInfo['controller'] : 'main'; ?>
        <?php $class = !empty($itemInfo['html_class']) ? $itemInfo['html_class'] : ''; ?>
        <?php $icon = !empty($itemInfo['icon']) ? $itemInfo['icon'] : ''; ?>
        <?php $sub = isset($itemInfo['sub']) ? $itemInfo['sub'] : array(); ?>
        <li>
            <span class="icon <?php echo $class; ?>"></span><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><span><?php echo ATrl::t()->getLabel($title); ?></span></a>
            <?php if(!empty($sub)): ?>
                <ul>
                    <?php foreach($sub as $subItemInfo): ?>
                        <?php $title = !empty($subItemInfo['title']) ? $subItemInfo['title'] : 'untitled'; ?>
                        <?php $controller = !empty($subItemInfo['controller']) ? $subItemInfo['controller'] : $controller; ?>
                        <li><a href="<?php echo Yii::app()->createUrl('/admin/'.$controller.'/'.$action); ?>"><?php echo ATrl::t()->getLabel($title); ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>