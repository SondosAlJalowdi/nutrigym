@extends('user.generalLayout')
@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 text-uppercase text-white" style="margin-top: 120px ">{{ $category->name }}</h2>

        <!-- Search Form -->
        <form method="GET" class="row mb-5">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search by service name"
                    value="{{ request('search') }}">
            </div>
            <div class="col-md-5">
                <input type="text" name="location" class="form-control" placeholder="Search by location"
                    value="{{ request('location') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>

        @if ($services->isEmpty())
            <p class="text-center">No services available in this category yet.</p>
        @else
            <div class="row">
                @php
                    $bookedSlots = [];
                    foreach ($services as $srv) {
                        $appointments = \App\Models\Appointment::where('service_id', $srv->id)->get();
                        foreach ($appointments as $appointment) {
                            $date = Carbon\Carbon::parse($appointment->date)->format('Y-m-d');
                            $time = Carbon\Carbon::parse($appointment->time)->format('H:i');
                            $bookedSlots[$srv->id][$date][] = $time;
                        }
                    }
                @endphp


                @foreach ($services as $service)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm"
                            style="border-radius: 10px; overflow: hidden; box-shadow: 0 0 10px rgba(207, 90, 12, 0.1); border-color:#f36100; border-width: 2px;">
                            @if ($service->serviceProvider->image)
                                <img src="{{ asset('storage/providers/' . $service->serviceProvider->image) }}"
                                    class="card-img-top" alt="{{ $service->title }}"
                                    style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title text-center">{{ $service->serviceProvider->user->name ?? 'Unknown' }}
                                </h5>
                                <p class="font-weight-bold">Location:
                                    {{ $service->serviceProvider->user->location ?? 'Unknown' }}</p>
                                <p class="font-weight-bold">Description: {{ Str::limit($service->description, 100) }}</p>
                                <p class="font-weight-bold" style="color: #f36100 ">Price:
                                    {{ number_format($service->price, 2) }}JD</p>
                                <!-- Book Button -->
                                <button class="btn btn-outline-primary mt-2" data-toggle="modal"
                                    data-target="#bookModal{{ $service->id }}">Book Appointment</button>
                            </div>
                        </div>
                    </div>

                    <!-- Appointment Modal -->
                    <div class="modal fade" id="bookModal{{ $service->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="bookModalLabel{{ $service->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="{{ route('appointments.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookModalLabel{{ $service->id }}">Book Appointment
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="date" class="form-control appointment-date"
                                                id="date-{{ $service->id }}" data-service-id="{{ $service->id }}"
                                                min="{{ now()->toDateString() }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Time</label>
                                            <select name="time" class="form-control time-select"
                                                id="time-select-{{ $service->id }}" required>
                                                @for ($hour = 9; $hour <= 17; $hour++)
                                                    <option value="{{ sprintf('%02d:00', $hour) }}">
                                                        {{ sprintf('%02d:00', $hour) }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input type="text" name="location" class="form-control"
                                                placeholder="Your Location" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Confirm Booking</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bookedSlots = @json($bookedSlots);

        document.querySelectorAll('.appointment-date').forEach(dateInput => {
            dateInput.addEventListener('change', function () {
                const selectedDate = this.value;
                const serviceId = this.getAttribute('data-service-id');
                const timeSelect = document.getElementById('time-select-' + serviceId);

                // Reset all options
                [...timeSelect.options].forEach(opt => opt.disabled = false);

                // Get today's date string and hour
                const today = new Date().toISOString().split('T')[0];
                const now = new Date();
                const currentHour = now.getHours();

                // Disable past hours for today
                if (selectedDate === today) {
                    [...timeSelect.options].forEach(opt => {
                        const hour = parseInt(opt.value.split(':')[0]);
                        if (hour <= currentHour) {
                            opt.disabled = true;
                        }
                    });
                }

                // Disable already booked slots
                const serviceSlots = bookedSlots[serviceId];
                if (serviceSlots && serviceSlots[selectedDate]) {
                    const bookedTimes = serviceSlots[selectedDate];
                    [...timeSelect.options].forEach(opt => {
                        if (bookedTimes.includes(opt.value)) {
                            opt.disabled = true;
                            opt.textContent = opt.value + ' (booked)';
                        }
                    });
                }
            });
        });

        // Auto-select today and trigger change when modal opens
        document.querySelectorAll('[id^="bookModal"]').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const dateInput = modal.querySelector('.appointment-date');
                if (dateInput) {
                    dateInput.value = new Date().toISOString().split('T')[0];
                    dateInput.dispatchEvent(new Event('change'));
                }
            });
        });
    });
</script>

