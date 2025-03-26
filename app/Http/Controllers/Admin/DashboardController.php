<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Consumption;
use App\Models\Activity;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
            'totalPermissions' => Permission::count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentConsumptions' => Consumption::with(['customer', 'card.station'])
                ->latest('date_consumption')
                ->take(5)
                ->get(),
            'recentActivities' => Activity::with('user')
                ->latest()
                ->take(5)
                ->get()
        ];

        return view('admin.dashboard.index', $data);
    }
}
