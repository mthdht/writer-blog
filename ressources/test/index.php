@extend('layouts.app')

@block('content')
<div>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="photo">
        <input type="submit">
    </form>
</div>
@endblock

@block('contentBis')
<div>
    contenu de <b>contentBis</b> dans dossier <b>test</b> <br>
    variable title: {{ $title }} <br>
    variable content: {{ $content }}
</div>
@endblock
