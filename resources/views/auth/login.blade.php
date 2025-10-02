<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Connexion - UMRED</title>

    <!-- Fonts + Styles -->
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    </style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row -->
                    <div class="row">
                        <!-- Image gauche -->
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>

                        <!-- Formulaire -->
                        <div class="col-lg-6">
                            <div class="p-5">
                                <!-- Logo -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('assets/img/logo/UMRED.png') }}" alt="Logo" style="height: 60px;">
                                </div>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bienvenue</h1>
                                </div>

                                <!-- Formulaire Laravel -->
                                <form class="user" method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- Email -->
                                    <div class="form-group">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               id="email" placeholder="Adresse email" required autofocus>
                                        @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group">
                                        <input type="password" name="password"
                                               class="form-control form-control-user @error('password') is-invalid @enderror"
                                               id="password" placeholder="Mot de passe" required>
                                        @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Remember Me -->
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember" class="custom-control-input" id="remember_me">
                                            <label class="custom-control-label" for="remember_me">Se souvenir de moi</label>
                                        </div>
                                    </div>

                                    <!-- Bouton login -->
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Connexion
                                    </button>
                                </form>

                                <hr>

                                <div class="text-center">
                                    @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                    @endif
                                </div>

                                <div class="text-center">
                                    @if (Route::has('register'))
                                        <a class="small" href="{{ route('register') }}">Créer un compte</a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- End Nested Row -->
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

</body>
</html>
