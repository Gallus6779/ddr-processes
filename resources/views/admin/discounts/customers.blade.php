@extends('layouts.admin')

@section('title', 'Customers')

@push('styles')
    <!-- Font Awesome -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}"> --}}
  <!-- daterange picker -->
  {{-- <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}"> --}}
  <!-- Select2 -->
  <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
  {{-- <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}"> --}}
  {{-- <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"> --}}
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  
  <style>
    div.dt-container div.row:last-child{
        display:none;
    }
  </style>
@endpush

@section('main')
    <!-- Main row -->
    <div class="row">
        <div class="col-12">

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible mt-4">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible mt-4">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Alert!</h5>
                    {{ session('success') }}
                </div>      
            @endif
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            @permission('discounts.discounts.create')
                <a href="#" class="mt-3 mb-3 btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus mr-1"></i>
                    {{ __('Add a customer') }}
                </a>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('Add a customer') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" action="{{ route('discounts.customers.create')}}">
                                @csrf
                                <div class="modal-body card-body row">
                                    <div class="form-group col-md-6">
                                        <label for="name">{{ __('Name') }}  <sup class="text-danger">*</sup></label>
                                        <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" name="name" placeholder="Neptune OIL" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="customer_type_id">{{ __('Customer Type') }}  <sup class="text-danger">*</sup></label>
                                        <select class="form-control @error('customer_type_id') is-invalid @enderror" style="width: 100%;" name="customer_type_id" id="customer_type_id" required>
                                            @foreach ($customer_types as $customer_type)
                                            <option value="{{ $customer_type->id }}" {{ (old('customer_type_id') == $customer_type->id) ? 'selected' : '' }}>{{ $customer_type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="number">{{ __('CardNumber') }}  <sup class="text-danger">*</sup></label>
                                        <input id="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number') }}" type="number" name="number" required>
                                        @error('number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="card_owner">{{ __('CardOwner') }}  <sup class="text-danger">*</sup></label>
                                        <input id="card_owner" class="form-control @error('card_owner') is-invalid @enderror" value="{{ old('card_owner') }}" type="text" name="card_owner" placeholder="Neptune OIL" required>
                                        @error('card_owner')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">{{ __('Customer Email') }}  <sup class="text-danger">*</sup></label>
                                        <input id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" type="email" name="email" placeholder="username@example.com">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">{{ __('Customer Phone') }}  <sup class="text-danger">*</sup></label>
                                        <input id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" type="tel" name="phone" placeholder="Neptune OIL" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                        <ion-icon name="close-circle-outline"></ion-icon>
                                        <i class="fas-solid fa-xmark"></i>
                                        <i class="fass fa-xmark"></i>
                                        {{ __('Cancel') }} 
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <ion-icon name="checkmark-circle" class="mt-1" size="small"></ion-icon>
                                        {{ __('Save') }} 
                                    </button>
                                </div>
                            </form>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            @endpermission
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ __('Customers') }}  </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('Name') }} </th>
                        <th>{{ __('CustomerType') }}</th>
                        <th>{{ __('CardNumber') }}</th>
                        <th>{{ __('CardOwner') }}</th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        @foreach ($customer->cards as $card)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->customer_type->name }}</td>
                                <td>{{ $card->number }}</td>
                                <td>{{ $card->card_owner }}</td> 
                                <td>
                                @permission('discounts.customers.update')
                                <a name="" id="" class="btn btn-primary" href="#" role="button"  data-toggle="modal" data-target="#customers-edit{{ $customer->id }}">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                                @endpermission
        
                                @permission('discounts.customers.delete')
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                @endpermission
        
                                <div class="modal fade" id="customers-edit{{ $customer->id }}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">{{ __('Update a customer') }}</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="{{ route('discounts.customers.update', ['customer' => $customer->id, 'card' => $card->id]) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body card-body row">
                                                    <div class="form-group col-md-6">
                                                        <label for="name">{{ __('Name') }}  <sup class="text-danger">*</sup></label>
                                                        <input id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" type="text" name="name" placeholder="Neptune OIL" required>
                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="customer_type_id">{{ __('Customer Type') }}  <sup class="text-danger">*</sup></label>
                                                        <select class="form-control @error('customer_type_id') is-invalid @enderror" style="width: 100%;" name="customer_type_id" id="customer_type_id" required>
                                                            @foreach ($customer_types as $customer_type)
                                                            <option value="{{ $customer_type->id }}" {{ $customer->customer_type_id == $customer_type->id | (old('customer_type_id') == $customer_type->id) ? 'selected' : '' }}>{{ $customer_type->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="number">{{ __('CardNumber') }}  <sup class="text-danger">*</sup></label>
                                                        <input id="number" class="form-control @error('number') is-invalid @enderror" value="{{ old('number', $card->number) }}" type="number" name="number" required>
                                                        @error('number')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="card_owner">{{ __('CardOwner') }}  <sup class="text-danger">*</sup></label>
                                                        <input id="card_owner" class="form-control @error('card_owner') is-invalid @enderror" value="{{ old('card_owner', $card->card_owner) }}" type="text" name="card_owner" placeholder="Neptune OIL" required>
                                                        @error('card_owner')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="email">{{ __('Customer Email') }}  <sup class="text-danger">*</sup></label>
                                                        <input id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" type="email" name="email" placeholder="username@example.com" required>
                                                        @error('email')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="phone">{{ __('Customer Phone') }}  <sup class="text-danger">*</sup></label>
                                                        <input id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}" type="tel" name="phone" placeholder="Neptune OIL" required>
                                                        @error('phone')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                        <ion-icon name="close-circle-outline"></ion-icon>
                                                        <i class="fas-solid fa-xmark"></i>
                                                        <i class="fass fa-xmark"></i>
                                                        {{ __('Cancel') }} 
                                                    </button>
                                                    <button type="submit" class="btn btn-primary float-left">
                                                        <ion-icon name="checkmark-circle" class="mt-1" size="small"></ion-icon>
                                                        {{ __('Update') }} 
                                                    </button>
                                                </div>
                                            </form>
                
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                </td> 
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>{{ __('Name') }} </th>
                        <th>{{ __('CustomerType') }}</th>
                        <th>{{ __('CardNumber') }}</th>
                        <th>{{ __('CardOwner') }}</th>
                        <th>Actions </th>
                    </tr>
                </tfoot>
              </table>
              {{-- {{ $customers->links('pagination::bootstrap-5') }} --}}
            </div>
            <!-- /.card-body -->
          </div>
          
          <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
      <!-- /.row (main row) -->
@endsection

@push('scripts')

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('js/select2.min.js') }}"></script>
{{-- <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script> --}}
<!-- date-range-picker -->
{{-- <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}

{{-- <script type="module" src="{{ asset('dist/ionicons/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('dist/ionicons/ionicons.js') }}"></script> --}}

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>



@endpush