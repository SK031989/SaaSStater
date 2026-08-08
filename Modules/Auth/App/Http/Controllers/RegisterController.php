<?php

namespace Modules\Auth\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Auth\App\Http\Requests\RegisterRequest;
use Modules\Auth\App\Services\RegistrationService;

class RegisterController extends Controller
{
    public function __construct(protected RegistrationService $registrationService) {}

    /**
     * Show the registration checkout form.
     */
    public function showRegistrationForm(Request $request): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect(auth()->user()->is_admin ? route('admin.dashboard') : route('dashboard'));
        }

        $plans = \Modules\Subscription\App\Models\SubscriptionPlan::all();
        $selectedPlanId = $request->input('plan_id', 2);
        $selectedPlan = $plans->where('id', $selectedPlanId)->first() ?? $plans->first();
        $gateways = \Modules\Payment\App\Models\PaymentGateway::active()->get();
        $addons = \Modules\Addons\App\Models\Addon::active()->get();

        $settingsPath = config_path('settings.json');
        $activeTheme = config('marketing.default_theme', 'obsidian');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $activeTheme = $settings['active_theme'] ?? $activeTheme;
        }

        $viewName = "themes.{$activeTheme}.pages.checkout";
        if (!view()->exists($viewName)) {
            $viewName = 'auth-module::register';
        }

        return view($viewName, compact('plans', 'selectedPlan', 'gateways', 'addons'));
    }

    /**
     * Handle registration checkout form submission.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email',
            'company_name' => 'required|string|max:255',
            'subdomain'    => 'required|string|max:50|alpha_dash|unique:tenants,subdomain',
            'password'     => 'required|string|min:8|confirmed',
            'plan_id'      => 'required|exists:subscription_plans,id',
            'gateway_id'   => 'required|exists:payment_gateways,id',
        ]);

        $user = $this->registrationService->registerTenantCheckout($request->all());

        auth()->login($user);

        $companyName = $user->tenant?->name ?? $request->input('company_name', 'Organization');

        return redirect()->route('dashboard')
            ->with('success', "🎉 Welcome to SaaSStater! Your organization '{$companyName}' has been successfully onboarded.");
    }
}
