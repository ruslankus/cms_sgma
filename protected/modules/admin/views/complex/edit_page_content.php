<?php /* @var $this ComplexController */ ?>
<?php /* @var $item ExtComplexPage */ ?>
<?php /* @var $languages Languages[] */ ?>
<?php /* @var $currentLng Languages */ ?>
<?php /* @var $itemTrl ComplexPageTrl */ ?>

<style>
    .content .inner-editor textarea {
        width: 100%;
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
    .notification
    {
        visibility: hidden;
    }
</style>

<main>
    <div class="title-bar world">
        <h1><?php echo ATrl::t()->getLabel('Custom pages'); ?></h1>
        <ul class="actions">
            <li><a href="<?php echo Yii::app()->createUrl('admin/complex/pages'); ?>" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content">
        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Edit item'); ?></span>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/editprodfields',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attributes'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/editpageattrgroup',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Attribute groups'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/edititemtrl',array('id' => $item->id)); ?>" class="active"><?php echo ATrl::t()->getLabel('Content'); ?></a>
            <a href="<?php echo Yii::app()->createUrl('admin/complex/edit',array('id' => $item->id)); ?>"><?php echo ATrl::t()->getLabel('Settings'); ?></a>
        </div><!--/header-->
        <form method="post" action="<?php echo Yii::app()->createUrl('admin/complex/edititemtrl',array('id' => $item->id)); ?>" class="main-form-trl">
            <div class="inner-top">
                <select name="language" id="styled-language-editor" class="float-left">
                    <?php foreach($languages as $language): ?>
                    <option value="<?php echo Yii::app()->createUrl('admin/complex/edititemtrl',array('id' => $item->id, 'lng' => $language->id)); ?>"><?php echo $language->name; ?></option>
                    <?php endforeach; ?>
                </select>
                <span class="notification"><?php echo ATrl::t()->getMsg("The changes are not saved"); ?></span>
            </div><!--/inner-top-->
            <div class="inner-editor">
                <table class="table-of-trl">
                    <tr>
                        <td class="label"><label for="title"><?php echo ATrl::t()->getLabel('Title'); ?></label></td>
                        <td class="value"><input id="title" type="text" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][title]" value="<?php echo $itemTrl->title; ?>"></td>
                    </tr>
                    <tr>
                        <td class="label"><label for="summary"><?php echo ATrl::t()->getLabel('Keywords'); ?></label></td>
                        <td class="value"><textarea id="summary" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][keywords]"><?php echo $itemTrl->meta_keywords; ?></textarea></td>
                    </tr>
                    <tr>
                        <td class="label"><label for="text"><?php echo ATrl::t()->getLabel('Text'); ?></label></td>
                        <td class="value"><textarea id="text" name="ComplexPageFormTrl[<?php echo $currentLng->id; ?>][text]"><?php echo $itemTrl->text; ?></textarea></td>
                    </tr>
                </table>
                <input type="submit" value="Save" />
            </div><!--/inner-editor-->
        </form>
    </div><!--/content translate-->
</main>