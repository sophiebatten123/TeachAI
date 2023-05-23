@extends('layouts.app')

@section('content')
<div class="container">
    <section>
        <div class="container py-5">
            <h1>Pricing</h1>
            @foreach ($plans as $plan)
                <h1>{{ $plan->name }}</h1>
                <h2>{{ $plan->price }}</h2>
                <a href="{{ route('plans.show', $plan->slug) }}">Subscribe Now</a>
            @endforeach
        </div>
    </section>
</div>
@endsection