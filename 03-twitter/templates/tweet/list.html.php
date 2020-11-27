<h1><?php $firstname ?></h1>

<ul>
    <?php foreach ($tweets as $tweet) : ?>
    <li><?= $tweet->content ?></li>
    <?php endforeach; ?>
</ul>