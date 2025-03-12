@extends('layouts.admin')

@section('title', 'Import Data')

@section('main')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Import Data from Excel</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.imports.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Choose Excel File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('file') is-invalid @enderror"
                                       id="file" name="file" accept=".xlsx,.xls,.csv">
                                <label class="custom-file-label" for="file">Choose file</label>
                            </div>
                            @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload mr-1"></i> Import Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
<script>
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush
