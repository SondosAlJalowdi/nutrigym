@extends('user.generalLayout')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100 p-4">
        <div class="card shadow-lg p-4 w-100" style="max-width: 500px; margin-top: 120px;">
            <h3 class="text-center mb-3">Complete Your Profile (Optional)</h3>
            <form method="POST" action="{{ route('profile.complete.post') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', auth()->user()->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email (cannot be changed)</label>
                    <input type="email" class="form-control" id="email"
                        name="email" value="{{ auth()->user()->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="07XXXXXXXX">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="age" class="form-label">Age</label>
                    <input type="number" class="form-control @error('age') is-invalid @enderror" id="age"
                        name="age" value="{{ old('age', auth()->user()->age) }}" min="0">
                    @error('age')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="" disabled {{ old('gender', auth()->user()->gender) == '' ? 'selected' : '' }}>-- Select --</option>
                        <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" class="form-control @error('height') is-invalid @enderror" id="height"
                        name="height" value="{{ old('height', auth()->user()->height) }}">
                    @error('height')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" class="form-control @error('weight') is-invalid @enderror" id="weight"
                        name="weight" value="{{ old('weight', auth()->user()->weight) }}">
                    @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location"
                        name="location" value="{{ old('location', auth()->user()->location) }}">
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                        name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center">
                    <button type="submit" class="btn" style="background-color: #f36100; color: white;">Save Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection
