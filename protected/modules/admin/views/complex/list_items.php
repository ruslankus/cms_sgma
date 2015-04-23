<?php /* @var $items ExtComplexPage[] */ ?>
<?php /* @var $this ComplexController */ ?>


<?php $params = array(); ?>
<?php $params['page'] = CPaginator::getInstance()->getCurrentPage(); ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('All pages'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/complex/add'); ?>" class="action add"></a></li>
            <li><a data-message="<?php echo ATrl::t()->getLabel('Delete all selected items ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/complex/deleteall',$params); ?>" class="action del delete-all" data-id="checkbox"></a></li>
        </ul>
    </div><!--/title-bar-->

    <?php if(!empty($items)): ?>
    <div class="content list">
        <div class="list-row title">
            <div class="cell checkbox"><input type="checkbox" value="0" name="checkbox[]" id="checkall_products"/></div>
            <div class="cell image"><?php echo ATrl::t()->getLabel('Image'); ?></div>
            <div class="cell"><span class="order asc"><?php echo ATrl::t()->getLabel('Page name'); ?><span></span></span></div>
            <div class="cell status"><?php echo ATrl::t()->getLabel('Status'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Action'); ?></div>
        </div><!--/list-row-->

        <?php foreach($items as $item): ?>
            <div class="list-row h94">
                <div class="cell checkbox"><input class="del-all-cb" type="checkbox" name="delete[<?php echo $item->id; ?>]"></div>

                <div class="cell image">
                    <?php if($item->getFirstImage() != null && $item->getFirstImage()->isFileExist()): ?>
                        <img style="width: 60px; height: 60px;" src="<?php echo $item->getFirstImage()->getUrl(); ?>" alt="<?php $item->getFirstImage()->trl->caption; ?>">
                    <?php else: ?>
                        <img style="width: 60px; height: 60px;" src="<?php echo ExtImages::model()->getUrlOf('no-image.png',true); ?>" alt="<?php $item->getFirstImage()->trl->caption; ?>">
                    <?php endif; ?>
                </div>

                <div class="cell"><?php echo $item->label; ?></div>
                <div class="cell status"><?php echo ATrl::t()->getLabel($item->status->label); ?></div>
                <div class="cell action">
                    <a href="<?php echo Yii::app()->createUrl('admin/complex/edit',array('id' => $item->id)); ?>" class="action edit"></a>
                    <?php $params['id'] = $item->id; ?>
                    <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/complex/delete',$params); ?>" class="action delete"></a>
                    <?php unset($params['id']); ?>
                </div>
            </div><!--/list-row-->
        <?php endforeach; ?>

    </div><!--/content-->
    <div class="pagination">
        <?php for($i = 0; $i < CPaginator::getInstance()->getTotalPages(); $i++): ?>
            <?php $params['page'] = $i + 1; ?>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/pages',$params); ?>" <?php if(CPaginator::getInstance()->getCurrentPage() == $i+1): ?> class="active" <?php endif; ?>><?php echo $i+1; ?></a>
        <?php endfor; ?>
    </div><!--/pagination-->
    <?php else: ?>
    <div class="content list">
        <div class="list-row">
            <div class="cell"><?php echo ATrl::t()->getLabel('List is empty'); ?></div>
        </div><!--/list-row-->
    </div>
    <?php endif; ?>
</main>