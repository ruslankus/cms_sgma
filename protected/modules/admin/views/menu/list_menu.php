<?php /* @var $this MenuController */ ?>
<?php /* @var $form_params array */ ?>
<?php /* @var $menus ExtMenu[] */ ?>
<?php /* @var $total_pages int */ ?>
<?php /* @var $current_page int */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('All menus'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/menu/addmenu'); ?>" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->
    <div class="content list">
        <div class="list-row title">
            <div class="cell drag-drop"></div>
            <div class="cell"><span class="order asc"><?php echo ATrl::t()->getLabel('All menus'); ?><span></span></span></div>
            <div class="cell item-qnt"><?php echo ATrl::t()->getLabel('Item QNT'); ?></div>
            <div class="cell template"><?php echo ATrl::t()->getLabel('Template File'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?></div>
        </div><!--/list-row-->

        <?php foreach($menus as $menu): ?>
        <div class="list-row">
            <div class="cell id"><?php echo $menu->id; ?></div>
            <div class="cell"><a href="<?php echo Yii::app()->createUrl('admin/menu/menuitems',array('id' => $menu->id)); ?>"><?php echo $menu->label; ?></a></div>
            <div class="cell item-qnt"><?php echo count($menu->menuItems); ?></div>
            <div class="cell template"><?php echo $menu->template_name; ?></div>
            <div class="cell action">
                <a href="<?php echo Yii::app()->createUrl('admin/menu/editmenu',array('id' => $menu->id)); ?>" class="action edit" data-id="<?php echo $menu->id; ?>"></a>
                <a href="<?php echo Yii::app()->createUrl('admin/menu/deletemenu',array('id' => $menu->id)); ?>" class="action delete" data-id="<?php echo $menu->id; ?>"></a>
            </div>
        </div><!--/list-row-->
        <?php endforeach; ?>

    </div><!--/content-->
    <div class="pagination">
        <?php for($i = 0; $i < $total_pages; $i++): ?>
            <a href="<?php echo Yii::app()->createUrl('admin/menu/index/',array('page' => $i+1)) ?>" <?php if($current_page == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->

    <?php $this->renderPartial('_add_menu_new',$form_params,false,true); ?>
</main>