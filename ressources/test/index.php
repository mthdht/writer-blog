@extend('layouts.app')

@block('content')
<div>
    contenu de <b>content</b> dans dossier <b>test</b> <br>
    variable title: <?= $title ?> <br>
    variable content: <?= $content; ?>
</div>
@endblock

@block('contentBis')
<div>
    contenu de <b>contentBis</b> dans dossier <b>test</b> <br>
    variable title: <?= $title; ?> <br>
    variable content: <?= $content; ?>
</div>
@endblock
