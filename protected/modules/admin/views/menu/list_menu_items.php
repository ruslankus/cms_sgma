<?php /* @var $items array() */ ?>
<?php /* @var $children ExtMenuItem */ ?>
<?php /* @var $pages int  */ ?>
<?php /* @var $templates array() */ ?>
<?php /* @var $menu ExtMenu */ ?>


<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Items of '); ?>"<?php echo $menu->label; ?>"</h1>
        <ul class="actions">
            <li><a href="#" class="action add"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content">
        <div class="title-table">
            <div class="cell drag-drop"><?php echo ATrl::t()->getLabel('Drag and Drop'); ?></div>
            <div class="cell"><?php echo ATrl::t()->getLabel('Label'); ?></div>
            <div class="cell sequen"><?php echo ATrl::t()->getLabel('Order'); ?></div>
            <div class="cell type"><?php echo ATrl::t()->getLabel('Type'); ?></div>
            <div class="cell action"><?php echo ATrl::t()->getLabel('Actions'); ?>Action</div>
        </div><!--table-->

        <?php foreach($items as $item): ?>
            <div class="drags">
                <div class="menu-table">
                    <div class="cell draggable"><span class="iconed drag"></span></div>
                    <div class="cell block">
                        <div class="inner-table">

                            <?php foreach($item as $children): ?>
                                <?php if(!$children->hasParent()): ?>
                                    <div class="row root" data-id="<?php echo $children->id; ?>">
                                        <div class="name"><?php echo $children->label; ?></div>
                                        <div class="sequen"></div>
                                        <div class="type">News</div>
                                        <div class="action"></div>
                                    </div><!--/row root-->
                                <?php else: ?>
                                    <div class="row" data-id="<?php echo $children->id; ?>" data-parent="<?php echo $children->parent_id; ?>">
                                        <div class="name"><?php echo $children->label; ?></div>
                                        <div class="sequen">
                                            <a href="#" class="go-up"><span class="iconed arrow-up"></span></a>
                                            <a href="#" class="go-down"><span class="iconed arrow-down"></span></a>
                                        </div><!--/sequen-->
                                        <div class="type">News</div>
                                        <div class="action">
                                            <a href="#" class="edit"><span class="iconed pencil"></span></a>
                                            <a href="#" class="delete"><span class="iconed trash-can"></span></a>
                                        </div>
                                    </div><!--/row-->
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div><!--/inner-table-->
                    </div><!--/menu-table-->
                </div><!--table-->
            </div><!--/drags-->
        <?php endforeach; ?>


    </div><!--/content-->
    <div class="pagination">
        <a href="#" class="active">1</a>
        <a href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
    </div><!--/pagination-->
</main>