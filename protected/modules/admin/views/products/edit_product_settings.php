<?php /* @var $categories array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form_model ProductForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $item ExtProduct */ ?>
<?php /* @var $images ExtImagesOfProduct[] */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $tags array */ ?>


<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Products'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/products/list',array('cat' => $item->category_id)); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content">
        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit item'); ?></span>
            <a href="<?php echo Yii::app()->createUrl('admin/products/editprodfields',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attributes'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/editprodattrgroup',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attribute groups'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/edititemtrl',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Content'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/products/edit',array('id' => $item->id)); ?>" class="active"><?php echo ATrl::t()->getLabel('Settings'); ?></a>
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
                            <td class="label"><?php echo $form->labelEx($form_model,'template_name'); ?></td>
                            <td class="value"><?php echo $form->dropDownList($form_model,'template_name',$templates,array('options'=>array($item->status_id => array('selected' => true))));?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'price'); ?></td>
                            <td class="value"><?php echo $form->textField($form_model,'price',array('placeholder' => '0.00', 'value' => Number::FormatPrice($item->price))); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'discount_price'); ?></td>
                            <td class="value"><?php echo $form->textField($form_model,'discount_price',array('placeholder' => '0.00', 'value' => Number::FormatPrice($item->discount_price))); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'stock_qnt'); ?></td>
                            <td class="value"><?php echo $form->textField($form_model,'stock_qnt',array('placeholder' => '0', 'value' => $item->stock_qnt)); ?></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo $form->labelEx($form_model,'product_code'); ?></td>
                            <td class="value"><?php echo $form->textField($form_model,'product_code',array('value' => $item->product_code)); ?></td>
                        </tr>
                        <?php if(!empty($tags)): ?>
                            <tr>
                                <td class="label" style="vertical-align: top;"><?php echo $form->labelEx($form_model,'selected_tags'); ?></td>
                                <td class="value"><?php echo $form->checkBoxList($form_model,'selected_tags',$tags,array('multiple' => true)); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="label">&nbsp;</td>
                            <td class="value">
                                <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'price',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'discount_price',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'stock_qnt',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'product_code',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'category_id',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                                <?php echo $form->error($form_model,'image',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                            </td>
                        </tr>
                    </table>
                <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array()); ?>
                <?php $this->endWidget(); ?>
            </div><!--/form-zone-->

            <div class="image-zone">
                <strong><?php echo ATrl::t()->getLabel('Images'); ?></strong>
                <div class="list">

                    <?php foreach($images as $ion): ?>
                        <?php if(!empty($ion)): ?>
                            <div class="image">
                                <img src="<?php echo $ion->image->getCachedUrl(160,120); ?>" alt="" />
                                <a href="<?php echo Yii::app()->createUrl('admin/products/deleteimage',array('id' => $ion->id)) ?>" class="delete active" data-id="1"></a>
                            </div>
                        <?php else: ?>
                            <div class="image">
                                <img src="<?php echo Image::getUrlOf('no-image-upload.png',true); ?>" alt="">
                                <a href="#" class="delete"></a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </div><!--/list-->
            </div><!--/image-zone-->
        </div><!--/inner-content-->
    </div><!--/content translate-->
</main>