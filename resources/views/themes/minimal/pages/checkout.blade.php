@extends('themes.minimal.layouts.marketing')

@section('title', 'Minimalist Multi-Step Checkout — ' . config('settings.project_name', 'SaaSStater'))

@section('content')
<style>
    .min-chk-page {
        background-color: #f8fafc;
        color: #0f172a;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .min-chk-title { color: #0f172a; }
    .min-chk-muted { color: #64748b; }
    .min-chk-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .min-chk-inner {
        background-color: #f1f5f9;
        border-color: #e2e8f0 !important;
    }
    .min-chk-input {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
        border-radius: 0.75rem;
    }

    /* STEP PROGRESS BAR */
    .step-progress-wrapper {
        position: relative;
        display: flex;
        justify-content: space-between;
        margin-bottom: 2.5rem;
    }
    .step-progress-line {
        position: absolute;
        top: 18px;
        left: 0;
        right: 0;
        height: 4px;
        background: #e2e8f0;
        z-index: 1;
    }
    .step-progress-bar-fill {
        height: 100%;
        background: #4f46e5;
        width: 0%;
        transition: width 0.3s ease;
    }
    .step-progress-item {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }
    .step-icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        color: #64748b;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    .step-progress-item.active .step-icon-circle {
        background: #4f46e5;
        border-color: #4f46e5;
        color: #ffffff;
        box-shadow: 0 0 15px rgba(79, 70, 229, 0.4);
    }
    .step-progress-item.completed .step-icon-circle {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }
    .step-title-text {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
    }
    .step-progress-item.active .step-title-text {
        color: #4f46e5;
        font-weight: 700;
    }

    /* DARK MODE OVERRIDES */
    html.dark .min-chk-page, .dark .min-chk-page { background-color: #0b0f19 !important; color: #ffffff !important; }
    html.dark .min-chk-title, .dark .min-chk-title { color: #ffffff !important; }
    html.dark .min-chk-muted, .dark .min-chk-muted { color: #94a3b8 !important; }
    html.dark .min-chk-card, .dark .min-chk-card { background-color: #111827 !important; border-color: rgba(255, 255, 255, 0.08) !important; box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important; }
    html.dark .min-chk-inner, .dark .min-chk-inner { background-color: #1e293b !important; border-color: rgba(255, 255, 255, 0.08) !important; }
    html.dark .min-chk-input, .dark .min-chk-input { background-color: #1e293b !important; border-color: rgba(255, 255, 255, 0.1) !important; color: #ffffff !important; }
    html.dark .step-progress-line, .dark .step-progress-line { background: #1e293b; }
    html.dark .step-icon-circle, .dark .step-icon-circle { background: #111827; border-color: #334155; color: #94a3b8; }
</style>

<div class="py-5 min-chk-page">
    <div class="container max-w-6xl">
        
        <!-- Header -->
        <div class="text-center mb-5">
            <span class="badge bg-indigo-100 text-indigo-700 px-3 py-2 rounded-pill mb-2 font-semibold" style="font-size: 0.75rem;">
                MINIMALIST MULTI-STEP WIZARD
            </span>
            <h1 class="fw-bold mb-2 display-5 min-chk-title">Clean Subscription Checkout</h1>
            <p class="lead mx-auto min-chk-muted" style="max-width: 600px;">Simple 4-step wizard for instant tenant onboarding and subscription payment.</p>
        </div>

        <!-- MULTI-STEP PROGRESS WIZARD INDICATOR -->
        <div class="step-progress-wrapper px-3 max-w-3xl mx-auto">
            <div class="step-progress-line">
                <div class="step-progress-bar-fill" id="wizardProgressBar"></div>
            </div>
            
            <div class="step-progress-item active" id="stepIndicator1">
                <div class="step-icon-circle">1</div>
                <div class="step-title-text d-none d-sm-block">Plan & Tier</div>
            </div>
            <div class="step-progress-item" id="stepIndicator2">
                <div class="step-icon-circle">2</div>
                <div class="step-title-text d-none d-sm-block">Account Details</div>
            </div>
            <div class="step-progress-item" id="stepIndicator3">
                <div class="step-icon-circle">3</div>
                <div class="step-title-text d-none d-sm-block">Addons & Coupon</div>
            </div>
            <div class="step-progress-item" id="stepIndicator4">
                <div class="step-icon-circle">4</div>
                <div class="step-title-text d-none d-sm-block">Payment & Launch</div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-4 shadow-sm border-0 bg-danger/10 text-danger">
                <ul class="mb-0 text-xs">
                    @foreach($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ auth()->check() ? route('checkout.process') : route('auth.register.store') }}" method="POST" id="minimalCheckoutForm">
            @csrf

            <div class="row g-4">
                
                <!-- LEFT COLUMN: WIZARD PANES -->
                <div class="col-lg-7">

                    <!-- PANE 1: CHOOSE PLAN -->
                    <div class="min-chk-card p-4 wizard-step-pane" id="stepPane1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="fw-bold mb-1 min-chk-title">Step 1: Choose Subscription Plan</h5>
                                <p class="text-xs mb-0 min-chk-muted">Select the plan package that fits your organization.</p>
                            </div>

                            <div class="btn-group p-1 rounded-pill min-chk-inner" role="group">
                                <input type="radio" class="btn-check" name="billing_interval" id="interval_monthly" value="monthly" checked onchange="recalculateMinimalTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3 min-chk-title" for="interval_monthly">Monthly</label>

                                <input type="radio" class="btn-check" name="billing_interval" id="interval_yearly" value="yearly" onchange="recalculateMinimalTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3 min-chk-title" for="interval_yearly">Annual <span class="badge bg-emerald-500 text-white ms-1">Save 20%</span></label>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($plans as $p)
                            <div class="col-md-4">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer plan-radio-card transition position-relative min-chk-inner {{ $selectedPlan->id == $p->id ? 'border-indigo-600 bg-indigo-50/50' : '' }}" style="cursor:pointer;">
                                    <input type="radio" name="plan_id" value="{{ $p->id }}" data-price="{{ $p->price_monthly }}" data-monthly="{{ $p->price_monthly }}" data-yearly="{{ $p->price_yearly }}" data-name="{{ $p->name }}" class="d-none plan-radio-input" {{ $selectedPlan->id == $p->id ? 'checked' : '' }} onchange="selectMinimalPlan(this)">
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold fs-6 min-chk-title">{{ $p->name }}</div>
                                        @if($p->is_popular || $p->name === 'Growth Pro')
                                            <span class="badge bg-indigo-600 text-white text-[10px] rounded-pill px-2.5 py-1">Popular</span>
                                        @endif
                                    </div>

                                    <div class="fs-4 font-extrabold text-indigo-600 mb-2">
                                        $<span class="plan-card-price" data-monthly="{{ number_format($p->price_monthly, 2) }}" data-yearly="{{ number_format($p->price_yearly, 2) }}">{{ number_format($p->price_monthly, 2) }}</span>
                                    </div>
                                    <div class="text-xs min-chk-muted">Max {{ $p->max_users ?? 'Unlimited' }} Users</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PANE 2: COMPANY & ADMIN ACCOUNT -->
                    <div class="min-chk-card p-4 wizard-step-pane" id="stepPane2" style="display:none;">
                        <h5 class="fw-bold mb-1 min-chk-title">Step 2: Company & Admin Details</h5>
                        <p class="text-xs mb-4 min-chk-muted">Enter your company subdomain and administrator login credentials.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label text-xs font-semibold min-chk-title">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-control min-chk-input" value="{{ old('company_name', auth()->user()?->tenant?->name ?? 'Acme Corp') }}" placeholder="Acme Corp" required oninput="autoMinimalSlug(this.value)">
                            </div>
                            <div class="col-md-6">
                                <label for="subdomain" class="form-label text-xs font-semibold min-chk-title">Company Subdomain</label>
                                <div class="input-group">
                                    <input type="text" name="subdomain" id="subdomain" class="form-control border-end-0 font-mono text-xs min-chk-input" value="{{ old('subdomain', auth()->user()?->tenant?->subdomain ?? 'acme') }}" placeholder="acme" {{ auth()->check() ? 'readonly' : 'required' }}>
                                    <span class="input-group-text border-start-0 text-xs font-mono min-chk-inner min-chk-muted">.saas.local</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label text-xs font-semibold min-chk-title">Billing Contact Name</label>
                                <input type="text" name="name" id="name" class="form-control min-chk-input" value="{{ old('name', auth()->user()?->name ?? '') }}" placeholder="John Doe" required>
                                <input type="hidden" name="billing_name" value="{{ auth()->user()?->name ?? 'John Doe' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-xs font-semibold min-chk-title">Billing Email Address</label>
                                <input type="email" name="email" id="email" class="form-control min-chk-input" value="{{ old('email', auth()->user()?->email ?? '') }}" placeholder="john@acme.com" required>
                                <input type="hidden" name="billing_email" value="{{ auth()->user()?->email ?? 'john@acme.com' }}">
                            </div>
                            @if(!auth()->check())
                            <div class="col-md-6">
                                <label for="password" class="form-label text-xs font-semibold min-chk-title">Password</label>
                                <input type="password" name="password" id="password" class="form-control min-chk-input" placeholder="••••••••" required minlength="8">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label text-xs font-semibold min-chk-title">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control min-chk-input" placeholder="••••••••" required minlength="8">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- PANE 3: OPTIONAL HR ADDONS & COUPONS -->
                    <div class="min-chk-card p-4 wizard-step-pane" id="stepPane3" style="display:none;">
                        <h5 class="fw-bold mb-1 min-chk-title">Step 3: Optional HR Modules & Voucher</h5>
                        <p class="text-xs mb-4 min-chk-muted">Select add-on HR modules and apply promo coupon codes.</p>

                        @if($addons->count() > 0)
                        <div class="row g-3 mb-4">
                            @foreach($addons as $ad)
                            <div class="col-md-12">
                                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between min-chk-inner">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" name="addons[]" value="{{ $ad->id }}" data-price="{{ $ad->price }}" id="addon_{{ $ad->id }}" class="form-check-input addon-checkbox" onchange="recalculateMinimalTotal()" style="width:20px; height:20px;">
                                        <div>
                                            <label for="addon_{{ $ad->id }}" class="fw-bold text-sm mb-0 cursor-pointer min-chk-title">{{ $ad->name }}</label>
                                            <div class="text-xs min-chk-muted">{{ $ad->description }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-indigo-600 text-sm">
                                        +${{ number_format($ad->price, 2) }}/mo
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div>
                            <label for="coupon_code" class="form-label text-xs font-semibold min-chk-title">Promo Coupon</label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" name="coupon_code" class="form-control font-mono text-xs uppercase min-chk-input" placeholder="e.g. SAVE20">
                                <button type="button" class="btn btn-indigo text-xs font-semibold px-4 text-white" style="background:#4f46e5;" onclick="applyMinimalCoupon()">Apply Voucher</button>
                            </div>
                            <div id="couponFeedback" class="text-xs mt-2 font-semibold"></div>
                        </div>
                    </div>

                    <!-- PANE 4: PAYMENT CHANNEL & SUBMIT -->
                    <div class="min-chk-card p-4 wizard-step-pane" id="stepPane4" style="display:none;">
                        <h5 class="fw-bold mb-1 min-chk-title">Step 4: Select Payment Channel</h5>
                        <p class="text-xs mb-4 min-chk-muted">Choose your payment channel to activate your SaaS subscription.</p>

                        <div class="row g-3 mb-4">
                            @foreach($gateways as $idx => $g)
                            <div class="col-md-6">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer gateway-radio-card transition min-chk-inner {{ $g->is_default || $idx == 0 ? 'border-indigo-600 bg-indigo-50/50' : '' }}" style="cursor:pointer;">
                                    <input type="radio" name="gateway_id" value="{{ $g->id }}" data-code="{{ $g->code }}" class="d-none gateway-radio-input" {{ $g->is_default || $idx == 0 ? 'checked' : '' }} onchange="selectMinimalGateway(this)">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2.5 rounded-3 border min-chk-card">
                                            @if($g->code === 'stripe')
                                                <i class="bi bi-credit-card-2-front fs-4 text-indigo-600"></i>
                                            @elseif($g->code === 'paypal')
                                                <i class="bi bi-paypal fs-4 text-blue-600"></i>
                                            @elseif($g->code === 'razorpay')
                                                <i class="bi bi-qr-code-scan fs-4 text-cyan-600"></i>
                                            @else
                                                <i class="bi bi-bank fs-4 text-emerald-600"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-xs mb-0 min-chk-title">{{ $g->name }}</div>
                                            <span class="text-[10px] min-chk-muted">Mode: {{ strtoupper($g->mode) }}</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- DYNAMIC CARD FORM SIMULATION -->
                        <div id="minCardForm" class="p-3 rounded-3 min-chk-inner border mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-xs min-chk-title"><i class="bi bi-credit-card me-1"></i> Payment Card Details</span>
                                <span class="badge bg-emerald-500 text-white text-[10px]">Encrypted</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <input type="text" class="form-control min-chk-input font-mono text-xs" placeholder="4242 •••• •••• 4242" value="4242 4242 4242 4242">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control min-chk-input font-mono text-xs" placeholder="MM/YY" value="12/28">
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control min-chk-input font-mono text-xs" placeholder="CVC" value="123">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- WIZARD STEP NAVIGATION BUTTONS -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 font-semibold text-xs" id="btnPrevStep" onclick="prevWizardStep()" style="display:none;">
                            <i class="bi bi-arrow-left me-1"></i> Back Step
                        </button>

                        <div>
                            <button type="button" class="btn btn-indigo text-white rounded-pill px-5 py-2.5 font-bold text-sm shadow-md" style="background:#4f46e5;" id="btnNextStep" onclick="nextWizardStep()">
                                Continue to Account <i class="bi bi-arrow-right ms-1"></i>
                            </button>

                            <button type="submit" class="btn btn-indigo text-white rounded-pill px-5 py-2.5 font-bold text-sm shadow-lg" id="btnSubmitOrder" style="background:#4f46e5; display:none;">
                                <i class="bi bi-check-lg me-2"></i> {{ auth()->check() ? 'Complete Payment & Upgrade' : 'Register & Complete Payment' }}
                            </button>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: SUMMARY -->
                <div class="col-lg-5">
                    <div class="min-chk-card p-4 sticky-top" style="top: 80px;">
                        <h5 class="fw-bold mb-3 min-chk-title">Order Summary</h5>

                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3 border-slate-200 dark:border-slate-800">
                            <div>
                                <span class="fw-bold d-block min-chk-title" id="summaryPlanName">{{ $selectedPlan->name }}</span>
                                <span class="text-xs min-chk-muted" id="summaryIntervalText">Billed Monthly</span>
                            </div>
                            <div class="fw-bold fs-5 min-chk-title" id="summarySubtotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- BREAKDOWN -->
                        <div class="space-y-2 text-xs border-top pt-3 mb-3 min-chk-muted border-slate-200 dark:border-slate-800">
                            <div class="d-flex justify-content-between">
                                <span>Plan Base Price</span>
                                <span id="breakdownPlan">${{ number_format($selectedPlan->price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Selected Addons</span>
                                <span id="breakdownAddons">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-emerald-600 font-semibold" id="discountRow" style="display:none !important;">
                                <span>Voucher Discount</span>
                                <span id="breakdownDiscount">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Instant Setup</span>
                                <span class="text-emerald-600 font-semibold">FREE ($0.00)</span>
                            </div>
                        </div>

                        <!-- TOTAL DUE TODAY -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 border mb-3 min-chk-inner">
                            <div>
                                <span class="text-xs uppercase font-semibold d-block min-chk-muted">Total Due Today</span>
                                <span class="text-[10px] min-chk-muted">Instant Activation</span>
                            </div>
                            <div class="fs-3 font-extrabold text-indigo-600" id="summaryTotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <div class="text-center text-xs min-chk-muted">
                            Already have an account? <a href="{{ route('auth.login') }}" class="text-indigo-600 text-decoration-none font-semibold">Sign In</a>
                        </div>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
    let currentWizardStep = 1;
    const totalWizardSteps = 4;

    let minimalPlanPrice = {{ $selectedPlan->price }};
    let minimalAddonsTotal = 0;
    let minimalDiscountPercent = 0;

    function showWizardStep(step) {
        for (let i = 1; i <= totalWizardSteps; i++) {
            const pane = document.getElementById('stepPane' + i);
            const indicator = document.getElementById('stepIndicator' + i);
            
            if (i === step) {
                pane.style.display = 'block';
                indicator.className = 'step-progress-item active';
            } else if (i < step) {
                pane.style.display = 'none';
                indicator.className = 'step-progress-item completed';
            } else {
                pane.style.display = 'none';
                indicator.className = 'step-progress-item';
            }
        }

        const fillPercent = ((step - 1) / (totalWizardSteps - 1)) * 100;
        document.getElementById('wizardProgressBar').style.width = fillPercent + '%';

        const btnPrev = document.getElementById('btnPrevStep');
        const btnNext = document.getElementById('btnNextStep');
        const btnSubmit = document.getElementById('btnSubmitOrder');

        btnPrev.style.display = (step > 1) ? 'inline-block' : 'none';
        btnNext.style.display = (step < totalWizardSteps) ? 'inline-block' : 'none';
        btnSubmit.style.display = (step === totalWizardSteps) ? 'inline-block' : 'none';

        if (step === 1) btnNext.innerHTML = 'Continue to Account <i class="bi bi-arrow-right ms-1"></i>';
        else if (step === 2) btnNext.innerHTML = 'Continue to Addons <i class="bi bi-arrow-right ms-1"></i>';
        else if (step === 3) btnNext.innerHTML = 'Continue to Payment <i class="bi bi-arrow-right ms-1"></i>';
    }

    function nextWizardStep() {
        if (currentWizardStep === 2) {
            const company = document.getElementById('company_name');
            const subdomain = document.getElementById('subdomain');
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const pass = document.getElementById('password');
            const passConf = document.getElementById('password_confirmation');

            if (!company.checkValidity() || !subdomain.checkValidity() || !name.checkValidity() || !email.checkValidity() || !pass.checkValidity() || !passConf.checkValidity()) {
                document.getElementById('minimalCheckoutForm').reportValidity();
                return;
            }
        }

        if (currentWizardStep < totalWizardSteps) {
            currentWizardStep++;
            showWizardStep(currentWizardStep);
        }
    }

    function prevWizardStep() {
        if (currentWizardStep > 1) {
            currentWizardStep--;
            showWizardStep(currentWizardStep);
        }
    }

    function autoMinimalSlug(val) {
        const slug = val.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('subdomain').value = slug;
    }

    function selectMinimalPlan(radio) {
        document.querySelectorAll('.plan-radio-card').forEach(c => {
            c.classList.remove('border-indigo-600', 'bg-indigo-50/50');
        });
        radio.closest('.plan-radio-card').classList.add('border-indigo-600', 'bg-indigo-50/50');
        recalculateMinimalTotal();
    }

    function selectMinimalGateway(radio) {
        document.querySelectorAll('.gateway-radio-card').forEach(c => {
            c.classList.remove('border-indigo-600', 'bg-indigo-50/50');
        });
        radio.closest('.gateway-radio-card').classList.add('border-indigo-600', 'bg-indigo-50/50');
    }

    function recalculateMinimalTotal() {
        const selectedPlanInput = document.querySelector('.plan-radio-input:checked');
        const intervalInput = document.querySelector('input[name="billing_interval"]:checked');
        const interval = intervalInput ? intervalInput.value : 'monthly';
        
        if (!selectedPlanInput) return;

        let monthlyPrice = parseFloat(selectedPlanInput.dataset.monthly || selectedPlanInput.dataset.price || 0);
        let yearlyPrice = parseFloat(selectedPlanInput.dataset.yearly || (monthlyPrice * 10));
        let basePrice = (interval === 'yearly') ? yearlyPrice : monthlyPrice;
        let planName = selectedPlanInput.dataset.name;

        if (interval === 'yearly') {
            document.getElementById('summaryIntervalText').innerText = 'Billed Annually (Save 20%)';
        } else {
            document.getElementById('summaryIntervalText').innerText = 'Billed Monthly';
        }

        document.querySelectorAll('.plan-card-price').forEach(el => {
            el.innerText = interval === 'yearly' ? el.dataset.yearly : parseFloat(el.dataset.monthly).toFixed(2);
        });

        minimalAddonsTotal = 0;
        document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
            let p = parseFloat(cb.dataset.price || 0);
            if (interval === 'yearly') p = p * 10;
            minimalAddonsTotal += p;
        });

        minimalPlanPrice = basePrice;
        let subtotal = minimalPlanPrice + minimalAddonsTotal;
        let discountAmount = subtotal * minimalDiscountPercent;
        let finalTotal = Math.max(0, subtotal - discountAmount);

        document.getElementById('summaryPlanName').innerText = planName;
        document.getElementById('breakdownPlan').innerText = '$' + minimalPlanPrice.toFixed(2);
        document.getElementById('breakdownAddons').innerText = '$' + minimalAddonsTotal.toFixed(2);
        document.getElementById('summarySubtotal').innerText = '$' + subtotal.toFixed(2);
        
        if (minimalDiscountPercent > 0) {
            document.getElementById('breakdownDiscount').innerText = '-$' + discountAmount.toFixed(2);
        }
        document.getElementById('summaryTotal').innerText = '$' + finalTotal.toFixed(2);
    }

    function applyMinimalCoupon() {
        const code = document.getElementById('coupon_code').value.trim().toUpperCase();
        const feedback = document.getElementById('couponFeedback');
        const discountRow = document.getElementById('discountRow');

        if (code === 'SAVE20' || code === 'WELCOME20') {
            minimalDiscountPercent = 0.20;
            feedback.className = 'text-xs mt-2 text-success font-semibold';
            feedback.innerText = '✔ Coupon SAVE20 applied! (20% Off)';
            discountRow.style.setProperty('display', 'flex', 'important');
        } else if (code === 'HALFOFF' || code === 'SAAS50') {
            minimalDiscountPercent = 0.50;
            feedback.className = 'text-xs mt-2 text-success font-semibold';
            feedback.innerText = '✔ Coupon SAAS50 applied! (50% Off)';
            discountRow.style.setProperty('display', 'flex', 'important');
        } else {
            minimalDiscountPercent = 0;
            feedback.className = 'text-xs mt-2 text-danger font-semibold';
            feedback.innerText = 'Invalid coupon code. Try SAVE20 or SAAS50.';
            discountRow.style.setProperty('display', 'none', 'important');
        }

        recalculateMinimalTotal();
    }
</script>
@endsection
