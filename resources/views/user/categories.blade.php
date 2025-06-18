@extends('user.generalLayout')
@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4 text-uppercase text-primary">{{ $category->name }}</h2>

    @if($services->isEmpty())
        <p class="text-center">No services available in this category yet.</p>
    @else
        <div class="row">
            @foreach($services as $service)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($service->image)
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->title }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->title }}</h5>
                            <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                            <p class="text-muted">Provided by: {{ $service->provider->user->name ?? 'Unknown' }}</p>
                            <p class="text-primary font-weight-bold">${{ number_format($service->price, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
