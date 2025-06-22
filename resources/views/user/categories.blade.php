@extends('user.generalLayout')
@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4 text-uppercase text-white" style="margin-top: 120px ">{{ $category->name }}</h2>

        <!-- Search Form -->
        <form method="GET" class="mb-4 p-3 rounded shadow-sm"
            style="border: 1px solid #f36100; background-color: rgba(0, 0, 0, 0.1);">
            <div class="row align-items-end">
                <div class="col-md-9">
                    <input type="text" class="form-control border-0" name="search" id="search"
                        placeholder="Search by service name or location" value="{{ request('search') }}"
                        style="background-color: #000000; color: white;">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn text-white w-100 mr-2"
                        style="background-color: #f36100; border: 2px solid #ffffff;">
                        <i class="fa-solid fa-search mr-2"></i> Search
                    </button>
                    <a href="{{ url()->current() }}" class="btn w-100"
                        style="border: 2px solid #f36100; color: #f36100; background-color: white;">
                        <i class="fa-solid fa-rotate-right mr-2"></i> Reset
                    </a>
                </div>
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
                                <div class="d-flex justify-content-between mt-3">
                                    <!-- Book Button -->
                                    <a class="btn text-white mr-2 flex-fill"
                                        style="background-color: #f36100; border: 2px solid #f36100;" data-toggle="modal"
                                        data-target="#bookModal{{ $service->id }}">
                                        Book Appointment
                                    </a>

                                    <!-- See Details Button -->
                                    <a class="btn  flex-fill"
                                    href="{{ route('provider.details', $service->serviceProvider->id) }}"
                                        style="border: 2px solid #f36100; background-color: transparent; color: #f36100;">
                                        See Details
                                    </a>
                                </div>

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
                                        <button type="submit" class="btn text-white mr-2 flex-fill"
                                        style="background-color: #f36100; border: 2px solid #f36100;">Confirm Booking</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($services->hasPages())
        <div class="mt-4 d-flex justify-content-center mb-2">
            <nav>
                <ul class="pagination pagination-md custom-pagination">

                    {{-- Previous Page Link --}}
                    @if ($services->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $services->previousPageUrl() }}">&laquo;</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($services->getUrlRange(1, $services->lastPage()) as $page => $url)
                        <li class="page-item {{ $services->currentPage() == $page ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($services->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $services->nextPageUrl() }}">&raquo;</a>
                        </li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif

                </ul>
            </nav>
        </div>
    @endif
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedSlots = @json($bookedSlots);

        document.querySelectorAll('.appointment-date').forEach(dateInput => {
            dateInput.addEventListener('change', function() {
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
            modal.addEventListener('shown.bs.modal', function() {
                const dateInput = modal.querySelector('.appointment-date');
                if (dateInput) {
                    dateInput.value = new Date().toISOString().split('T')[0];
                    dateInput.dispatchEvent(new Event('change'));
                }
            });
        });
    });
</script>

<style>
    .custom-pagination .page-link {
        color: #f36100;
        /* default text color (black) */
        background-color: rgb(43, 43, 43);
        border: 1px solid #f36100;
        /* orange border */
    }

    .custom-pagination .page-link:hover {
        background-color: #f36100;
        /* orange on hover */
        color: #fff;
        border-color: #f36100;

    }

    .custom-pagination .page-item.active .page-link {
        background-color: #f36100;
        /* active page - orange */
        border-color: #f36100;
        color: #fff;
        font-weight: bold;

    }

    .custom-pagination .page-item.disabled .page-link {
        background-color: rgb(43, 43, 43);
        color: #ffa467;
        border: 1px solid #f36100;
    }
</style>
