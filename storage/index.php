<?php ob_start(); ?>
voici le blog <br>
titre : <?= $title ?>
<?php $content = ob_get_clean(); ?>
<?php ob_start(); ?>
Voici le contenu bis
contenu : <?= $content; ?>
<?php $contentBis = ob_get_clean(); ?>
<?php require '/home/mthdht/sites/lab/myProject/formation-OC/projet8-blog/projet/blog/ressources/layouts/app.php'; 