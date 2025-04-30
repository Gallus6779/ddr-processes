@extends('layouts.admin')

@section('title', 'Consumptions')

@push('styles')
<style>
.consumption-card {
    border-radius: 15px;
    border: none;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
    transition: background-color 0.2s ease;
}

.import-btn {
    transition: transform 0.2s ease;
    border-radius: 10px;
    padding: 10px 20px;
}

.import-btn:hover {
    transform: translateY(-2px);
}

.modal-content {
    border-radius: 15px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

.modal-footer {
    border-top: 1px solid rgba(0,0,0,0.05);
}

.format-list {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1.5rem;
    margin: 1rem 0;
}

.format-list li {
    margin-bottom: 0.75rem;
    display: flex;
    align-items: flex-start;
}

.format-list li i {
    margin-right: 0.5rem;
    margin-top: 0.25rem;
    color: #4e73df;
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
        <li class="breadcrumb-item">
            <a href="{{ route('discounts.discounts.read') }}">
                <i class="fas fa-percentage mr-1"></i>Ristournes
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Consommations
        </li>
    </x-breadcrumb>

    <!-- Header Section -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-2">Consommation des Clients</h1>
            <p class="mb-0 text-muted">Consultez la consommation des clients et importez de nouvelles données facilement.</p>
        </div>
        <div>
            <button class="btn btn-primary import-btn" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-import mr-2"></i>
                Importer les consommations
            </button>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-lg" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-lg" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    <!-- Main Content -->
    <div class="card consumption-card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>Client</th>
                            <th>Contact</th>
                            <th>Consommation</th>
                            <th>Station</th>
                            <th>Ristourne</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($consumptions as $consumption)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary-subtle rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <span class="text-primary">{{ substr($consumption->customer->firstname, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $consumption->customer->firstname }} {{ $consumption->customer->lastname }}</h6>
                                            <small class="text-muted">ID: {{ $consumption->customer->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-phone-alt text-muted mr-1"></i>
                                    {{ $consumption->customer->phone }}
                                </td>
                                <td>
                                    <strong>{{ number_format($consumption->quantity, 2) }} L</strong>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ optional($consumption->card->station)->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge bg-success text-white">
                                        {{ number_format($consumption->discount_amount, 2) }} XAF
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p class="mb-0">Aucune consommation trouvée</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $consumptions->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import mr-2"></i>
                    Importer les consommations
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.consumptions.import') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                    @csrf
                    <div class="form-group">
                        <label for="file">Sélectionnez votre fichier</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" required>
                            <label class="custom-file-label" for="file">Choisir un fichier</label>
                        </div>
                        <small class="form-text text-muted">Formats acceptés : .xlsx, .xls, .csv (max 2MB)</small>
                    </div>

                    <hr class="my-4">

                    <h6 class="font-weight-bold mb-3">
                        <i class="fas fa-info-circle mr-2 text-info"></i>
                        Instructions de formatage
                    </h6>

                    <div class="format-list">
                        <p class="mb-3">Votre fichier Excel doit contenir les colonnes suivantes :</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check-circle"></i> <strong>customer_id</strong> - ID du client</li>
                            <li><i class="fas fa-check-circle"></i> <strong>card_id</strong> - ID de la carte</li>
                            <li><i class="fas fa-check-circle"></i> <strong>wallet_id</strong> - ID du portefeuille</li>
                            <li><i class="fas fa-check-circle"></i> <strong>quantity</strong> - Quantité consommée</li>
                            <li><i class="fas fa-check-circle"></i> <strong>date_consumption</strong> - Date (YYYY-MM-DD)</li>
                        </ul>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Importer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Script personnalisé pour gérer l'ouverture et la fermeture du modal
document.addEventListener("DOMContentLoaded", function(){
    // Ouvrir le modal
    document.querySelectorAll('[data-toggle="modal"]').forEach(function(trigger) {
        trigger.addEventListener("click", function(e) {
            e.preventDefault();
            var modalSelector = trigger.getAttribute("data-target");
            var modal = document.querySelector(modalSelector);
            if(modal){
                modal.style.display = "block";
                modal.classList.add("show");
            }
        });
    });
    // Fermer le modal via les boutons avec data-dismiss="modal"
    document.querySelectorAll('[data-dismiss="modal"]').forEach(function(btn){
        btn.addEventListener("click", function(){
            var modal = btn.closest(".modal");
            if(modal){
                modal.style.display = "none";
                modal.classList.remove("show");
            }
        });
    });
    // Fermer le modal en cliquant en dehors du contenu
    document.querySelectorAll('.modal').forEach(function(modal){
        modal.addEventListener("click", function(e){
            if(e.target === modal){
                modal.style.display = "none";
                modal.classList.remove("show");
            }
        });
    });
});

// Ajout du nom de fichier dans l'input
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
@endpush
