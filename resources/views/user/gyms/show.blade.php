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
                                <form id="enroll-form-{{ $service->id }}" method="POST"
                                    action="{{ route('subscriptions.store') }}">
                                    @csrf
                                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                                </form>

                                <a href="javascript:void(0)" class="primary-btn pricing-btn mt-2 text-white"
                                    onclick="openPaymentModal({{ $service->id }})">
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

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function openPaymentModal(serviceId) {
        Swal.fire({
                title: 'Choose Payment Method',
                html: `
   <div style="font-family: 'Segoe UI', Arial, sans-serif; max-width: 500px; margin: 0 auto;">
    <div style="margin-bottom: 20px;">
        <label for="start-date" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Start Date</label>
        <input type="date" id="start-date" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="payment-method-select" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Payment Method</label>
        <select id="payment-method-select" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box; background-color: white; appearance: none;" onchange="toggleCardForm(this.value)">
            <option value="" disabled selected>Select a payment method</option>
            <option value="cash">Cash</option>
            <option value="online">Online</option>
        </select>
    </div>

    <div id="card-details-form" style="display: none; background: #f8f9fa; padding: 15px; border-radius: 6px; margin-top: 10px;">
        <div style="margin-bottom: 15px;">
            <label for="card-number" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Card Number</label>
            <input type="text" id="card-number" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;" placeholder="1234 5678 9012 3456">
        </div>

        <div style="margin-bottom: 15px;">
            <label for="card-name" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Name on Card</label>
            <input type="text" id="card-name" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;" placeholder="John Doe">
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 5px;">
            <div style="flex: 1;">
                <label for="card-expiry" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Expiry Date</label>
                <input type="text" id="card-expiry" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;" placeholder="MM/YY">
            </div>
            <div style="flex: 1;">
                <label for="card-cvc" style="display: block; font-weight: 600; margin-bottom: 6px; color: #333;">Security Code</label>
                <input type="text" id="card-cvc" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; box-sizing: border-box;" placeholder="CVC">
            </div>
        </div>
    </div>
</div>
`,
                didOpen: () => {
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('start-date').setAttribute('min', today);
                },
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Continue',
                confirmButtonColor: '#f36100',
                preConfirm: () => {
                    const method = document.getElementById('payment-method-select').value;
                    const startDate = document.getElementById('start-date').value;

                    if (!startDate) {
                        Swal.showValidationMessage('Please select a start date');
                        return false;
                    }

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

                    return {
                        payment_method: method,
                        start_date: startDate
                    };
                }
            })
            .then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Confirm Enrollment?',
                        text: `You selected "${result.value.payment_method}" as payment method.`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#f36100',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Yes, enroll me!',
                    }).then((finalResult) => {
                        if (finalResult.isConfirmed) {
                            const form = document.getElementById(`enroll-form-${serviceId}`);

                            const startDateInput = document.createElement('input');
                            startDateInput.type = 'hidden';
                            startDateInput.name = 'start_date';
                            startDateInput.value = result.value.start_date;
                            form.appendChild(startDateInput);

                            form.submit();
                        }
                    });
                }
            });
    }

    function toggleCardForm(paymentType) {
        const form = document.getElementById('card-details-form');
        form.style.display = paymentType === 'online' ? 'block' : 'none';
    }
</script>
