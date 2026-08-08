@extends('themes.cyber.layouts.marketing')

@section('title', 'Cyber Neon Multi-Step Checkout — ' . config('settings.project_name', 'SaaSStater'))

@section('content')
<style>
    .cyb-chk-page {
        background-color: #f0f9ff;
        color: #0369a1;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .cyb-chk-title { color: #0369a1; }
    .cyb-chk-muted { color: #0284c7; }
    .cyb-chk-card {
        background-color: #ffffff;
        border: 1px solid #7dd3fc;
        border-radius: 1.25rem;
        box-shadow: 0 0 15px rgba(56, 189, 248, 0.15);
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }
    .cyb-chk-inner {
        background-color: #e0f2fe;
        border-color: #7dd3fc !important;
    }
    .cyb-chk-input {
        background-color: #ffffff !important;
        border-color: #38bdf8 !important;
        color: #0369a1 !important;
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
        background: #7dd3fc;
        z-index: 1;
    }
    .step-progress-bar-fill {
        height: 100%;
        background: #06b6d4;
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
        border: 2px solid #38bdf8;
        color: #0369a1;
        font-weight: 700;
        font-family: monospace;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }
    .step-progress-item.active .step-icon-circle {
        background: #06b6d4;
        border-color: #06b6d4;
        color: #050b14;
        box-shadow: 0 0 15px rgba(6, 182, 212, 0.5);
    }
    .step-progress-item.completed .step-icon-circle {
        background: #10b981;
        border-color: #10b981;
        color: #ffffff;
    }
    .step-title-text {
        font-size: 0.75rem;
        font-weight: 600;
        font-family: monospace;
        color: #0284c7;
    }
    .step-progress-item.active .step-title-text {
        color: #06b6d4;
        font-weight: 700;
    }

    /* DARK MODE OVERRIDES */
    html.dark .cyb-chk-page, .dark .cyb-chk-page { background-color: #050b14 !important; color: #ffffff !important; }
    html.dark .cyb-chk-title, .dark .cyb-chk-title { color: #ffffff !important; }
    html.dark .cyb-chk-muted, .dark .cyb-chk-muted { color: #38bdf8 !important; }
    html.dark .cyb-chk-card, .dark .cyb-chk-card { background-color: #091322 !important; border-color: rgba(6, 182, 212, 0.3) !important; box-shadow: 0 0 20px rgba(6, 182, 212, 0.2) !important; }
    html.dark .cyb-chk-inner, .dark .cyb-chk-inner { background-color: #050b14 !important; border-color: rgba(6, 182, 212, 0.3) !important; }
    html.dark .cyb-chk-input, .dark .cyb-chk-input { background-color: #050b14 !important; border-color: rgba(6, 182, 212, 0.4) !important; color: #ffffff !important; }
    html.dark .step-progress-line, .dark .step-progress-line { background: rgba(6, 182, 212, 0.3); }
    html.dark .step-icon-circle, .dark .step-icon-circle { background: #050b14; border-color: rgba(6, 182, 212, 0.4); color: #38bdf8; }
</style>

<div class="py-5 cyb-chk-page">
    <div class="container max-w-6xl">
        
        <!-- Header -->
        <div class="text-center mb-5">
            <span class="badge border px-3 py-2 rounded-pill mb-2 font-mono" style="font-size: 0.75rem; background: rgba(6,182,212,0.15); border-color: var(--cyb-border) !important; color: var(--cyb-text-muted);">
                CYBER NEON MULTI-STEP WIZARD
            </span>
            <h1 class="fw-bold mb-2 display-5 font-mono cyb-chk-title">SYS_PROVISIONING // CHECKOUT</h1>
            <p class="lead mx-auto font-mono text-xs cyb-chk-muted" style="max-width: 600px;">[>] Execute 4 sequential steps to initialize tenant subdomain payload.</p>
        </div>

        <!-- MULTI-STEP PROGRESS WIZARD INDICATOR -->
        <div class="step-progress-wrapper px-3 max-w-3xl mx-auto">
            <div class="step-progress-line">
                <div class="step-progress-bar-fill" id="wizardProgressBar"></div>
            </div>
            
            <div class="step-progress-item active" id="stepIndicator1">
                <div class="step-icon-circle">01</div>
                <div class="step-title-text d-none d-sm-block">SELECT_TIER</div>
            </div>
            <div class="step-progress-item" id="stepIndicator2">
                <div class="step-icon-circle">02</div>
                <div class="step-title-text d-none d-sm-block">IDENTITY</div>
            </div>
            <div class="step-progress-item" id="stepIndicator3">
                <div class="step-icon-circle">03</div>
                <div class="step-title-text d-none d-sm-block">ADDONS</div>
            </div>
            <div class="step-progress-item" id="stepIndicator4">
                <div class="step-icon-circle">04</div>
                <div class="step-title-text d-none d-sm-block">GATEWAY</div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-4 mb-4 shadow-sm border-0 bg-danger/10 text-danger font-mono text-xs">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li><i class="bi bi-exclamation-circle-fill me-1"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ auth()->check() ? route('checkout.process') : route('auth.register.store') }}" method="POST" id="cyberCheckoutForm">
            @csrf

            <div class="row g-4">
                
                <!-- LEFT COLUMN: WIZARD PANES -->
                <div class="col-lg-7">

                    <!-- PANE 1: CHOOSE PLAN -->
                    <div class="cyb-chk-card p-4 wizard-step-pane" id="stepPane1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <h5 class="fw-bold mb-1 font-mono text-sm cyb-chk-title">Step 01: SELECT_TIER</h5>
                                <p class="text-xs mb-0 font-mono cyb-chk-muted">Select operational capacity parameters.</p>
                            </div>

                            <div class="btn-group p-1 rounded-pill cyb-chk-inner" style="border: 1px solid var(--cyb-border);" role="group">
                                <input type="radio" class="btn-check" name="billing_interval" id="interval_monthly" value="monthly" checked onchange="recalculateCyberTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-mono px-3 cyb-chk-title" for="interval_monthly">MONTHLY</label>

                                <input type="radio" class="btn-check" name="billing_interval" id="interval_yearly" value="yearly" onchange="recalculateCyberTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-mono px-3 cyb-chk-title" for="interval_yearly">ANNUAL <span class="badge bg-cyan-400 text-dark ms-1">-20%</span></label>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($plans as $p)
                            <div class="col-md-4">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer plan-radio-card transition position-relative cyb-chk-inner {{ $selectedPlan->id == $p->id ? 'border-cyan-400 bg-cyan-500/10' : '' }}" style="cursor:pointer;">
                                    <input type="radio" name="plan_id" value="{{ $p->id }}" data-price="{{ $p->price_monthly }}" data-monthly="{{ $p->price_monthly }}" data-yearly="{{ $p->price_yearly }}" data-name="{{ $p->name }}" class="d-none plan-radio-input" {{ $selectedPlan->id == $p->id ? 'checked' : '' }} onchange="selectCyberPlan(this)">
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold fs-6 font-mono cyb-chk-title">{{ $p->name }}</div>
                                        @if($p->is_popular || $p->name === 'Growth Pro')
                                            <span class="badge bg-cyan-400 text-dark text-[10px] rounded-pill px-2.5 py-1 font-mono">POPULAR</span>
                                        @endif
                                    </div>

                                    <div class="fs-4 font-extrabold text-cyan-600 mb-2 font-mono">
                                        $<span class="plan-card-price" data-monthly="{{ number_format($p->price_monthly, 2) }}" data-yearly="{{ number_format($p->price_yearly, 2) }}">{{ number_format($p->price_monthly, 2) }}</span>
                                    </div>
                                    <div class="text-xs font-mono cyb-chk-muted">Max {{ $p->max_users ?? 'Unlimited' }} Users</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- PANE 2: COMPANY & ADMIN ACCOUNT -->
                    <div class="cyb-chk-card p-4 wizard-step-pane" id="stepPane2" style="display:none;">
                        <h5 class="fw-bold mb-1 font-mono text-sm cyb-chk-title">Step 02: TENANT_IDENTITY</h5>
                        <p class="text-xs mb-4 font-mono cyb-chk-muted">Configure tenant subdomain and admin authentication key.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label text-xs font-mono cyb-chk-title">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-control cyb-chk-input font-mono text-xs" value="{{ old('company_name', auth()->user()?->tenant?->name ?? 'Acme Corp') }}" placeholder="Acme Corp" required oninput="autoCyberSlug(this.value)">
                            </div>
                            <div class="col-md-6">
                                <label for="subdomain" class="form-label text-xs font-mono cyb-chk-title">Company Subdomain</label>
                                <div class="input-group">
                                    <input type="text" name="subdomain" id="subdomain" class="form-control border-end-0 font-mono text-xs cyb-chk-input" value="{{ old('subdomain', auth()->user()?->tenant?->subdomain ?? 'acme') }}" placeholder="acme" {{ auth()->check() ? 'readonly' : 'required' }}>
                                    <span class="input-group-text border-start-0 text-xs font-mono cyb-chk-inner cyb-chk-muted">.saas.local</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label text-xs font-mono cyb-chk-title">Billing Contact Name</label>
                                <input type="text" name="name" id="name" class="form-control cyb-chk-input font-mono text-xs" value="{{ old('name', auth()->user()?->name ?? '') }}" placeholder="John Doe" required>
                                <input type="hidden" name="billing_name" value="{{ auth()->user()?->name ?? 'John Doe' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label text-xs font-mono cyb-chk-title">Billing Email</label>
                                <input type="email" name="email" id="email" class="form-control cyb-chk-input font-mono text-xs" value="{{ old('email', auth()->user()?->email ?? '') }}" placeholder="john@acme.com" required>
                                <input type="hidden" name="billing_email" value="{{ auth()->user()?->email ?? 'john@acme.com' }}">
                            </div>
                            @if(!auth()->check())
                            <div class="col-md-6">
                                <label for="password" class="form-label text-xs font-mono cyb-chk-title">Password</label>
                                <input type="password" name="password" id="password" class="form-control cyb-chk-input font-mono text-xs" placeholder="••••••••" required minlength="8">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label text-xs font-mono cyb-chk-title">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control cyb-chk-input font-mono text-xs" placeholder="••••••••" required minlength="8">
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- PANE 3: OPTIONAL HR ADDONS & COUPONS -->
                    <div class="cyb-chk-card p-4 wizard-step-pane" id="stepPane3" style="display:none;">
                        <h5 class="fw-bold mb-1 font-mono text-sm cyb-chk-title">Step 03: ADDON_MODULES</h5>
                        <p class="text-xs mb-4 font-mono cyb-chk-muted">Inject optional HR expansion modules and discount vouchers.</p>

                        @if($addons->count() > 0)
                        <div class="row g-3 mb-4">
                            @foreach($addons as $ad)
                            <div class="col-md-12">
                                <div class="p-3 rounded-3 border d-flex align-items-center justify-content-between cyb-chk-inner">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" name="addons[]" value="{{ $ad->id }}" data-price="{{ $ad->price }}" id="addon_{{ $ad->id }}" class="form-check-input addon-checkbox" onchange="recalculateCyberTotal()" style="width:20px; height:20px;">
                                        <div>
                                            <label for="addon_{{ $ad->id }}" class="fw-bold text-sm mb-0 cursor-pointer font-mono cyb-chk-title">{{ $ad->name }}</label>
                                            <div class="text-xs font-mono cyb-chk-muted">{{ $ad->description }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-cyan-600 text-sm font-mono">
                                        +${{ number_format($ad->price, 2) }}/mo
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <div>
                            <label for="coupon_code" class="form-label text-xs font-mono cyb-chk-title">PROMO_VOUCHER</label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" name="coupon_code" class="form-control font-mono text-xs uppercase cyb-chk-input" placeholder="e.g. SAVE20">
                                <button type="button" class="btn btn-info text-xs font-mono text-dark fw-bold px-4" style="background:#06b6d4;" onclick="applyCyberCoupon()">APPLY</button>
                            </div>
                            <div id="couponFeedback" class="text-xs mt-2 font-mono"></div>
                        </div>
                    </div>

                    <!-- PANE 4: PAYMENT CHANNEL & SUBMIT -->
                    <div class="cyb-chk-card p-4 wizard-step-pane" id="stepPane4" style="display:none;">
                        <h5 class="fw-bold mb-1 font-mono text-sm cyb-chk-title">Step 04: PAYMENT_GATEWAY</h5>
                        <p class="text-xs mb-4 font-mono cyb-chk-muted">Select gateway node to execute final subscription payload.</p>

                        <div class="row g-3 mb-4">
                            @foreach($gateways as $idx => $g)
                            <div class="col-md-6">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer gateway-radio-card transition cyb-chk-inner {{ $g->is_default || $idx == 0 ? 'border-cyan-400 bg-cyan-500/10' : '' }}" style="cursor:pointer;">
                                    <input type="radio" name="gateway_id" value="{{ $g->id }}" data-code="{{ $g->code }}" class="d-none gateway-radio-input" {{ $g->is_default || $idx == 0 ? 'checked' : '' }} onchange="selectCyberGateway(this)">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2.5 rounded-3 border cyb-chk-card">
                                            @if($g->code === 'stripe')
                                                <i class="bi bi-credit-card-2-front fs-4 text-cyan-600"></i>
                                            @elseif($g->code === 'paypal')
                                                <i class="bi bi-paypal fs-4 text-blue-600"></i>
                                            @elseif($g->code === 'razorpay')
                                                <i class="bi bi-qr-code-scan fs-4 text-teal-600"></i>
                                            @else
                                                <i class="bi bi-bank fs-4 text-emerald-600"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-xs mb-0 font-mono cyb-chk-title">{{ $g->name }}</div>
                                            <span class="text-[10px] font-mono cyb-chk-muted">MODE: {{ strtoupper($g->mode) }}</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- DYNAMIC CARD FORM SIMULATION -->
                        <div id="cybCardForm" class="p-3 rounded-3 cyb-chk-inner border mb-3 font-mono">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-xs cyb-chk-title"><i class="bi bi-credit-card me-1"></i> CARD_CREDENTIALS</span>
                                <span class="badge bg-cyan-400 text-dark text-[10px]">ENCRYPTED</span>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-12">
                                    <input type="text" class="form-control cyb-chk-input font-mono text-xs" placeholder="4242 •••• •••• 4242" value="4242 4242 4242 4242">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control cyb-chk-input font-mono text-xs" placeholder="MM/YY" value="12/28">
                                </div>
                                <div class="col-md-6">
                                    <input type="password" class="form-control cyb-chk-input font-mono text-xs" placeholder="CVC" value="123">
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- WIZARD STEP NAVIGATION BUTTONS -->
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4 font-mono text-xs" id="btnPrevStep" onclick="prevWizardStep()" style="display:none;">
                            [<] BACK_STEP
                        </button>

                        <div>
                            <button type="button" class="btn btn-info text-dark font-mono font-bold rounded-pill px-5 py-2.5 text-sm shadow-md" style="background:#06b6d4;" id="btnNextStep" onclick="nextWizardStep()">
                                CONTINUE_TO_IDENTITY [>]
                            </button>

                            <button type="submit" class="btn btn-info text-dark font-mono font-bold rounded-pill px-5 py-2.5 text-sm shadow-lg" id="btnSubmitOrder" style="background:#06b6d4; display:none;">
                                [>] {{ auth()->check() ? 'EXECUTE PAYMENT & UPGRADE' : 'INITIALIZE & EXECUTE CHECKOUT' }}
                            </button>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: SUMMARY -->
                <div class="col-lg-5">
                    <div class="cyb-chk-card p-4 sticky-top" style="top: 80px;">
                        <h5 class="fw-bold mb-3 font-mono text-sm cyb-chk-title">// ORDER_SUMMARY</h5>

                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3 border-slate-200 dark:border-slate-800">
                            <div>
                                <span class="fw-bold d-block font-mono cyb-chk-title" id="summaryPlanName">{{ $selectedPlan->name }}</span>
                                <span class="text-xs font-mono cyb-chk-muted" id="summaryIntervalText">BILLED_MONTHLY</span>
                            </div>
                            <div class="fw-bold fs-5 font-mono cyb-chk-title" id="summarySubtotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- BREAKDOWN -->
                        <div class="space-y-2 text-xs font-mono border-top pt-3 mb-3 cyb-chk-muted border-slate-200 dark:border-slate-800">
                            <div class="d-flex justify-content-between">
                                <span>PLAN_PRICE</span>
                                <span id="breakdownPlan">${{ number_format($selectedPlan->price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>ADDONS_TOTAL</span>
                                <span id="breakdownAddons">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-emerald-500 font-semibold" id="discountRow" style="display:none !important;">
                                <span>DISCOUNT</span>
                                <span id="breakdownDiscount">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>PROVISIONING_FEE</span>
                                <span class="text-emerald-500 font-semibold">FREE ($0.00)</span>
                            </div>
                        </div>

                        <!-- TOTAL DUE TODAY -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 border mb-3 cyb-chk-inner">
                            <div>
                                <span class="text-xs uppercase font-mono d-block cyb-chk-muted">TOTAL_DUE</span>
                                <span class="text-[10px] font-mono cyb-chk-muted">INSTANT_PROVISION</span>
                            </div>
                            <div class="fs-3 font-extrabold text-cyan-600 font-mono" id="summaryTotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <div class="text-center text-xs font-mono cyb-chk-muted">
                            AUTHENTICATED SSL ENCRYPTION
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

    let cyberPlanPrice = {{ $selectedPlan->price }};
    let cyberAddonsTotal = 0;
    let cyberDiscountPercent = 0;

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

        if (step === 1) btnNext.innerHTML = 'CONTINUE_TO_IDENTITY [>]';
        else if (step === 2) btnNext.innerHTML = 'CONTINUE_TO_ADDONS [>]';
        else if (step === 3) btnNext.innerHTML = 'CONTINUE_TO_GATEWAY [>]';
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
                document.getElementById('cyberCheckoutForm').reportValidity();
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

    function autoCyberSlug(val) {
        const slug = val.toLowerCase().replace(/[^a-z0-9]/g, '-').replace(/-+/g, '-').replace(/^-|-$/g, '');
        document.getElementById('subdomain').value = slug;
    }

    function selectCyberPlan(radio) {
        document.querySelectorAll('.plan-radio-card').forEach(c => {
            c.classList.remove('border-cyan-400', 'bg-cyan-500/10');
        });
        radio.closest('.plan-radio-card').classList.add('border-cyan-400', 'bg-cyan-500/10');
        recalculateCyberTotal();
    }

    function selectCyberGateway(radio) {
        document.querySelectorAll('.gateway-radio-card').forEach(c => {
            c.classList.remove('border-cyan-400', 'bg-cyan-500/10');
        });
        radio.closest('.gateway-radio-card').classList.add('border-cyan-400', 'bg-cyan-500/10');
    }

    function recalculateCyberTotal() {
        const selectedPlanInput = document.querySelector('.plan-radio-input:checked');
        const intervalInput = document.querySelector('input[name="billing_interval"]:checked');
        const interval = intervalInput ? intervalInput.value : 'monthly';
        
        if (!selectedPlanInput) return;

        let monthlyPrice = parseFloat(selectedPlanInput.dataset.monthly || selectedPlanInput.dataset.price || 0);
        let yearlyPrice = parseFloat(selectedPlanInput.dataset.yearly || (monthlyPrice * 10));
        let basePrice = (interval === 'yearly') ? yearlyPrice : monthlyPrice;
        let planName = selectedPlanInput.dataset.name;

        if (interval === 'yearly') {
            document.getElementById('summaryIntervalText').innerText = 'BILLED_ANNUALLY (-20%)';
        } else {
            document.getElementById('summaryIntervalText').innerText = 'BILLED_MONTHLY';
        }

        document.querySelectorAll('.plan-card-price').forEach(el => {
            el.innerText = interval === 'yearly' ? el.dataset.yearly : parseFloat(el.dataset.monthly).toFixed(2);
        });

        cyberAddonsTotal = 0;
        document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
            let p = parseFloat(cb.dataset.price || 0);
            if (interval === 'yearly') p = p * 10;
            cyberAddonsTotal += p;
        });

        cyberPlanPrice = basePrice;
        let subtotal = cyberPlanPrice + cyberAddonsTotal;
        let discountAmount = subtotal * cyberDiscountPercent;
        let finalTotal = Math.max(0, subtotal - discountAmount);

        document.getElementById('summaryPlanName').innerText = planName;
        document.getElementById('breakdownPlan').innerText = '$' + cyberPlanPrice.toFixed(2);
        document.getElementById('breakdownAddons').innerText = '$' + cyberAddonsTotal.toFixed(2);
        document.getElementById('summarySubtotal').innerText = '$' + subtotal.toFixed(2);
        
        if (cyberDiscountPercent > 0) {
            document.getElementById('breakdownDiscount').innerText = '-$' + discountAmount.toFixed(2);
        }
        document.getElementById('summaryTotal').innerText = '$' + finalTotal.toFixed(2);
    }

    function applyCyberCoupon() {
        const code = document.getElementById('coupon_code').value.trim().toUpperCase();
        const feedback = document.getElementById('couponFeedback');
        const discountRow = document.getElementById('discountRow');

        if (code === 'SAVE20' || code === 'WELCOME20') {
            cyberDiscountPercent = 0.20;
            feedback.className = 'text-xs mt-2 text-success font-mono font-semibold';
            feedback.innerText = '✔ COUPON_SAVE20_APPLIED (-20%)';
            discountRow.style.setProperty('display', 'flex', 'important');
        } else if (code === 'HALFOFF' || code === 'SAAS50') {
            cyberDiscountPercent = 0.50;
            feedback.className = 'text-xs mt-2 text-success font-mono font-semibold';
            feedback.innerText = '✔ COUPON_SAAS50_APPLIED (-50%)';
            discountRow.style.setProperty('display', 'flex', 'important');
        } else {
            cyberDiscountPercent = 0;
            feedback.className = 'text-xs mt-2 text-danger font-mono font-semibold';
            feedback.innerText = 'ERR: INVALID_COUPON (TRY SAVE20 / SAAS50)';
            discountRow.style.setProperty('display', 'none', 'important');
        }

        recalculateCyberTotal();
    }
</script>
@endsection
