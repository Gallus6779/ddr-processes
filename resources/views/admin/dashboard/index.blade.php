@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: none;
    border-radius: 15px;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}

.activity-timeline .timeline-item {
    position: relative;
    padding-left: 45px;
    margin-bottom: 20px;
}

.activity-timeline .timeline-icon {
    position: absolute;
    left: 0;
    top: 0;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.recent-data-card {
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    border: none;
}

.recent-data-card .table {
    margin-bottom: 0;
}

.recent-data-card .table td,
.recent-data-card .table th {
    padding: 1rem;
    vertical-align: middle;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
}
</style>
@endpush

@section('main')
<div class="container-fluid">
    <!-- Breadcrumb -->
    <x-breadcrumb>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </x-breadcrumb>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Utilisateurs</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $totalUsers }}</h2>
                            <div class="mt-2">
                                <span class="text-white-50">+12% ce mois</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Consommations</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $recentConsumptions->count() }}</h2>
                            <div class="mt-2">
                                <span class="text-white-50">Dernières 24h</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-gas-pump"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Rôles</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $totalRoles }}</h2>
                            <div class="mt-2">
                                <span class="text-white-50">Configuration système</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stat-card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Permissions</h6>
                            <h2 class="mb-0 font-weight-bold">{{ $totalPermissions }}</h2>
                            <div class="mt-2">
                                <span class="text-white-50">Sécurité système</span>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row">
        <!-- Recent Consumptions -->
        <div class="col-xl-8 mb-4">
            <div class="card recent-data-card h-100">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Consommations Récentes</h5>
                        <a href="{{ route('admin.consumptions.index') }}" class="btn btn-sm btn-outline-primary">
                            Voir tout <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Client</th>
                                    <th>Station</th>
                                    <th>Quantité</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentConsumptions as $consumption)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary-subtle rounded-circle me-3">
                                                <span class="avatar-title">{{ substr($consumption->customer->firstname, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $consumption->customer->firstname }} {{ $consumption->customer->lastname }}</h6>
                                                <small class="text-muted">ID: {{ $consumption->customer->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ optional($consumption->card->station)->name ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ number_format($consumption->quantity, 2) }} L</strong>
                                    </td>
                                    <td>
                                        {{ $consumption->date_consumption instanceof \DateTime
                                            ? $consumption->date_consumption->format('d/m/Y')
                                            : date('d/m/Y', strtotime($consumption->date_consumption)) }}
                                    </td>
                                    <td>
                                        <span class="status-badge bg-success text-white">
                                            Validée
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-inbox fa-2x mb-3"></i>
                                            <p class="mb-0">Aucune consommation récente</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="col-xl-4 mb-4">
            <div class="card recent-data-card h-100">
                <div class="card-header bg-transparent">
                    <h5 class="mb-0">Activités Système</h5>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        @forelse($recentActivities as $activity)
                        <div class="timeline-item">
                            <div class="timeline-icon bg-info">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div>
                                <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                <p class="mb-0 mt-1">{{ $activity->description }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-stream fa-2x mb-3"></i>
                            <p class="mb-0">Aucune activité récente</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
