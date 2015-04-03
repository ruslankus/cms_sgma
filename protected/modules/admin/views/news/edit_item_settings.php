<?php /* @var $categories array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form_model NewsForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this NewsController */ ?>
<?php /* @var $item ExtNews */ ?>
<?php /* @var $images ExtImages[] */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('News'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/news/list',array('cat' => $item->category_id)); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content">
        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit item'); ?></span>
            <a href="#"><?php echo ATrl::t()->getLabel('Content'); ?></a>
            <a href="#" class="active"><?php echo ATrl::t()->getLabel('Settings'); ?></a>
        </div><!--/header-->

        <div class="inner-content">
            <div class="form-zone">
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'edit-item-form','enableAjaxValidation'=>true, 'htmlOptions'=>array('enctype' => 'multipart/form-data'), 'clientOptions' => array('validateOnSubmit'=>true))); ?>
                    <table>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'image'); ?></td>
                            <td class="value"><?php echo $form->fileField($form_model,'image',array('data-label' => ATrl::t()->getLabel('Browse...'))); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                            <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'), 'value' => $item->label)); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'status_id'); ?></td>
                            <td class="value"><?php echo $form->dropDownList($form_model,'status_id',$statuses,array('options'=>array($item->status_id => array('selected' => true))));?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'category_id'); ?></td>
                            <td class="value"><?php echo $form->dropDownList($form_model,'category_id',$categories,array('options'=>array($item->category_id => array('selected' => true))));?></td>
                        </tr>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value">
                                <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage')); ?>
                                <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage')); ?>
                                <?php echo $form->error($form_model,'category_id',array('class'=>'float-right errorMessage')); ?>
                                <?php echo $form->error($form_model,'image',array('class'=>'float-right errorMessage')); ?>
                            </td>
                        </tr>
                    </table>
                <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array()); ?>
                <?php $this->endWidget(); ?>
            </div><!--/form-zone-->

            <div class="image-zone">
                <strong><?php echo ATrl::t()->getLabel('Images'); ?></strong>
                <div class="list">

                    <?php foreach($images as $image): ?>
                        <?php if(!empty($image)): ?>
                            <div class="image">
                                <img src="/uploads/images/<?php echo $image->filename; ?>" alt="" />
                                <a href="#" class="delete active" data-id="1"></a>
                            </div>
                        <?php else: ?>
                            <div class="image">
                                <img src="/images/no-image-upload.png" alt="" />
                                <a href="#" class="delete"></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/list-->
            </div><!--/image-zone-->
        </div><!--/inner-content-->
    </div><!--/content translate-->
</main>