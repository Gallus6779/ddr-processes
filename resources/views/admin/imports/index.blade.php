@extends('layouts.admin')

@section('title', __('Import Customers'))

@section('main')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 text-gray-800">{{ __('Import Customers') }}</h1>
            <p class="mb-0">{{ __('Upload an Excel file containing the list of customers. Follow the file format instructions below.') }}</p>
        </div>
    </div>

    <!-- Feedback Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
    @endif

    <!-- Import Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-upload mr-1"></i> {{ __('Upload Customers Excel File') }}
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.imports.customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file"><i class="fas fa-file-excel mr-1"></i> {{ __('Select Excel File') }}</label>
                    <input type="file" name="file" id="file"
                           class="form-control-file @error('file') is-invalid @enderror" required>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <small class="form-text text-muted">
                        {{ __('Accepted formats: .xlsx, .xls, .csv (max 2MB)') }}
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check-circle mr-1"></i> {{ __('Import Customers') }}
                </button>
            </form>
        </div>
    </div>

    <!-- File Format Instructions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-info">
                <i class="fas fa-info-circle mr-1"></i> {{ __('File Format Instructions') }}
            </h6>
        </div>
        <div class="card-body">
            <p>{{ __('Your Excel file must contain the following columns:') }}</p>
            <ul>
                <li><strong>{{ __('firstname') }}</strong> - {{ __('First name of the customer') }}</li>
                <li><strong>{{ __('lastname') }}</strong> - {{ __('Last name of the customer') }}</li>
                <li><strong>{{ __('email') }}</strong> - {{ __('Customer email address (unique)') }}</li>
                <li><strong>{{ __('phone') }}</strong> - {{ __('Contact number (formatted as text)') }}</li>
                <li><strong>{{ __('customer_type_id') }}</strong> - {{ __('ID of the customer type (must exist)') }}</li>
            </ul>
            <p class="mb-0">
                {{ __('Please ensure that the file is in one of the accepted formats and does not exceed 2MB in size.') }}
            </p>
        </div>
    </div>
</div>
@endsection
