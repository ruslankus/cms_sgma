<?php /* @var $this NewsController */ ?>
<?php /* @var $content array */ ?>

<h1><?php echo $content['trl_name'] ?></h1>

<?php foreach($content['items'] as $itemArr): ?>
    <a href="<?php echo $itemArr['url']; ?>"><?php echo $itemArr['trl_name']; ?></a><br>
    <p><?php echo $itemArr['trl_summary'];?></p>
    <p><?php echo $itemArr['trl_text']; ?></p><br>
    <?php foreach($itemArr['images'] as $imageArr): ?>
        <img width="150" src="<?php echo $imageArr['url']; ?>">
    <?php endforeach ?>
    <hr>
<?php endforeach; ?>