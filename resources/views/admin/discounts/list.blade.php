@extends('layouts.admin')

@section('title', 'Station services')

@push('styles')
    <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
@endpush

@section('main')
    <!-- Main row -->
    <div class="row">
        <div class="col-6"></div>
        <div class="col-6">
            @permission('settings.stations.create')
                <a href="#" class="mt-3 mb-3 btn btn-primary float-right">
                    <i class="fas fa-plus mr-1"></i>
                    {{ __('Add a station') }}
                </a>
            @endpermission
        </div>
    </div>
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Station services </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Discount name</th>
                        <th> Discount period</th>
                        <th>District name</th>
                        <th>Created By</th>
                        <th>Validated By</th>
                        <th>Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <td>Trident</td>
                    <td>Internet</td>
                    <td>Win 95+</td>
                    <td> 4</td>
                    <td>X</td>
                    <td>

                        <a name="" id="" class="btn btn-primary" href="#" role="button">
                            <i class="fas fa-edit"></i> Update
                        </a>

                        <button type="button" class="btn btn-danger">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                    <th>Discount name</th>
                    <th> Discount period</th>
                    <th>District name</th>
                    <th>Created By</th>
                    <th>Validated By</th>
                    <th>Actions </th>
                    </tr>
                </tfoot>
              </table>
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
<script src="{{ asset('dist/js/demo.js') }}"></script>


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