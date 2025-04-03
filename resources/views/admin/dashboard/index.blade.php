@extends('layouts.admin')

@section('title', 'Dashboard')

@section('main')
    <div class="row">
        <!-- Users Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Roles Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalRoles }}</h3>
                    <p>Roles</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tag"></i>
                </div>
                <a href="{{ route('settings.roles.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Permissions Stats -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalPermissions }}</h3>
                    <p>Permissions</p>
                </div>
                <div class="icon">
                    <i class="fas fa-key"></i>
                </div>
                <a href="{{ route('settings.permissions.index') }}" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Latest Users -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Users</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Latest Activities -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">System Activities</h3>
                </div>
                <div class="card-body">
                    <!-- Add your activity log here if you have one -->
                    <div class="timeline">
                        @foreach($recentActivities as $activity)
                        <div>
                            <i class="fas fa-user bg-info"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $activity->created_at->diffForHumans() }}</span>
                                <h3 class="timeline-header">{{ $activity->description }}</h3>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="timeline">
                    @php
                        $districts = array(
                            [
                                'name' => 'LITTORAL OUEST SUD-OUEST',
                                'acronym' => 'LOSO'
                            ],
                            [
                                'name' => 'DISTRICT CENTRE SUD EST',
                                'acronym' => 'DCSE'
                            ]
                        );

                        for($i=0; $i < count($districts);$i++){
                            var_dump($districts[$i]['name']);
                        }
                                    // foreach($districts as $district){
                                            
                                            
                                    //     \App\Models\District::firstOrCreate([
                                    //         'name' => $district
                                    //     ],[
                                    //         'name' => $district
                                    //     ]);
                                    // }
                    @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
