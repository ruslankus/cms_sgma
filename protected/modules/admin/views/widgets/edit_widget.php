<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $types array */ ?>
<?php /* @var $form_model WidgetForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $widget ExtSystemWidget */ ?>
<?php /* @var $templates array */ ?>
<?php /* @var $this MenuController */ ?>

<style>
    .text-input-in-form
    {
        width: 360px;
        height: 100px;
        padding-left: 3px;
        padding-right: 3px;
        background-color: #FFF;
        border-radius: 3px;
        border: 1px solid #DDD;
        color: #968B8B;
        font-size: 15px;
        font-family: "Open_sans";
        resize: none;
    }
</style>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Edit widget'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/widgets/list') ?>" class="action undo"></a></li>
            <li><a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/widgets/delete',array('id' => $widget->id)); ?>" class="action del"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content page-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit widget'); ?></span>
            <?php
            if($widget->type_id==7):
            ?>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/bannerimages',array('id' => $widget->id)); ?>"><?php echo ATrl::t()->getLabel('Banner images'); ?></a>
                <a href="<?php echo Yii::app()->createUrl('admin/widgets/edit',array('id' => $widget->id)); ?>" class="active"><?php echo ATrl::t()->getLabel('Widget settings'); ?></a>
            <?php
            endif;
            ?>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'edit-widget','enableAjaxValidation'=>true,'htmlOptions'=>array('data-update_url' => Yii::app()->createUrl('/admin/menu/AjaxContentItemsByType')),'clientOptions' => array('validateOnSubmit'=>true))); ?>
            <div class="tabs">
                <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="WidgetForm[custom_name][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="<?php echo $widget->getTrl($language->id)->custom_name; ?>" /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Text'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value">
                                <textarea class="text-input-in-form" name="WidgetForm[custom_html][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your custom HTML or text'); ?>"><?php echo $widget->getTrl($language->id)->custom_html; ?></textarea>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </div><!--/tabs-->

            <table>
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'label'); ?></td>
                    <td class="value"><?php echo $form->textField($form_model,'label',array('placeholder' => ATrl::t()->getLabel('label'), 'value' => $widget->label)); ?></td>
                </tr>
<!--                <tr>-->
<!--                    <td class="label">--><?php //echo $form->labelEx($form_model,'type_id'); ?><!--</td>-->
<!--                    <td class="value">-->
<!--                        --><?php //echo $form->dropDownList($form_model,'type_id',$types,array('class'=>'load-items-selector','options' => array($widget->type_id =>array('selected'=>true))));?>
<!--                    </td>-->
<!--                </tr>-->
                <tr>
                    <td class="label"><?php echo $form->labelEx($form_model,'template_name'); ?></td>
                    <td class="value">
                        <?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>'load-items-selector','options' => array($widget->template_name =>array('selected'=>true))));?>
                    </td>
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
                        <?php echo $form->error($form_model,'type_id',array('class'=>'float-right errorMessage')); ?>
                        <?php echo $form->error($form_model,'template_name',array('class'=>'float-right errorMessage')); ?>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>