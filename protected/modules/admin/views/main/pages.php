<?php $controllerInfo = AdminModule::$adminMenu[Yii::app()->controller->id]; ?>
<?php $title = !empty($controllerInfo['actions']) ? $controllerInfo['actions'][Yii::app()->controller->action->id]['title'] : $controllerInfo['title'];  ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel($title); ?></h1>
        <ul class="actions">
            <li><a href="" class="action add"></a></li>
            <li><a href="" class="action del"></a></li>
        </ul>
    </div><!--/title-bar-->
    <div class="content">
        <div class="module-block">
            <div class="module-head">HEAD</div><!--/module-head-->
            <div class="module-content">CONTENT</div><!--/module-content-->
        </div><!--/module-block-->
    </div><!--/content-->
</main>