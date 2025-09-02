@extends('layouts.app')
@section('title', 'Modifier un utilisateur')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Modifier Utilisateur</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.utilisateurs.update', $utilisateur->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Prénom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="prenom" value="{{ $utilisateur->prenom }}" class="form-control"
                            required>
                    </div>
                    <div class="col-md-6">
                        <label>Nom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="name" value="{{ $utilisateur->name }}" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Email <span class="text-danger fw-bold">*</span></label>
                        <input type="email" name="email" value="{{ $utilisateur->email }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Téléphone</label>
                        <input type="number" name="telephone" value="{{ $utilisateur->telephone }}" class="form-control">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Adresse</label>
                        <input type="text" name="adresse" value="{{ $utilisateur->adresse }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Rôle <span class="text-danger fw-bold">*</span></label>
                        <select name="role" class="form-control" required>
                            <option value="admin" {{ $utilisateur->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="chercheur" {{ $utilisateur->role == 'chercheur' ? 'selected' : '' }}>Chercheur
                            </option>
                            <option value="technicien" {{ $utilisateur->role == 'technicien' ? 'selected' : '' }}>Technicien
                            </option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Statut du compte</label><br>
                        <select name="status" class="form-control">
                            <option value="active" {{ $utilisateur->status === 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="suspendu" {{ $utilisateur->status === 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Photo</label><br>
                    <input type="file" name="photo" class="form-control-file" accept="image/*">
                    @if ($utilisateur->photo)
                        <img src="{{ asset('storage/' . $utilisateur->photo) }}" class="img-thumbnail mt-2" width="100">
                    @endif

                    <!-- Aperçu de l'image -->
                    <div class="mt-3">
                        <img id="photo-preview" src="#" alt="Aperçu de la photo" class="img-thumbnail mt-2" width="100">
                    </div>
                </div>

                <button class="btn btn-primary">Mettre à jour</button>
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
