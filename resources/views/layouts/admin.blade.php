<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    @vite(['resources/css/app.css'])
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- @permission('dashboard.read')
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="{{ route('admin.dashboard.index') }}" class="nav-link">{{ __('Dashboard') }}</a>
                    </li>
                @endpermission --}}
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#" role="button">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ $user->name }}</span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @permission('profile.read')
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="nav-icon fas fa-user"></i>
                                My Profile 
                            </a>
                            @endpermission
                            <a href="#" id="logout-button" class="dropdown-item">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                            <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="javascript:void(0);" class="brand-link">
                {{-- <span class="brand-image">
                    {{ __('Foo') }}
                </span> --}}
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @permission('dashboard.read')
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>{{ __('Dashboard') }}</p>
                                </a>
                            </li>
                        @endpermission
                        {{-- @permission('roles.read')
                            <li class="nav-item">
                                <a href="{{ route('settings.roles.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-shield-alt"></i>
                                    <p>{{ __('Roles') }}</p>
                                </a>
                            </li>
                        @endpermission
                        @permission('permissions.read')
                            <li class="nav-item">
                                <a href="{{ route('settings.permissions.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>{{ __('Permissions') }}</p>
                                </a>
                            </li>
                        @endpermission --}}
                        @permission('users.read')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>{{ __('Users') }}</p>
                                </a>
                            </li>
                        @endpermission
                         {{-- @permission('profile.read')

                            <li class="nav-item">
                                <a href="{{ route('profile.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>{{ __('My Profile') }}</p>
                                </a>
                            </li>

                        @endpermission --}}

                        @permission('customers.read')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-toolbox"></i>
                                <p>
                                    {{ __('Discounts Manag.') }}

                                    <i class="right fas fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @permission('discounts.discounts.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.discounts.read') }}" class="nav-link">
                                        <i class="nav-icon fas fa-dollar-sign"></i>
                                        <p>{{ __('Discounts') }}</p>
                                    </a>
                                </li>
                                @endpermission
                                @permission('discounts.consumptions.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.consumptions') }}" class="nav-link">
                                      <i class="nav-icon fas fa-oil-can"></i>
                                      <p>{{ __('Consumptions') }}</p>
                                    </a>            
                                </li>
                                @endpermission
                                @permission('discounts.discount_periods.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.discount_periods.read') }}" class="nav-link">
                                      <i class="nav-icon fas fa-calendar-alt"></i>
                                      <p>{{ __('Discounts period') }}</p>
                                    </a>            
                                </li>
                                @endpermission
                                @permission('discounts.customers.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.customers.read') }}" class="nav-link">
                                      <i class="nav-icon fas fa-hand-holding-usd"></i>
                                      <p>{{ __('Customers') }}</p>
                                    </a>            
                                </li>
                                @endpermission
                                @permission('discounts.beneficiary.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.beneficiary.read') }}" class="nav-link">
                                      <i class="nav-icon fas fa-hand-holding-usd"></i>
                                      <p>{{ __('Beneficiary of Disc.') }}</p>
                                    </a>            
                                </li>
                                @endpermission
                            </ul> 
                        </li>
                        @endpermission
                        @permission('settings.read')
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>
                                    {{ __('Settings') }}
                                    <i class="right fas fa-angle-down"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @permission('settings.districts.read')
                                <li class="nav-item">
                                    <a href="{{ route('settings.districts.read') }}" class="nav-link">
                                        <i class="nav-icon fas fa-building"></i>
                                        <p>{{ __('Districts') }}</p>
                                    </a>
                                </li>
                                @endpermission
                                @permission('settings.stations.read')
                                <li class="nav-item">
                                    <a href="{{ route('settings.stations.read') }}" class="nav-link">
                                        <i class="nav-icon fas fa-gas-pump"></i>
                                        <p>{{ __('Stations') }}</p>
                                    </a>
                                </li>
                                @endpermission
                                {{-- @permission('settings.discount_periods.read')
                                <li class="nav-item">
                                    <a href="{{ route('settings.discount_periods.read') }}" class="nav-link">
                                      <i class="nav-icon fas fa-coins"></i>
                                      <p>{{ __('Discounts period') }}</p>
                                    </a>            
                                </li>
                                @endpermission
                                @permission('discounts.discounts.read')
                                <li class="nav-item">
                                    <a href="{{ route('discounts.discounts.read') }}" class="nav-link">
                                      <i class="nav-icon fas fa-coins"></i>
                                      <p>{{ __('Beneficiary of Disc.') }}</p>
                                    </a>            
                                </li>
                                @endpermission --}}
                                @permission('roles.read')
                                <li class="nav-item">
                                    <a href="{{ route('settings.roles.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-shield-alt"></i>
                                        <p>{{ __('Roles') }}</p>
                                    </a>
                                </li>
                                @endpermission
                                @permission('permissions.read')
                                <li class="nav-item">
                                    <a href="{{ route('settings.permissions.index') }}" class="nav-link">
                                        <i class="nav-icon fas fa-user-shield"></i>
                                        <p>{{ __('Permissions') }}</p>
                                    </a>
                                </li>
                                @endpermission
                            </ul> 
                        </li>
                        @endpermission

                        {{-- <li class="nav-item">
                            <a href="javascript:void(0);" id="logout-button" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>{{ __('Logout') }}</p>
                            </a>
                            <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </li> --}}

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    @yield('main')
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2024 <a
                    href="{{ route('admin.dashboard.index') }}">{{ config('app.name') }}</a>.</strong>
            <span>{{ __('All rights reserved.') }}</span>
        </footer>
    </div>

    <script>
        window.jQuery = null;
        window.$ = null;
    </script>

    @vite(['resources/js/app.js'])
    @stack('scripts')

</body>

</html>
