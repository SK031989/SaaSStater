<?php

namespace Modules\Dashboard\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Auth\App\Models\User;
use Modules\Auth\App\Models\LoginActivity;

class DashboardController extends Controller
{
    /**
     * Display the admin control panel.
     */
    public function index(): View
    {
        // Gather real database metrics
        $totalUsers = User::count();
        $activeAdmins = User::where('is_admin', true)->count();
        $totalLogs = LoginActivity::count();
        $successfulLogs = LoginActivity::where('status', 'success')->count();

        // Calculate a simulated growth and value for SaaS presentation
        $metrics = [
            'total_users'     => $totalUsers,
            'active_admins'   => $activeAdmins,
            'total_logs'      => $totalLogs,
            'successful_logs' => $successfulLogs,
            
            // Modern SaaS Metrics (KPI Cards)
            'sales' => [
                'value' => '$45,289.40',
                'change' => '+12.5%',
                'trend' => 'up',
            ],
            'users' => [
                'value' => number_format($totalUsers > 0 ? $totalUsers : 1248),
                'change' => '+4.3%',
                'trend' => 'up',
            ],
            'orders' => [
                'value' => '1,482',
                'change' => '-2.1%',
                'trend' => 'down',
            ],
            'revenue' => [
                'value' => '$98,245.00',
                'change' => '+28.4%',
                'trend' => 'up',
            ],
        ];

        // Retrieve last 10 login activities
        $recentLogs = LoginActivity::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // High-fidelity Mock Orders
        $recentOrders = [
            [
                'id' => '#ORD-8942',
                'customer' => 'Sarah Connor',
                'email' => 'sarah@cyberdyne.io',
                'avatar' => 'https://ui-avatars.com/api/?name=Sarah+Connor&background=c084fc&color=fff',
                'product' => 'Growth Pro Monthly',
                'amount' => '$29.00',
                'status' => 'Completed',
                'date' => 'July 01, 2026',
            ],
            [
                'id' => '#ORD-8941',
                'customer' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=60a5fa&color=fff',
                'product' => 'Enterprise Custom Pack',
                'amount' => '$1,490.00',
                'status' => 'Completed',
                'date' => 'June 30, 2026',
            ],
            [
                'id' => '#ORD-8940',
                'customer' => 'Marcus Wright',
                'email' => 'marcus@projectangel.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Marcus+Wright&background=f87171&color=fff',
                'product' => 'Growth Pro Annual',
                'amount' => '$290.00',
                'status' => 'Pending',
                'date' => 'June 30, 2026',
            ],
            [
                'id' => '#ORD-8939',
                'customer' => 'Ellen Ripley',
                'email' => 'ripley@weyland.org',
                'avatar' => 'https://ui-avatars.com/api/?name=Ellen+Ripley&background=34d399&color=fff',
                'product' => 'Starter Monthly',
                'amount' => '$9.00',
                'status' => 'Completed',
                'date' => 'June 29, 2026',
            ],
            [
                'id' => '#ORD-8938',
                'customer' => 'Peter Parker',
                'email' => 'peter.parker@dailybugle.com',
                'avatar' => 'https://ui-avatars.com/api/?name=Peter+Parker&background=fbbf24&color=fff',
                'product' => 'Growth Pro Monthly',
                'amount' => '$29.00',
                'status' => 'Cancelled',
                'date' => 'June 28, 2026',
            ],
        ];

        // Top Products List
        $topProducts = [
            [
                'name' => 'Growth Pro Monthly',
                'category' => 'SaaS Subscription',
                'sales' => 842,
                'revenue' => '$24,418.00',
                'percentage' => 78,
                'color' => 'bg-purple-600',
            ],
            [
                'name' => 'Enterprise Scale Pack',
                'category' => 'Custom Plan',
                'sales' => 312,
                'revenue' => '$46,488.00',
                'percentage' => 54,
                'color' => 'bg-blue-600',
            ],
            [
                'name' => 'Starter Plan Annual',
                'category' => 'SaaS Subscription',
                'sales' => 240,
                'revenue' => '$2,160.00',
                'percentage' => 35,
                'color' => 'bg-indigo-600',
            ],
            [
                'name' => 'Developer API Access Addon',
                'category' => 'API Token Usage',
                'sales' => 195,
                'revenue' => '$9,750.00',
                'percentage' => 28,
                'color' => 'bg-emerald-600',
            ],
        ];

        // Sales Line Chart Data (Monthly representation)
        $salesChart = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'sales' => [28000, 32000, 31000, 38000, 42000, 40000, 45289, 48000, 52000, 50000, 58000, 64000],
            'revenue' => [18000, 22000, 25000, 24000, 30000, 29000, 32000, 35000, 38000, 36000, 41000, 48000]
        ];

        // Donut Chart Order Status
        $orderStatusChart = [
            'labels' => ['Completed', 'Pending', 'Processing', 'Cancelled'],
            'series' => [65, 18, 12, 5]
        ];

        return view('dashboard::index', compact(
            'metrics', 
            'recentLogs', 
            'recentOrders', 
            'topProducts', 
            'salesChart', 
            'orderStatusChart'
        ));
    }

    /**
     * Privacy Policy page.
     */
    public function privacyPolicy(): View
    {
        return view('dashboard::pages.privacy-policy');
    }

    /**
     * Terms of Service page.
     */
    public function termsOfService(): View
    {
        return view('dashboard::pages.terms-of-service');
    }

    /**
     * Support page.
     */
    public function support(): View
    {
        return view('dashboard::pages.support');
    }

    /**
     * Show general settings.
     */
    public function settings(): View
    {
        $settingsPath = config_path('settings.json');
        $activeTheme = 'obsidian';
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $activeTheme = $settings['active_theme'] ?? 'obsidian';
        }

        return view('dashboard::settings', compact('activeTheme'));
    }

    /**
     * Update general settings.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'theme' => 'required|string|in:obsidian,cyber,astral,minimal',
        ]);

        $settingsPath = config_path('settings.json');
        $settings = [];
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
        }

        $settings['active_theme'] = $request->input('theme');
        file_put_contents($settingsPath, json_encode($settings, JSON_PRETTY_PRINT));

        return back()->with('success', 'System settings updated successfully.');
    }
}
