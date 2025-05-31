@extends('user.generalLayout')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100 p-4">
    <div class="card shadow-lg p-4 w-100" style="max-width: 500px; margin-top: 90px;">
        <h3 class="text-center mb-3">Complete Your Profile (Optional)</h3>
        <form method="POST" action="{{ route('profile.complete.post') }}">
            @csrf


            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number"
                    class="form-control @error('age') is-invalid @enderror"
                    id="age"
                    name="age"
                    value="{{ old('age') }}"
                    min="0"
                    placeholder="Your age">
                @error('age')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select
                    class="form-select @error('gender') is-invalid @enderror"
                    id="gender"
                    name="gender">
                    <option value="" {{ old('gender') == '' ? 'selected' : '' }}>-- Select --</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="height" class="form-label">Height (cm)</label>
                <input type="number"
                    class="form-control @error('height') is-invalid @enderror"
                    id="height"
                    name="height"
                    value="{{ old('height') }}"
                    placeholder="Your height in cm">
                @error('height')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number"
                    class="form-control @error('weight') is-invalid @enderror"
                    id="weight"
                    name="weight"
                    value="{{ old('weight') }}"
                    placeholder="Your weight in kg">
                @error('weight')
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
