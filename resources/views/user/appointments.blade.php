@extends('user.generalLayout')
@section('content')
<div class="container py-5">
    <h2 class="text-center mb-5" style="color: #f36100; margin-top: 100px;" >My Appointments</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    
    @if($appointments->isEmpty())
        <p class="text-center">You have no appointments yet.</p>
    @else
        <div class="table-responsive bg-white" style="border: 1px solid #f36100; border-radius: 10px; overflow: hidden;">
            <table class="table table-striped text-center" >
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $index => $appointment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $appointment->service->title ?? 'N/A' }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->location }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
