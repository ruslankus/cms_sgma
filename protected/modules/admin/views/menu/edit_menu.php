<?php /* @var $items ExtMenuItem[] */ ?>
<?php /* @var $pages int  */ ?>
<?php /* @var $templates array() */ ?>

<table border="1" width="500px">
    <tr>
        <th>Label</th>
        <td>type</td>
        <th>actions</th>
    </tr>
    <?php foreach($items as $item): ?>
        <tr>
            <td style="text-indent: <?php echo ($item->nestingLevel()-1) * 20; ?>px; <?php if(!$item->hasParent()): ?>font-weight: bold;<?php endif; ?>"><?php echo $item->label; ?></td>
            <td><?php echo $item->type->label; ?></td>
            <td>
                <?php if($item->hasParent()): ?>
                    <a href="<?php echo Yii::app()->createUrl('/admin/menu/moveitem',array('id' => $item->id, 'dir' => 'top')); ?>">top</a>
                    <a href="<?php echo Yii::app()->createUrl('/admin/menu/moveitem',array('id' => $item->id, 'dir' => 'down')); ?>">down</a>
                <?php endif; ?>
                
                <a href="<?php echo Yii::app()->createUrl('/admin/menu/edititem',array('id' => $item->id)); ?>">Edit</a>
                <a href="<?php echo Yii::app()->createUrl('/admin/menu/deleteitem',array('id' => $item->id)); ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>