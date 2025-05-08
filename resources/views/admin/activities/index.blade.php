@extends('layouts.admin')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Journal des activités</h3>
                </div>
                <div class="card-body">
                    <!-- DEBUG -->
                    <div class="alert alert-info">
                        <h5>Activités récupérées: {{ $activities->total() }}</h5>
                        <p>Table utilisée: {{ config('activitylog.table_name') }}</p>
                    </div>

                    <!-- Filtres -->
                    <form action="{{ route('admin.activities.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="log_name">Type de log</label>
                                    <select name="log_name" id="log_name" class="form-control">
                                        <option value="">Tous</option>
                                        @foreach($logNames as $name)
                                            <option value="{{ $name }}" {{ $logName == $name ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">Date début</label>
                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ $dateFrom }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">Date fin</label>
                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ $dateTo }}">
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filtrer</button>
                                <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary ml-2">Réinitialiser</a>
                            </div>
                        </div>
                    </form>

                    <!-- Tableau des activités -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Utilisateur</th>
                                    <th>Type de log</th>
                                    <th>Sujet</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ $activity->description }}</td>
                                        <td>
                                            @if($activity->causer)
                                                {{ $activity->causer->name }}
                                            @else
                                                Système
                                            @endif
                                        </td>
                                        <td>{{ $activity->log_name }}</td>
                                        <td>
                                            @if($activity->subject)
                                                {{ class_basename($activity->subject_type) }} #{{ $activity->subject_id }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Détails
                                            </a>
                                            @can('admin.activities.delete')
                                                <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette activité?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Supprimer
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Aucune activité trouvée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $activities->appends(request()->query())->links() }}
                    </div>

                    <!-- Actions -->
                    @can('admin.activities.delete')
                        <div class="mt-4">
                            <form action="{{ route('admin.activities.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('ATTENTION: Êtes-vous sûr de vouloir supprimer TOUS les journaux d\'activité? Cette action est irréversible!')">
                                @csrf
                                <input type="hidden" name="confirm" value="true">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Vider tous les journaux
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
