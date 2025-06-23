@extends('user.generalLayout')
@php
    use Carbon\Carbon;
    /** @var \Illuminate\Database\Eloquent\Model $provider */
@endphp

@section('content')
    <div class="container py-5" style="max-width: 900px; margin-top: 120px;">

        <!-- Profile Section -->
        <section class="profile-section mb-5 bg-dark text-white p-0 rounded-3 overflow-hidden shadow-lg">
            <div class="row g-0">
                <!-- Profile Image Column -->
                <div class="col-md-4 bg-dark d-flex align-items-center justify-content-center p-4 position-relative">
                    @if ($provider->image)
                        <img src="{{ asset('storage/providers/' . $provider->image) }}" alt="{{ $provider->user->name }}"
                            class="img-fluid rounded-3 shadow" style="max-height: 280px; width: 100%; object-fit: cover;">
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center text-center p-4"
                            style="height: 280px; width: 100%;">
                            <i class="fas fa-user-circle fa-5x mb-3 text-light opacity-75"></i>
                            <small class="text-white-50">No Image Available</small>
                        </div>
                    @endif
                </div>

                <!-- Profile Info Column -->
                <div class="col-md-8">
                    <div class="p-4">
                        <!-- Name -->
                        <h2 class="fw-bold mb-3" style="color: #f36100">{{ $provider->user->name }}</h2>

                        <!-- Location -->
                        @if ($provider->user->location)
                            <div class="d-flex align-items-center mb-3">
                                Location:
                                <i class="fas fa-map-marker-alt text-white-50 mr-2"></i>
                                <span class="text-white">{{ $provider->user->location }}</span>
                            </div>
                        @endif

                        <!-- Rating -->
                        @if ($provider->reviews->count() > 0)
                            <div class="d-flex align-items-center mb-4">
                                Rating:
                                <div class="d-flex align-items-center mr-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= round($provider->reviews->avg('stars')))
                                            <i class="fas fa-star mr-1" style="color: #f36100"></i>
                                        @else
                                            <i class="far fa-star mr-1" style="color: #f36100"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-white-50">
                                    <strong
                                        class="text-white">{{ number_format($provider->reviews->avg('stars'), 1) }}</strong>/5
                                    ({{ $provider->reviews->count() }} reviews)
                                </span>
                            </div>
                        @endif

                        <!-- About Section -->
                        <div class="mb-4">
                            <h5 class="text-uppercase text-white-50 mb-3">About</h5>
                            <p class="lead mb-0 text-white" style="line-height: 1.6;">{{ $provider->about }}</p>
                        </div>

                        <!-- Response Time -->
                        <div class="d-flex align-items-center text-white-50 border-top pt-3">
                            <i class="fas fa-clock mr-2"></i>
                            <span>Typically responds within 24 hours</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="services-section mb-5 p-4 bg-white rounded-3 border">
            <h3 class="mb-3">Services Offered</h3>

            @php
                $bookedSlots = [];
                foreach ($provider->services as $srv) {
                    $appointments = \App\Models\Appointment::where('service_id', $srv->id)->get();
                    foreach ($appointments as $appointment) {
                        $date = Carbon::parse($appointment->date)->format('Y-m-d');
                        $time = Carbon::parse($appointment->time)->format('H:i');
                        $bookedSlots[$srv->id][$date][] = $time;
                    }
                }
            @endphp

            @if ($provider->services->isEmpty())
                <div class="text-center text-muted fst-italic py-4">
                    No services available yet.
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach ($provider->services as $service)
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                            <div>
                                <h5 class="mb-1">{{ $service->title }}</h5>
                                @if ($service->description)
                                    <p class="text-muted mb-0">{{ Str::limit($service->description, 100) }}</p>
                                @endif
                            </div>

                            <div class="text-end">
                                <span class="badge bg-primary rounded-pill px-3 py-2 fs-5 d-block mb-2">
                                    {{ number_format($service->price, 2) }} JD
                                </span>
                                <button type="button" class="btn text-white mr-2"
                                    style="background-color: #f36100; border: 2px solid #f36100;" data-toggle="modal"
                                    data-target="#bookModal{{ $service->id }}">
                                    Book Appointment
                                </button>
                            </div>
                        </li>
                    @endforeach

                    @foreach ($provider->services as $service)
                        <!-- Booking Modal -->
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
                </ul>

                @foreach ($provider->services as $service)
                    <!-- Booking Modal -->
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
                                        <!-- Your form fields here -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn text-white flex-fill"
                                            style="background-color: #f36100; border: 2px solid #f36100;">
                                            Confirm Booking
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </section>

        <!-- Reviews Section -->
        <section class="reviews-section mb-5 p-4 bg-white rounded-3 border">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Customer Reviews</h3>
            </div>

            <div>
                @forelse($provider->reviews as $review)
                    <div class="review-item border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between mb-2 align-items-center">
                            <div class="d-flex align-items-center fs-5 text-dark">
                                @if ($review->user->image)
                                    <img src="{{ asset('storage/users/' . $review->user->image) }}"
                                        alt="{{ $review->user->name }}" class="rounded-circle mr-2"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('default-user-img.webp') }}" alt="{{ $review->user->name }}"
                                        class="rounded-circle mr-2" style="width: 40px; height: 40px; object-fit: cover;">
                                @endif
                                <strong>{{ $review->user->name }}</strong>
                            </div>

                            <span class="text-warning fs-5">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $review->stars ? 'fas' : 'far' }} fa-star text-warning"></i>
                                @endfor
                            </span>

                        </div>
                        @auth
                        @if (auth()->id() === $review->user_id)
                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this review?');"
                                class="mt-2 float-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-white">
                                    <i class="fa-solid fa-trash-can text-danger"></i>
                                </button>
                            </form>
                        @endif
                    @endauth
                        <p class="mb-1 fs-6 text-secondary">{{ $review->comment }}</p>
                        <small class="text-muted fst-italic">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted fst-italic">
                        No reviews yet. Be the first to review!
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Review Form or Login Prompt -->
        @auth
            @php
                $hasBooked = \App\Models\Appointment::where('user_id', auth()->id())
                    ->whereHas('service.serviceProvider', fn($q) => $q->where('id', $provider->id))
                    ->exists();
            @endphp

            @if ($hasBooked)
                <section class="review-form-section mb-5 p-4 bg-white rounded-3 border">
                    <h3 class="mb-4">Write a Review</h3>
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="provider_id" value="{{ $provider->id }}">
                        <div class="mb-4">
                            <label class="form-label fw-bold">Your Rating</label>
                            <div class="star-rating">
                                @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="stars"
                                        value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="comment" class="form-label fw-bold">Your Review</label>
                            <textarea name="comment" id="comment" class="form-control" rows="4"
                                placeholder="Share your experience with this provider..." required></textarea>
                        </div>

                        <button type="submit" class="btn text-white mr-2"
                                    style="background-color: #f36100; border: 2px solid #f36100;">
                            Submit Review
                        </button>
                    </form>
                </section>
            @else
                <div class="alert alert-warning border-0 shadow rounded-4 d-flex align-items-center">
                    <i class="fas fa-exclamation-circle mr-3 fa-lg text-warning"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Book First to Review</h5>
                        <p class="mb-0">You must book an appointment with this provider before writing a review.</p>
                    </div>
                </div>
            @endif
        @else
            <div class="alert alert-info border-0 shadow rounded-4 d-flex align-items-center">
                <i class="fas fa-info-circle mr-3 fa-lg text-info"></i>
                <div>
                    <h5 class="alert-heading mb-1">Join Our Community</h5>
                    <p class="mb-0">Please <a href="{{ route('login') }}" class="alert-link fw-bold">log in</a> to book
                        services and leave reviews.</p>
                </div>
            </div>
        @endauth

        <!-- Back Button -->
        <div class="text-center mt-5">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary px-4">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </a>
        </div>
    </div>
@endsection

<style>
    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: flex-start;
    }

    .star-rating input[type="radio"] {
        display: none;
    }

    .star-rating label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
        margin: 0 4px;
    }

    .star-rating label:hover,
    .star-rating label:hover~label {
        color: orange;
    }

    .star-rating input[type="radio"]:checked~label {
        color: orange;
    }

    .profile-section {
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .profile-section h2 {
        font-size: 1.8rem;
        letter-spacing: 0.5px;
    }

    .profile-section .lead {
        font-size: 1.1rem;
        font-weight: 300;
    }

    .profile-section i {
        width: 20px;
        text-align: center;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookedSlots = @json($bookedSlots);

        document.querySelectorAll('.appointment-date').forEach(dateInput => {
            dateInput.addEventListener('change', function() {
                const selectedDate = this.value;
                const serviceId = this.getAttribute('data-service-id');
                const timeSelect = document.getElementById('time-select-' + serviceId);

                // Reset all options
                [...timeSelect.options].forEach(opt => {
                    opt.disabled = false;
                    opt.textContent = opt
                    .value; // reset text if it was appended with "(booked)"
                });

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

        // Auto-select today and trigger change when modal opens (Bootstrap 5 event)
        document.querySelectorAll('.modal').forEach(modal => {
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
