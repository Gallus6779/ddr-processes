@extends('layouts.admin')

@section('title', 'Sales')

@push('styles')
    
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
                    {{ session('success') }}
                </div>      
            @endif
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            <!-- @permission('sales.create') -->
                <a href="#" class="mt-2 mb-3 btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus mr-1"></i>
                    {{ __('Add Sale') }}
                </a>
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">{{ __('Add Sale') }}</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="put" action="{{ route('admin.sales.create')}}">
                                @csrf
                                <div class="modal-body card-body row">
                                    <div class="form-group col-md-12">
                                        <label for="station_id">Station  <sup class="text-danger">*</sup></label>
                                        <select class="form-control @error('name') is-invalid @enderror" style="width: 100%;" name="station_id" id="station_id" required>
                                            @foreach ($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('item') == $station->id ? 'selected' : '' }}>{{ $station->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="product_id">Product  <sup class="text-danger">*</sup></label>
                                        <select class="form-control @error('name') is-invalid @enderror" style="width: 100%;" name="product_id" id="product_id" required>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('item') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="quantity">{{ __('Quantity') }}  <sup class="text-danger">*</sup></label>
                                        <input id="quantity" class="form-control @error('name') is-invalid @enderror" 
                                                value="{{ old('quantity') }}" type="number" min=0 name="quantity" placeholder="Entrer le volume de produit vendu ce jour" 
                                                required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="sale_date">{{ __('Date ') }}  <sup class="text-danger">*</sup></label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                            <input id="sale_date" name="sale_date" type="datetime-local" class="form-control" data-target="#reservationdate" readonly/>
                                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
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
                                        <ion-icon name="checkmark-circle" size="small"></ion-icon>
                                        {{ __('Save') }} 
                                    </button>
                                </div>
                            </form>

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            <!-- @endpermission -->
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ __('Sales') }}  </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }} </th>
                            <th> {{ __('Station ') }}</th>
                            <th>{{ __('Produit') }} </th>
                            <th>{{ __('Volume vendu') }} </th>
                            <th>{{ __('status') }} </th>
                            <th>Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_date }}</td>
                            <td>{{ $sale->station->name }}</td>
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>
                                

                            </td>
                        </tr>
                        @endforeach

                        
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Date ') }} </th>
                            <th> {{ __('Station') }}</th>
                            <th>{{ __('Produit') }} </th>
                            <th>{{ __('Volume vendu') }} </th>
                            <th>{{ __('Status') }} </th>
                            <th>Actions </th>
                        </tr>
                    </tfoot>
                </table>
                {{ $sales->links('pagination::bootstrap-5') }}
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
<!-- DataTables  & Plugins -->

<!-- <script src="{{ asset('../../js/daterangepicker/daterangepicker.js') }}"></script> -->
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('dist/js/demo.js') }}"></script> --}}

{{-- <script type="module" src="{{ asset('dist/ionicons/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('dist/ionicons/ionicons.js') }}"></script> --}}

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const now = new Date();
        const offset = now.getTimezoneOffset();
        const localDateTime = new Date(now.getTime() - (offset * 60 * 1000)).toISOString().slice(0,16);
        document.getElementById('sale_date').value = localDateTime;
    });

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