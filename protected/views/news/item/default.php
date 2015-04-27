<?php /* @var $this NewsController */ ?>
<?php /* @var $content array */ ?>

<h1><?php echo $content['trl_name']; ?></h1>
<p><?php echo $content['trl_summary']; ?></p>
<p><?php echo $content['trl_text']; ?></p>

<?php foreach($content['images'] as $imageArr): ?>
    <img width="250" src="<?php echo $imageArr['url']; ?>">
<?php endforeach ?>