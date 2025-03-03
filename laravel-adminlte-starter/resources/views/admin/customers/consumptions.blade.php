@extends('layouts.admin')

@section('title', 'Consumptions')

@section('main')
<div class="row">
    <div class="col-6"></div>
    <div class="col-6">
        @permission('roles.create')
            <a href="{{ route('admin.roles.create') }}" class="mt-3 btn btn-primary float-right">
                <i class="fas fa-plus mr-1"></i>
                {{ __('New Role') }}
            </a>
        @endpermission
    </div>
</div>
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
          
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Consommation des Clients </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
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
                        <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 5.0
                        </td>
                        <td>Win 95+</td>
                        <td>5</td>
                        <td>C</td>
                        </tr>
                        <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 5.5
                        </td>
                        <td>Win 95+</td>
                        <td>5.5</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Trident</td>
                        <td>Internet
                            Explorer 6
                        </td>
                        <td>Win 98+</td>
                        <td>6</td>
                        <td>A</td>
                        </tr>
                        
                        <tr>
                        <td>Presto</td>
                        <td>Opera 7.0</td>
                        <td>Win 95+ / OSX.1+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Presto</td>
                        <td>Opera 7.5</td>
                        <td>Win 95+ / OSX.2+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Presto</td>
                        <td>Opera 8.0</td>
                        <td>Win 95+ / OSX.2+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Presto</td>
                        <td>Opera 8.5</td>
                        <td>Win 95+ / OSX.2+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Presto</td>
                        <td>Opera 9.0</td>
                        <td>Win 95+ / OSX.3+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Presto</td>
                        <td>Opera 9.2</td>
                        <td>Win 88+ / OSX.3+</td>
                        <td>-</td>
                        <td>A</td>
                        </tr>
                        <tr>
                        <td>Misc</td>
                        <td>PSP browser</td>
                        <td>PSP</td>
                        <td>-</td>
                        <td>C</td>
                        </tr>
                        <tr>
                        <td>Other browsers</td>
                        <td>All others</td>
                        <td>-</td>
                        <td>-</td>
                        <td>U</td>
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
