<?php /* @var $this ProductsController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_model TagForm */ ?>

<div class="lightbox add-box">
    <div class="wrap"><div class="middle">
            <div class="content">
                <span class="header"><?php echo ATrl::t()->getLabel('Add tag'); ?></span>
                <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>true,'htmlOptions'=>array(),'clientOptions' => array('validateOnSubmit'=>true))); ?>

                <table>
                    <tr>
                        <td><?php echo $form->labelEx($form_model,'label'); ?></td>
                        <td><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'))); ?></td>
                    </tr>
                </table>

                <?php echo CHtml::submitButton(ATrl::t()->getLabel('Save'),array('class' => 'float-left')); ?>
                <input type="button" value="Cancel" class="float-left" id="cancel-label"/>
                <div class="errorMessage float-right">
                    <?php echo $form->error($form_model,'label'); ?>
                </div>
                <?php $this->endWidget(); ?>
            </div><!--/content-->
        </div></div><!--/wrap/middle-->
</div><!--/lightbox-->

