@extends('client.layouts.app')

@section('title', 'Stripe Payment - E Shop')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3>Stripe Payment</h3>
                    </div>
                    <div class="card-body">
                        <div class="order-summary mb-4">
                            <h5>Order Summary</h5>
                            <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
                            <p><strong>Total Amount:</strong> ${{ number_format($checkoutData['total_amount'], 2) }}</p>
                        </div>

                        <form id="payment-form" action="{{ route('stripe.process') }}" method="POST">
                            @csrf
                            <input type="hidden" name="order_code" value="{{ $order->order_code }}">
                            <input type="hidden" name="amount" value="{{ $checkoutData['total_amount'] }}">

                            <div class="form-group mb-3">
                                <label for="card-element">Credit or Debit Card</label>
                                <div id="card-element" class="form-control" style="height: 40px; padding-top: 10px;">
                                    <!-- Stripe Card Element will be inserted here -->
                                </div>
                                <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg btn-block" id="submit-button">
                                Pay ${{ number_format($checkoutData['total_amount'], 2) }}
                            </button>

                            <a href="{{ route('checkout') }}" class="btn btn-secondary btn-lg btn-block mt-2">
                                Cancel & Go Back
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
        var elements = stripe.elements();

        var style = {
            base: {
                fontSize: '16px',
                color: '#32325d',
            }
        };

        var card = elements.create('card', {
            style: style
        });
        card.mount('#card-element');

        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            var submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.textContent = 'Processing...';

            const {
                token,
                error
            } = await stripe.createToken(card);

            if (error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                submitButton.disabled = false;
                submitButton.textContent = 'Pay ${{ number_format($checkoutData['total_amount'], 2) }}';
            } else {
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    </script>
@endsection
