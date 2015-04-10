<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $categories array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form_model ProductForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this ProductsController */ ?>
<?php /* @var $category int */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $product_code string */ ?>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('News'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->request->urlReferrer; ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Add item'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-item-form','enableAjaxValidation'=>true,'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <div class="tabs">
                <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="ProductForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="" /></td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </div><!--/tabs-->

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'))); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'status_id'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>''));?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'category_id'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'category_id',$categories,array('class'=>'','options' => array($category => array('selected' => true))));?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'template_name'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>''));?>
                    </td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'price'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'price',array('placeholder' => '0.00')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'discount_price'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'discount_price',array('placeholder' => '0.00')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'stock_qnt'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'stock_qnt',array('placeholder' => '0')); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'product_code'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'product_code',array('value' => $product_code)); ?></td>
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
                        <?php echo $form->error($form_model,'label',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'price',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'discount_price',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'stock_qnt',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'product_code',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                        <?php echo $form->error($form_model,'category_id',array('class'=>'float-right errorMessage', 'style' => 'display:block')); ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>