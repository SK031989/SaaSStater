@extends('dashboard::layouts.admin')

@section('title', 'Secure Checkout — Plan Subscription & Payment')

@section('content')
<style>
    .chk-card-hover {
        transition: all 0.25s ease-in-out;
    }
    .chk-card-hover:hover {
        transform: translateY(-2px);
    }
    .chk-active-glow {
        box-shadow: 0 0 20px rgba(99, 102, 241, 0.15);
    }
</style>

<div class="container-fluid py-4">
    <div class="max-w-6xl mx-auto">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 font-bold text-slate-900 dark:text-white mb-1">
                    <i class="bi bi-shield-lock-fill text-indigo-500 me-2"></i> Secure Plan Checkout
                </h1>
                <p class="text-sm text-slate-500 mb-0">Select your subscription tier, add optional modules, apply promo vouchers, and complete instant payment.</p>
            </div>
            <a href="{{ route('subscriptions.index') }}" class="btn btn-outline-secondary rounded-pill px-4 font-medium text-sm">
                <i class="bi bi-arrow-left me-1"></i> Change Plan
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger rounded-4 mb-4 shadow-sm border-0 bg-danger/10 text-danger">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="row g-4">
                
                <!-- LEFT COLUMN: BILLING & PAYMENT SELECTION -->
                <div class="col-lg-7">
                    
                    <!-- STEP 1: PLAN & BILLING INTERVAL -->
                    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h5 class="fw-bold text-slate-900 dark:text-white mb-0">
                                <span class="badge bg-indigo-500 text-white rounded-circle me-2" style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center;">1</span>
                                Select Subscription Tier
                            </h5>
                            
                            <!-- Monthly / Annual Toggle -->
                            <div class="btn-group p-1 bg-slate-100 dark:bg-slate-800 rounded-pill" role="group">
                                <input type="radio" class="btn-check" name="billing_interval" id="interval_monthly" value="monthly" checked onchange="updateCheckoutTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3" for="interval_monthly">Monthly</label>

                                <input type="radio" class="btn-check" name="billing_interval" id="interval_yearly" value="yearly" onchange="updateCheckoutTotal()">
                                <label class="btn btn-sm rounded-pill text-xs font-semibold px-3" for="interval_yearly">Annual <span class="badge bg-emerald-500 text-white ms-1">Save 20%</span></label>
                            </div>
                        </div>

                        <div class="row g-3">
                            @foreach($plans as $p)
                            <div class="col-md-4">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer plan-radio-card chk-card-hover transition position-relative {{ $selectedPlan->id == $p->id ? 'border-indigo-500 bg-indigo-50/30 dark:bg-indigo-500/10 chk-active-glow' : 'border-slate-200 dark:border-slate-800' }}" style="cursor:pointer;">
                                    <input type="radio" name="plan_id" value="{{ $p->id }}" data-price="{{ $p->price_monthly }}" data-monthly="{{ $p->price_monthly }}" data-yearly="{{ $p->price_yearly }}" data-name="{{ $p->name }}" class="d-none plan-radio-input" {{ $selectedPlan->id == $p->id ? 'checked' : '' }} onchange="selectPlan(this)">
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="fw-bold text-slate-900 dark:text-white fs-6">{{ $p->name }}</div>
                                        @if($p->is_popular || $p->name === 'Growth Pro')
                                            <span class="badge bg-indigo-600 text-white text-[10px] rounded-pill px-2.5 py-1">Popular</span>
                                        @endif
                                    </div>

                                    <div class="fs-4 font-extrabold text-indigo-600 dark:text-indigo-400 mb-2">
                                        $<span class="plan-card-price" data-monthly="{{ number_format($p->price_monthly, 2) }}" data-yearly="{{ number_format($p->price_yearly, 2) }}">{{ number_format($p->price_monthly, 2) }}</span>
                                    </div>
                                    <div class="text-xs text-slate-500">Max {{ $p->max_users ?? 'Unlimited' }} Users</div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- STEP 2: OPTIONAL HR ADDON MODULES -->
                    @if(isset($addons) && $addons->count() > 0)
                    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 mb-4">
                        <h5 class="fw-bold text-slate-900 dark:text-white mb-3">
                            <span class="badge bg-indigo-500 text-white rounded-circle me-2" style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center;">2</span>
                            Optional Add-on Expansion Modules
                        </h5>

                        <div class="row g-3">
                            @foreach($addons as $ad)
                            <div class="col-md-12">
                                <label class="p-3 rounded-4 border d-flex align-items-center justify-content-between cursor-pointer transition border-slate-200 dark:border-slate-800 hover:border-indigo-500 bg-slate-50/50 dark:bg-slate-800/40" style="cursor:pointer;">
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="checkbox" name="addons[]" value="{{ $ad->id }}" data-price="{{ $ad->price }}" id="addon_{{ $ad->id }}" class="form-check-input addon-checkbox" onchange="updateCheckoutTotal()" style="width:20px; height:20px;">
                                        <div>
                                            <div class="fw-bold text-sm text-slate-900 dark:text-white mb-0">{{ $ad->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $ad->description }}</div>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-indigo-600 dark:text-indigo-400 text-sm">
                                        +${{ number_format($ad->price, 2) }}/mo
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- STEP 3: BILLING INFORMATION -->
                    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4 mb-4">
                        <h5 class="fw-bold text-slate-900 dark:text-white mb-3">
                            <span class="badge bg-indigo-500 text-white rounded-circle me-2" style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center;">3</span>
                            Billing Contact Details
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="billing_name" class="form-label text-xs font-semibold text-slate-700 dark:text-slate-300">Full Name</label>
                                <input type="text" name="billing_name" id="billing_name" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('billing_name', auth()->user()->name ?? '') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="billing_email" class="form-label text-xs font-semibold text-slate-700 dark:text-slate-300">Billing Email</label>
                                <input type="email" name="billing_email" id="billing_email" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('billing_email', auth()->user()->email ?? '') }}" required>
                            </div>
                            <div class="col-md-12">
                                <label for="company_name" class="form-label text-xs font-semibold text-slate-700 dark:text-slate-300">Company / Organization</label>
                                <input type="text" name="company_name" id="company_name" class="form-control dark:bg-slate-800 dark:border-slate-700 dark:text-white rounded-3" value="{{ old('company_name', auth()->user()->tenant->name ?? 'Acme Corp') }}" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: PAYMENT METHOD SELECTION -->
                    <div class="card border-0 shadow-sm rounded-4 bg-white dark:bg-slate-900 p-4">
                        <h5 class="fw-bold text-slate-900 dark:text-white mb-3">
                            <span class="badge bg-indigo-500 text-white rounded-circle me-2" style="width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center;">4</span>
                            Select Payment Channel
                        </h5>

                        <div class="row g-3 mb-4">
                            @foreach($gateways as $idx => $g)
                            <div class="col-md-6">
                                <label class="card h-100 border-2 rounded-4 p-3 cursor-pointer gateway-radio-card chk-card-hover transition {{ $g->is_default || $idx == 0 ? 'border-indigo-500 bg-indigo-50/30 dark:bg-indigo-500/10 chk-active-glow' : 'border-slate-200 dark:border-slate-800' }}" style="cursor:pointer;">
                                    <input type="radio" name="gateway_id" value="{{ $g->id }}" data-code="{{ $g->code }}" class="d-none gateway-radio-input" {{ $g->is_default || $idx == 0 ? 'checked' : '' }} onchange="selectGateway(this)">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="p-2.5 rounded-3 bg-slate-100 dark:bg-slate-800">
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
                                            <div class="fw-bold text-slate-900 dark:text-white text-xs mb-0">{{ $g->name }}</div>
                                            <span class="text-[10px] text-slate-400">Mode: {{ strtoupper($g->mode) }}</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        </div>

                        <!-- DYNAMIC CARD FORM (STRIPE / CARD SIMULATION) -->
                        <div id="cardDetailsForm" class="p-4 rounded-4 bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <h6 class="fw-bold text-slate-800 dark:text-slate-200 text-xs mb-0"><i class="bi bi-credit-card me-1"></i> Credit / Debit Card Details</h6>
                                <span class="badge bg-emerald-500/10 text-emerald-500 text-[10px] font-semibold">256-Bit Encrypted</span>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="text-[10px] uppercase font-semibold text-slate-500 mb-1 d-block">Card Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control font-mono text-xs dark:bg-slate-900 dark:border-slate-700 dark:text-white rounded-start-3" placeholder="4242 •••• •••• 4242" value="4242 4242 4242 4242">
                                        <span class="input-group-text dark:bg-slate-900 dark:border-slate-700 text-indigo-500"><i class="bi bi-shield-check"></i></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-[10px] uppercase font-semibold text-slate-500 mb-1 d-block">Expiration Date</label>
                                    <input type="text" class="form-control font-mono text-xs dark:bg-slate-900 dark:border-slate-700 dark:text-white rounded-3" placeholder="MM/YY" value="12/28">
                                </div>
                                <div class="col-md-6">
                                    <label class="text-[10px] uppercase font-semibold text-slate-500 mb-1 d-block">Security Code (CVC)</label>
                                    <input type="password" class="form-control font-mono text-xs dark:bg-slate-900 dark:border-slate-700 dark:text-white rounded-3" placeholder="CVC" value="123">
                                </div>
                            </div>
                        </div>

                        <!-- PAYPAL NOTICE (DYNAMICALLY SHOWS IF PAYPAL SELECTED) -->
                        <div id="paypalNotice" class="p-3 rounded-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-xs" style="display:none;">
                            <i class="bi bi-paypal me-2 fs-5 align-middle"></i> You will be redirected to PayPal Express Checkout to log in and approve your subscription.
                        </div>

                        <!-- BANK TRANSFER NOTICE (DYNAMICALLY SHOWS IF BANK SELECTED) -->
                        <div id="bankNotice" class="p-3 rounded-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 text-xs" style="display:none;">
                            <i class="bi bi-bank me-2 fs-5 align-middle"></i> Wire Transfer Details: <strong>Bank of America - IBAN US98 1234 5678 9012</strong>. Subscription activates upon payment clearance.
                        </div>

                    </div>

                </div>

                <!-- RIGHT COLUMN: ORDER SUMMARY CARD -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 bg-white dark:bg-slate-900 p-4 sticky-top" style="top: 80px; z-index:100;">
                        <h5 class="fw-bold text-slate-900 dark:text-white mb-3">Order Summary</h5>

                        <div class="d-flex justify-content-between align-items-center pb-3 border-bottom mb-3 border-slate-100 dark:border-slate-800">
                            <div>
                                <span class="fw-bold text-slate-900 dark:text-white d-block" id="summaryPlanName">{{ $selectedPlan->name }}</span>
                                <span class="text-xs text-slate-400" id="summaryIntervalText">Billed Monthly</span>
                            </div>
                            <div class="fw-bold text-slate-900 dark:text-white fs-5" id="summarySubtotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- COUPON INPUT -->
                        <div class="mb-3">
                            <label for="coupon_code" class="form-label text-xs font-semibold text-slate-600 dark:text-slate-400">Have a Promo Voucher?</label>
                            <div class="input-group">
                                <input type="text" id="coupon_code" name="coupon_code" class="form-control font-mono text-xs uppercase dark:bg-slate-800 dark:border-slate-700 dark:text-white" placeholder="e.g. SAVE20">
                                <button type="button" class="btn btn-indigo text-xs font-semibold px-3" style="background:#6366f1; color:#fff;" onclick="applyCoupon()">Apply Voucher</button>
                            </div>
                            <div id="couponFeedback" class="text-xs mt-1 font-semibold"></div>
                        </div>

                        <!-- COST BREAKDOWN -->
                        <div class="space-y-2 text-xs text-slate-600 dark:text-slate-400 border-top border-slate-100 dark:border-slate-800 pt-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Plan Base Subtotal</span>
                                <span id="breakdownPlan">${{ number_format($selectedPlan->price, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between" id="addonsRow" style="display:none;">
                                <span>Selected Addon Modules</span>
                                <span id="breakdownAddons">$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between text-emerald-500 font-semibold" id="discountRow" style="display:none !important;">
                                <span>Voucher Discount</span>
                                <span id="breakdownDiscount">-$0.00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Instant SSL & Provisioning</span>
                                <span class="text-emerald-500 font-semibold">FREE ($0.00)</span>
                            </div>
                        </div>

                        <!-- TOTAL DUE TODAY -->
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4 bg-indigo-50/50 dark:bg-slate-800 border border-indigo-100 dark:border-slate-700 mb-4">
                            <div>
                                <span class="text-xs text-slate-500 uppercase font-semibold d-block">Total Due Today</span>
                                <span class="text-[10px] text-emerald-500 font-semibold">Instant Plan Upgrade</span>
                            </div>
                            <div class="fs-3 font-extrabold text-indigo-600 dark:text-indigo-400" id="summaryTotal">
                                ${{ number_format($selectedPlan->price, 2) }}
                            </div>
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="btn btn-indigo w-full rounded-pill py-3 font-bold fs-6 shadow-lg shadow-indigo-500/20 mb-3" style="background:#6366f1; color:#fff;">
                            <i class="bi bi-shield-check me-2"></i> Pay & Upgrade Subscription Now
                        </button>

                        <!-- SECURITY GUARANTEES -->
                        <div class="text-center text-xs text-slate-400 space-y-1">
                            <div><i class="bi bi-lock-fill text-emerald-500 me-1"></i> 256-Bit SSL Encrypted Payment</div>
                            <div><i class="bi bi-arrow-repeat text-indigo-400 me-1"></i> Flexible plan management from settings</div>
                        </div>

                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

<script>
    let planBasePrice = {{ $selectedPlan->price }};
    let addonsTotal = 0;
    let discountPercent = 0;

    function selectPlan(radio) {
        document.querySelectorAll('.plan-radio-card').forEach(c => {
            c.classList.remove('border-indigo-500', 'bg-indigo-50/30', 'dark:bg-indigo-500/10', 'chk-active-glow');
            c.classList.add('border-slate-200', 'dark:border-slate-800');
        });
        radio.closest('.plan-radio-card').classList.add('border-indigo-500', 'bg-indigo-50/30', 'dark:bg-indigo-500/10', 'chk-active-glow');
        updateCheckoutTotal();
    }

    function selectGateway(radio) {
        document.querySelectorAll('.gateway-radio-card').forEach(c => {
            c.classList.remove('border-indigo-500', 'bg-indigo-50/30', 'dark:bg-indigo-500/10', 'chk-active-glow');
            c.classList.add('border-slate-200', 'dark:border-slate-800');
        });
        radio.closest('.gateway-radio-card').classList.add('border-indigo-500', 'bg-indigo-50/30', 'dark:bg-indigo-500/10', 'chk-active-glow');

        const code = radio.dataset.code;
        const cardForm = document.getElementById('cardDetailsForm');
        const paypalNotice = document.getElementById('paypalNotice');
        const bankNotice = document.getElementById('bankNotice');

        if (cardForm) cardForm.style.display = (code === 'stripe' || code === 'razorpay') ? 'block' : 'none';
        if (paypalNotice) paypalNotice.style.display = (code === 'paypal') ? 'block' : 'none';
        if (bankNotice) bankNotice.style.display = (code === 'bank' || code === 'wire') ? 'block' : 'none';
    }

    function updateCheckoutTotal() {
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

        // Update Price Labels on Plan Cards
        document.querySelectorAll('.plan-card-price').forEach(el => {
            el.innerText = interval === 'yearly' ? el.dataset.yearly : parseFloat(el.dataset.monthly).toFixed(2);
        });

        // Calculate Addons Total
        addonsTotal = 0;
        document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
            let p = parseFloat(cb.dataset.price || 0);
            if (interval === 'yearly') p = p * 10;
            addonsTotal += p;
        });

        const addonsRow = document.getElementById('addonsRow');
        if (addonsRow) {
            if (addonsTotal > 0) {
                addonsRow.style.display = 'flex';
                document.getElementById('breakdownAddons').innerText = '+$' + addonsTotal.toFixed(2);
            } else {
                addonsRow.style.display = 'none';
            }
        }

        planBasePrice = basePrice;
        let subtotal = planBasePrice + addonsTotal;
        let discountAmount = subtotal * discountPercent;
        let finalTotal = Math.max(0, subtotal - discountAmount);

        document.getElementById('summaryPlanName').innerText = planName;
        document.getElementById('summarySubtotal').innerText = '$' + subtotal.toFixed(2);
        document.getElementById('breakdownPlan').innerText = '$' + planBasePrice.toFixed(2);

        const discountRow = document.getElementById('discountRow');
        if (discountPercent > 0 && discountRow) {
            discountRow.style.setProperty('display', 'flex', 'important');
            document.getElementById('breakdownDiscount').innerText = '-$' + discountAmount.toFixed(2);
        }

        document.getElementById('summaryTotal').innerText = '$' + finalTotal.toFixed(2);
    }

    function applyCoupon() {
        const code = document.getElementById('coupon_code').value.trim().toUpperCase();
        const feedback = document.getElementById('couponFeedback');
        const discountRow = document.getElementById('discountRow');

        if (!code) {
            feedback.className = 'text-xs mt-1 text-danger';
            feedback.innerText = 'Please enter a valid coupon code.';
            return;
        }

        if (code === 'SAVE20' || code === 'WELCOME20') {
            discountPercent = 0.20;
            feedback.className = 'text-xs mt-1 text-success';
            feedback.innerText = '✔ Coupon SAVE20 applied! (20% Off Order Subtotal)';
        } else if (code === 'HALFOFF' || code === 'SAAS50') {
            discountPercent = 0.50;
            feedback.className = 'text-xs mt-1 text-success';
            feedback.innerText = '✔ Coupon SAAS50 applied! (50% Off Order Subtotal)';
        } else {
            discountPercent = 0;
            feedback.className = 'text-xs mt-1 text-danger';
            feedback.innerText = 'Invalid voucher code. Try SAVE20 or SAAS50.';
            if (discountRow) discountRow.style.setProperty('display', 'none', 'important');
        }

        updateCheckoutTotal();
    }
</script>
@endsection
