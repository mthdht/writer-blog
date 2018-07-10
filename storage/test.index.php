<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<nav>
    <ul>
        <li>test</li>
        <li>de</li>
        <li>layout</li>
    </ul>
</nav>
<section class="main">
<div>
    contenu de <b>content</b> dans dossier <b>test</b> <br>
    variable title: <?= $title ?> <br>
    variable content: <?= $content; ?>
</div>
</section>
<section class="second">
<div>
    contenu de <b>contentBis</b> dans dossier <b>test</b> <br>
    variable title: <?= htmlspecialchars($title); ?> <br>
    variable content: <?= htmlspecialchars($content); ?>
</div>
</section>
</body>
</html>