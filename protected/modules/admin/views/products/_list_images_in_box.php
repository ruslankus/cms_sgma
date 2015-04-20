<?php /* @var $objPhotos ExtImages[] */ ?>
<div class="wrap">
    <div class="middle" id="model">
        <div class="content-images">
            <span class="header"><?php echo ATrl::t()->getLabel('Choose image'); ?></span>
            <div class="images">
                <?php foreach ($objPhotos as $image):?>
                    <div class="image">
                        <img class="selectable-image" data-id="<?php echo $image->id; ?>" src="<?php echo $image->getUrl(); ?>" alt="<?php $image->label; ?>"/>
                    </div><!--/image-->
                <?php endforeach;?>
            </div><!--/images-->
            <a href="#" class="cancel-images"><?php echo ATrl::t()->getLabel('Cancel'); ?></a>
        </div><!--/content-->
    </div>
</div><!--/wrap/middle-->