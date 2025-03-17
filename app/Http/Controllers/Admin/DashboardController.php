<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        validate_permission('dashboard.read');
        // validate_permission('profile.read');
        $user = $request->user();
        return view('admin.dashboard.index', compact('user'));
    }
}
