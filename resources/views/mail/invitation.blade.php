<!DOCTYPE html>
<html>
<head>
    <title>Invitation à rejoindre un groupe</title>
</head>
<body>
    <h1>Bonjour,</h1>
    <p>Vous avez été ajouté au groupe <strong>{{ $groupName }} </strong>.</p>
    <p>Si vous ne vous êtes pas encore inscrit sur notre plateforme, veuillez le faire en cliquant sur le lien ci-dessous pour rejoindre le groupe :</p>
    <a href="{{ ('$groupLink') }}">S'inscrire ici</a>
    <p>Merci !</p>
</body>
</html>
