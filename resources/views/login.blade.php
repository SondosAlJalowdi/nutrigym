@extends('user.generalLayout')
@section('content')

<div class="container d-flex justify-content-center align-items-center" style="height: 100vh">
    <div class="card shadow-lg p-4 w-100" style="max-width: 400px; margin-top: 150px;">
        <h3 class="text-center mb-4">Login</h3>
        <div class="mt-5">
            @if ($errors->any())
                <div class="col-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            @if (session()->has('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

        </div>
        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required
                    autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn" style="background-color: #f36100; color:white">Login</button>
            </div>

            <div class="mt-3 text-center">
                <small>Don't have an account? <a href="{{ route('registration') }}" style="color: #f36100">Register</a></small>
            </div>
        </form>
    </div>
</div>
@endsection
