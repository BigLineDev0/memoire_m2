@extends('layouts.app')
@section('title', 'Ajouter un Equipement')
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
            <h6 class="m-0 font-weight-bold text-primary">Ajouter un ou des Équipement (s)</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.equipements.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <label>Nom (séparer par ";" pour plusieurs) <span class="text-danger fw-bold">*</span></label>
                        <input type="text" name="nom" class="form-control" placeholder="Ex : Microscope" required>
                    </div>

                    <div class="col-md-4">
                        <label>Statut <span class="text-danger fw-bold">*</span></label>
                        <select name="statut" class="form-control">
                            <option value="disponible">Disponible</option>
                            <option value="reserve">Réservé</option>
                            <option value="maintenance">Maintenance</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Description détaillée de l’équipement..."></textarea>
                </div>

                <div class="mb-3">
                    <label>Laboratoires associés <span class="text-danger fw-bold">*</span></label>
                    <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                        @foreach ($laboratoires as $lab)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" name="laboratoires[]" value="{{ $lab->id }}"> {{ $lab->nom }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.equipements.index') }}" class="btn btn-secondary">Retour</a>

            </form>
        </div>
    </div>

@endsection
