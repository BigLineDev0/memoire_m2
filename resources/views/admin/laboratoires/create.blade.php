@extends('layouts.app')
@section('title', 'Ajouter un Laboratoire')
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
            <h6 class="m-0 font-weight-bold text-primary">Nouveau Laboratoire</h6>
        </div>
        <div class="card-body">
            <form id="addlaboForm" action="{{ route('admin.laboratoires.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <label for="labo-nom" class="form-label">Nom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nom" class="form-control" id="labo-nom" placeholder="Nom du laboratoire" required>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('nom')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <!-- localisation -->
                    <div class="col-md-4">
                        <label for="labo-localisation" class="form-label">Localisation <span
                                class="text-danger fw-bold">*</span></label>
                        <input type="text" name="localisation" class="form-control" id="labo-localisation"
                            placeholder="Localisation" required>
                        <p class="error-message mt-2"></p>
                        <div class="text-danger small">
                            @error('localisation')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="labo-description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="labo-description" rows="3" placeholder="Description"></textarea>
                    <p class="error-message mt-2"></p>
                    <div class="text-danger small">
                        @error('description')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label for="labo-photo" class="form-label">Photo</label><br>
                    <input type="file" name="photo" class="form-control-file" id="labo-photo" accept="image/*">
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

                <!-- Boutons -->
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.laboratoires.index') }}" class="btn btn-secondary">Annuler</a>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('labo-photo').addEventListener('change', function (event) {
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
