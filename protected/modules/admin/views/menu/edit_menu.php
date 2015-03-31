<?php /* @var $this MenuController */ ?>
<?php /* @var $form CActiveForm */ ?>
<?php /* @var $form_model MenuForm */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $statuses array() */ ?>
<?php /* @var $menu ExtMenu */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Menu'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('/admin/menu/list'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->
    <div class="content editor">
        <div class="header"><span><?php echo ATrl::t()->getLabel('Edit menu'); ?></span></div><!--/header-->
        <div class="editor-content">
            <?php $form=$this->beginWidget('CActiveForm', array('id' =>'add-form','enableAjaxValidation'=>false,'htmlOptions'=>array())); ?>
                <table>
                    <tr>
                        <td><?php echo $form->label($form_model,'label'); ?></td>
                        <td><?php echo $form->textField($form_model,'label',array('value' => $menu->label)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->label($form_model,'template_name'); ?></td>
                        <td><?php echo $form->dropDownList($form_model,'template_name',$templates,array('class'=>'','options' => array($menu->template_name =>array('selected'=>true))));?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->label($form_model,'status_id'); ?></td>
                        <td><?php echo $form->dropDownList($form_model,'status_id',$statuses,array('class'=>'','options' => array($menu->status_id =>array('selected'=>true))));?></td>
                    </tr>
                </table>
                <?php echo CHtml::submitButton('Submit',array('class' => 'float-left', 'id' => 'save-label')); ?>
                <div class="errorMessage float-left">
                    <?php echo $form->error($form_model,'label'); ?>
                    <?php echo $form->error($form_model,'status_id'); ?>
                    <?php echo $form->error($form_model,'template_name'); ?>
                </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</main>