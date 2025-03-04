@extends('layouts.admin')

@section('title', 'Station services')

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
              <table id="example1" class="table table-bordered table-striped dataTable">
                <thead>
                <tr>
                  <th>Nom du client </th>
                  <th> Contact </th>
                  <th>Volume de consommation</th>
                  <th>Station</th>
                  <th>Montant de la ristourne </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Trident</td>
                  <td>Internet
                    Explorer 4.0
                  </td>
                  <td>Win 95+</td>
                  <td> 4</td>
                  <td>X</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nom du client </th>
                  <th> Contact </th>
                  <th>Volume de consommation</th>
                  <th>Station</th>
                  <th>Montant de la ristourne </th>
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