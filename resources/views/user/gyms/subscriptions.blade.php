@extends('user.generalLayout')

@section('content')
<div class="container py-5" style="margin-top: 150px; min-height: 100vh;">
    <h2 class="text-center mb-5" style="color: #f36100;">My Subscriptions</h2>

    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @forelse($subscriptions as $subscription)
    <div class="card mb-4 border-0 shadow-sm rounded-3">
        <div class="row g-0 align-items-center">
            <div class="col-md-9 p-4">
                <h4 class="text-uppercase" style="color: #333;">
                    {{ $subscription->service->title }}
                </h4>
                <p class="mb-1"><strong>Status:</strong>
                    <span class="badge
                        {{ $subscription->status == 'active' ? 'bg-success' :
                            ($subscription->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                        {{ ucfirst($subscription->status) }}
                    </span>
                </p>
                <p class="mb-1"><strong>Start:</strong> {{ $subscription->start_date->format('Y-m-d') }}</p>
                <p class="mb-1"><strong>End:</strong> {{ $subscription->end_date->format('Y-m-d') }}</p>
                @if($subscription->details)
                <p class="mb-0"><strong>Details:</strong> {{ $subscription->details }}</p>
                @endif
            </div>
            <div class="col-md-3 text-center">
                <i class="fa fa-check-circle fa-3x text-success"></i>
            </div>
        </div>
    </div>
    
    @empty
    <div class="text-center text-muted">
        <p class="lead">You have no subscriptions yet.</p>
        <a href="{{ route('gyms.index') }}" class="btn btn-outline-primary mt-3">Browse Services</a>
    </div>
    @endforelse
</div>
@endsection
