@extends('dashboard::layouts.admin')

@section('title', 'Terms of Service')
@section('meta_description', 'Terms of Service for ' . config('app.name', 'SaaSStater') . ' — please read carefully before using our platform.')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">

    {{-- Back button + breadcrumb --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="javascript:history.back()"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition no-underline">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <nav class="text-sm text-slate-400">
            <span>Portal</span>
            <span class="mx-2">/</span>
            <span class="text-slate-600 dark:text-slate-300 font-medium">Terms of Service</span>
        </nav>
    </div>

    {{-- Header Card --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-8 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2.5 bg-white/20 backdrop-blur-sm rounded-xl">
                    <i data-lucide="scroll-text" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-blue-200 text-sm font-semibold uppercase tracking-wider">Legal</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Terms of Service</h1>
            <p class="text-blue-200 text-sm">Last updated: {{ date('F d, Y') }} &nbsp;·&nbsp; Please read carefully before using our services</p>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-8 space-y-8">

        {{-- Intro --}}
        <div class="p-4 bg-blue-50 dark:bg-blue-500/10 border border-blue-200 dark:border-blue-500/30 rounded-xl text-sm text-blue-800 dark:text-blue-300">
            <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
            By accessing or using <strong>{{ config('app.name', 'SaaSStater') }}</strong>, you agree to be bound by these Terms of Service. If you disagree with any part, you may not use our services.
        </div>

        @php
        $sections = [
            ['icon' => 'file-check', 'color' => 'blue', 'title' => '1. Acceptance of Terms', 'body' => 'By creating an account or using our services, you confirm that you are at least 18 years old, have read and understood these Terms, and agree to be legally bound by them. If you are using our services on behalf of an organization, you represent that you have authority to bind that organization.'],
            ['icon' => 'layers', 'color' => 'indigo', 'title' => '2. Description of Service', 'body' => config('app.name', 'SaaSStater') . ' provides a multi-tenant SaaS platform for business management, including tenant management, subscription handling, billing, role-based access control, and related modules. We reserve the right to modify, suspend, or discontinue any part of our service at any time.'],
            ['icon' => 'credit-card', 'color' => 'violet', 'title' => '3. Billing & Subscriptions', 'body' => 'You agree to pay all fees associated with your chosen subscription plan. All fees are non-refundable unless otherwise specified. We reserve the right to change our pricing with 30 days notice. Failure to pay may result in suspension or termination of your account.'],
            ['icon' => 'user-x', 'color' => 'rose', 'title' => '4. Prohibited Activities', 'body' => 'You agree not to: use the service for unlawful purposes; violate any laws; infringe on intellectual property; distribute malware or harmful code; attempt to gain unauthorized access; reverse engineer or decompile the platform; or resell the service without written permission.'],
            ['icon' => 'shield', 'color' => 'emerald', 'title' => '5. Intellectual Property', 'body' => 'The service and its original content, features, and functionality are and will remain the exclusive property of ' . config('app.name', 'SaaSStater') . ' and its licensors. Our trademarks may not be used in connection with any product or service without prior written consent.'],
            ['icon' => 'alert-triangle', 'color' => 'amber', 'title' => '6. Disclaimer of Warranties', 'body' => 'Our service is provided "as is" without warranties of any kind, either express or implied, including but not limited to implied warranties of merchantability, fitness for a particular purpose, or non-infringement. We do not warrant that the service will be uninterrupted or error-free.'],
            ['icon' => 'shield-off', 'color' => 'orange', 'title' => '7. Limitation of Liability', 'body' => 'To the maximum extent permitted by law, ' . config('app.name', 'SaaSStater') . ' shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of or inability to use the service, even if we have been advised of the possibility of such damages.'],
            ['icon' => 'map-pin', 'color' => 'cyan', 'title' => '8. Governing Law', 'body' => 'These Terms shall be governed by and construed in accordance with applicable laws, without regard to conflict of law provisions. Any disputes shall be resolved through binding arbitration, except where prohibited by law.'],
            ['icon' => 'refresh-cw', 'color' => 'teal', 'title' => '9. Changes to Terms', 'body' => 'We reserve the right to modify these terms at any time. We will notify users of significant changes via email or through our platform. Continued use of the service after such changes constitutes your acceptance of the new Terms.'],
        ];
        @endphp

        @foreach($sections as $s)
        <div class="flex gap-4">
            <div class="flex-shrink-0 mt-1">
                <div class="w-9 h-9 rounded-xl bg-{{ $s['color'] }}-100 dark:bg-{{ $s['color'] }}-500/15 flex items-center justify-center">
                    <i data-lucide="{{ $s['icon'] }}" class="w-4 h-4 text-{{ $s['color'] }}-600 dark:text-{{ $s['color'] }}-400"></i>
                </div>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900 dark:text-white mb-1.5">{{ $s['title'] }}</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $s['body'] }}</p>
            </div>
        </div>
        @if(!$loop->last)<hr class="border-slate-100 dark:border-slate-800">@endif
        @endforeach
    </div>

    {{-- Contact Footer --}}
    <div class="mt-6 p-5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Have questions about our terms?</p>
            <p class="text-xs text-slate-500 mt-0.5">Our legal team is available to help clarify.</p>
        </div>
        <a href="{{ route('dashboard.pages.support') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition no-underline">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            Contact Support
        </a>
    </div>

</div>
@endsection
