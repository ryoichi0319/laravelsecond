<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Subscription') }}
        </h2>
    </x-slot>
    <style>
       #card-element,#card-holder-name {
    border-radius: 4px 4px 0 0 ;
    padding: 12px;
    border: 1px solid rgba(50, 50, 93, 0.1);
    height: 44px;
    width: 100%;
    background: white;
}
button#card-button {
    background: #5469d4;
    color: #ffffff;
    font-family: Arial, sans-serif;
    border-radius: 0 0 4px 4px;
    border: 0;
    padding: 12px 16px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    display: block;
    box-shadow: 0px 4px 5.5px 0px rgba(0, 0, 0, 0.07);
    width: 100%;
}

    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form id="setup-form" action="{{ route('subscribe.post') }}" method="post">
                        @csrf
                        <input id="card-holder-name" type="text" placeholder="カード名義人" name="card-holder-name">
                        <div id="card-element"></div>
                        <button id="card-button" data-secret="{{ $intent->client_secret }}">
                          サブスクリプション
                        </button>
                      </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
      
        const stripe = Stripe('pk_test_51OH1dUDTe2j0pcnD1bAxuPYbR5WcPBBdytixdddNMuVb7SG4Vb1Ws8HvxawCWCm3aG0sNrYXqEBnsvIfoWNQlPQ500gQhNKYY2');
        console.log(stripe)
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

     cardButton.addEventListener('click', async (e) => {
        e.preventDefault()
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            if (error) {
                // Display "error.message" to the user...
                console.log(error);
            } else {
                // The card has been verified successfully...
                stripePaymentIdHandler(setupIntent.payment_method);
            }
        });
        function stripePaymentIdHandler(paymentMethodId) {
            // Insert the paymentMethodId into the form so it gets submitted to the server
            const form = document.getElementById('setup-form');

            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethodId');
            hiddenInput.setAttribute('value', paymentMethodId);
            form.appendChild(hiddenInput);

            // Submit the form
            form.submit();
            
}
            </script>
            @endpush
        </x-app-layout>
