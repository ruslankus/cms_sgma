<main>
    <div class="title-bar">
        <h1>Uploaded images</h1>
        <ul class="actions">
            <li><a href="" class="action undo" data-id="1"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content editor">
        <div class="header"><span>Some title</span></div><!--/header-->
        <div class="inner-content">
            <form>
                <?php if (Yii::app()->user->hasFlash('error')): ?>
                    <div class="message">
                        <?php echo CHtml::encode(Yii::app()->user->getFlash('error')); ?>
                    </div>
                <?php endif;?>
                <div class="images">

                    <?php foreach($objImgs as $objImg):?>
                        <div class="image">
                            <img src="/uploads/images/<?php echo $objImg->filename; ?>" alt="" />
                            <input type="checkbox" name="image[<?php echo $objImg->id?>]" value="1"/>
                            <a href="#" data-id="<?php echo $objImg->id; ?>" class="delete"></a>
                            <a href="#" class="edit"></a>
                        </div><!--/image-->
                    <?php endforeach; ?>


                </div><!--/images-->



                <a href="#" class="add-images"></a>
                <input type="submit" class="delete-images" disabled="disabled" value=" " />
            </form>
        </div><!--/inner-content-->
        <?php if($showPaginator):?>
            <div class="pagination" style="border:none  ">
                <?php for($p=1; $p <= $totalPages; $p++): ?>
                    <?php if($p == $currentPage):?>
                        <?php echo CHtml::link($p,array('/admin/gallery/index',
                            'page'=> $p),array('class'=>'active')); ?>
                    <?php else:?>
                        <?php echo CHtml::link($p,array('/admin/gallery/index',
                            'page'=> $p)); ?>
                    <?php endif;?>
                <?php endfor;?>

            </div><!--/pagination-->
        <?php endif;?>
    </div><!--/content editor-->
</main>

