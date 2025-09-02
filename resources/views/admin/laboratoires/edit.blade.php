@extends('layouts.app')
@section('title', 'Modifier un Laboratoire')
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
            <h6 class="m-0 font-weight-bold text-primary">Modification d'un Laboratoire</h6>
        </div>
        <div class="card-body">
            <form id="addlaboForm" action="{{ route('admin.laboratoires.update', $laboratoire->id) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-8">
                        <label for="labo-nom" class="form-label">Nom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nom" class="form-control" id="labo-nom"
                               value="{{ old('nom', $laboratoire->nom) }}" required>
                        <div class="text-danger small">
                            @error('nom') {{ $message }} @enderror
                        </div>
                    </div>

                    <!-- localisation -->
                    <div class="col-md-4">
                        <label for="labo-localisation" class="form-label">Localisation <span
                                class="text-danger fw-bold">*</span></label>
                        <input type="text" name="localisation" class="form-control" id="labo-localisation"
                               value="{{ old('localisation', $laboratoire->localisation) }}" required>
                        <div class="text-danger small">
                            @error('localisation') {{ $message }} @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-3 mt-3">
                    <label for="labo-description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" id="labo-description" rows="3"
                              placeholder="Description">{{ old('description', $laboratoire->description) }}</textarea>
                    <div class="text-danger small">
                        @error('description') {{ $message }} @enderror
                    </div>
                </div>

                <!-- Statut -->
                <div class="mb-3">
                    <label class="form-label">Statut</label><br>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="statut" name="statut"
                               value="actif" {{ old('statut', $laboratoire->statut) === 'actif' ? 'checked' : '' }}>
                        <label class="form-check-label" for="statut">
                            {{ old('statut', $laboratoire->statut) === 'actif' ? 'Actif' : 'Inactif' }}
                        </label>
                    </div>
                    <div class="text-danger small">
                        @error('statut') {{ $message }} @enderror
                    </div>
                </div>

                <!-- Photo -->
                <div class="mb-3">
                    <label for="labo-photo" class="form-label">Photo</label><br>

                    <!-- Aperçu de la photo actuelle -->
                    @if($laboratoire->photo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$laboratoire->photo) }}" alt="Photo du laboratoire"
                                 class="img-thumbnail" width="200" id="current-photo">
                        </div>
                    @endif

                    <!-- Input file -->
                    <input type="file" name="photo" class="form-control-file" id="labo-photo" accept="image/*">

                    <!-- Aperçu dynamique -->
                    <div class="mt-2">
                        <img id="preview-photo" src="#" alt="Aperçu de la nouvelle photo"
                             class="img-thumbnail d-none" width="200">
                    </div>

                    <div class="text-danger small">
                        @error('photo') {{ $message }} @enderror
                    </div>
                </div>

                <!-- Btn soumission -->
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary fw-bold">Modifier</button>
                    &nbsp; &nbsp;
                    <a href="{{ route('admin.laboratoires.index') }}" class="btn btn-danger fw-bold">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Script pour l’aperçu dynamique de la photo --}}
    <script>
        document.getElementById('labo-photo').addEventListener('change', function (event) {
            let reader = new FileReader();
            reader.onload = function () {
                let preview = document.getElementById('preview-photo');
                preview.src = reader.result;
                preview.classList.remove('d-none');
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        });
    </script>
@endsection
