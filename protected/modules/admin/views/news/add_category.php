<?php /* @var $languages ExtLanguages[] */ ?>
<?php /* @var $parent_items array */ ?>
<?php /* @var $statuses array */ ?>
<?php /* @var $form_model CategoryForm */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $this NewsController */ ?>
<?php /* @var $templates Array */ ?>

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
        <h1><?php echo ATrl::t()->getLabel('Categories'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->request->urlReferrer; ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content menu-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Add category'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <?php foreach($languages as $index => $language): ?>
                <span <?php if($index == 0): ?> class="active" <?php endif; ?>  data-lang="<?php echo $language->prefix; ?>"><?php echo $language->name; ?></span>
            <?php endforeach; ?>
        </div><!--/tab-line-->

        <div class="inner-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-cat-form','enableAjaxValidation'=>true,'htmlOptions'=>array('data-update_url' => Yii::app()->createUrl('/admin/menu/AjaxContentItemsByType')),'clientOptions' => array('validateOnSubmit'=>true))); ?>
                <div class="tabs">
                    <?php foreach($languages as $index => $language): ?>
                    <table data-tab="<?php echo $language->prefix; ?>" <?php if($index == 0): ?> class="active" <?php endif; ?>>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Title'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="CategoryForm[titles][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Your title'); ?>" value="" /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Keywords'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value"><input type="text" name="CategoryForm[keywords][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Keyword one, keyword two, keyword three'); ?>" value="" /></td>
                        </tr>
                        <tr>
                            <td class="label"><?php echo ATrl::t()->getLabel('Description'); ?> [<?php echo $language->prefix; ?>]:</td>
                            <td class="value">
                                <textarea class="text-input-in-form" name="CategoryForm[descriptions][<?php echo $language->id; ?>]" placeholder="<?php echo ATrl::t()->getLabel('Description'); ?>"></textarea>
                            </td>
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
                        <td class="label"><?php echo $form->labelEx($form_model,'parent_id'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'parent_id',$parent_items,array('class'=>''));?>
                        </td>
                    </tr>
                    <tr>
                        <td class="label"><?php echo $form->labelEx($form_model,'template_name'); ?></td>
                        <td class="value">
                            <?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>''));?>
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
                            <?php echo $form->error($form_model,'status_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'parent_id',array('class'=>'float-right errorMessage')); ?>
                            <?php echo $form->error($form_model,'template_name',array('class'=>'float-right errorMessage')); ?>
                        </td>
                    </tr>
                </table>
            <?php $this->endWidget(); ?>

        </div><!--/inner-content-->

    </div><!--/content translate-->
</main>