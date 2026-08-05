@extends('dashboard::layouts.admin')

@section('title', 'Support Center')
@section('meta_description', 'Get help and support for ' . config('app.name', 'SaaSStater') . ' — contact our team or browse resources.')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    {{-- Back button + breadcrumb --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="javascript:history.back()"
           class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition no-underline">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
        </a>
        <nav class="text-sm text-slate-400">
            <span>Portal</span>
            <span class="mx-2">/</span>
            <span class="text-slate-600 dark:text-slate-300 font-medium">Support Center</span>
        </nav>
    </div>

    {{-- Header Card --}}
    <div class="bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl p-8 mb-8 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23fff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    <div class="p-2.5 bg-white/20 backdrop-blur-sm rounded-xl">
                        <i data-lucide="headset" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-emerald-200 text-sm font-semibold uppercase tracking-wider">Help Center</span>
                </div>
                <h1 class="text-3xl font-bold text-white mb-1">Support Center</h1>
                <p class="text-emerald-200 text-sm">We're here to help · Avg. response time: 2 hours</p>
            </div>
            <div class="flex items-center gap-2 bg-white/15 backdrop-blur-sm rounded-xl px-4 py-3">
                <div class="w-2 h-2 bg-emerald-300 rounded-full animate-pulse"></div>
                <span class="text-white text-sm font-medium">Support Online</span>
            </div>
        </div>
    </div>

    {{-- Contact Channels --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

        {{-- Email --}}
        <div class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-6 text-center hover:border-purple-400 dark:hover:border-purple-500/60 transition-all hover:shadow-lg hover:shadow-purple-500/10">
            <div class="mx-auto mb-4 w-14 h-14 bg-purple-100 dark:bg-purple-500/15 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="mail" class="w-6 h-6 text-purple-600 dark:text-purple-400"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white mb-1.5">Email Support</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Detailed issues and account questions handled by our specialist team.</p>
            <a href="mailto:support@{{ str()->slug(config('app.name', 'saas')) }}.com"
               class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-semibold rounded-xl transition no-underline">
                <i data-lucide="send" class="w-3.5 h-3.5"></i> Send Email
            </a>
        </div>

        {{-- Live Chat --}}
        <div class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-6 text-center hover:border-blue-400 dark:hover:border-blue-500/60 transition-all hover:shadow-lg hover:shadow-blue-500/10">
            <div class="mx-auto mb-4 w-14 h-14 bg-blue-100 dark:bg-blue-500/15 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="message-circle" class="w-6 h-6 text-blue-600 dark:text-blue-400"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white mb-1.5">Live Chat</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Get real-time help from our team Monday–Friday, 9am–6pm IST.</p>
            <button onclick="alert('Live chat coming soon!')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition cursor-pointer">
                <i data-lucide="zap" class="w-3.5 h-3.5"></i> Start Chat
            </button>
        </div>

        {{-- Submit Ticket --}}
        <div class="group bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-6 text-center hover:border-emerald-400 dark:hover:border-emerald-500/60 transition-all hover:shadow-lg hover:shadow-emerald-500/10">
            <div class="mx-auto mb-4 w-14 h-14 bg-emerald-100 dark:bg-emerald-500/15 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                <i data-lucide="ticket" class="w-6 h-6 text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <h3 class="font-bold text-slate-900 dark:text-white mb-1.5">Submit a Ticket</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-4 leading-relaxed">Open a formal support ticket and track its status in real time.</p>
            <a href="{{ route('tickets.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition no-underline">
                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Open Ticket
            </a>
        </div>
    </div>

    {{-- FAQ Section --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/70 rounded-2xl p-8 mb-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-9 h-9 rounded-xl bg-amber-100 dark:bg-amber-500/15 flex items-center justify-center">
                <i data-lucide="help-circle" class="w-5 h-5 text-amber-600 dark:text-amber-400"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Frequently Asked Questions</h2>
                <p class="text-xs text-slate-400">Quick answers to common questions</p>
            </div>
        </div>

        <div class="space-y-3">
            @php
            $faqs = [
                ['q' => 'How do I upgrade my subscription plan?', 'a' => 'Go to Subscriptions in your admin panel, select your desired plan, and follow the upgrade prompts. Changes take effect immediately with prorated billing.'],
                ['q' => 'Can I add multiple tenants to my account?', 'a' => 'Yes! Depending on your plan, you can onboard multiple client tenants. Navigate to Tenant Management to create and configure each organization.'],
                ['q' => 'How do I reset a user\'s password?', 'a' => 'Go to Users in your admin panel, find the user, click the 3-dot action menu, and select "Reset Password". An email will be sent to the user.'],
                ['q' => 'What happens when I exceed my user quota?', 'a' => 'You will receive an email notification when you approach your limit. New user creation will be blocked until you upgrade your plan or remove existing users.'],
                ['q' => 'How is my billing data secured?', 'a' => 'All billing data is encrypted using AES-256. We are PCI-DSS compliant and use certified payment processors. We never store raw card data on our servers.'],
                ['q' => 'Can I export my data?', 'a' => 'Yes. You can export data from most modules via the export button in the list views. Full account data exports are available on Enterprise plans.'],
            ];
            @endphp

            @foreach($faqs as $i => $faq)
            <div class="border border-slate-100 dark:border-slate-800 rounded-xl overflow-hidden">
                <button onclick="toggleFaq({{ $i }})"
                        class="w-full flex items-center justify-between p-4 text-left hover:bg-slate-50 dark:hover:bg-slate-800/50 transition">
                    <span class="text-sm font-semibold text-slate-900 dark:text-white pr-4">{{ $faq['q'] }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 flex-shrink-0 faq-chevron-{{ $i }} transition-transform"></i>
                </button>
                <div id="faq-answer-{{ $i }}" class="hidden px-4 pb-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Status Banner --}}
    <div class="p-5 bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/30 rounded-2xl flex items-center gap-4">
        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0">
            <i data-lucide="activity" class="w-5 h-5 text-emerald-600 dark:text-emerald-400"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-semibold text-emerald-800 dark:text-emerald-300">All Systems Operational</p>
            <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-0.5">API · Dashboard · Authentication · Billing — 99.98% uptime this month</p>
        </div>
        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold bg-emerald-100 dark:bg-emerald-500/20 px-3 py-1 rounded-full">Operational</span>
    </div>

</div>

@push('scripts')
<script>
function toggleFaq(index) {
    var answer  = document.getElementById('faq-answer-' + index);
    var chevron = document.querySelector('.faq-chevron-' + index);
    var hidden  = answer.classList.contains('hidden');
    answer.classList.toggle('hidden', !hidden);
    if (chevron) chevron.style.transform = hidden ? 'rotate(180deg)' : '';
}
</script>
@endpush

@endsection
