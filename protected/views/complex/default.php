<?php /* @var $content array */ ?>

<h1><?php echo $content['trl_name']; ?></h1>
<p><?php echo $content['trl_text']; ?></p>

<?php foreach($content['images'] as $imageArr): ?>
    <img width="150" src="<?php echo $imageArr['url']; ?>">
    <span><?php echo $imageArr['trl_caption']; ?></span>
<?php endforeach; ?>

<?php foreach($content['groups'] as $groupArr): ?>
    <h3><u><?php echo $groupArr['trl_name']; ?></u></h3>
    <p><?php echo $groupArr['trl_description']; ?></p>

    <?php foreach($groupArr['fields'] as $fieldArr): ?>
        <h4>
            <?php echo $fieldArr['trl_title'] ?> -
            <?php if(is_array($fieldArr['value'])): ?>
                <?php if(isset($fieldArr['value']['url'])): ?>
                    <img width="100" src="<?php echo $fieldArr['value']['url']; ?>">
                <?php else: ?>
                    <?php echo $fieldArr['value']['option_name']; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php echo $fieldArr['value'] ?>
            <?php endif; ?>
        </h4>
        <br>
    <?php endforeach; ?>
<?php endforeach; ?>
