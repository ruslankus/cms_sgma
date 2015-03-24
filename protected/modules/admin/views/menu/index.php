<?php /* @var $menus ExtMenu[] */ ?>

<table border="1">
    <tr>
        <th>Id</th>
        <th>Label</th>
        <th>Item QNT'</th>
        <th>Template file</th>
        <td>Actions</td>
    </tr>

    <?php foreach($menus as $menu): ?>
        <tr>
            <td><?php echo $menu->id; ?></td>
            <td><?php echo $menu->label; ?></td>
            <td><?php echo count($menu->menuItems); ?></td>
            <td><?php echo $menu->template_name; ?></td>
            <td>
                <a href="<?php echo Yii::app()->createUrl('admin/menu/editmenu',array('id' => $menu->id)); ?>"><?php echo ATrl::t()->getLabel('Edit'); ?></a>
                <a href="<?php echo Yii::app()->createUrl('admin/menu/deletemenu',array('id' => $menu->id)); ?>"><?php echo ATrl::t()->getLabel('Delete'); ?></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>