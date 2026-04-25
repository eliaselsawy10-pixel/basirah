@extends('admin.layouts.app')
@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')
<div class="filter-bar">
    <div class="filter-tabs">
        @foreach(['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $label)
        <a href="{{ route('admin.appointments.index', ['status' => $key]) }}" class="filter-tab {{ (request('status', 'all') == $key) ? 'active' : '' }}">{{ $label }}</a>
        @endforeach
    </div>
    <div class="admin-search">
        <i class="fas fa-search"></i>
        <form method="GET" action="{{ route('admin.appointments.index') }}" style="margin:0">
            <input type="hidden" name="status" value="{{ request('status', 'all') }}">
            <input type="text" name="search" placeholder="Search patient..." value="{{ request('search') }}" class="admin-input" style="padding-left:38px">
        </form>
    </div>
    <form method="GET" action="{{ route('admin.appointments.index') }}" class="d-flex gap-2" style="margin:0">
        <input type="hidden" name="status" value="{{ request('status', 'all') }}">
        <input type="date" name="date" value="{{ request('date') }}" class="admin-input" style="width:auto" onchange="this.form.submit()">
    </form>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr><th>Patient</th><th>Doctor</th><th>Date</th><th>Time</th><th>Paid</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($appointments as $apt)
                <tr>
                    <td>
                        <strong>{{ $apt->patient_name }}</strong>
                        <br><small style="color:var(--text-secondary)">{{ $apt->patient_email }}</small>
                    </td>
                    <td>{{ $apt->doctor->name ?? '—' }}</td>
                    <td>{{ $apt->appointment_date->format('M d, Y') }}</td>
                    <td>{{ $apt->time_slot ?? $apt->appointment_time }}</td>
                    <td>${{ number_format($apt->price_paid, 2) }}</td>
                    <td><span class="badge-status {{ $apt->status }}">{{ ucfirst($apt->status) }}</span></td>
                    <td>
                        <form action="{{ route('admin.appointments.updateStatus', $apt->id) }}" method="POST" class="d-flex gap-2">
                            @csrf @method('PATCH')
                            <select name="status" class="admin-select" style="font-size:0.75rem;padding:4px 8px;">
                                @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                <option value="{{ $s }}" {{ $apt->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-admin btn-admin-primary btn-admin-sm"><i class="fas fa-check"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:var(--text-secondary);padding:40px;">No appointments found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-3 admin-pagination">{{ $appointments->links() }}</div>
</div>
@endsection
