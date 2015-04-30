<main>
    <div class="title-bar world">
        <h1>Edit page content</h1>
        <ul class="actions">
            <li><a href="" class="action undo"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content page-content">
        <div class="header">
            <span>Some title</span>
            <?php $prefix = SiteLng::lng()->getCurrLng()->prefix ?>

            <a href="/<?php echo $prefix  ?>/admin/pages/pagesetting/<?php echo $page_id; ?>" class="active">
                Page Setting
            </a>

            <a href="/<?php echo $prefix  ?>/admin/pages/editcontent/<?php echo $page_id; ?>" >
                Content
            </a>
        </div><!--/header-->

        <div class="inner-content">
            <div class="form-zone">
                <!--/ <form enctype="multipart/form-data"> -->
                <?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
                <table>
                    <?php if(!empty($arrSelect)): ?>
                    <tr>
                        <td class="label">Template:</td>
                        <td class="value">
                            <?php echo Chtml::dropDownList('template','',$arrSelect);?>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td class="label">Choose image:</td>
                        <td class="value">

                            <?php echo CHtml::activeFileField($model,'file', array(
                                'id'=>'file-input','data-label'=>'Browse...'
                            ))?>
                            <?php echo Chtml::error($model, 'file')?>

                        </td>
                    </tr>
                    <tr>
                        <td class="label"><strong>Caption:</strong></td>
                        <td class="value"></td>
                    </tr>
                    <?php foreach(SiteLng::lng()->getLngs() as $objLng):?>
                        <tr>
                            <td class="label"><?php echo $objLng->name?></td>
                            <td class="value">
                                <?php echo CHtml::activeTextField($model,"captions[{$objLng->prefix}]")?>
                                <?php echo CHtml::error($model,"captions[{$objLng->prefix}]") ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </table>
                <input type="submit" value="Save" />

                <?php echo CHtml::endForm(); ?>
            </div><!--/form-zone-->
            <div class="image-zone">
                <strong>Preview</strong>
                <?php if($elCount < 5):?>
                    <a href="#"  data-page="<?php echo $page_id; ?>" data-count="<?php echo $elCount ?>" data-prefix="<?php echo $lngPrefix?>" class="add-image">Add local image</a>
                <?php endif; ?>
                <div class="list">
                    <?php foreach($arrImages as $item):?>
                        <?php if(!empty($item)):?>
                            <div class="image">
                                <img src="/uploads/images/<?php echo $item['filename']?>" alt="" />
                                <a href="#" class="delete active" data-prefix="<?php echo $lngPrefix?>"
                                   data-page="<?php echo $page_id; ?>" data-id="<?php echo $item['link_id']; ?>"></a>
                            </div>
                        <?php else:?>
                            <div class="image">
                                <img src="<?php echo $this->assetsPath ?>/images/no-image-upload.png" alt="" />
                                <a href="#" class="delete"></a>
                            </div>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div><!--/list-->
            </div><!--/image-zone-->
        </div><!--/inner-content-->
    </div><!--/content translate-->
</main>
