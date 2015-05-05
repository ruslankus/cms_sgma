<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $form_model TagForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $tag ExtTag */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Edit menu'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/products/tags'); ?>" class="action undo"></a></li>
            <li><a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/products/deletetag',array('id'=>$tag->id)); ?>" class="action del"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit tag'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <div class="form-zone">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-item-form','enableAjaxValidation'=>true,'htmlOptions'=>array('enctype' => 'multipart/form-data'),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <div class="tabs">
                <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="TagForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="<?php echo $tag->getTrl($language->id)->name; ?>" /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Description'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="TagForm[descriptions][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="<?php echo $tag->getTrl($language->id)->description; ?>" /></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </div><!--/tabs-->

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'image'); ?></td>
                    <td class="value"><?php echo $form->fileField($form_model,'image',array('data-label' => ATrl::t()->getLabel('Browse...'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'), 'value' => $tag->label)); ?></td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="value">
                        <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage')); ?>
                        <?php echo $form->error($form_model,'image',array('class'=>'float-right errorMessage')); ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
            </div>

            <div class="image-zone">
                <strong><?php echo ATrl::t()->getLabel('Image'); ?></strong>
                <div class="list">
                    <?php $image = $tag->getFirstImage(); ?>
                    <?php if(!empty($image)): ?>
                        <div class="image">
                            <img src="<?php echo $image->getCachedUrl(160,120); ?>" alt="">
                            <a href="<?php echo Yii::app()->createUrl('admin/products/deletetagimage',array('id' => $tag->imagesOfTags[0]->id)) ?>" class="delete active" data-id="1"></a>
                        </div>
                    <?php else: ?>
                        <div class="image">
                            <img src="<?php echo Image::getUrlOf('no-image-upload.png',true); ?>" alt="">
                            <a href="#" class="delete"></a>
                        </div>
                    <?php endif;?>
                </div><!--/list-->
            </div><!--/image-zone-->

        </div><!--/inner-content-->
    </div><!--/content translate-->
</main>