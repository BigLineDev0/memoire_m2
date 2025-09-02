{{-- resources/views/errors/unauthorized.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès non autorisé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            color: #fff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0px 5px 25px rgba(0,0,0,0.2);
        }
        .btn-custom {
            background-color: #0d6efd;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #0b5ed7;
            transform: scale(1.05);
        }
        .icon {
            font-size: 5rem;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card p-5 bg-white text-dark">
                    <div class="mb-4">
                        <i class="bi bi-shield-lock-fill icon"></i>
                    </div>
                    <h1 class="fw-bold">403</h1>
                    <h3 class="mb-3">Accès non autorisé</h3>
                    <p class="mb-4">
                        Vous n’avez pas les droits nécessaires pour accéder à cette page.
                        Si vous pensez qu’il s’agit d’une erreur, contactez l’administrateur.
                    </p>
                    <a href="{{ url()->previous() }}" class="btn btn-primary px-4">Retour</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>
</html>
