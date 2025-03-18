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
                <a href="{{ route('admin.roles.index') }}" class="small-box-footer">
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
                <a href="{{ route('admin.permissions.index') }}" class="small-box-footer">
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
                        // $permissions = [
                        //     ['name' => 'profile.read'],
                        //     ['name' => 'dashboard.read'],
                        //     ['name' => 'imports.create'],
                        //     ['name' => 'imports.read'],
                        //     ['name' => 'roles.create'],
                        //     ['name' => 'roles.read'],
                        //     ['name' => 'roles.update'],
                        //     ['name' => 'roles.delete'],
                        //     ['name' => 'permissions.create'],
                        //     ['name' => 'permissions.read'],
                        //     ['name' => 'permissions.update'],
                        //     ['name' => 'permissions.delete'],
                        //     ['name' => 'users.create'],
                        //     ['name' => 'users.read'],
                        //     ['name' => 'users.update'],
                        //     ['name' => 'users.delete'],
                        //     ['name' => 'profile.read'],
                        //     ['name' => 'profile.update'],
                        //     ['name' => 'dashboard.read'],
                        //     ['name' => 'customers.read'],
                        //     ['name' => 'customers.update'],
                        //     ['name' => 'customers.discounts.read'],
                        //     ['name' => 'customers.discounts.update'],
                        //     ['name' => 'customers.discounts.create'],
                        //     ['name' => 'customers.discounts.delete'],
                        //     ['name' => 'customers.consumptions.create'],
                        //     ['name' => 'customers.consumptions.update'],
                        //     ['name' => 'customers.consumptions.read'],
                        //     ['name' => 'customers.consumptions.delete'],
                        //     ['name' => 'settings.discount_periods.read'],
                        //     ['name' => 'settings.discount_periods.create'],
                        //     ['name' => 'settings.discount_periods.delete'],
                        //     ['name' => 'settings.discount_periods.update']
                        // ];

                        $permissions = [
                            'profile.read',
                            'dashboard.read',
                            'imports.create',
                            'imports.read',
                            'roles.create',
                            'roles.read',
                            'roles.update',
                            'roles.delete',
                            'permissions.create',
                            'permissions.read',
                            'permissions.update',
                            'permissions.delete',
                            'users.create',
                            'users.read',
                            'users.update',
                            'users.delete',
                            'profile.read',
                            'profile.update',
                            'dashboard.read',
                            'customers.read',
                            'customers.update',
                            'customers.discounts.read',
                            'customers.discounts.update',
                            'customers.discounts.create',
                            'customers.discounts.delete',
                            'customers.consumptions.create',
                            'customers.consumptions.update',
                            'customers.consumptions.read',
                            'customers.consumptions.delete',
                            'settings.discount_periods.read',
                            'settings.discount_periods.create',
                            'settings.discount_periods.delete',
                            'settings.discount_periods.update'
                    ];

                        // var_dump($permissions);
                        foreach($permissions as $permission){
                            echo $permission;
                            // \App\Models\Permission::firstOrCreate(['name' => $permission['name']], ['name' => $permission['name']]);
                        }
                    @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
