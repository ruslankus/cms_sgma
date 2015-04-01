<?php /* @var $registered array */ ?>
<?php /* @var $all ExtSystemWidget[]|ExtMenu[]  */ ?>
<?php /* @var $objects ExtSystemWidget[]|ExtMenu[] */ ?>

<form>
    <div class="row">
        <?php $count = 0; ?>
        <?php foreach($registered as $position_id => $array): ?>
        <?php $count ++; ?>
        <?php $title = $array['title']; ?>
        <?php $objects = $array['objects']; ?>
        <?php $addedIds = $array['keys']; ?>

        <div class="cell">
            <div class="widget">
                <div class="widget-header"><?php echo $title; ?></div>
                <div class="widget-content">

                    <?php foreach($objects as $object): ?>
                        <div class="item">
                            <span><?php echo $object->label; ?></span>
                            <a href="<?php echo Yii::app()->createUrl('admin/positions/move',array('rt' => $object->registration_type, 'id' => $object->id, 'pos' => $position_id, 'dir' => 'down')); ?>" class="move-down move"><i class="ficoned arrow-down"></i></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/positions/move',array('rt' => $object->registration_type, 'id' => $object->id, 'pos' => $position_id, 'dir' => 'up')); ?>" class="move-up move"><i class="ficoned arrow-up"></i></a>
                            <a href="<?php echo Yii::app()->createUrl('admin/positions/delete',array('rt' => $object->registration_type, 'id' => $object->id, 'pos' => $position_id)) ?>" class="iconed delete"></a>

                            <select disabled name="name">
                                <option value="<?php echo $object->registration_type.','.$object->id; ?>"><?php echo $object->label; ?></option>
                            </select>
                        </div><!--/item-->
                    <?php endforeach; ?>

                    <?php $available = array(); ?>
                    <?php foreach($all as $obj): ?>
                        <?php if(!in_array(array($obj->registration_type,$obj->id),$addedIds)): ?>
                            <?php $available[] = $obj; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if(!empty($available)): ?>
                    <div class="item">
                        <span><?php echo ATrl::t()->getLabel('Select widget'); ?></span>
                        <a style="visibility: hidden;" href="#" class="move-down"><i class="ficoned arrow-down"></i></a>
                        <a style="visibility: hidden;"  href="#" class="move-up"><i class="ficoned arrow-up"></i></a>
                        <a style="visibility: hidden;"  href="#" class="iconed delete"></a>
                        <select name="name" class="selector-of-widget">
                            <option value="0,0,0"></option>
                            <?php foreach($available as $obj): ?>
                                <?php if(!in_array(array($obj->registration_type,$obj->id),$addedIds)): ?>
                                    <option value="<?php echo $obj->registration_type.','.$obj->id.','.$position_id; ?>"><?php echo $obj->label; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div><!--/item-->
                    <?php endif; ?>

                </div><!--/widget-content-->
            </div><!--/widget-->
        </div><!--/cell-->
        <?php if($count == 2): ?></div><div class="row"><?php $count = 0;?><?php endif; ?>
        <?php endforeach; ?>
    </div><!--/row-->

    <input type="submit" value="Save" class="save float-left" />
</form>