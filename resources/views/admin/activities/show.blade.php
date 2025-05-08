@extends('layouts.admin')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails de l'activité</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.activities.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Informations générales</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th style="width: 30%">ID</th>
                                            <td>{{ $activity->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Description</th>
                                            <td>{{ $activity->description }}</td>
                                        </tr>
                                        <tr>
                                            <th>Type de log</th>
                                            <td>{{ $activity->log_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td>{{ $activity->created_at->format('d/m/Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Utilisateur</th>
                                            <td>
                                                @if($activity->causer)
                                                    {{ $activity->causer->name }} ({{ $activity->causer->email }})
                                                @else
                                                    Système
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Sujet</th>
                                            <td>
                                                @if($activity->subject)
                                                    {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                                    @if(method_exists($activity->subject, 'getActivitySubjectDescription'))
                                                        <br>{{ $activity->subject->getActivitySubjectDescription() }}
                                                    @endif
                                                @else
                                                    Aucun
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Propriétés</h5>
                                </div>
                                <div class="card-body">
                                    @if($activity->properties && count($activity->properties) > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Clé</th>
                                                        <th>Valeur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($activity->properties as $key => $value)
                                                        @if($key !== 'attributes' && $key !== 'old')
                                                            <tr>
                                                                <td>{{ $key }}</td>
                                                                <td>
                                                                    @if(is_array($value) || is_object($value))
                                                                        <pre>{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                                                    @else
                                                                        {{ $value }}
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">Aucune propriété supplémentaire</p>
                                    @endif
                                </div>
                            </div>

                            @if($activity->properties && ($activity->properties->has('attributes') || $activity->properties->has('old')))
                                <div class="card mt-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Changements</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Attribut</th>
                                                        <th>Ancienne valeur</th>
                                                        <th>Nouvelle valeur</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($activity->properties->has('attributes') && $activity->properties->has('old'))
                                                        @foreach($activity->properties->get('attributes') as $key => $value)
                                                            @php
                                                                $oldValue = $activity->properties->get('old')[$key] ?? null;
                                                            @endphp
                                                            @if($value != $oldValue)
                                                                <tr>
                                                                    <td>{{ $key }}</td>
                                                                    <td>{{ $oldValue ?? '-' }}</td>
                                                                    <td>{{ $value ?? '-' }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="3" class="text-center">Aucun changement détecté</td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    @can('admin.activities.delete')
                        <div class="mt-4">
                            <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette activité?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Supprimer cette activité
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
