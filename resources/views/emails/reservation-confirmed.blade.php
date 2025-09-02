<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de réservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .header {
            background: #2563eb;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .header img {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        h2 {
            color: #2563eb;
            margin-bottom: 15px;
        }
        .details {
            margin: 20px 0;
            border-collapse: collapse;
            width: 100%;
        }
        .details td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .footer {
            background: #f4f7fa;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
        }
        @media (max-width: 600px) {
            .content {
                padding: 20px;
            }
            h2 {
                font-size: 20px;
            }
            .btn {
                display: block;
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <h1>Réservation Confirmée</h1>
        </div>

        <!-- CONTENT -->
        <div class="content">
            <h2>Bonjour {{ $reservation->user->prenom }} {{ $reservation->user->name }},</h2>
            <p> Votre réservation a été enregistrée avec succès. Voici le récapitulatif ::</p>

            <table class="details">
                <tr>
                    <td><strong>Laboratoire :</strong></td>
                    <td>{{ $reservation->laboratoire->nom }}</td>
                </tr>
                <tr>
                    <td><strong>Date :</strong></td>
                    <td>{{ $reservation->date->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td><strong>Équipements :</strong></td>
                    <td>
                        {{ $reservation->equipements->pluck('nom')->implode(', ') }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Horaire :</strong></td>
                    <td>
                        @foreach($reservation->horaires as $horaire)
                            {{ $horaire->debut }} - {{ $horaire->fin }}<br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td><strong>Objectif :</strong></td>
                    <td>{{ $reservation->objectif ?? 'Non renseigné' }}</td>
                </tr>
            </table>

            <a href="{{ url('/') }}" class="btn">Voir ma réservation</a>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p>Merci d'avoir réservé avec notre plateforme.<br>
            &copy; {{ date('Y') }} UMRED UFR Santé Thiès. Tous droits réservés.</p>
        </div>
    </div>
</body>
</html>
