@extends('dashboard::layouts.admin')

@section('title', 'Dashboard')

@section('content')

    {{-- Metrics Cards (matching user mockup card format) --}}
    <div class="row g-4 mb-4">
        
        <div class="col-md-3">
            <div class="card admin-card border-0 p-4 h-100">
                <div class="card-body p-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small mb-1 fw-semibold">Total Users</div>
                        <h3 class="fw-bold text-dark mb-1">{{ $metrics['total_users'] }}</h3>
                        <div class="text-muted small">Registered Accounts</div>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary" style="padding: 1rem; border-radius: 0.75rem;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card admin-card border-0 p-4 h-100">
                <div class="card-body p-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small mb-1 fw-semibold">Active Admins</div>
                        <h3 class="fw-bold text-dark mb-1">{{ $metrics['active_admins'] }}</h3>
                        <div class="text-muted small">System Administrators</div>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning" style="padding: 1rem; border-radius: 0.75rem;">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card admin-card border-0 p-4 h-100">
                <div class="card-body p-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small mb-1 fw-semibold">Total Logs</div>
                        <h3 class="fw-bold text-dark mb-1">{{ $metrics['total_logs'] }}</h3>
                        <div class="text-muted small">Login Log Entries</div>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10 text-success" style="padding: 1rem; border-radius: 0.75rem;">
                        <i class="bi bi-activity fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card admin-card border-0 p-4 h-100">
                <div class="card-body p-0 d-flex align-items-center justify-content-between">
                    <div>
                        <div class="text-secondary small mb-1 fw-semibold">Success Rate</div>
                        <h3 class="fw-bold text-dark mb-1">
                            @if($metrics['total_logs'] > 0)
                                {{ round(($metrics['successful_logs'] / $metrics['total_logs']) * 100) }}%
                            @else
                                100%
                            @endif
                        </h3>
                        <div class="text-muted small">Authentication Ratio</div>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10 text-info" style="padding: 1rem; border-radius: 0.75rem;">
                        <i class="bi bi-percent fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabs structure matching user mockup --}}
    <div class="card admin-card border-0 p-4">
        
        <ul class="nav nav-tabs nav-tabs-custom mb-4" id="adminTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="logs-tab" data-bs-toggle="tab" data-bs-target="#logs-pane" type="button" role="tab">
                    Security Logs
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="system-tab" data-bs-toggle="tab" data-bs-target="#system-pane" type="button" role="tab">
                    System Overview
                </button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            
            {{-- Security logs panel --}}
            <div class="tab-pane fade show active" id="logs-pane" role="tabpanel">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>IP Address</th>
                                <th>Browser / Platform</th>
                                <th>Status</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-person-circle fs-5 text-muted"></i>
                                            <div>
                                                <div class="fw-bold text-dark small">{{ $log->user->name ?? 'Unknown' }}</div>
                                                <div class="text-muted" style="font-size: 0.75rem;">{{ $log->user->email ?? $log->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><code>{{ $log->ip_address }}</code></td>
                                    <td><span class="text-muted small">{{ $log->user_agent }}</span></td>
                                    <td>
                                        @if($log->status === 'success')
                                            <span class="badge badge-published py-1 px-2.5 rounded">Success</span>
                                        @else
                                            <span class="badge badge-draft py-1 px-2.5 rounded">Failed</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">{{ $log->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">No security events logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- System overview panel --}}
            <div class="tab-pane fade" id="system-pane" role="tabpanel">
                <div class="p-3">
                    <h6 class="fw-bold text-dark mb-3">System Specifications</h6>
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Laravel Framework</span>
                            <span class="fw-semibold text-dark">12.x</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">Database Engine</span>
                            <span class="fw-semibold text-dark">MySQL</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                            <span class="text-muted">PHP Version</span>
                            <span class="fw-semibold text-dark">8.2+</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

@endsection
