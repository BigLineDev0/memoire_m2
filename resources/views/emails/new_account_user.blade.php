<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .card { background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 3px 6px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; }
        .btn { display: inline-block; background: #3498db; color: #fff; padding: 10px 20px; border-radius: 5px; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Bonjour {{ $user->prenom }} {{ $user->name }},</h2>
        <p>Votre compte a été créé sur notre plateforme.</p>
        <p><strong>Email :</strong> {{ $user->email }}</p>
        <p><strong>Mot de passe :</strong> {{ $password }}</p>
        <p><a href="{{ url('/') }}" class="btn">Se connecter</a></p>
        <p style="color: #888;">Merci,<br>L'équipe Support</p>
    </div>
</body>
</html>
