<?php /* @var $registered array */ ?>
<?php /* @var $objects ExtSystemWidget[]|ExtMenu[] */ ?>
<?php /* @var $all ExtSystemWidget[]|ExtMenu[]  */ ?>
<?php /* @var $this PositionsController */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Settings'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->request->urlReferrer; ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content widget-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Theme settings'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <span><a href="#"><?php echo ATrl::t()->getLabel('Templates'); ?></a></span>
            <span class="active"><a href="#"><?php echo ATrl::t()->getLabel('Positions'); ?></a></span>
            <span><a href="#"><?php echo ATrl::t()->getLabel('General settings'); ?></a></span>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $this->renderPartial('_registration',array('registered' => $registered, 'all' => $all)); ?>
        </div><!--/inner-content-->

        <input type="hidden" id="ajax-refresh-link" value="<?php echo Yii::app()->createUrl('admin/positions/registration'); ?>">
        <input type="hidden" id="ajax-register-link" value="<?php echo Yii::app()->createUrl('admin/positions/ajaxregister'); ?>">
    </div><!--/content menu-->
</main>