@extends('dashboard::layouts.admin')

@section('title', 'Privacy Policy')
@section('meta_description', 'Privacy Policy for ' . config('app.name', 'SaaSStater') . ' — learn how we handle your data.')

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
            <span class="text-slate-600 dark:text-slate-300 font-medium">Privacy Policy</span>
        </nav>
    </div>

    {{-- Header Card --}}
    <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-8 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-3">
                <div class="p-2.5 bg-white/20 backdrop-blur-sm rounded-xl">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <span class="text-purple-200 text-sm font-semibold uppercase tracking-wider">Legal</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Privacy Policy</h1>
            <p class="text-purple-200 text-sm">Last updated: {{ date('F d, Y') }} &nbsp;·&nbsp; Effective immediately</p>
        </div>
    </div>

    {{-- Content Card --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-8 space-y-8">

        {{-- Intro --}}
        <div class="p-4 bg-purple-50 dark:bg-purple-500/10 border border-purple-200 dark:border-purple-500/30 rounded-xl text-sm text-purple-800 dark:text-purple-300">
            <i data-lucide="info" class="w-4 h-4 inline mr-2"></i>
            <strong>{{ config('app.name', 'SaaSStater') }}</strong> is committed to protecting your privacy. This policy explains what data we collect, how we use it, and your rights.
        </div>

        @php
        $sections = [
            ['icon' => 'database', 'color' => 'blue', 'title' => '1. Information We Collect', 'body' => 'We collect information you provide directly to us, such as when you create an account, use our services, or contact us for support. This includes: name, email address, company information, billing details, usage data, and communication preferences.'],
            ['icon' => 'settings', 'color' => 'indigo', 'title' => '2. How We Use Your Information', 'body' => 'We use the information we collect to: provide, operate, and improve our services; process transactions and send related information; send promotional communications (with your consent); monitor and analyze trends and usage; detect and prevent fraudulent transactions; and respond to your comments and questions.'],
            ['icon' => 'share-2', 'color' => 'violet', 'title' => '3. Information Sharing', 'body' => 'We do not share, sell, rent or trade your personal information with third parties for their commercial purposes. We may share your information with third-party vendors and service providers that perform services on our behalf, such as payment processing, data analysis, email delivery, hosting services, and customer service.'],
            ['icon' => 'lock', 'color' => 'emerald', 'title' => '4. Data Security', 'body' => 'We take reasonable measures to help protect your personal information from loss, theft, misuse and unauthorized access, disclosure, alteration and destruction. We use industry-standard encryption (TLS/SSL) for data in transit and AES-256 encryption for data at rest.'],
            ['icon' => 'cookie', 'color' => 'amber', 'title' => '5. Cookies & Tracking', 'body' => 'We use cookies and similar tracking technologies to track activity on our service and hold certain information. Cookies are files with small amounts of data which may include an anonymous unique identifier. You can instruct your browser to refuse all cookies or to indicate when a cookie is being sent.'],
            ['icon' => 'user-check', 'color' => 'teal', 'title' => '6. Your Rights', 'body' => 'You have the right to: access your personal data; correct inaccurate data; request deletion of your data; object to processing of your data; request restriction of processing; and data portability. To exercise these rights, please contact us at privacy@' . str()->slug(config('app.name', 'saas')) . '.com.'],
            ['icon' => 'globe', 'color' => 'cyan', 'title' => '7. International Transfers', 'body' => 'Your information may be transferred to — and maintained on — computers located outside of your state, province, country or other governmental jurisdiction where the data protection laws may differ from those of your jurisdiction.'],
            ['icon' => 'refresh-cw', 'color' => 'rose', 'title' => '8. Changes to This Policy', 'body' => 'We may update our Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy Policy on this page and updating the "Last updated" date. You are advised to review this Privacy Policy periodically for any changes.'],
        ];
        $colorMap = ['blue'=>'blue','indigo'=>'indigo','violet'=>'violet','emerald'=>'emerald','amber'=>'amber','teal'=>'teal','cyan'=>'cyan','rose'=>'rose'];
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
            <p class="text-sm font-semibold text-slate-900 dark:text-white">Questions about this policy?</p>
            <p class="text-xs text-slate-500 mt-0.5">Our team is happy to clarify anything.</p>
        </div>
        <a href="{{ route('dashboard.pages.support') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition no-underline">
            <i data-lucide="message-circle" class="w-4 h-4"></i>
            Contact Support
        </a>
    </div>

</div>
@endsection
