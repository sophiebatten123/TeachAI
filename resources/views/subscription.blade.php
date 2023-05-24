@extends('layouts.app')

@section('content')
<div class="container py-5 bg-blue-600 mt-5">
            <div class="m-auto w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <div class="text-2xl font-extrabold mb-4">
                    We are excited for you to join!
                </div>
                <hr/>
                <div class="my-4 text-md font-medium text-gray-500 dark:text-gray-400">
                    £{{ number_format($plan->price, 2) }}/month for the {{ $plan->name }}
                </div>
                <div class="card-body">
                    <form id="payment-form" action="{{ route('subscription.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" id="plan" value="{{ $plan->id }}">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <input type="text" name="name" id="card-holder-name" class="w-full form-control border bg-gray-200 py-1 px-4" value="" placeholder="Name on card">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <div id="card-element" class="form-control border bg-gray-200 py-2 px-4"></div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 mt-4">
                            <hr>
                                <button type="submit" id="card-button" data-secret="{{ $intent->client_secret }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 dark:focus:ring-blue-900 font-medium rounded-lg text-sm px-5 py-2.5 inline-flex justify-center w-full text-center">Purchase</button>
                            </div>
                        </div>
   
                    </form>
   
                </div>
            </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}')
   
    const elements = stripe.elements()
    const cardElement = elements.create('card')
   
    cardElement.mount('#card-element')
   
    const form = document.getElementById('payment-form')
    const cardBtn = document.getElementById('card-button')
    const cardHolderName = document.getElementById('card-holder-name')
   
    form.addEventListener('submit', async (e) => {
        e.preventDefault()
        cardBtn.disabled = true
        const { setupIntent, error } = await stripe.confirmCardSetup(
            cardBtn.dataset.secret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: cardHolderName.value
                    }   
                }
            }
        )
   
        if(error) {
            cardBtn.disable = false
        } else {
            let token = document.createElement('input')
            token.setAttribute('type', 'hidden')
            token.setAttribute('name', 'token')
            token.setAttribute('value', setupIntent.payment_method)
            form.appendChild(token)
            form.submit();
        }
    })
</script>
@endsection