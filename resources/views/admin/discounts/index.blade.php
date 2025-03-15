@extends('layouts.admin')

@section('title', 'Discounts')

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
        <div class="col-12 mt-3">
            @permission('settings.discounts.create')
            <!-- general form elements -->
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">{{ __('Calcultation of Discount')}}</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form>
                    <div class="card-body row">
                        <div class="form-group col-md-4">
                            <label for="district_id">District  <sup class="text-danger">*</sup></label>
                            <select class="form-control @error('name') is-invalid @enderror" style="width: 100%;" name="district_id" id="district_id" required>
                                @foreach ($districts as $district)
                                {{-- <option value="{{ $district->id }}" {{ old('item') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option> --}}
                                <option value="" >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="district_id">beneficiary of discounts  <sup class="text-danger">*</sup></label>
                            <select class="form-control @error('name') is-invalid @enderror" style="width: 100%;" name="district_id" id="district_id" required>
                                @foreach ($districts as $district)
                                {{-- <option value="{{ $district->id }}" {{ old('item') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option> --}}
                                <option value="" >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="district_id">Discount period  <sup class="text-danger">*</sup></label>
                            <select class="form-control @error('name') is-invalid @enderror" style="width: 100%;" name="district_id" id="district_id" required>
                                @foreach ($districts as $district)
                                {{-- <option value="{{ $district->id }}" {{ old('item') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option> --}}
                                <option value="" >{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">
                            {{ __('Calculate a discount') }}
                        </button>
                    </div>
                    </form>
                </div>
              <!-- /.card -->
                {{-- <a href="#" class="mt-3 mb-3 btn btn-primary float-right" data-toggle="modal" data-target="#modal-default">
                    <i class="fas fa-plus mr-1"></i>
                    {{ __('Create a period') }}
                </a> --}}
            @endpermission
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">{{ __('Customers Discounts') }}  </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>{{ __('CustomerName') }} </th>
                        <th>{{ __('CadrNumber') }} </th>
                        <th>{{ __('Quantity') }} </th>
                        <th>{{ __('Amount') }} </th>
                        <th> {{ __('Discount Period') }}</th>
                        <th>{{ __('District') }}</th>
                        <th>{{ __('Created By') }} </th>
                        <th>{{ __('Validated By') }} </th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discounts as $discount)
                    <tr>
                        <td>Trident</td>
                        <td>Internet</td>
                        <td>Win 95+</td>
                        <td> 4</td>
                        <td>X</td>
                        <td>

                        <a name="" id="" class="btn btn-primary" href="#" role="button"  data-toggle="modal" data-target="#discount-edit{{ $discount->id }}">
                            <i class="fas fa-edit"></i> Update
                        </a>

                        <button type="button" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>

                        <div class="modal fade" id="discount-edit{{ $discount->id }}">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">{{ __('Create a period') }}</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="post" action="{{ route('settings.discounts.update')}}">
                                        @csrf
                                        <div class="modal-body card-body row">
                                            <div class="form-group col-md-6">
                                                <label for="name">{{ __('Name') }} </label>
                                                <input id="name" class="form-control" type="text" name="name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>District</label>
                                                <select class="form-control" style="width: 100%;">
                                                    <option>LOSO</option>
                                                    <option>DCSE</option>
                                                    <option>Ngaoundere</option>
                                                </select>
                                            </div>
                                            <!-- Date -->
                                            <div class="form-group col-md-6">
                                                <label for="start_date">{{ __('Start date') }} </label>
                                                <input type="date" class="form-control" name="start_date" id="start_date"/>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="end_date">{{ __('End date') }} </label>
                                                <input type="date" class="form-control" name="end_date" id="end_date"/>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label for="description">Description</label>
                                                <textarea id="description" class="form-control" name="description" rows="3"></textarea>
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
                                            <button type="button" class="btn btn-primary">
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
                </tbody>
                <tfoot>
                    <tr>
                        <th>{{ __('CustomerName') }} </th>
                        <th>{{ __('CadrNumber') }} </th>
                        <th>{{ __('Quantity') }} </th>
                        <th>{{ __('Amount') }} </th>
                        <th> {{ __('Discount Period') }}</th>
                        <th>{{ __('District') }}</th>
                        <th>{{ __('Created By') }} </th>
                        <th>{{ __('Validated By') }} </th>
                        <th>Actions </th>
                    </tr>
                </tfoot>
              </table>
              {{ $discounts->links('pagination::bootstrap-5') }}
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="button" class="btn btn-primary float-right">
                    {{ __('Export as PDF') }}
                </button>
                <button type="button" class="mr-2 btn btn-warning float-right">
                    {{ __('Export as Excel') }}
                </button>
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

  <script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
  </script>


@endpush