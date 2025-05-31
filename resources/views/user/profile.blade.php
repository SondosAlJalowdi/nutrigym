@extends('user.generalLayout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 p-4">
        <div class="card shadow-lg p-4 w-100" style="max-width: 600px; margin-top: 90px;">
            <h2 class="text-center mb-4">My Profile</h2>

            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    @if (Auth::user()->image)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" class="img-fluid rounded-circle border"
                            style="width: 140px; height: 140px; object-fit: cover;" alt="Profile Image">
                    @else
                        <img src="{{ asset('default-profile.png') }}" class="img-fluid rounded-circle border"
                            style="width: 140px; height: 140px; object-fit: cover;" alt="Default Profile Image">
                    @endif
                </div>

                <div class="col-md-8">
                    <div class="mb-2"><strong>Name:</strong> {{ Auth::user()->name }}</div>
                    <div class="mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</div>
                    <div class="mb-2"><strong>Phone:</strong> {{ Auth::user()->phone ?? '-' }}</div>
                    <div class="mb-2"><strong>Age:</strong> {{ Auth::user()->age ?? '-' }}</div>
                    <div class="mb-2"><strong>Gender:</strong> {{ ucfirst(Auth::user()->gender) ?? '-' }}</div>
                    <div class="mb-2"><strong>Height:</strong>
                        {{ Auth::user()->height ? Auth::user()->height . ' cm' : '-' }}</div>
                    <div class="mb-2"><strong>Weight:</strong>
                        {{ Auth::user()->weight ? Auth::user()->weight . ' kg' : '-' }}</div>
                    <div class="mb-2"><strong>Location:</strong> {{ Auth::user()->location ?? '-' }}</div>
                </div>
            </div>

            <div class="mt-4 text-center">
                <a href="" class="btn" style="background-color: #f36100; color: white; min-width: 120px;">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
@endsection

