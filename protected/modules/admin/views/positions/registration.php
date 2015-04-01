<?php /* @var $registered array */ ?>
<?php /* @var $objects ExtSystemWidget[]|ExtMenu[] */ ?>
<?php /* @var $all ExtSystemWidget[]|ExtMenu[]  */ ?>
<?php /* @var $this PositionsController */ ?>

<main>
    <div class="title-bar">
        <h1><?php echo ATrl::t()->getLabel('Settings'); ?></h1>
        <ul class="actions">
            <li><a href="" class="action undo"></a></li>
            <li><a href="" class="action del" data-id="1"></a></li>
        </ul>
    </div><!--/title-bar-->

    <div class="content widget-content">

        <div class="header">
            <span><?php echo ATrl::t()->getLabel('Theme settings'); ?></span>
        </div><!--/header-->

        <div class="tab-line">
            <span><a href="#"><?php echo ATrl::t()->getLabel('Templates'); ?></a></span>
            <span class="active"><a href="#"><?php echo ATrl::t()->getLabel('Positions'); ?></a></span>
            <span><a href="#"><?php echo ATrl::t()->getLabel('General settings'); ?></a></span>
        </div><!--/tab-line-->

        <div class="inner-content">
            <form>
                <div class="row">
                    <?php foreach($registered as $position_id => $array): ?>
                        <?php $title = $array['title']; ?>
                        <?php $objects = $array['objects']; ?>
                        <div class="cell">
                            <div class="widget">
                                <div class="widget-header"><?php echo $title; ?></div>
                                <div class="widget-content">

                                    <?php foreach($objects as $object): ?>
                                        <div class="item">
                                            <span data-type="<?php echo $object->registration_type; ?>" data-id="<?php echo $object->id; ?>"><?php echo $object->label; ?></span>
                                            <a href="#" class="move-down"><i class="ficoned arrow-down"></i></a>
                                            <a href="#" class="move-up"><i class="ficoned arrow-up"></i></a>
                                            <a href="#" class="iconed delete"></a>

                                            <select name="name">
                                                <option value="<?php echo $object->registration_type.','.$object->id; ?>"><?php echo $object->label; ?></option>
                                                <?php foreach($all as $obj): ?>
                                                    <option value="<?php echo $obj->registration_type.','.$obj->id; ?>"><?php echo $obj->label; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div><!--/item-->
                                    <?php endforeach; ?>

                                </div><!--/widget-content-->
                            </div><!--/widget-->
                        </div><!--/cell-->
                    <?php endforeach; ?>
                </div><!--/row-->

                <input type="submit" value="Save" class="save float-left" />
            </form>
        </div><!--/inner-content-->

    </div><!--/content menu-->
</main>