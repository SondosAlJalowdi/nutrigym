@extends('user.generalLayout')

@section('content')
    <section class="pricing-section spad" style="margin-top: 150px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center">
                        <span>Our Plans</span>
                        <h2>Services Offered by {{ $gym->user->name ?? 'Gym' }}</h2>
                        <p class="mt-2">{{ $gym->about }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse($gym->services as $service)
                    <div class="col-lg-4 col-md-8 mb-4">
                        <div class="ps-item text-center">
                            <h3>{{ $service->title }}</h3>
                            <div class="pi-price">
                                <h2>${{ $service->price }}</h2>
                                <span>{{ $service->category->name ?? 'Service' }}</span>
                            </div>
                            <ul class="text-start px-4">
                                <li>{{ $service->description ?? 'No description available.' }}</li>
                            </ul>
                            @auth
                            <form id="enroll-form-{{ $service->id }}" method="POST" action="{{ route('subscriptions.store') }}">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">
                            </form>

                            <a type="button" class="primary-btn pricing-btn mt-2 text-white" onclick="openPaymentModal({{ $service->id }})">
                                Enroll Now
                            </a>
                            @else
                            <a href="{{ route('login') }}" class="primary-btn pricing-btn">Login to Enroll</a>
                            @endauth



                            @if ($service->image)
                                <a href="#" class="thumb-icon mt-3 d-block">
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Service Image"
                                        style="max-width: 100%; height: 150px; object-fit: cover;">
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-center">No services available for this gym.</p>
                @endforelse
            </div>
            <a href="{{ route('gyms.index') }}" class="primary-btn mb-3">← Back to All Gyms</a>

        </div>
    </section>
@endsection


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openPaymentModal(serviceId) {
    Swal.fire({
        title: 'Choose Payment Method',
        html: `
            <div>
                <select id="payment-method-select" class="swal2-input" onchange="toggleCardForm(this.value)">
                    <option value="" disabled selected>Select a method</option>
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                </select>
                <div id="card-details-form" style="display: none;">
                    <input type="text" id="card-number" class="swal2-input" placeholder="Card Number">
                    <input type="text" id="card-name" class="swal2-input" placeholder="Name on Card">
                    <input type="text" id="card-expiry" class="swal2-input" placeholder="MM/YY">
                    <input type="text" id="card-cvc" class="swal2-input" placeholder="CVC">
                </div>
            </div>
        `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: 'Continue',
        confirmButtonColor: '#f36100',
        preConfirm: () => {
            const method = document.getElementById('payment-method-select').value;
            if (!method) {
                Swal.showValidationMessage('Please select a payment method');
                return false;
            }

            if (method === 'online') {
                const number = document.getElementById('card-number').value;
                const name = document.getElementById('card-name').value;
                const expiry = document.getElementById('card-expiry').value;
                const cvc = document.getElementById('card-cvc').value;

                if (!number || !name || !expiry || !cvc) {
                    Swal.showValidationMessage('Please fill all card details');
                    return false;
                }
            }

            return method;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Confirm Enrollment?',
                text: `You selected "${result.value}" as payment method.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f36100',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Yes, enroll me!',
            }).then((finalResult) => {
                if (finalResult.isConfirmed) {
                    document.getElementById(`enroll-form-${serviceId}`).submit();
                }
            });
        }
    });
}

// Helper to toggle card fields
function toggleCardForm(paymentType) {
    const form = document.getElementById('card-details-form');
    form.style.display = paymentType === 'online' ? 'block' : 'none';
}
</script>

