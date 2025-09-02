@extends('layouts.app')
@section('title', 'Modifier un Equipement')

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
            <h6 class="m-0 font-weight-bold text-primary">Modifier un Équipement</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.equipements.update', $equipement->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label>Nom <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nom" class="form-control"
                               value="{{ old('nom', $equipement->nom) }}"
                               placeholder="Ex : Microscope" required>
                    </div>

                    <div class="col-md-4">
                        <label>Statut <span class="text-danger fw-bold">*</span></label>
                        <select name="statut" class="form-control">
                            <option value="disponible" {{ $equipement->statut == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="reserve" {{ $equipement->statut == 'reserve' ? 'selected' : '' }}>Réservé</option>
                            <option value="maintenance" {{ $equipement->statut == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Description détaillée de l’équipement...">{{ old('description', $equipement->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Laboratoires associés <span class="text-danger fw-bold">*</span></label>
                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                        @foreach ($laboratoires as $lab)
                            <div class="form-check">
                                <input type="checkbox"
                                       class="form-check-input"
                                       name="laboratoires[]"
                                       value="{{ $lab->id }}"
                                       {{ in_array($lab->id, old('laboratoires', $equipement->laboratoires->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label class="form-check-label">{{ $lab->nom }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.equipements.index') }}" class="btn btn-secondary">Retour</a>
            </form>
        </div>
    </div>
@endsection
