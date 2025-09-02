@extends('layouts.app')
@section('title', 'Ajouter un Utilisateur')
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Nouvel Utilisateur</h6>
        </div>
        <div class="card-body">
            <form id="addlaboForm" action="{{ route('admin.utilisateurs.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="prenom" class="form-control" id="lprenom" placeholder="Prénom" required>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('prenom')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="name" class="form-control" id="nom" placeholder="Nom" required>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email <span class="text-danger fw-bold">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="number" name="telephone" class="form-control" id="telephone" placeholder="Téléphone">
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('telephone')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control" id="adresse" placeholder="Adresse">
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('adresse')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">Rôle <span class="text-danger fw-bold">*</span></label>
                        <select name="role" id="labo-role" class="form-control" required>
                            <option value="" disabled selected>-- Sélectionner un rôle --</option>
                            <option value="admin">Admin</option>
                            <option value="chercheur">Chercheur</option>
                            <option value="technicien">Technicien</option>
                        </select>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('role')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label><br>
                    <input type="file" name="photo" class="form-control-file" id="photo" accept="image/*">
                    <p class="error-message mt-2"></p>
                    <div class="text-danger small">
                        @error('photo')
                            {{ $message }}
                        @enderror
                    </div>

                    <!-- Aperçu de l'image -->
                    <div class="mt-3">
                        <img id="photo-preview" src="#" alt="Aperçu de la photo" class="img-fluid rounded shadow d-none" style="max-height: 200px;">
                    </div>
                </div>

                <!-- Boutons-->
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('photo').addEventListener('change', function (event) {
            let preview = document.getElementById('photo-preview');
            let file = event.target.files[0];

            if (file) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.classList.add('d-none');
            }
        });
    </script>

@endsection
