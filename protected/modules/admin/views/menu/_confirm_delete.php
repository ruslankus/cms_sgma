<?php /* @var $link string */ ?>
<div class="message"><?php echo ATrl::t()->getMsg('Are you sure ?'); ?></div>
<a href="#" class="button cancel"><?php echo ATrl::t()->getLabel('Cancel'); ?></a>
<a href="<?php echo $link; ?>" class="button confirm unique-class-name"><?php echo ATrl::t()->getLabel('Confirm'); ?></a>