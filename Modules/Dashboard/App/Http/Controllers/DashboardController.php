<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Models\LoginActivity;

class DashboardController extends Controller
{
    /**
     * Display the admin control panel.
     */
    public function index(): View
    {
        // Gather analytics metrics
        $metrics = [
            'total_users'     => User::count(),
            'active_admins'   => User::where('is_admin', true)->count(),
            'total_logs'      => LoginActivity::count(),
            'successful_logs' => LoginActivity::where('status', 'success')->count(),
        ];

        // Retrieve last 10 login activities
        $recentLogs = LoginActivity::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard::index', compact('metrics', 'recentLogs'));
    }
}
