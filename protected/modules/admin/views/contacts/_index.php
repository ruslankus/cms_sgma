<?php foreach($objContacts as $contact): ?>
    <div class="menu-table" data-menu="<?php echo $contact->id ?>">
        <div class="cell draggable"><span class="ficoned drag"></span></div>
        <div class="cell block">
            <div class="inner-table">
                <div class="row root" data-id="<?php echo $contact->id; ?>">
                    <div class="name"><a href="<?php echo Yii::app()->createUrl('admin/contacts/blocks',array('group' => $contact->id)); ?>"><?php echo $contact->label; ?></a></div>
                    <div class="type"><?php echo $contact->priority;?></div>
                    <div class="action">
                        <a href="/<?php echo $currLng?>/admin/contacts/editcontent/<?php echo $contact->id?>" class="edit"><span class="ficoned pencil"></span></a>
                        <a data-message="<?php echo ATrl::t()->getLabel('Are your sure ?'); ?>" data-yes="<?php echo ATrl::t()->getLabel('Delete'); ?>" data-no="<?php echo ATrl::t()->getLabel('Cancel'); ?>" href="<?php echo Yii::app()->createUrl('/admin/contacts/DeleteContact',array('id' => $contact->id)); ?>" class="delete"><span class="ficoned trash-can"></span></a>
                    </div>
                </div><!--/row root-->
            </div><!--/inner-table-->
        </div><!--/menu-table-->
    </div><!--table-->
<?php endforeach; ?>