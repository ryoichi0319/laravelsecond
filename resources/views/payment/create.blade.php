<x-app-layout>
    <div class="container mx-auto">
        @if (session('flash_alert'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('flash_alert') }}</span>
            </div>
        @elseif(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif
        <div class="p-5">
            <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                <div class="md:flex">
                    <div class="p-8">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold">Stripe決済</div>
                        <div class="mt-2 text-gray-500">カード情報を入力してください。</div>
                        <form id="card-form" action="{{ route('payment.store') }}" method="POST" class="mt-6">
                            @csrf
                            <div>
                                <label for="card_number" class="block text-sm font-medium text-gray-700">カード番号</label>
                                <div id="card-number" class="mt-1"></div>
                            </div>
                            <div class="mt-4">
                                <label for="card_expiry" class="block text-sm font-medium text-gray-700">有効期限</label>
                                <div id="card-expiry" class="mt-1"></div>
                            </div>
                            <div class="mt-4">
                                <label for="card-cvc" class="block text-sm font-medium text-gray-700">セキュリティコード</label>
                                <div id="card-cvc" class="mt-1"></div>
                            </div>
                            <div id="card-errors" class="text-sm text-red-500 mt-2"></div>
                            <button type="submit" class="mt-6 w-full inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                支払い
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input id="card-holder-name" type="text">

<!-- ストライプ要素のプレースホルダ -->
<div id="card-element"></div>

<button id="card-button" data-secret="{{ $intent->client_secret }}">
    Update Payment Method
</button>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_public_key = "{{ config('stripe.stripe_public_key') }}"
        const stripe = Stripe(stripe_public_key);
        const elements = stripe.elements();

        var cardNumber = elements.create('cardNumber');
        cardNumber.mount('#card-number');
        cardNumber.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardExpiry = elements.create('cardExpiry');
        cardExpiry.mount('#card-expiry');
        cardExpiry.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var cardCvc = elements.create('cardCvc');
        cardCvc.mount('#card-cvc');
        cardCvc.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        var form = document.getElementById('card-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            var errorElement = document.getElementById('card-errors');
            if (event.error) {
                errorElement.textContent = event.error.message;
            } else {
                errorElement.textContent = '';
            }

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    errorElement.textContent = result.error.message;
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('card-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }
    </script>
</x-app-layout>
