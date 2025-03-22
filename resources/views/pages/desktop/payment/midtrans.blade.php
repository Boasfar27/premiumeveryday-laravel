@extends('pages.desktop.layouts.app')

@section('title', 'Payment - Premium Everyday')

@section('content')
    <div class="bg-white py-12 mt-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Complete Your Payment</h1>
                <p class="text-lg text-gray-600">Order #{{ $order->order_number }}</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-10">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Order Summary</h2>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('d F Y, H:i') }}</span>
                    </div>
                    <div class="flex justify-between mb-1">
                        <span class="text-gray-600">Total Amount:</span>
                        <span class="font-bold text-primary">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium capitalize">{{ $order->payment_status }}</span>
                    </div>
                </div>

                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Details</h2>

                    <div class="space-y-4">
                        <div class="rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h3 class="text-sm font-medium text-blue-800">Payment Instructions</h3>
                                    <div class="mt-2 text-sm text-blue-700">
                                        <p>You'll be redirected to Midtrans payment gateway where you can select your
                                            preferred payment method (Bank Transfer, E-wallet, QRIS, etc).</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Button -->
                        <div class="mt-6">
                            <a href="{{ route('payment.midtrans.redirect', $order) }}" id="pay-button"
                                class="block w-full bg-pink-600 hover:bg-pink-700 text-white py-3 px-4 rounded-lg text-base font-semibold transition-colors text-center">
                                Pay Now
                            </a>
                            <p class="mt-2 text-sm text-center text-gray-500 italic">
                                You will be redirected to Midtrans payment page
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('user.payments.detail', $order) }}"
                    class="text-primary hover:text-primary-dark font-medium">
                    Return to Order Details
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Add Midtrans script tag with defer attribute and proper client key -->
    <script type="text/javascript" src="{{ config('midtrans.snap_url') }}" data-client-key="{{ $client_key }}" defer>
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, waiting for Midtrans to be ready...');

            // Check if Midtrans script is loaded every 500ms
            const checkMidtrans = setInterval(function() {
                if (typeof window.snap !== 'undefined') {
                    console.log('Midtrans is ready!');
                    clearInterval(checkMidtrans);
                    setupMidtransButton();
                }
            }, 500);

            // After 10 seconds, stop checking and show error if Midtrans is not loaded
            setTimeout(function() {
                if (typeof window.snap === 'undefined') {
                    console.error('Midtrans still not loaded after 10 seconds');
                    clearInterval(checkMidtrans);
                    const payButton = document.getElementById('pay-button');
                    if (payButton) {
                        payButton.classList.add('bg-yellow-500');
                        payButton.textContent = 'Retry Payment';
                        payButton.addEventListener('click', function() {
                            window.location.reload();
                        });
                    }
                }
            }, 10000);

            function setupMidtransButton() {
                const payButton = document.getElementById('pay-button');
                const token = "{{ $order->midtrans_token }}";

                console.log('Setting up payment button');
                console.log('Token exists:', Boolean(token));

                if (payButton && token) {
                    payButton.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('Pay button clicked, opening Midtrans popup');

                        try {
                            // Alternative direct implementation for opening snap
                            window.open('https://app.sandbox.midtrans.com/snap/v2/vtweb/' + token,
                                'Midtrans Payment',
                                'width=800,height=600,location=yes,resizable=yes,scrollbars=yes,status=yes'
                            );

                            /* // Commented out original implementation as backup
                            window.snap.pay(token, {
                                onSuccess: function(result) {
                                    console.log('Payment success:', result);
                                    window.location.href = "{{ route('payment.midtrans.finish') }}";
                                },
                                onPending: function(result) {
                                    console.log('Payment pending:', result);
                                    window.location.href = "{{ route('payment.midtrans.unfinish') }}";
                                },
                                onError: function(result) {
                                    console.error('Payment error:', result);
                                    window.location.href = "{{ route('payment.midtrans.error') }}";
                                },
                                onClose: function() {
                                    console.log('Customer closed payment popup');
                                    alert('You closed the payment window before completing payment');
                                }
                            });
                            */
                        } catch (error) {
                            console.error('Error opening payment window:', error);
                            alert('Failed to open payment window: ' + error.message +
                                '\nPlease try refreshing the page.');
                        }
                    });
                } else {
                    console.error('Button or token not available');
                    if (payButton) {
                        payButton.disabled = true;
                        payButton.classList.add('bg-gray-400');
                        payButton.textContent = 'Payment Unavailable';
                    }
                }
            }
        });
    </script>
@endpush
