<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Système UMRED</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Rapport des Réservations et Maintenances</h2>

    <h3>Réservations</h3>
    <table>
        <thead>
            <tr>
                <th>Utilisateur</th>
                <th>Laboratoire</th>
                <th>Date</th>
                <th>Équipements</th>
                <th>Horaires</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservations as $r)
                <tr>
                    <td>{{ $r->user->name }}</td>
                    <td>{{ $r->laboratoire->nom }}</td>
                    <td>{{ $r->date }}</td>
                    <td>
                        {{ $r->equipements->pluck('nom')->join(', ') }}
                    </td>
                    <td>
                        {{ $r->horaires->map(fn($h) => $h->debut.'-'.$h->fin)->join(', ') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Maintenances</h3>
    <table>
        <thead>
            <tr>
                <th>Équipement</th>
                <th>Signalé par</th>
                <th>Date</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $m)
                <tr>
                    <td>{{ $m->equipement->nom }}</td>
                    <td>{{ $m->user->name }}</td>
                    <td>{{ $m->created_at->format('d/m/Y à H:i') }}</td>
                    <td>{{ ucfirst($m->statut) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>