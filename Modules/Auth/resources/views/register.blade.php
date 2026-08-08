@php
    $settingsPath = config_path('settings.json');
    $activeTheme = config('marketing.default_theme', 'obsidian');
    if (file_exists($settingsPath)) {
        $settings = json_decode(file_get_contents($settingsPath), true);
        $activeTheme = $settings['active_theme'] ?? $activeTheme;
    }
    $isLight = ($activeTheme === 'minimal');
@endphp
<!DOCTYPE html>
<html lang="en" class="{{ $isLight ? 'light' : 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Registration & Plan Checkout — {{ config('settings.project_name', 'SaaSStater') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --bg-main: {{ $isLight ? '#f8fafc' : '#0b0f19' }};
            --card-bg: {{ $isLight ? '#ffffff' : '#111827' }};
            --card-inner: {{ $isLight ? '#f1f5f9' : '#1e293b' }};
            --border-main: {{ $isLight ? '#e2e8f0' : 'rgba(255, 255, 255, 0.08)' }};
            --text-heading: {{ $isLight ? '#0f172a' : '#ffffff' }};
            --text-muted: {{ $isLight ? '#64748b' : '#94a3b8' }};
            --input-bg: {{ $isLight ? '#ffffff' : '#1e293b' }};
            --input-border: {{ $isLight ? '#cbd5e1' : 'rgba(255, 255, 255, 0.1)' }};
            --input-text: {{ $isLight ? '#0f172a' : '#ffffff' }};
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-heading);
            min-height: 100vh;
        }

        .checkout-card {
            background-color: var(--card-bg);
            border: 1px solid var(--border-main);
            border-radius: 1.25rem;
            padding: 1.75rem;
            box-shadow: 0 10px 30px {{ $isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(0, 0, 0, 0.3)' }};
        }

        .step-badge {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #6366f1;
            color: #fff;
            font-weight: 700;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-control, .form-select {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            color: var(--input-text);
            border-radius: 0.75rem;
            font-size: 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            background-color: var(--input-bg);
            border-color: #6366f1;
            color: var(--input-text);
            box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.25);
        }

        .text-theme-title {
            color: var(--text-heading) !important;
        }

        .text-theme-muted {
            color: var(--text-muted) !important;
        }
    </style>
</head>
<body class="py-5">

    <div class="container max-w-6xl">
        
        <!-- Header Brand -->
        <div class="text-center mb-5">
            <a href="/" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-2">
                <div class="p-2 rounded-3" style="background: linear-gradient(135deg, #6366f1, #a855f7);">
                    <i class="bi bi-shield-check text-white fs-4"></i>
                </div>
                <span class="fw-extrabold fs-3 text-theme-title">{{ config('settings.project_name', 'SaaSStater') }}</span>
            </a>
            <h2 class="fw-bold text-theme-title mb-1">Create Your Organization & Subscribe</h2>
            <p class="text-theme-muted text-sm mb-0">Theme Mode: <span class="badge bg-indigo-500 text-white rounded-pill px-3">{{ strtoupper($activeTheme) }}</span> — Instant activation & secure checkout.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-4 shadow-sm border-0">
                <ul class="mb-0 text-xs">
                    @foreach($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.register.store') }}" method="POST" id="regCheckoutForm">
            @csrf

            <div class="row g-4">
                
                <!-- LEFT COLUMN: STEPS -->
                <div class="col-lg-7">

                    <!-- STEP 1: CHOOSE PLAN -->
                    <div class="checkout-card mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold text-theme-title mb-0">
                                <span class="step-badge me-2">1</span> Choose Subscription Plan
                            </h5>

                            <!-- Monthly / Annual Toggle -->
                            <div class="btn-group p-1 rounded-pill" style="background-color: var(--card-inner);" role="group">
                                <input type="radio" class="btn-check" name="billing_interval" id="interval_monthly" value="monthly" checked onchange="recalculateTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3 text-theme-title" for="interval_monthly">Monthly</label>

                                <input type="radio" class="btn-check" name="billing_interval" id="interval_yearly" value="yearly" onchange="recalculateTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3 text-theme-title" for="interval_yearly">Annual <span class="badge bg-emerald-500 text-white ms-1">Save 20%</span></label>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($plans as $p)
                            <div class="col-md-4">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer plan-radio-card transition position-relative {{ $selectedPlan->id == $p->id ? 'border-indigo-500 bg-indigo-500/10' : '' }}" style="cursor:pointer; background-color: var(--card-inner); border-color: var(--border-main);">
                                    <input type="radio" name="plan_id" value="{{ $p->id }}" data-price="{{ $p->price }}" data-name="{{ $p->name }}" class="d-none plan-radio-input" {{ $selectedPlan->id == $p->id ? 'checked' : '' }} onchange="selectPlan(this)">
                                    
                                    @if($p->name === 'Growth Pro')
                                        <span class="position-absolute top-0 end-0 translate-middle-y me-3 badge bg-indigo-600 text-white text-xs rounded-pill">Popular</span>
                                    @endif

                                    <div class="fw-bold text-theme-title mb-1 fs-6">{{ $p->name }}</div>
                                    <div class="fs-4 font-extrabold text-indigo-500 mb-2">
                                        $<span class="plan-card-price" data-monthly="{{ $p->price }}" data-yearly="{{ number_format($p->price * 10, 2) }}">{{ number_format($p->price, 2) }}</span>
                                    </div>
                                    <div class="text-xs text-theme-muted">Max {{ $p->max_users ?? 'Unlimited' }} Users</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- STEP 2: COMPANY & ADMIN ACCOUNT -->
                    <div class="checkout-card mb-4">
                        <h5 class="fw-bold text-theme-title mb-3">
                            <span class="step-badge me-2">2</span> Company & Admin Account
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label text-xs font-semibold text-theme-title">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="Acme Corp" required oninput="autoSlug(this.value)">
                            </div>
                            <div class="col-md-6">
                                <label for="subdomain" class="form-label text-xs font-semibold text-theme-title">Company Subdomain</label>
                                <div class="input-group">
                                    <input type="text" name="subdomain" id="subdomain" class="form-control border-end-0 font-mono text-xs" value="{{ old('subdomain') }}" placeholder="acme" required>
                                    <span class="input-group-text border-start-0 text-xs font-mono" style="background-color: var(--card-inner); color: var(--text-muted); border-color: var(--input-border);">.saas.local</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label text-xs font-semibold text-theme-title">Admin Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-xs font-semibold text-theme-title">Admin Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" placeholder="john@acme.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label text-xs font-semibold text-theme-title">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label text-xs font-semibold text-theme-title">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: OPTIONAL HR ADDONS -->
                    @if($addons->count() > 0)
                    <div class="checkout-card mb-4">
                        <h5 class="fw-bold text-theme-title mb-3">
                            <span class="step-badge me-2">3</span> Optional HR Add-on Modules
                        </h5>

                        <div class="row g-3">
                            @foreach($addons as $ad)
                            <div class="col-md-12">
                                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between" style="background-color: var(--card-inner); border-color: var(--border-main) !important;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" name="addons[]" value="{{ $ad->id }}" data-price="{{ $ad->price }}" id="addon_{{ $ad->id }}" class="form-check-input addon-checkbox" onchange="recalculateTotal()" style="width:20px; height:20px;">
                                        <div>
                                            <label for="addon_{{ $ad->id }}" class="fw-bold text-theme-title text-sm mb-0 cursor-pointer">{{ $ad->name }}</label>
                                            <div class="text-xs text-theme-muted">{{ $ad->description }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-indigo-500 text-sm">
                                        +${{ number_format($ad->price, 2) }}/mo
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- STEP 4: PAYMENT METHOD SELECTION -->
                    <div class="checkout-card">
                        <h5 class="fw-bold text-theme-title mb-3">
                            <span class="step-badge me-2">4</span> Select Payment Channel
                        </h5>

                        <div class="row g-3 mb-4">
                            @foreach($gateways as $idx => $g)
                            <div class="col-md-6">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer gateway-radio-card transition {{ $g->is_default || $idx == 0 ? 'border-indigo-500 bg-indigo-500/10' : '' }}" style="cursor:pointer; background-color: var(--card-inner); border-color: var(--border-main);">
                                    <input type="radio" name="gateway_id" value="{{ $g->id }}" data-code="{{ $g->code }}" class="d-none gateway-radio-input" {{ $g->is_default || $idx == 0 ? 'checked' : '' }} onchange="selectGateway(this)">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2.5 rounded-3 border" style="background-color: var(--card-bg); border-color: var(--border-main) !important;">
                                            @if($g->code === 'stripe')
                                                <i class="bi bi-credit-card-2-front fs-4 text-indigo-500"></i>
                                            @elseif($g->code === 'paypal')
                                                <i class="bi bi-paypal fs-4 text-blue-500"></i>
                                            @elseif($g->code === 'razorpay')
                                                <i class="bi bi-qr-code-scan fs-4 text-cyan-500"></i>
                                            @else
                                                <i class="bi bi-bank fs-4 text-emerald-500"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-theme-title text-xs mb-0">{{ $g->name }}</div>
                                            <span class="text-[10px] text-theme-muted">Mode: {{ strtoupper($g->mode) }}</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: ORDER SUMMARY -->
                <div class="col-lg-5">
                    <div class="checkout-card sticky-top" style="top: 20px;">
                        <h5 class="fw-bold text-theme-title mb-3">Order & Subscription Summary</h5>

                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3" style="border-color: var(--border-main) !important;">
                            <div>
                                <span class="fw-bold text-theme-title d-block" id="summaryPlanName">{{ $selectedPlan->name }}</span>
                                <span class="text-xs text-theme-muted" id="summaryIntervalText">Billed Monthly</span>
                            </div>
                            <div class="fw-bold text-theme-title fs-5" id="summarySubtotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- COUPON INPUT -->
                        <div class="mb-3">
                            <label for="coupon_code" class="form-label text-xs font-semibold text-theme-muted">Promotional Coupon</label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" name="coupon_code" class="form-control font-mono text-xs uppercase" placeholder="e.g. SAVE20">
                                <button type="button" class="btn btn-indigo text-xs font-semibold px-3" style="background:#6366f1; color:#fff;" onclick="applyCoupon()">Apply</button>
                            </div>
                            <div id="couponFeedback" class="text-xs mt-1 font-semibold"></div>
                        </div>

                        <!-- BREAKDOWN -->
                        <div class="space-y-2 text-xs text-theme-muted border-top pt-3 mb-3" style="border-color: var(--border-main) !important;">
                            <div class="d-flex justify-content-between">
                                <span>Plan Price</span>
                                <span id="breakdownPlan">${{ number_format($selectedPlan->price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Add-ons Total</span>
                                <span id="breakdownAddons">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-emerald-500 font-semibold" id="discountRow" style="display:none !important;">
                                <span>Coupon Discount</span>
                                <span id="breakdownDiscount">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Setup & Processing</span>
                                <span class="text-emerald-500 font-semibold">FREE ($0.00)</span>
                            </div>
                        </div>

                        <!-- TOTAL DUE TODAY -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 border mb-4" style="background-color: var(--card-inner); border-color: var(--border-main) !important;">
                            <div>
                                <span class="text-xs text-theme-muted uppercase font-semibold d-block">Total Due Today</span>
                                <span class="text-[10px] text-theme-muted">Instant Activation</span>
                            </div>
                            <div class="fs-3 font-extrabold text-indigo-500" id="summaryTotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn btn-indigo w-full rounded-pill py-3 font-bold fs-6 shadow-lg shadow-indigo-500/20 mb-3" style="background:#6366f1; color:#fff;">
                            <i class="bi bi-rocket-takeoff me-2"></i> Register & Complete Payment
                        </button>

                        <div class="text-center text-xs text-theme-muted">
                            Already have an account? <a href="{{ route('auth.login') }}" class="text-indigo-500 text-decoration-none font-semibold">Sign In here</a>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentPlanPrice = {{ $selectedPlan->price }};
        let currentAddonsTotal = 0;
        let discountPercent = 0;

        function autoSlug(val) {
            const slug = val.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
            document.getElementById('subdomain').value = slug;
        }

        function selectPlan(radio) {
            document.querySelectorAll('.plan-radio-card').forEach(c => {
                c.classList.remove('border-indigo-500', 'bg-indigo-500/10');
            });
            radio.closest('.plan-radio-card').classList.add('border-indigo-500', 'bg-indigo-500/10');
            recalculateTotal();
        }

        function selectGateway(radio) {
            document.querySelectorAll('.gateway-radio-card').forEach(c => {
                c.classList.remove('border-indigo-500', 'bg-indigo-500/10');
            });
            radio.closest('.gateway-radio-card').classList.add('border-indigo-500', 'bg-indigo-500/10');
        }

        function recalculateTotal() {
            const selectedPlanInput = document.querySelector('.plan-radio-input:checked');
            const interval = document.querySelector('input[name="billing_interval"]:checked').value;
            
            let basePrice = parseFloat(selectedPlanInput.dataset.price);
            let planName = selectedPlanInput.dataset.name;

            if (interval === 'yearly') {
                basePrice = basePrice * 10;
                document.getElementById('summaryIntervalText').innerText = 'Billed Annually (Save 20%)';
            } else {
                document.getElementById('summaryIntervalText').innerText = 'Billed Monthly';
            }

            // Update Price Labels
            document.querySelectorAll('.plan-card-price').forEach(el => {
                el.innerText = interval === 'yearly' ? el.dataset.yearly : parseFloat(el.dataset.monthly).toFixed(2);
            });

            // Calculate Addons
            currentAddonsTotal = 0;
            document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
                let p = parseFloat(cb.dataset.price);
                if (interval === 'yearly') p = p * 10;
                currentAddonsTotal += p;
            });

            currentPlanPrice = basePrice;
            let subtotal = currentPlanPrice + currentAddonsTotal;
            let discountAmount = subtotal * discountPercent;
            let finalTotal = Math.max(0, subtotal - discountAmount);

            document.getElementById('summaryPlanName').innerText = planName;
            document.getElementById('breakdownPlan').innerText = '$' + currentPlanPrice.toFixed(2);
            document.getElementById('breakdownAddons').innerText = '$' + currentAddonsTotal.toFixed(2);
            document.getElementById('summarySubtotal').innerText = '$' + subtotal.toFixed(2);
            
            if (discountPercent > 0) {
                document.getElementById('breakdownDiscount').innerText = '-$' + discountAmount.toFixed(2);
            }
            document.getElementById('summaryTotal').innerText = '$' + finalTotal.toFixed(2);
        }

        function applyCoupon() {
            const code = document.getElementById('coupon_code').value.trim().toUpperCase();
            const feedback = document.getElementById('couponFeedback');
            const discountRow = document.getElementById('discountRow');

            if (code === 'SAVE20' || code === 'WELCOME20') {
                discountPercent = 0.20;
                feedback.className = 'text-xs mt-1 text-success';
                feedback.innerText = '✔ Coupon SAVE20 applied! (20% Off)';
                discountRow.style.setProperty('display', 'flex', 'important');
            } else if (code === 'HALFOFF' || code === 'SAAS50') {
                discountPercent = 0.50;
                feedback.className = 'text-xs mt-1 text-success';
                feedback.innerText = '✔ Coupon SAAS50 applied! (50% Off)';
                discountRow.style.setProperty('display', 'flex', 'important');
            } else {
                discountPercent = 0;
                feedback.className = 'text-xs mt-1 text-danger';
                feedback.innerText = 'Invalid coupon code. Try SAVE20 or SAAS50.';
                discountRow.style.setProperty('display', 'none', 'important');
            }

            recalculateTotal();
        }
    </script>
</body>
</html>
