<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        validate_permission('dashboard.read');

        $data = [
            'totalUsers' => User::count(),
            'totalRoles' => Role::count(),
            'totalPermissions' => Permission::count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentActivities' => [] // Si vous avez un système d'activités, vous pouvez l'ajouter ici
        ];

        return view('admin.dashboard.index', $data);
    }
}
